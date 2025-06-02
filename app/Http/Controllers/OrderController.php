<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function CheckOutForm()
    {
        $order = Order::with('delivery')
            ->where('customers_id', Auth::id())
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Belum ada order untuk ditampilkan.');
        }

        return view('customer.checkout', compact('order'));
    }

    public function CheckOut(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
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

        // Simpan order
        $order = new Order();
        $order->date = now();
        $order->total = $totalHarga;
        $order->status = 'pending';
        $order->created_at = now();
        $order->updated_at = now();
        $order->customers_id = Auth::id();
        $order->admins_id = null;
        $order->employees_id = null;
        $order->branches_id = $request->delivery_method === 'pickup' ? $request->branch_id : 1;
        $order->created_id = Auth::id();
        $order->updated_id = Auth::id();
        $order->deleted_id = null;
        $order->save();

        // Simpan data delivery
        $delivery = new Delivery();
        $delivery->type = $request->delivery_method;
        $delivery->status = 'on progress';
        $delivery->resi = null;
        $delivery->orders_id = $order->id;
        $delivery->save();

        session()->forget('cart');

        return redirect()->route('customer.checkout.show', $order->id)
            ->with('success', 'Order berhasil dibuat!');
    }

    public function ShowCheckOut($orderId)
    {
        $order = Order::with('delivery')->findOrFail($orderId);
        return view('customer.checkout', compact('order'));
    }

    public function CheckOutSuccess()
    {
        return view('customer.checkout-success');
    }
}
