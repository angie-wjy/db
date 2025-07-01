<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

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

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

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

    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function ShowBySlug(Request $request, $slug)
    {
        $selectedCategory = Category::where('slug', $slug)->firstOrFail();
        $dataCat = Category::all();
        $query = Product::whereHas('category', function ($q) use ($selectedCategory) {
            $q->where('id', $selectedCategory->id);
        });
        if ($request->has('cat') && is_array($request->input('cat'))) {
            $selectedFilterCodes = $request->input('cat');
            $query->whereHas('category', function ($q) use ($selectedFilterCodes) {
                $q->whereIn('code', $selectedFilterCodes);
            });
        }
        if ($request->has('price')) {
            $maxPrice = (float)$request->input('price');
            $query->where('price', '<=', $maxPrice);
        }
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'PRICE_UP':
                    $query->orderBy('price', 'asc');
                    break;
                case 'PRICE_DOWN':
                    $query->orderBy('price', 'desc');
                    break;
                case 'DATE_UP':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $dataProd = $query->filter(request(['search', 'sort']))->paginate(10)->appends(request()->query());
        $dataProd = $query->paginate(10)->withQueryString();
        return view('customer.product.category', compact('selectedCategory', 'dataCat', 'dataProd'));
    }
}
