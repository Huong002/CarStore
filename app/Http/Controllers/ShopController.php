<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        // $products = Product::with(['category', 'brand', 'images'])
        // ->where('stock_status', 'instock')
        // ->orderBy('created_at', 'DESC')
        // ->paginate(12);
        // $categories = Category::orderBy('name', 'ASC')->get();
        // $brands = Brand::orderBy('name', 'ASC')->get();
        // return view('shop', compact('products', 'categories', 'brands'));
        $query = $request->input('search');
        $products = Product::with(['category', 'brand', 'images'])
            ->where('stock_status', 'instock');

        if ($query) {
            $products = $products->where('name', 'like', '%' . $query . '%');
        }

        $products = $products->orderBy('created_at', 'DESC')->paginate(12);
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('shop', compact('products', 'categories', 'brands'));
    }
    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts  = Product::where('slug', '<>', $product->slug)->get()->take(8);

        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('details', compact('product', 'rproducts', 'categories', 'brands'));
    }
}
