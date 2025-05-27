<?php

namespace App\Http\Controllers;

use App\Models\OrdersHasProducts;
use Illuminate\Http\Request;

class OrdersHasProductsController extends Controller
{
    // Menampilkan semua Order Items
    public function index()
    {
        $orderItems = OrdersHasProducts::with(['order', 'product'])->get();
        return response()->json($orderItems);
    }

    // Menyimpan Order Item baru
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem = OrdersHasProducts::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Order Item added successfully', 'data' => $orderItem], 201);
    }

    // Menampilkan Order Item berdasarkan ID
    public function show($order_id, $product_id)
    {
        $orderItem = OrdersHasProducts::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->first();

        if (!$orderItem) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        return response()->json($orderItem);
    }

    // Mengupdate Order Item
    public function update(Request $request, $order_id, $product_id)
    {
        $orderItem = OrdersHasProducts::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->first();

        if (!$orderItem) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Order Item updated successfully', 'data' => $orderItem]);
    }

    // Menghapus Order Item
    public function delete($order_id, $product_id)
    {
        $orderItem = OrdersHasProducts::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->first();

        if (!$orderItem) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        $orderItem->delete();

        return response()->json(['message' => 'Order Item deleted successfully']);
    }
}
