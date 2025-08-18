<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
   public function index()
{
    $products = Product::with(['category', 'brand', 'images', 'primaryImage'])
        ->where('stock_status', 'instock')
        ->orderBy('created_at', 'DESC')
        ->paginate(12); 

    return view('index', compact('products'));
}
    
}