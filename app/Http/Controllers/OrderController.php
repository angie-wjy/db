<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function CheckOutForm()
    {
        $cart = session('cart') ?? [];
        return view('customer.checkout', compact('cart'));
    }

    public function CheckOut(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
            // Kalau pakai pickup, wajib pilih branch_id
            'branch_id' => $request->delivery_method == 'pickup' ? 'required|exists:branches,id' : 'nullable',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['price'] * $item['quantity'];
        }

        $order = new Order();
        $order->date = now();
        $order->total = $totalHarga;
        $order->status = 'pending';
        $order->created_at = now();
        $order->updated_at = now();
        $order->customers_id = Auth::id();
        $order->admins_id = null;
        $order->employees_id = null;

        // Kalau delivery method pickup, isi branches_id dengan input branch_id
        if ($request->delivery_method == 'pickup') {
            $order->branches_id = $request->branch_id; // wajib valid dan tidak null
        } else {
            // Kalau delivery, bisa isi dengan branch default atau 0 (tapi harus valid)
            // Atau kalau db tidak boleh null, isi branch default misal 1
            $order->branches_id = 1; // sesuaikan dengan branch default
        }

        $order->created_id = Auth::id();
        $order->updated_id = Auth::id();
        $order->deleted_id = null;

        $order->save();

        session()->forget('cart');

        return redirect()->route('customer.checkout.success')->with('success', 'Order berhasil dibuat!');
    }


    public function ShowCheckOut($orderId)
    {
        $order = Order::with('deliveryOption')->findOrFail($orderId);
        return view('customer.checkout', compact('order'));
    }

    public function CheckOutSuccess()
    {
        return view('customer.checkout-success');
    }


    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }
}
