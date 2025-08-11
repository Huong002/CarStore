<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        // Không cần lấy dữ liệu từ database vì sẽ lấy từ localStorage trong JS
        // Chỉ cần lấy tất cả sản phẩm để hiển thị chi tiết khi cần
        $products = Product::with(['category', 'brand', 'images', 'primaryImage'])->get();

        return view('wishlist', compact('products'));
    }
}
