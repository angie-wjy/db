<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        return response()->json(Category::all());
    }

    // Menambahkan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|unique:categories,id',
            'name' => 'required|string|max:100',
        ]);
        $create_data = $request->all();
        $create_data['slug'] = str_replace(' ', '-', strtolower($request->name));

        $category = Category::create($create_data);
        return response()->json($category, 201);
    }

    // Menampilkan kategori berdasarkan ID
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // Memperbarui kategori berdasarkan ID
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:100',
        ]);
        $edited_data = $request->all();
        $edited_data['slug'] = str_replace(' ', '-', strtolower($request->name));

        $category->update($edited_data);
        return response()->json($category);
    }

    // Menghapus kategori berdasarkan ID
    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function ShowBySlug($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }
}
