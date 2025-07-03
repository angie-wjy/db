<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function Ship(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pick up,delivery',
            'branch_id' => $request->delivery_method == 'pick up' ? 'required|exists:branches,id' : 'nullable',
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
        $order->branches_id = $request->delivery_method === 'pick up' ? $request->branch_id : 1;
        $order->created_id = Auth::id();
        $order->updated_id = Auth::id();
        $order->deleted_id = null;
        $order->save();

        foreach ($cart as $item) {
            if (str_starts_with($item['id'], 'bundle_')) {
                // Jika item adalah bundle, kita perlu mengaitkan produk bundle
                $bundle = \App\Models\Bundle::find(str_replace('bundle_', '', $item['id']));
                if ($bundle) {
                    $order->bundles()->attach($bundle->id, [
                        'amount' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                    continue;
                }
            }
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // kurangi stok barang
        // foreach ($cart as $item) {
        //     $product = $item['product'];
        //     $product->stock -= $item['stock'];
        //     $product->save();
        // }

        foreach ($cart as $item) {
            if (str_starts_with($item['id'], 'bundle_')) {
                // Jika item adalah bundle, kita perlu mengaitkan produk bundle
                $bundle = \App\Models\Bundle::find(str_replace('bundle_', '', $item['id']));
                if ($bundle) {
                    foreach ($bundle->products as $product) {
                        $branchProduct = $product->branches()->where('branches_id', $order->branches_id)->first();
                        if ($branchProduct) {
                            $branchProduct->pivot->stock -= $item['quantity'];
                            if ($branchProduct->pivot->stock < 0) {
                                $branchProduct->pivot->stock = 0;
                            }
                            $branchProduct->pivot->save();
                        } else {
                            Log::warning("Produk dengan ID {$product->id} tidak ditemukan di cabang dengan ID {$order->branches_id}.");
                        }
                    }
                } else {
                    Log::warning("Bundle dengan ID " . str_replace('bundle_', '', $item['id']) . " tidak ditemukan.");
                }
                continue;
            }

            $product = \App\Models\Product::find($item['id']);

            if ($product) {
                $branchProduct = $product->branches()->where('branches_id', $order->branches_id)->first();

                if ($branchProduct) {
                    $branchProduct->pivot->stock -= $item['quantity'];

                    if ($branchProduct->pivot->stock < 0) {
                        $branchProduct->pivot->stock = 0;
                    }

                    $branchProduct->pivot->save();
                } else {
                    Log::warning("Produk dengan ID {$item['id']} tidak ditemukan di cabang dengan ID {$order->branches_id}.");
                }
            } else {
                Log::warning("Produk dengan ID {$item['id']} tidak ditemukan saat mengurangi stok.");
            }
        }

        // Simpan data delivery
        $ship = new Ship();
        $ship->type = $request->delivery_method;
        $ship->address = isset($request->address) ? $request->address : null;
        $ship->status = 'on progress';
        $ship->resi = null;
        $ship->orders_id = $order->id;
        $ship->save();

        session()->forget('cart');

        return redirect()->route('customer.checkout.form', $order->id)
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
        $order = Order::with(['ship', 'products', 'bundles'])->where('customers_id', Auth::id())
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
        $order = Order::with(['ship', 'orderDetails.product'])
            ->where('id', $orderId)
            ->where('customers_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('customer.checkout.show', $orderId)
                ->with('error', 'Order tidak ditemukan.');
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

    public function Notification(Request $request)
    {
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
    }

    public function OrderCheckReady($orderId)
    {
        $order = Order::where('id', $orderId);
        $order->update(['status' => 'checked']);
        return redirect()->route('admin.order.check.index')
            ->with('success', 'The order is ready to be collected.');
    }

    public function OrderCheckNotReady($orderId)
    {
        $order = Order::where('id', $orderId);
        $order->update(['status' => 'canceled']);
        return redirect()->route('admin.order.check.index')
            ->with('success', 'The order has been canceled.');
    }

    public function CheckOutSuccess($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('customer.checkout-success', compact('order'));
    }

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
}
