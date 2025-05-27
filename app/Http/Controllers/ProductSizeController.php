<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    // Menampilkan daftar Product Sizes
    public function index()
    {
        $productSizes = ProductSize::all();
        return view('admin.product.size.index', compact('productSizes'));
    }

    // Menampilkan form untuk menambah Product Size
    public function create()
    {
        return view('admin.product.size.create');
    }

    // Menyimpan Product Size baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ProductSize::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.product.size.index')->with('success', 'Product Size created successfully!');
    }

    // Menampilkan form untuk mengedit Product Size
    public function edit($id)
    {
        $productSize = ProductSize::findOrFail($id);
        return view('admin.product.size.edit', compact('productSize'));
    }

    // Memperbarui Product Size
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productSize = ProductSize::findOrFail($id);
        $productSize->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.product.size.index')->with('success', 'Product Size updated successfully!');
    }

    // Menghapus Product Size
    public function destroy($id)
    {
        $productSize = ProductSize::findOrFail($id);
        $productSize->delete();

        return redirect()->route('admin.product.size.index')->with('success', 'Product Size deleted successfully!');
    }
}
