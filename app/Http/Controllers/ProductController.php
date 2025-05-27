<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::with('products')->get();
        $product_themes = ProductTheme::with('products')->get();
        $product_sizes = ProductSize::with('products')->get();
        // dd($categories);
        // dd($product_themes);
        return view('admin.product.index', compact('products', 'categories', 'product_themes', 'product_sizes'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    public function TopSell()
    {
        $products = Product::select('products.*', FacadesDB::raw('SUM(orders_items.quantity) as total_sold'))
            ->join('orders_items', 'products.id', '=', 'orders_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        return view('welcome', compact('products'));
    }

    public function ProductDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('customer.product.detail', compact('product'));
    }

    public function ProductAdd(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }
        session()->put('cart', $cart);
        return view('customer.product.detail', compact('product'));
        // return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function ByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->get();

        return view('products.byCategory', compact('category', 'products'));
    }
}
