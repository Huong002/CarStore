<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(){
        // $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        $products = Product::with(['category', 'brand', 'images'])
        ->where('stock_status', 'instock')
        ->orderBy('created_at', 'DESC')
        ->paginate(12);
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('shop', compact('products', 'categories', 'brands'));
    }
    public function product_details($product_slug)
{
    // $product = Product::with(['primaryImage', 'images'])->where('slug', $product_slug)->firstOrFail();
    $product = Product::with(['primaryImage', 'galleryImages'])
                  ->where('slug', $product_slug)
                  ->firstOrFail();

    $rproducts  = Product::where('slug', '<>', $product->slug)->take(8)->get();

    $categories = Category::orderBy('name', 'ASC')->get();
    $brands = Brand::orderBy('name', 'ASC')->get();
      // Thêm dòng này để kiểm tra dữ liệu
    // dd($product->primaryImage, $product->galleryImages);

    return view('details', compact('product', 'rproducts', 'categories', 'brands'));
}

public function show($id)
{
    $product = Product::with(['reviews.user'])
        ->findOrFail($id);

    return view('shop.detail', compact('product'));
}

 
}