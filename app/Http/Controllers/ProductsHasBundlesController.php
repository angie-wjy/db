<?php

namespace App\Http\Controllers;

use App\Models\ProductsHasBundles;
use Illuminate\Http\Request;

class ProductsHasBundlesController extends Controller
{
    // Menampilkan semua bundling
    public function index()
    {
        return response()->json(ProductsHasBundles::with('mainProduct')->get());
    }

    // Menyimpan bundling baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
        ]);

        $bundling = ProductsHasBundles::create($validated);

        return response()->json($bundling, 201);
    }

    // Menampilkan bundling berdasarkan ID
    public function show($id)
    {
        $bundling = ProductsHasBundles::with('mainProduct')->findOrFail($id);
        return response()->json($bundling);
    }

    // Mengupdate data bundling
    public function update(Request $request, $id)
    {
        $bundling = ProductsHasBundles::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:45',
            'price' => 'sometimes|numeric|min:0',
            'product_id' => 'sometimes|exists:products,id',
        ]);

        $bundling->update($validated);

        return response()->json($bundling);
    }

    // Menghapus bundling
    public function delete($id)
    {
        $bundling = ProductsHasBundles::findOrFail($id);
        $bundling->delete();

        return response()->json(['message' => 'Bundling deleted successfully']);
    }
}
