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

    // public function ShowBySlug($slug)
    // {
    //     $category = Category::where('slug', $slug)->first();
    //     if (!$category) {
    //         return response()->json(['message' => 'Category not found'], 404);
    //     }
    //     return response()->json($category);
    // }

    public function ShowBySlug(Request $request, $slug)
    {
        // 1. Dapatkan kategori yang sedang aktif (dari slug URL)
        $selectedCategory = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil semua kategori untuk sidebar filter
        $dataCat = Category::all();

        // 3. Mulai query produk berdasarkan kategori yang dipilih
        $query = Product::whereHas('category', function ($q) use ($selectedCategory) {
            $q->where('id', $selectedCategory->id); // Filter berdasarkan ID kategori yang ditemukan
        });

        // 4. Terapkan Filter Tambahan dari Request (checkbox kategori di sidebar)
        if ($request->has('cat') && is_array($request->input('cat'))) {
            $selectedFilterCodes = $request->input('cat');
            // Jika checkbox kategori dipilih, override filter awal dengan yang dipilih di checkbox
            // Atau, jika Anda ingin memfilter *di dalam* kategori slug yang sedang aktif,
            // maka pastikan $selectedCategory->code juga ada di $selectedFilterCodes
            $query->whereHas('category', function ($q) use ($selectedFilterCodes) {
                $q->whereIn('code', $selectedFilterCodes);
            });
        }
        // Jika tidak ada filter 'cat' dari request, produk sudah difilter berdasarkan $selectedCategory->id
        // Jadi tidak perlu 'else' di sini

        // 5. Terapkan Filter Rentang Harga
        if ($request->has('price')) {
            $maxPrice = (float)$request->input('price');
            $query->where('price', '<=', $maxPrice);
        }

        // 6. Terapkan Pengurutan
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
                // Default ke pengurutan tertentu jika tidak ada yang cocok
            }
        } else {
            // Pengurutan default jika tidak ada parameter 'sort'
            $query->orderBy('created_at', 'desc');
        }

        $dataProd = $query->filter(request(['search', 'sort']))->paginate(15)->appends(request()->query());

        return view('customer.product.category', compact('selectedCategory', 'dataCat', 'dataProd'));
    }
}
