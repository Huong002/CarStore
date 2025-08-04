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
use Illuminate\Cache\Events\RetrievingKey;
use Mockery\Matcher\Not;

// use Intervention\Image\Laravel\Facades\Image;1


class AdminController extends Controller
{
    public function index()
    {
        $orderTotal = StatisticsController::totalOrder();
        $orderPending = StatisticsController::orderPenfing();
        $orderCancelled = StatisticsController::orderCancelled();
        $orderComplated = StatisticsController::orderCompleted();
        $currentOrders = StatisticsController::currentOrder();
        $orderApprored = StatisticsController::orderApproed();
        $totalStatis = StatisticsController::totalRevenue();
        $totalStatisApproved = StatisticsController::totalRevenueApproved();
        $totalStatisComplated = StatisticsController::totalRevenueCompleted();
        $totalStatisCancelled = StatisticsController::totalRevenueCancelled();
        $totalStatisPending = StatisticsController::totalRevenuePending();
        return view('admin.index', compact('orderTotal', 'orderPending', 'orderCancelled', 'orderComplated', 'currentOrders', 'orderApprored', 'totalStatis', 'totalStatisCancelled', 'totalStatisApproved', 'totalStatisComplated', 'totalStatisPending'));
    }

    #region ThuongHieu
    public function brands(Request $request)
    {
        $search = $request->get('name');
        $query = Brand::query();
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $brands = $query->orderBy('id', 'DESC')->whereNull('deleted_at')->paginate(10);
        return view('admin.brands', compact('brands'));
    }
    public function add_brand()
    {
        return view('admin.brand-add');
    }


    public function brand_store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:brands,slug',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
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
            'name'  => 'required',
            'slug'  => 'required|unique:brands,slug,' . $request->id,
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
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
        $brands = Brand::onlyTrashed()->orderBy('name')->paginate(10);

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
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
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
            'name'  => 'required',
            'slug'  => 'required|unique:categories,slug',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;

        // Di chuyển file vào thư mục uploads/brands
        $destinationPath = public_path('uploads/categories');
        $image->move($destinationPath, $file_name);

        $category->image = $file_name;
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
            // 'name'  => 'required',
            // 'slug'  => 'required|unique:brands,slug',
            // 'image' => 'required|mimes:png,jpg,jpeg|max:2048'
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
    // product
    // public function products()
    // {
    //     $products = Product::with(['category', 'brand', 'images'])
    //         ->orderBy('created_at', 'DESC')
    //         ->paginate(10);
    //     return view('admin.products', compact('products'));
    // }

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

        $products = $query->paginate(10);

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
            // 'name' => 'required|string|max:255',
            // 'slug' => 'required|string|unique:products,slug|max:255',
            // 'short_description' => 'nullable|string',
            // 'description' => 'required|string',
            // 'regular_price' => 'required|numeric|min:0',
            // 'sale_price' => 'nullable|numeric|min:0',
            // 'SKU' => 'required|string|max:255',
            // 'stock_status' => 'required|in:instock,outofstock',
            // 'featured' => 'nullable|boolean',
            // 'quantity' => 'required|integer|min:0',
            // 'category_id' => 'nullable|exists:categories,id',
            // 'brand_id' => 'nullable|exists:brands,id',
            // 'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            // 'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
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
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm bạn cần');
        }
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

        // Xử lý bộ sưu tập ản
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
            ->paginate(10);

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
    // // xóa vĩnh viễn sản phẩm (không thể khôi phục)
    // public function product_force_delete(Request $request, $id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);

    //         // Xóa tất cả hình ảnh liên quan
    //         foreach ($product->images as $image) {
    //             // Xóa file vật lý
    //             $imagePath = public_path('uploads/' . $image->path);
    //             if (file_exists($imagePath)) {
    //                 unlink($imagePath);
    //             }
    //             // Xóa record trong database
    //             $image->delete();
    //         }

    //         // Xóa vĩnh viễn sản phẩm
    //         $product->forceDelete();

    //         return redirect()
    //             ->route('admin.products.history')
    //             ->with('success', 'Sản phẩm đã được xóa vĩnh viễn thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()
    //             ->route('admin.products.history')
    //             ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    //     d
    // }
    #endregion



    #region Hoa Don


    // public function orders()
    // {
    //     $pendingCount = Order::where('status', 'pending')->count();
    //     $approvedCount = Order::where('status', 'approved')->count();
    //     $cancelledCount = Order::where('status', 'cancelled')->count();
    //     $orders = Order::with(['orderDetails.product', 'customer', 'employee'])
    //         ->orderBy('created_at', 'DESC')
    //         ->paginate(10);
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



        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);

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

    // public function order_add()
    // {
    //     // $orderdetails = OrderDetail::orderBy('name', 'ASC')->get();
    //     $customers = Customer::orderBy('customerName', 'ASC')->get();
    //     $employees = Employee::orderBy('name', 'ASC')->get();
    //     return view('admin.order-add', compact('customers', 'employees'));
    // }

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
        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);


        return  view('admin.orders', compact('orders', 'status'));
    }
    // danh sach don hang chua duyet
    public function orders_pending()
    {
        $orders = Order::with(['orderDetails.product', 'customer', 'employee'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('admin.orders-pending', compact('orders'));
    }

    // lay don hang da duyet
    public function order_approved()
    {
        $orders  = Order::with(['orderDetails.product', 'customer', 'employee'])->where('status', 'approved')->orderBy('created_at', "DESC")->paginate(10);
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
            ->paginate(10);

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

        $users = $query->paginate(10);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:6',
            'utype' => 'required|in:USR,ADM',
            'customer_id' => 'nullable|exists:customers,id',
            'employee_id' => 'nullable|exists:employees,id',
        ]);
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        // $user ->phone = $request ->phone;
        $user->utype = $request->utype;
        $user->customer_id = $request->customer_id;
        $user->employee_id = $request->employee_id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('admin.users')->with('message', 'Đã cập nhập thông tin tài khoản thành công');
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
    public function notifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.notifications', compact('notifications'));
    }
    public function notification_add()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('admin.notification-add', compact('users'));
    }

    public function notification_store(Request $request)
    {

        // tao doi tuong de gan du lie
        $notification = new Notification();
        $notification->name = $request->name;
        $notification->content = $request->content;
        // savwe vao csdl 
        $notification->save();
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

        $notification->save();
        return redirect()->route('admin.notification.update')->with('status', 'Cập nhập thành công');
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
        $notifications = Notification::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
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
        $notificationTypes = ['all']; // Loại thông báo chung cho tất cả

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
            ->paginate(10);

        return view('admin.notifications', ['notifications' => $user_notifications]);
    }


    public function inbox()
    {
        return view('admin.inbox');
    }
    public function settings()
    {
        return view('admin.setting');
    }
    #endregion
}
