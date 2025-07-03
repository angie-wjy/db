<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;

class CartItemController extends Controller
{
    public function CartMinus($product_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            if ($cart[$product_id]['quantity'] > 1) {
                $cart[$product_id]['quantity']--;
            } else {
                unset($cart[$product_id]);
            }
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item updated');
    }

    public function CartPlus($product_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity']++;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item updated');
    }

    public function CartDelete($product_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Item removed');
        }

        return back()->with('error', 'Item not found in cart');
    }
}
