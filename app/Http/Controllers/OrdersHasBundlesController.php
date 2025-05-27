<?php

namespace App\Http\Controllers;

use App\Models\OrdersHasBundles;
use Illuminate\Http\Request;

class OrdersHasBundlesController extends Controller
{
    // Menampilkan semua order bundling
    public function index()
    {
        $orderBundlings = OrdersHasBundles::with(['order', 'productBundling'])->get();
        return response()->json($orderBundlings);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_bundling_id' => 'required|exists:products_bundling,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderBundling = OrdersHasBundles::create([
            'order_id' => $request->order_id,
            'product_bundling_id' => $request->product_bundling_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Order Bundling added successfully', 'data' => $orderBundling], 201);
    }

    // Menampilkan satu data berdasarkan id
    public function show($order_id, $product_bundling_id)
    {
        $orderBundling = OrdersHasBundles::where('order_id', $order_id)
            ->where('product_bundling_id', $product_bundling_id)
            ->first();

        if (!$orderBundling) {
            return response()->json(['message' => 'Order Bundling not found'], 404);
        }

        return response()->json($orderBundling);
    }

    // Mengupdate data
    public function update(Request $request, $order_id, $product_bundling_id)
    {
        $orderBundling = OrdersHasBundles::where('order_id', $order_id)
            ->where('product_bundling_id', $product_bundling_id)
            ->first();

        if (!$orderBundling) {
            return response()->json(['message' => 'Order Bundling not found'], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderBundling->update([
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Order Bundling updated successfully', 'data' => $orderBundling]);
    }

    public function delete($order_id, $product_bundling_id)
    {
        $orderBundling = OrdersHasBundles::where('order_id', $order_id)
            ->where('product_bundling_id', $product_bundling_id)
            ->first();

        if (!$orderBundling) {
            return response()->json(['message' => 'Order Bundling not found'], 404);
        }

        $orderBundling->delete();

        return response()->json(['message' => 'Order Bundling deleted successfully']);
    }
}
