<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Order;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = explode('-', $notif->order_id)[0]; // karena di controller kamu tambahkan uniqid
        $fraud = $notif->fraud_status;

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update status order
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->status = 'pending';
                } else {
                    $order->status = 'paid';
                }
            }
        } elseif ($transaction == 'settlement') {
            $order->status = 'paid';
        } elseif ($transaction == 'pending') {
            $order->status = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $order->status = 'failed';
        }

        $order->save();

        return response()->json(['message' => 'Payment status updated']);
    }
}
