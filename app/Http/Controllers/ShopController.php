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
                ->inRandomOrder() // Xáo trộn kết quả để đa dạng
                ->take(8)
                ->get();

            // Lấy danh sách danh mục và thương hiệu cho menu
            $categories = Category::orderBy('name', 'ASC')->get();
            $brands = Brand::orderBy('name', 'ASC')->get();

            return view('details', compact(
                'product',
                'rproducts',
                'categories',
                'brands'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Xử lý khi không tìm thấy sản phẩm
            Log::error('Product not found', ['slug' => $product_slug]);
            return redirect()->route('shop.index')
                ->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            // Xử lý lỗi chung
            Log::error('Error displaying product details', [
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
            // Kiểm tra xem có file ảnh được gửi lên không
            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy file ảnh'
                ], 400);
            }

            $image = $request->file('image');

            // Kiểm tra định dạng file
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Định dạng file không hợp lệ. Chỉ hỗ trợ JPEG, PNG, JPG và GIF.'
                ], 400);
            }

            // Tạo một HTTP client để gửi ảnh đến API nhận diện
            $client = new \GuzzleHttp\Client();

            // Gửi ảnh đến API nhận diện (Python Flask)
            $response = $client->post('http://127.0.0.1:5000/predict', [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($image->getPathname(), 'r'),
                        'filename' => $image->getClientOriginalName()
                    ]
                ]
            ]);

            // Lấy kết quả nhận diện
            $result = json_decode($response->getBody(), true);

            // Log kết quả để debug
            Log::info('Image Recognition Result:', $result);

            // Kiểm tra kết quả từ API Python
            // Nếu Flask trả về car_name thì coi như nhận diện thành công (bỏ qua error từ Flask)
            if (!isset($result['car_name']) || empty($result['car_name'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể nhận diện sản phẩm từ ảnh.',
                    'detected_product' => 'Không xác định'
                ], 404);
            }

            // Tìm sản phẩm trong database Laravel
            $detectedCarName = $result['car_name'];
            Log::info('Tìm sản phẩm:', ['detected_name' => $detectedCarName]);

            // Tìm sản phẩm bằng cách so sánh tên (flexible matching)
            $product = Product::where(function ($query) use ($detectedCarName) {
                $query->where('name', 'LIKE', '%' . $detectedCarName . '%')
                    ->orWhere('name', 'LIKE', '%BMW 3 Series Wagon%')
                    ->orWhere('name', 'LIKE', '%BMW%')
                    ->orWhere('name', 'LIKE', '%3 Series%')
                    ->orWhere('name', 'LIKE', '%Wagon%');
            })->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm nhận diện được nhưng không có trong cửa hàng.',
                    'detected_product' => $detectedCarName
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'car_name' => $detectedCarName,
                    'product' => $product,
                    'message' => 'Tìm thấy sản phẩm trong cửa hàng!'
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Xử lý lỗi 404 từ Flask - nhưng vẫn có thể có car_name
            if ($e->getResponse()->getStatusCode() == 404) {
                $responseBody = json_decode($e->getResponse()->getBody(), true);
                Log::info('Flask trả về 404 nhưng có car_name: ', $responseBody);

                // Nếu Flask trả về car_name mặc dù có lỗi, vẫn tìm trong database Laravel
                if (isset($responseBody['car_name']) && !empty($responseBody['car_name'])) {
                    $detectedCarName = $responseBody['car_name'];

                    // Tìm sản phẩm trong database Laravel
                    $product = Product::where(function ($query) use ($detectedCarName) {
                        $query->where('name', 'LIKE', '%' . $detectedCarName . '%')
                            ->orWhere('name', 'LIKE', '%BMW 3 Series Wagon%')
                            ->orWhere('name', 'LIKE', '%BMW%')
                            ->orWhere('name', 'LIKE', '%3 Series%')
                            ->orWhere('name', 'LIKE', '%Wagon%');
                    })->first();

                    if ($product) {
                        return response()->json([
                            'success' => true,
                            'data' => [
                                'car_name' => $detectedCarName,
                                'product' => $product,
                                'message' => 'Tìm thấy sản phẩm trong cửa hàng!'
                            ]
                        ]);
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm nhận diện được nhưng không có trong cửa hàng.',
                    'detected_product' => $responseBody['car_name'] ?? 'Không xác định'
                ], 404);
            }

            Log::error('Lỗi API client: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi từ máy chủ nhận diện: ' . $e->getMessage()
            ], 400);
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
