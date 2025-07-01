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

    public function OrderIndex()
    {
        $orders = Order::with(['customer', 'products'])->latest()->get();
        return view('employee.order.index', compact('orders'));
        // return view('employee.order.index');
    }

    public function OrderCheckIndex()
    {
        return view('employee.order.check.index');
    }

    public function OrderPackIndex()
    {
        return view('employee.order.pack.index');
    }

    public function OrderSendIndex()
    {
        return view('employee.order.send.index');
    }

    public function OrderCompleteIndex()
    {
        return view('employee.order.completed.index');
    }
}
