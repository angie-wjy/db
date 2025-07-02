<?php

namespace App\Http\Controllers;

use App\Models\ProductTheme;
use Illuminate\Http\Request;

class ProductThemeController extends Controller
{
    // Menampilkan daftar Product Themes
    public function index()
    {
        $productThemes = ProductTheme::all();
        return view('admin.product.theme.index', compact('productThemes'));
    }

    // Menampilkan form untuk menambah Product Theme
    public function create()
    {
        return view('admin.product.size.create');
    }

    // Menyimpan Product Theme baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ProductTheme::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.product.theme.index')->with('success', 'Product Theme Created Successfully!');
    }

    // Menampilkan form untuk mengedit Product Theme
    public function edit($id)
    {
        $productTheme = ProductTheme::findOrFail($id);
        return view('admin.product.theme.edit', compact('productTheme'));
    }

    // Memperbarui Product Theme
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productTheme = ProductTheme::findOrFail($id);
        $productTheme->update([
            'name' => $request->name,
        ]);

        return response()->json($productTheme);

        // return redirect()->route('admin.product.theme.index')->with('success', 'Product Theme updated successfully!');
    }

    // Menghapus Product Theme
    public function destroy($id)
    {
        $productTheme = ProductTheme::findOrFail($id);
        $productTheme->delete();

        return redirect()->route('admin.product.theme.index')->with('success', 'Product Theme deleted successfully!');
    }
}
