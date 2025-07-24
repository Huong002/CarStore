<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
   public function index()
   {
      return view('cart-bag');
   }
   public function bag()
   {
      return view('cart-bag');
   }
   public function checkout()
   {
      return view('checkout');
   }
   public function confirm()
   {
      return view('order-confirm');
   }
}
