<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function CartIndex(Request $request)
    {
        $dataCart = null;
        $branches = Branch::all();
        return view('customer.cart', compact('dataCart', 'branches'));
    }
}
