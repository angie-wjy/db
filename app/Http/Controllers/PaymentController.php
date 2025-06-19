<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $orderId = $request->input('order_id'); // dari Snap response
        $transactionStatus = $request->input('transaction_status');

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $order = Order::find($orderId);
            if ($order) {
                $order->status = 'completed';
                $order->save();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }
}
