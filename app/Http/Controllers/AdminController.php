<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Soap\Sdl;
use App\Models\Notification;
use App\Http\Controllers\StatisticsController;
use App\Models\UserNotification;
use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Cache\Events\RetrievingKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Mockery\Matcher\Not;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Email;

// use Intervention\Image\Laravel\Facades\Image;1


class AdminController extends Controller
{
    public function index()
    {
        $orderTotal = StatisticsController::totalOrder();
        $orderPending = StatisticsController::orderPending();
        $orderCancelled = StatisticsController::orderCancelled();
        $orderComplated = StatisticsController::orderCompleted();
        $currentOrders = StatisticsController::currentOrder();
        $orderApprored = StatisticsController::orderApproed();
        $totalStatis = StatisticsController::totalRevenue();
        $totalStatisApproved = StatisticsController::totalRevenueApproved();
        $totalStatisComplated = StatisticsController::totalRevenueCompleted();
        $totalStatisCancelled = StatisticsController::totalRevenueCancelled();
        $totalStatisPending = StatisticsController::totalRevenuePending();

        // Lấy dữ liệu biểu đồ
        $chartData = StatisticsController::getMonthlyChartData();

        return view('admin.index', compact(
            'orderTotal',
            'orderPending',
            'orderCancelled',
            'orderComplated',
            'currentOrders',
            'orderApprored',
            'totalStatis',
            'totalStatisCancelled',
            'totalStatisApproved',
            'totalStatisComplated',
            'totalStatisPending',
            'chartData'
        ));
    }

    #region ThuongHieu
    public function brands(Request $request)
    {
        $search = $request->get('name');
        $query = Brand::query();
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $brands = $query->withCount('products')->orderBy('id', 'DESC')->whereNull('deleted_at')->paginate(6);
        return view('admin.brands', compact('brands'));
    }
    public function add_brand()
    {
        return view('admin.brand-add');
    }


