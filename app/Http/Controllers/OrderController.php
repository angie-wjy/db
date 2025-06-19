<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification; // Pastikan ini ada

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

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

    // public function CheckOutForm()
    // {
    //     $order = Order::with('delivery')
    //         ->where('customers_id', Auth::id())
    //         ->latest()
    //         ->first();

    //     if (!$order) {
    //         return redirect()->back()->with('error', 'Belum ada order untuk ditampilkan.');
    //     }

    //     return view('customer.checkout', compact('order'));
    // }

    public function CheckOutForm()
    {
        $order = Order::with(['delivery', 'products'])->where('customers_id', Auth::id())
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Belum ada order untuk ditampilkan.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false; // ganti true kalau sudah live
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data untuk Snap
        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . uniqid(),
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        return view('customer.checkout', compact('order', 'snapToken'));
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

        $total_amount = 0;
        $item_detail = [];

        foreach ($order->orderDetails as $orderDetail) {
            $total_amount += $orderDetail->product->price * $orderDetail->quantity;

            $item_detail[] = [
                'id' => $orderDetail->product->id,
                'price' => $orderDetail->product->price,
                'quantity' => $orderDetail->quantity,
                'name' => $orderDetail->product->name
            ];
        }

        $user = Auth::user();

        // Parameter transaksi
        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId, // Pastikan order_id unik
                'gross_amount' => $total_amount, // Jumlah transaksi
            ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone
            ),
            // Opsional: item details
            'item_details' => $item_detail,
        );


        $snapToken = Snap::getSnapToken($params);
        return view('customer.checkout', compact('order', 'snapToken'));
    }


    public function notification(Request $request)
    {
        // Ini adalah endpoint untuk menerima notifikasi dari Midtrans (Webhook)
        // Anda perlu memverifikasi notifikasi dan mengupdate status pesanan di database Anda.
        // Contoh sederhana (perlu penanganan error dan keamanan lebih lanjut)

        // Baris yang Anda maksud
        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;

            // update order status
            $order = Order::find($orderId);
            $order->status = "paid";
            $order->save();

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage(), ['exception' => $e]);
            // Kirim respons non-200 jika ada error serius (Midtrans mungkin akan retry)
            return response('Error', 500);
        }

        // error_log("Order ID: " . $orderId . " - Transaction Status: " . $transactionStatus . " - Fraud Status: " . $fraudStatus);

        // if ($transactionStatus == 'capture') {
        //     if ($fraudStatus == 'challenge') {
        //         // TODO set transaction status on your database to 'challenge'
        //     } else if ($fraudStatus == 'accept') {
        //         // TODO set transaction status on your database to 'success'
        //     }
        // } else if ($transactionStatus == 'settlement') {
        //     // TODO set transaction status on your database to 'success'
        // } else if ($transactionStatus == 'pending') {
        //     // TODO set transaction status on your database to 'pending' / waiting payment
        // } else if ($transactionStatus == 'deny') {
        //     // TODO set transaction status on your database to 'deny'
        // } else if ($transactionStatus == 'expire') {
        //     // TODO set transaction status on your database to 'expire' / cancelled
        // } else if ($transactionStatus == 'cancel') {
        //     // TODO set transaction status on your database to 'cancel'
        // }
    }

    public function OrderCheckReady($orderId)
    {
        $order = Order::where('id', $orderId);
        $order->update(['status' => 'checked']);
        return redirect()->route('admin.order.check.index')
            ->with('success', 'Order telah siap untuk diambil.');
    }

    public function OrderCheckNotReady($orderId)
    {
        $order = Order::where('id', $orderId);
        $order->update(['status' => 'canceled']);
        return redirect()->route('admin.order.check.index')
            ->with('success', 'Order telah siap untuk diambil.');
    }

    public function CheckOutSuccess()
    {
        return view('customer.checkout-success');
    }
<<<<<<< Updated upstream
=======

    public function Payment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($request->paid == true) {
            $order->status = 'new';
            $order->save();
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order sudah diproses atau dibatalkan.');
        }

        // Simpan bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/payment_proofs'), $filename);
            $order->payment_proof = 'uploads/payment_proofs/' . $filename;
        }

        $order->status = 'paid';
        $order->save();

        return redirect()->route('customer.checkout.success')->with('success', 'Pembayaran berhasil dilakukan.');
    }
>>>>>>> Stashed changes
}
