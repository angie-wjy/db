<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function CartIndex(Request $request)
    {
        $dataCart = null;
        return view('customer.cart', compact('dataCart'));
    }
}
