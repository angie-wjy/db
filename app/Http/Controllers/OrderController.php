<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function CheckOut(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pick up,delivery',
            'branch_id' => $request->delivery_method == 'pick up' ? 'required|exists:branches,id' : 'nullable',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        // $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $cart = session('cart', []);

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
        $order->branches_id = $request->delivery_method === 'pick up' ? $request->branch_id : 1;
        $order->created_id = Auth::id();
        $order->updated_id = Auth::id();
        $order->deleted_id = null;
        $order->save();

        // foreach ($cart as $products_id => $item) {
        //     $order->products()->attach($products_id, [
        //         'quantity' => $item['quantity'],
        //         'price' => $item['price'],
        //     ]);
        // }

        foreach ($cart as $item) {
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }


        // Simpan data delivery
        $delivery = new Delivery();
        $delivery->type = $request->delivery_method;
        $delivery->address = isset($request->address) ? $request->address : null;
        $delivery->status = 'on progress';
        $delivery->resi = null;
        $delivery->orders_id = $order->id;
        $delivery->save();

        session()->forget('cart');

        return redirect()->route('customer.checkout.show', $order->id)
            ->with('success', 'Order berhasil dibuat!');
    }

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

    // public function ShowCheckOut($orderId)
    // {
    //     $order = Order::with('delivery')->findOrFail($orderId);
    //     return view('customer.checkout', compact('order'));
    // }

    public function ShowCheckOut($orderId)
    {
        $order = Order::with(['delivery', 'orderDetails.product'])
            ->where('id', $orderId)
            ->where('customers_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('customer.checkout')->with('error', 'Order tidak ditemukan.');
        }

        return view('customer.checkout', compact('order'));
    }

    public function CheckOutSuccess()
    {
        return view('customer.checkout-success');
    }
}
