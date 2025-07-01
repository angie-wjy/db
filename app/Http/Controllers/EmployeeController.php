<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function Dashboard()
    {
        // $employees = Employee::with('user')->get();
        // return view('employee.home', compact('employees'));
        return view('employee.dashboard');
    }
}
