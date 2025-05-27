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

    public function CartUpdate(Request $request, $cart_id, $product_id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->update(['jumlah' => $request->jumlah]);
        return response()->json(['message' => 'Cart item updated', 'data' => $cartItem]);
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
