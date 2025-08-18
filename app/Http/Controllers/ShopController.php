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

    public function index(Request $request)
    {
        // Lấy các tham số từ request (ô tìm kiếm và query string)
        $search = $request->input('search') ?? $request->input('search_product');
        $categoriesParam = $request->input('categories');
        $colorsParam = $request->input('colors');
        $brandsParam = $request->input('brands');

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

        // Lấy tham số sắp xếp
        $sortBy = $request->input('sort', '');

        Log::info('Request Params: ', [
            'search' => $search,
            'categories' => $selectedCategoryIds,
            'colors' => $selectedColorIds,
            'brands' => $selectedBrandIds,
            'sort' => $sortBy
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

        // Áp dụng sắp xếp
        switch ($sortBy) {
            case '1': // Nổi bật
                $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
                break;
            case '2': // Bán chạy nhất
                $query->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
                    ->selectRaw('products.*, COALESCE(SUM(order_details.quantity), 0) as total_sold')
                    ->groupBy('products.id')
                    ->orderBy('total_sold', 'desc');
                break;
            case '3': // A-Z
                $query->orderBy('name', 'asc');
                break;
            case '4': // Z-A
                $query->orderBy('name', 'desc');
                break;
            case '5': // Giá thấp đến cao
                $query->orderByRaw('COALESCE(sale_price, regular_price) asc');
                break;
            case '6': // Giá cao đến thấp
                $query->orderByRaw('COALESCE(sale_price, regular_price) desc');
                break;
            case '7': // Ngày cũ đến mới
                $query->orderBy('created_at', 'asc');
                break;
            case '8': // Ngày mới đến cũ
                $query->orderBy('created_at', 'desc');
                break;
            default: // Mặc định
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Debug query
        Log::info('Generated SQL: ', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        // Phân trang kết quả
        $products = $query->paginate(12)->withQueryString();

        foreach ($products as $product) {
            $product->reviews_count = $product->reviews()->count();
            $product->average_rating = $product->reviews()->avg('rating') ? round($product->reviews()->avg('rating'), 1) : 0;
        }

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
            'selectedBrandIds',
            'sortBy'
        ));
    }
   
    public function product_details($product_slug)
    {
        try {
            // Lấy thông tin sản phẩm kèm theo các mối quan hệ cần thiết
            $product = Product::with([
                'primaryImage',
                'galleryImages',
                'brand',
                'category',
                'color'
            ])
                ->where('slug', $product_slug)
                ->firstOrFail();

            // Log thông tin sản phẩm được xem để phân tích
            Log::info('Product viewed', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'user_id' => Auth::check() ? Auth::id() : 'guest'
            ]);

            // Lấy các sản phẩm liên quan (không bao gồm sản phẩm hiện tại)
            $rproducts = Product::where('slug', '<>', $product->slug)
                ->where(function ($query) use ($product) {
                    // Ưu tiên sản phẩm cùng danh mục hoặc thương hiệu
                    $query->where('category_id', $product->category_id)
                        ->orWhere('brand_id', $product->brand_id);
                })
                ->inRandomOrder() 
                ->take(8)
                ->get();

            $categories = Category::orderBy('name', 'ASC')->get();
            $brands = Brand::orderBy('name', 'ASC')->get();

            return view('details', compact(
                'product',
                'rproducts',
                'categories',
                'brands'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Không tìm thấy sản phẩm', ['slug' => $product_slug]);
            return redirect()->route('shop.index')
                ->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            Log::error('Lỗi hiển thị chi tiết sản phẩm', [
                'slug' => $product_slug,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('shop.index')
                ->with('error', 'Có lỗi xảy ra khi hiển thị chi tiết sản phẩm.');
        }
    }
    public function scanImage(Request $request)
    {
        try {
            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy file ảnh'
                ], 400);
            }

            $image = $request->file('image');

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Định dạng file không hợp lệ. Chỉ hỗ trợ JPEG, PNG, JPG và GIF.'
                ], 400);
            }

            $client = new \GuzzleHttp\Client();

            $response = $client->post('http://127.0.0.1:5000/predict', [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($image->getPathname(), 'r'),
                        'filename' => $image->getClientOriginalName()
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            Log::info('Image Recognition Result:', $result);

            return response()->json($result);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('API không phản hồi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể kết nối đến máy chủ nhận diện. Vui lòng thử lại sau.'
            ], 503);
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý ảnh: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xử lý ảnh: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        $product = Product::with(['reviews.user'])
            ->findOrFail($id);

        // Tính rating trung bình và số lượng review
        $reviewsCount = $product->reviews->count();
        $averageRating = $reviewsCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;

        return view('shop.detail', compact('product', 'reviewsCount', 'averageRating'));
    }
    public function wishlistShow($id)
    {
        $product = \App\Models\Product::with(['images', 'primaryImage'])->findOrFail($id);

        return view('wishlistshow', compact('product'));
    }
}
