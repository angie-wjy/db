<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Order;
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

    public function OrderApprove($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'new') {
            return redirect()->back()->with('error', 'Only new orders can be approved.');
        }

        $order->status = 'processed';
        $order->is_ready_stock = true;
        $order->save();

        return redirect()->back()->with('success', 'Order approved and moved to processed!');
    }

    public function OrderCheckIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'paid')->get();
        return view('employee.order.check.index', compact('orders'));
    }

    public function OrderPackIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'checked')->get();
        return view('employee.order.pack.index', compact('orders'));
    }

    public function OrderPacked($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'packed';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as packed and ready to send!');
    }

    public function OrderSendIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'packed')->get();
        return view('employee.order.send.index', compact('orders'));
    }

    public function OrderAccShip($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipping';
        $order->save();

        return back()->with('success', 'Shipping approved successfully.');
    }

    public function OrderRejectShip($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipping_rejected';
        $order->save();

        return back()->with('success', 'Shipping has been rejected.');
    }

    public function showApproveShipping()
    {
        $orders = Order::where('status', 'packed')->get();
        return view('employee.orders.approve-shipping', compact('orders'));
    }

    public function OrderCompleteIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'shipping')->get();
        return view('employee.order.completed.index', compact('orders'));
    }
}