    public function brand_store(Request $request)
    {
        $request->validate([
            'name'  => 'nullable',
            'slug'  => 'nullable|unique:brands,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);


        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;

        $destinationPath = public_path('uploads/brands');
        $image->move($destinationPath, $file_name);

        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Thêm hãng thành công');
    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate([
            'name'  => 'nullable',
            'slug'  => 'nullable|unique:brands,slug,' . $request->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($request->id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found');
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extenstion = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extenstion;
            $destinationPath = public_path('uploads/brands');
            $image->move($destinationPath, $file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Cập nhật hãng thành công');
    }


    public function brand_soft_delete($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with('error', 'Không tìm thấy thương hiệu');
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Đã chuyển thương hiệu xuống thùng rác');
    }

    public function brand_delete($id)
    {
        $brand = Brand::onlyTrashed()->find($id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Không tìm thấy thương hiệu');
        }
        // if(File::exits(public_path('uploads/brands').'/'.$brand->image)){
        //     File::delete(public_path('uploads/brands').'/'.$brand->image);
        // }

        if ($brand->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/brands/' . $brand->image))) {
            \Illuminate\Support\Facades\File::delete(public_path('uploads/brands/' . $brand->image));
        }
        $brand->forceDelete();
        return redirect()->route('admin.brands')->with('status', 'Đã xóa thương hiệu thành công');
    }
    public function brand_his()
    {
        $brands = Brand::onlyTrashed()->orderBy('name')->paginate(6);

        return view('admin.brand-history', compact('brands'));
    }
    public function brand_restore($id)
    {

        $brand = Brand::onlyTrashed()->find($id);

        $brand->restore();
        return redirect()->route('admin.product.history')->with('status', 'Đã khôi phục thành công');
    }



    #endregion




    #region DanhMuc
    // danh muc
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(6);
        return view('admin.categories', compact('categories'));
    }
    public function category_add()
    {
        $parentCategories = \App\Models\Category::orderBy('name')->get();
        return view('admin.category-add', compact('parentCategories'));
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name'  => 'nullable',
            'slug'  => 'nullable|unique:categories,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $destinationPath = public_path('uploads/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);
            $category->image = $file_name;
        }

        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Thêm danh mục thành công');
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:categories,slug,' . $request->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục');
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extenstion = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extenstion;
            $destinationPath = public_path('uploads/categories');
            $image->move($destinationPath, $file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Cập nhập danh mục thành công');
    }
    public function category_delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục');
        }
        // if(File::exits(public_path('uploads/brands').'/'.$brand->image)){
        //     File::delete(public_path('uploads/brands').'/'.$brand->image);
        // }
        if ($category->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/categories/' . $category->image))) {
            \Illuminate\Support\Facades\File::delete(public_path('uploads/categories/' . $category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Đã xóa danh mục thành công');
    }
    #endregion



    #region SanPham
    public function products(Request $request)
    {
        $search = $request->get('name');
        $query = Product::with(['category', 'brand', 'images'])->orderBy('created_at', 'DESC');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('SKU', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($catQuery) use ($search) {
                        $catQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('brand', function ($brandQuery) use ($search) {
                        $brandQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $products = $query->paginate(6);

        return view('admin.products', compact('products'));
    }
    public function product_add()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'SKU' => 'required|string|max:255',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured ?? 0;
        $product->quantity = $request->quantity ?? 10;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;


        $product->save();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '_main.' . $file_extension;
            $destinationPath = public_path('uploads/products');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $file_name);


            Image::create([
                'product_id' => $product->id,
                'imageName' => $file_name,
                'is_primary' => true // Đánh dấu đây là ảnh chính
            ]);
        }

        // Lưu các ảnh phụ vào bảng images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $destinationPath = public_path('uploads/products');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($images as $image) {
                $file_extension = $image->extension();
                $file_name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file_extension;
                $image->move($destinationPath, $file_name);

                Image::create([
                    'product_id' => $product->id,
                    'imageName' => $file_name,
                    'is_primary' => false // Đánh dấu đây là ảnh phụ
                ]);
            }
        }

        return redirect()->route('admin.products')->with('status', 'Thêm sản phẩm thành công!');
    }
    public function product_edit($id)
    {
        $product = Product::with(['category', 'brand', 'images'])->find($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $request->id . '|max:255',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'SKU' => 'required|string|max:255',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
        }

        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured ?? 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $product->save();

        // Xử lý ảnh chính
        if ($request->hasFile('image')) {
            // Xóa ảnh chính cũ
            $oldPrimaryImage = $product->images()->where('is_primary', true)->first();
            if ($oldPrimaryImage) {
                if (\Illuminate\Support\Facades\File::exists(public_path('uploads/products/' . $oldPrimaryImage->imageName))) {
                    \Illuminate\Support\Facades\File::delete(public_path('uploads/products/' . $oldPrimaryImage->imageName));
                }
                $oldPrimaryImage->delete();
            }

            // Upload ảnh chính mới
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '_main.' . $file_extension;
            $destinationPath = public_path('uploads/products');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $file_name);

            Image::create([
                'product_id' => $product->id,
                'imageName' => $file_name,
                'is_primary' => true
            ]);
        }

        // Xử lý bộ sưu tập ảnh
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $destinationPath = public_path('uploads/products');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($images as $image) {
                $file_extension = $image->extension();
                $file_name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file_extension;
                $image->move($destinationPath, $file_name);

                Image::create([
                    'product_id' => $product->id,
                    'imageName' => $file_name,
                    'is_primary' => false
                ]);
            }
        }

        return redirect()->route('admin.products')->with('status', 'Cập nhật sản phẩm thành công!');
    }

    public function product_delete($id)
    {
        $product = Product::onlyTrashed()->find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm bạn cần');
        }

        // Xóa tất cả ảnh của sản phẩm
        foreach ($product->images as $image) {
            if (\Illuminate\Support\Facades\File::exists(public_path('uploads/products/' . $image->imageName))) {
                \Illuminate\Support\Facades\File::delete(public_path('uploads/products/' . $image->imageName));
            }
            $image->forceDelete();
        }

        $product->forceDelete();
        return redirect()->route('admin.products')->with('status', 'Xóa sản phẩm thành công');
    }
    // lay danh sach cac san pham co isDeleted = true
    public function product_his()
    {
        $products = Product::onlyTrashed()->with(['category', 'brand', 'images'])
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);

