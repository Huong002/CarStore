<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    // public function index(Request $request)
    // {

    //     // Lấy từ cả ô tìm kiếm và query string
    //     $search = $request->input('search') ?? $request->input('search_product');
    //     $products = Product::with(['category', 'brand', 'images', 'color'])
    //         ->where('stock_status', 'instock')
    //         ->when($search, function ($query) use ($search) {
    //             $query->where('name', 'like', '%' . $search . '%');
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(12);

    //     $maxPrice = Product::max('regular_price');
    //     $minPrice = Product::min('regular_price');

    //     $colors = Color::orderBy('name', 'asc')->get();
    //     $categories = Category::orderBy('name', 'asc')->get();
    //     $brands = Brand::orderBy('name', 'asc')->get();
    //     return view('shop', compact('products', 'categories', 'brands', 'colors', 'maxPrice', 'minPrice'));
    // }
    public function index(Request $request)
    {
        // Lấy các tham số từ request (ô tìm kiếm và query string)
        $search = $request->input('search') ?? $request->input('search_product');
        $categoriesParam = $request->input('categories');
        $colorsParam = $request->input('colors');
        $brandsParam = $request->input('brands');

        // Chuyển đổi chuỗi thành mảng nếu có dữ liệu hoặc lấy từ request array
        $selectedCategoryIds = [];
        if (is_array($request->input('categories'))) {
            $selectedCategoryIds = $request->input('categories');
        } elseif ($categoriesParam) {
            $selectedCategoryIds = explode(',', $categoriesParam);
        }

        $selectedColorIds = [];
        if (is_array($request->input('colors'))) {
            $selectedColorIds = $request->input('colors');
        } elseif ($colorsParam) {
            $selectedColorIds = explode(',', $colorsParam);
        }

        $selectedBrandIds = [];
        if (is_array($request->input('brands'))) {
            $selectedBrandIds = $request->input('brands');
        } elseif ($brandsParam) {
            $selectedBrandIds = explode(',', $brandsParam);
        }

        Log::info('Request Params: ', [
            'search' => $search,
            'categories' => $selectedCategoryIds,
            'colors' => $selectedColorIds,
            'brands' => $selectedBrandIds
        ]);

        // Xây dựng query
        $query = Product::with(['category', 'brand', 'images', 'color'])
            ->where('stock_status', 'instock');

        // Thêm điều kiện tìm kiếm theo tên
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc theo danh mục
        if (!empty($selectedCategoryIds)) {
            $query->whereIn('category_id', $selectedCategoryIds);
        }

        // Lọc theo màu sắc
        if (!empty($selectedColorIds)) {
            $query->whereIn('color_id', $selectedColorIds);
        }

        // Lọc theo thương hiệu
        if (!empty($selectedBrandIds)) {
            $query->whereIn('brand_id', $selectedBrandIds);
        }

        // Debug query
        Log::info('Generated SQL: ', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        // Phân trang kết quả
        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        // Lấy giá trị min-max để hiển thị slider giá
        $maxPrice = Product::max('regular_price');
        $minPrice = Product::min('regular_price');

        // Lấy danh sách màu sắc, danh mục và thương hiệu
        $allColors = Color::orderBy('name', 'asc')->get();
        $allCategories = Category::orderBy('name', 'asc')->get();
        $allBrands = Brand::orderBy('name', 'asc')->get();

        return view('shop', compact(
            'products',
            'allCategories',
            'allBrands',
            'allColors',
            'maxPrice',
            'minPrice',
            'search',
            'selectedCategoryIds',
            'selectedColorIds',
            'selectedBrandIds'
        ));
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
public function wishlistShow($id)
{
    $product = \App\Models\Product::with(['images', 'primaryImage'])->findOrFail($id);

    return view('wishlistshow', compact('product'));
}

 
}