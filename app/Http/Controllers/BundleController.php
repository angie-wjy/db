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

        $bundles = $query->paginate(8)->withQueryString();

        return view('customer.bundle.index', compact('bundles'));
    }

    public function ShowBundles()
    {
        // $bundles = Bundle::with('products')->get();
        $bundles = Bundle::with('products')->take(1)->get();
        return view('welcome', compact('bundles'));
    }

    public function BundleBuy($id)
    {
        $bundle = Bundle::with('products')->findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart['bundle_' . $id])) {
            $cart['bundle_' . $id]['quantity'] ++;
        } else {
            $cart['bundle_' . $id] = [
                'id' => 'bundle_' . $bundle->id,
                'name' => $bundle->name,
                'quantity' => 1,
                'price' => $bundle->price,
                'image' => $bundle->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product has been successfully added to the cart!');
    }
}