        return view('admin.product-history', compact('products'));
    }
    //xoa mem  -> chi dua vao thung rac
    public function product_soft_delete($id)
    {
        $product  = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm bạn cần xóa');
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Chuyển vào thùng rác thành công');
    }
    // khoi phuc 
    public function product_restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.product.history')->with('status', 'Khôi phục sản phẩm thành công!');
    }
    #endregion



    #region Hoa Don


    // public function orders()
    // {
    //     $pendingCount = Order::where('status', 'pending')->count();
    //     $approvedCount = Order::where('status', 'approved')->count();
    //     $cancelledCount = Order::where('status', 'cancelled')->count();
    //     $orders = Order::with(['orderDetails.product', 'customer', 'employee'])
    //         ->orderBy('created_at', 'DESC')
    //         ->paginate(6);
    //     return view('admin.orders', compact('orders', 'pendingCount', 'approvedCount', 'cancelledCount'));
    // }
    public function orders(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('name');
        $query = Order::with(['customer', 'employee']);

        if ($status && $status != 'all') {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('customerName', 'like', '%' . $search . '%');
                    });
            });
        }




        $orders = $query->orderBy('created_at', 'DESC')->paginate(6);

        // Đếm số lượng theo từng trạng thái
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders', compact('orders', 'statusCounts'));
    }

    public function check_order(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng');
        }
        if (!$user || !$user->employee_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền duyệt đơn hàng này');
        }


        if ($order->status == 'pending') {
            $order->status = 'approved';
            $order->employee_id = $user->employee_id;
            $order->save();
            return redirect()->back()->with('status', 'Đã chuyển đơn hàng sang trạng thái đã xử lý');
        }

        return redirect()->back()->with('info', 'Đơn hàng đã được xử lý trước đó');
    }


    public function order_store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'order_date' => 'required|date',
            'total_item' => 'required|integer|min:1',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->employee_id = $request->employee_id;
        $order->tax = $request->tax ?? 0;
        $order->status = $request->status;
        $order->order_date = $request->order_date;
        $order->total_item = $request->total_item;
        $order->save();

        // tao order detail;
        foreach ($request->products as $productData) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productData['product_id'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
                'total' => $productData['quantity'] * $productData['price'],
            ]);

            // Cập nhật số lượng sản phẩm trong kho (tuỳ chọn)
            $product = Product::find($productData['product_id']);
            if ($product) {
                $product->quantity -= $productData['quantity'];
                if ($product->quantity <= 0) {
                    $product->stock_status = 'outofstock';
                }
                $product->save();
            }
        }


        return  redirect()->route('admin.orders') . with('message', 'Thêm mới đơn hàng thành công');
    }
    public function order_detail($id)
    {
        $order = Order::with([
            'orderDetails.product.category',
            'orderDetails.product.brand',
            'orderDetails.product.images',
            'customer',
            'employee'
        ])->findOrFail($id);

        return view('admin.order-detail', compact('order'));
    }

    // phan don hang theo trang thai
    public function order_status(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Order::with(['orderDetails.product', 'customer', 'employee']);


        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $orders = $query->orderBy('created_at', 'DESC')->paginate(6);


        return  view('admin.orders', compact('orders', 'status'));
    }
    // danh sach don hang chua duyet
    public function orders_pending()
    {
        $orders = Order::with(['orderDetails.product', 'customer', 'employee'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return view('admin.orders-pending', compact('orders'));
    }

    // lay don hang da duyet
    public function order_approved()
    {
        $orders  = Order::with(['orderDetails.product', 'customer', 'employee'])->where('status', 'approved')->orderBy('created_at', "DESC")->paginate(6);
        if ($orders == null) {
            return redirect('admin.orders')->back()->with('error', "Không có sản phẩm nào đã duyệt");
        }
        return view('admin.order-approved', compact('orders'));
    }
    // aly don hang da huy
    public function orders_cancelled()
    {
        $orders = Order::with(['orderDetails.product', 'customer', 'employee'])
            ->where('status', 'cancelled')
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return view('admin.orders-cancelled', compact('orders'));
    }
    // dueyt don hang
    public function order_approve($id)
    {
        $order = Order::find($id);
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể duyệt đơn hàng đang chờ duyệt');
        }
        $order->update(['status' => 'approved']);

        return redirect()->back()->with('staus', 'Đã duyệt đơn hàng thành công');
    }
    // huy don hang 
    public function order_cancel($id)
    {
        $order = Order::find($id);
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Đơn hàng đã bị hủy');
        }
        foreach ($order->orderDetails as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->quantity += $detail->quantity;
                if ($product->quantity > 0 && $product->stock_status === 'outofstock') {
                    $product->stock_status = 'instock';
                }
                $product->save();
            }
        }
        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('status', 'Đã hủy đơn hàng và hoàn lại kho');
    }


    // nguoi dung
    public function users(Request $request)
    {
        $search = $request->get('name');
        $query = User::with(['customer', 'employee'])->orderBy('created_at', 'DESC');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('customerName', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    });
            });
        }

        $users = $query->paginate(6);

        return view('admin.users', compact('users'));
    }

    public function user_edit($id)
    {
        $user = User::with(['customer', 'employee'])->findOrFail($id);
        $customers = Customer::orderBy('customerName', 'ASC')->get();
        $employees = Employee::orderBy('name', 'ASC')->get();
        return view('admin.user-edit', compact('user', 'customers', 'employees'));
    }

    public function user_update(Request $request)
    {
        try {
            // Debug: Kiểm tra request
            Log::info('Update user request:', [
                'user_id' => $request->id,
                'has_file' => $request->hasFile('image'),
                'all_files' => $request->allFiles(),
                'all_data' => $request->all()
            ]);

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $request->id,
                // 'password' => 'nullable|string|min:6',
                // 'utype' => 'required|in:CTM,EMP,ADM',
                // 'customer_id' => 'nullable|exists:customers,id',
                // 'employee_id' => 'nullable|exists:employees,id',
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ]);
            $user = User::findOrFail($request->id);

            Log::info('User before update:', [
                'current_image' => $user->image
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->hasFile('image')) {
                Log::info('Processing image upload');
                $image = $request->file('image');
                $file_extenstion = $image->extension();
                $file_name = Carbon::now()->timestamp . '.' . $file_extenstion;
                $destinationPath = public_path('images/avatar');

                Log::info('Image details:', [
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $file_extenstion,
                    'new_filename' => $file_name,
                    'destination' => $destinationPath
                ]);

                $image->move($destinationPath, $file_name);
                $user->image = $file_name;

                Log::info('Image uploaded successfully:', [
                    'filename' => $file_name,
                    'user_image_field' => $user->image
                ]);
            }
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            Log::info('User after save:', [
                'user_id' => $user->id,
                'image' => $user->image
            ]);

            return redirect()->back()->with('message', 'Đã cập nhập thông tin tài khoản thành công');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Lỗi cơ sở dữ liệu: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function user_lock($id)
    {
        $user = User::findOrFail($id);
        $user->isLock = true;
        $user->save();

        return redirect()->back()->with('status', 'Đã khóa tài khoản thành công');
    }
    public function user_unlock($id)
    {
        $user = User::findOrFail($id);
        $user->isLock = false;
        $user->save();

        return redirect()->back()->with('status', 'Đã mở khóa tài khoản thành công');
    }


    #endregion

    #region Thong bao
    public function notifications(Request $request)
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(6);
        return view('admin.notifications', compact('notifications'));
    }
    public function notification_add()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('admin.notification-add', compact('users'));
    }

    public function notification_store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:customer,employee,admin,all'
        ]);

        // Tạo thông báo mới
        $notification = new Notification();
        $notification->name = $request->name;
        $notification->content = $request->content;
        $notification->type = $request->type;
        $notification->save();

        // Tự động tạo UserNotification cho các users phù hợp
        $userIds = [];

        if ($request->type === 'all') {
            // Lấy tất cả users
            $userIds = User::pluck('id')->toArray();
        } elseif ($request->type === 'admin') {
            // Lấy users có utype = 'ADM'
            $userIds = User::where('utype', 'ADM')->pluck('id')->toArray();
        } elseif ($request->type === 'employee') {
            // Lấy users có utype = 'EMP'
            $userIds = User::where('utype', 'EMP')->pluck('id')->toArray();
        } elseif ($request->type === 'customer') {
            // Lấy users có utype = 'CTM'
            $userIds = User::where('utype', 'CTM')->pluck('id')->toArray();
        }

        // Tạo UserNotification cho mỗi user
        foreach ($userIds as $userId) {
            UserNotification::create([
                'user_id' => $userId,
                'notification_id' => $notification->id,
                'isRead' => false,
                'isArchived' => false
            ]);
        }

        return redirect()->route('admin.notifications')->with('status', 'Bạn đã thêm thông báo thành công');
    }

    public function notification_edit($id)
    {
        $notification = Notification::find($id);
        return view('admin.notification-edit', compact('notification'));
    }
    public function notification_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',

        ]);
        $notification = Notification::find($request->id);
        if (!$notification) {
            return redirect()->back()->with('error', 'Không tìm thấy id bạn cần');
        }
        $notification->name = $request->name;
        $notification->content = $request->content;
        $notification->type = $request->type;

        $notification->save();
        return redirect()->route('admin.notifications')->with('status', 'Cập nhật thành công');
    }
    // xoa thong bao
    public function notification_delete($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return redirect()->back()->with('error', 'Không tìm thấy id bạn cần');
        }
        $notification->delete();
        return redirect()->route('admin.notifications')->with('status', 'Chúc mừng bạn xóa thành công');
    }
    // danh sach 
    public function notification_history()
    {
        $notifications = Notification::onlyTrashed()->orderBy('created_at', 'desc')->paginate(6);
        return view('admin.notification-history', compact('notifications'));
    }


    public function notification_restore($id)
    {
        $notification = Notification::onlyTrashed()->find($id);
        if (!$notification) {
            return redirect()->back()->with('error', 'Không tìm thấy thông báo bạn cần');
        }
        $notification->restore();
        return redirect()->route('admin.notification.history')->with('status', 'Chúc mừng đã khôi phục thông báo thành công');
    }
    public function notificaion_list_user($id)
    {
        $notifications = UserNotification::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('admin.notifications', compact($notifications));
    }
    public function notifitionByUser()
    {
        // Lấy thông tin user đang đăng nhập
        $currentUser = \Illuminate\Support\Facades\Auth::user();

        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông báo');
        }

        // Xác định loại thông báo dựa vào quyền của người dùng
        $notificationTypes = ['all']; // Loại thông báo chungp cho tất cả

        if ($currentUser->utype === 'ADM') {
            $notificationTypes[] = 'admin';
        } elseif ($currentUser->employee_id) {
            $notificationTypes[] = 'employee';
        } elseif ($currentUser->customer_id) {
            $notificationTypes[] = 'customer';
        }

        // Lấy các notification phù hợp với quyền của user (Cách tối ưu hơn)
        $user_notifications = UserNotification::where('user_id', $currentUser->id)
            ->whereHas('notification', function ($query) use ($notificationTypes) {
                $query->whereIn('type', $notificationTypes);
            })
            ->with('notification')
            ->orderBy('created_at', 'desc')->take(5)
            ->paginate(6);

        return view('admin.notifications', ['notifications' => $user_notifications]);
    }
    public function list_user_notifi(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông báo của mình');
        }

        // Tự động xóa thông báo đã lưu trữ quá 15 ngày
        $fifteenDaysAgo = Carbon::now()->subDays(15);
        UserNotification::where('user_id', $currentUser->id)
            ->where('isArchived', true)
            ->where('updated_at', '<', $fifteenDaysAgo)
            ->delete();

        $tab = $request->get('tab', 'all');

        // Lọc theo user và notification chưa bị xóa
        $query = UserNotification::with('notification')
            ->where('user_id', $currentUser->id)
            ->whereHas('notification', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->orderBy('created_at', 'desc');

        // Phân loại theo tab
        if ($tab === 'archived') {
            $query->where('isArchived', true);
        } elseif ($tab === 'unread') {
            $query->where('isRead', false);
        } elseif ($tab === 'read') {
            $query->where('isRead', true);
        }

        $userNotifications = $query->paginate(10);

        return view('admin.user-notification', compact('userNotifications', 'tab'));
    }
    public function markAsRead($id)
    {
        $userNotification = UserNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $userNotification->isRead = true;
        $userNotification->save();

        return redirect()->back()->with('status', 'Đã đánh dấu thông báo là đã đọc!');
    }

    public function archiveNotification($id)
    {
        $userNotification = UserNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $userNotification->isArchived = true;
        $userNotification->save();

        // Tự động xóa thông báo đã lưu trữ quá 15 ngày của user hiện tại
        $fifteenDaysAgo = Carbon::now()->subDays(15);
        UserNotification::where('user_id', Auth::id())
            ->where('isArchived', true)
            ->where('updated_at', '<', $fifteenDaysAgo)
            ->delete();

        return redirect()->back()->with('status', 'Lưu trữ thành công. Hệ thống tự động xóa sau 15 ngày!');
    }

    public function inbox()
    {
        return view('admin.inbox');
    }
    public function settings()
    {
        $user = Auth::user();
        // Load relationship employee nếu có
        $user->load('employee');
        return view('admin.setting', compact('user'));
    }

    public function settings_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cập nhật thông tin cơ bản của user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Cập nhật thông tin phone trong bảng employees nếu user có employee_id
        if ($user->employee_id && $user->employee) {
            $user->employee->name = $request->name;
            $user->employee->phone = $request->mobile;
            $user->employee->email = $request->email;
            $user->employee->save();
        }

        // Kiểm tra và cập nhật mật khẩu nếu có
        if ($request->filled('old_password') && $request->filled('new_password')) {
            // Kiểm tra mật khẩu cũ
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['old_password' => 'Mật khẩu cũ không đúng!'])
                    ->withInput();
            }

            // Cập nhật mật khẩu mới
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->route('admin.setting')->with('status', 'Cập nhật thông tin thành công!');
    }


    #endregion
}
