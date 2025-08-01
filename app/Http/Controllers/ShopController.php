<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {

        // Lấy từ cả ô tìm kiếm và query string
        $search = $request->input('search') ?? $request->input('search_product');
        $products = Product::with(['category', 'brand', 'images', 'color'])
            ->where('stock_status', 'instock')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $maxPrice = Product::max('regular_price');
        $minPrice = Product::min('regular_price');

        $colors = Color::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('shop', compact('products', 'categories', 'brands', 'colors', 'maxPrice', 'minPrice'));
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
