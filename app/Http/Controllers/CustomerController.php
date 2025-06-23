<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerHasAddress;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Menampilkan semua customer
    public function index()
    {
        $customers = Customer::with('user')->get();
        return response()->json($customers);
    }


    public function welcome()
    {
        $products = Product::all();
        $categories = Category::with('products')->get();
        return view('welcome', compact('products', 'categories'));
    }

    // public function cart(Request $request)
    // {
    //     $dataCart = null;
    //     return view('customer.cart', compact('dataCart'));
    // }

    // Menampilkan detail customer berdasarkan user_id
    public function show($user_id)
    {
        $customer = Customer::with('user')->find($user_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json($customer);
    }

    // Menambahkan customer baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:customers,user_id',
            'code' => 'required|integer',
            'rate' => 'nullable|integer|min:1|max:5',
        ]);

        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    // Mengupdate data customer
    public function update(Request $request, $user_id)
    {
        $customer = Customer::find($user_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'code' => 'integer',
            'rate' => 'nullable|integer|min:1|max:5',
        ]);

        $customer->update($request->all());
        return response()->json($customer);
    }

    // Menghapus customer
    public function delete($user_id)
    {
        $customer = Customer::find($user_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }

    public function AddressAdd(Request $request)
    {
        $data = $request->all();
        $data['customer_id'] = auth()->user()->id;
        $customer_has_address = CustomerHasAddress::create($data);
        return response()->json($customer_has_address);
    }

    public function AddressIndex()
    {
        $customer_has_address = CustomerHasAddress::where('customer_id', auth()->user()->id)->get();
        return response()->json($customer_has_address);
    }

    public function Profile()
    {
        $customer = Auth::guard('customer')->user();

        // Retrieve all orders associated with the customer
        // Using 'customers_id' column based on your Order model
        $orders = Order::where('customers_id', $customer->id)
            ->with(['orderDetails.product', 'ship']) // Changed from 'items' to 'orderDetails.product'
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Using pagination for better performance, adjust as needed

        return view('customer.profile.index', compact('customer', 'orders'));
    }

    public function ShowOrder($id)
    {
        $customer = Auth::guard('customer')->user();
        $order = Order::where('id', $id)
            ->where('customers_id', $customer->id)
            ->with(['orderDetails.product', 'ship'])
            ->firstOrFail();
        return view('customer.order.show', compact('order'));
    }
}
