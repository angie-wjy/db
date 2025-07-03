<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\DB;

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
        $product = Product::with('category', 'branches')->findOrFail($id);

        return view('customer.product.detail', compact('product'));
    }

    public function ProductAdd(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = session()->get('cart', []);
        $amount = $request->input('jumlah', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $amount;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $amount,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product has been successfully added to the cart!');
        // return view('customer.product.detail', compact('product'));
    }

    public function RestockForm($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.restock', compact('product'));
    }

    public function RestockStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $product->stock += $request->quantity;
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product restocked successfully.');
    }
}
