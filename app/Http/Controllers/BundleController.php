<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{
    public function BundleIndex(Request $request)
    {
        $query = Bundle::with('products');

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'PRICE_UP':
                    $query->orderBy('price', 'asc');
                    break;
                case 'PRICE_DOWN':
                    $query->orderBy('price', 'desc');
                    break;
                case 'NAME':
                    $query->orderBy('name', 'asc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $bundles = $query->paginate(10)->withQueryString();

        return view('customer.bundle.index', compact('bundles'));
    }

    public function ShowBundles()
    {
        $bundles = Bundle::with('products')->get();
        return view('welcome', compact('bundles'));
    }

    public function BundleBuy($id)
    {
        $bundle = Bundle::with('products')->findOrFail($id);
        $cart = Cart::firstOrCreate([
            'customer_user_id' => auth()->user()->id,
            'status' => 'cart'
        ]);


        foreach ($bundle->products as $product) {
            $cartItem = $cart->cartItems()->updateOrCreate(
                ['products_id' => $product->id],
                ['quantity' => \DB::raw('quantity + ' . $product->pivot->quantity)]
            );
        }

        return redirect()->route('customer.checkout.form')->with('success', 'Bundle added to cart!');
    }
}
