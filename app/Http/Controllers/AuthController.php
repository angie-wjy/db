<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if ($user->role == 'admin'){
            Auth::guard("admin")->login($user);
            return redirect()->route('admin.dashboard');
        }else if ($user->role == 'employee'){
            Auth::guard("employee")->login($user);
            return redirect()->route('employee.dashboard');
        }else if ($user->role == 'customer'){
            Auth::guard("customer")->login($user);
            return redirect()->route('welcome');
        }

        return redirect()->route('welcome');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        if ($request->password !== $request->password_confirmation) {
            throw ValidationException::withMessages([
                'password' => ['The password confirmation does not match.'],
            ]);
        }
        $role = str_ends_with($request->email, '@admin.id') ? 'admin' : 'customer';

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'role' => $role,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::guard('customer')->login($user);
        return redirect()->route('welcome');
    }

    public function signout(Request $request)
    {
        Auth::guard("customer")->logout();
        return redirect()->route('welcome');
    }
}
