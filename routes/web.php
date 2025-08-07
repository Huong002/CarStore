<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Auth\ForgotPasswordController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::post('/shop/scan-image', [ShopController::class, 'scanImage'])->name('shop.scan.image');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');

Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    //thuong hieu
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand.delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');
    Route::patch('/admin/brand/restore/{id}', [AdminController::class, 'brand_restore'])->name('admin.brand.restore');
    Route::delete('admin/brand/soft-delete/{id}', [AdminController::class, 'brand_soft_delete'])->name('admin.brand.soft_delete');
    Route::get('admin/brand/history', [AdminController::class, 'brand_his'])->name('admin.brand.history');
    // danh muc
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/categories/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('admin/categories/add', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/categories/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/categories/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/categories/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    // san pham
    Route::get('admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product.delete');
    // them xoa mem
    // danh sach san pham xoa mem
    Route::get('admin/products/history', [AdminController::class, 'product_his'])->name('admin.product.history');
    // xoa mem
    Route::delete('admin/product/soft-delete/{id}', [AdminController::class, 'product_soft_delete'])->name('admin.product.soft_delete');
    // khoi phuc: 
    Route::patch('/admin/product/restore/{id}', [AdminController::class, 'product_restore'])->name('admin.product.restore');

    // xóa vĩnh viễn sản phẩm
    Route::delete('/admin/product/force-delete/{id}', [AdminController::class, 'product_force_delete'])->name('admin.product.force-delete');


    // doon hang
    Route::get('admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('admin/order/add', [AdminController::class, 'order_add'])->name('admin.order.add');
    Route::post('admin/order/store', [AdminController::class, 'order_store'])->name('admin.order.store');
    Route::get('admin/order/detail/{id}', [AdminController::class, 'order_detail'])->name('admin.order.details');
    Route::get('/orders/status', [AdminController::class, 'order_status'])->name('orders.status');

    // Phân loại theo trạng thái
    Route::get('/admin/orders/pending', [AdminController::class, 'orders_pending'])->name('orders.pending');
    Route::get('/admin/orders/approved', [AdminController::class, 'orders_approved'])->name('orders.approved');
    Route::get('/admin/orders/cancelled', [AdminController::class, 'orders_cancelled'])->name('orders.cancelled');

    // Thao tác đơn hàng
    Route::post('/admin/order/approve/{id}', [AdminController::class, 'order_approve'])->name('order.approve');
    Route::post('/admin/order/cancel/{id}', [AdminController::class, 'order_cancel'])->name('order.cancel');
    Route::get('/admin/invoice/print/{id}', [InvoiceController::class, 'printInvoice'])->name('order.invoice.print');


    // nguoi dung
    Route::get('admin/users/', [AdminController::class, 'users'])->name('admin.users');
    Route::post('admin/users/{id}/lock', [AdminController::class, 'user_lock'])->name('admin.user.lock');
    Route::post('admin/users/{id}/unlock', [AdminController::class, 'user_unlock'])->name('admin.user.unlock');


    //acount for admin
    Route::post('admin/account/{id}', [AdminController::class, 'user_update'])->name('admin.account.update');


    // notification
    Route::get('admin/notification', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::patch('admin/notification/history', [AdminController::class, 'notification-history'])->name('admin.notification.history');
    Route::post('admin/notification/store', [AdminController::class, 'notification_store'])->name('admin.notification.store');
    Route::delete('admin/notification/delete/{id}', [AdminController::class, 'notification_delete'])->name('admin.notification.delete');
    Route::delete('admin/notification/softs_delete', [AdminController::class, 'notification_soft_delete'])->name('admin.notifiction.soft_delete');
    // inbox
    Route::get('admin/inbox', [AdminController::class, 'inbox'])->name('admin.inbox');
});
    Route::get('/location', function () { return view('location'); })->name('location.index');
    
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::patch('/update-ajax/{productId}', [CartController::class, 'updateAjax'])->name('updateAjax');

    // Những route này yêu cầu đăng nhập:
    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/submit-deposit', [CartController::class, 'submitDeposit'])->name('submitDeposit');
    });
});

// PayPal routes – yêu cầu đăng nhập khi thực hiện thanh toán
Route::middleware('auth')->group(function () {
    Route::get('paypal', [PayPalController::class, 'index'])->name('paypal.index');
    Route::post('paypal/pay', [PayPalController::class, 'payWithPayPal'])->name('paypal.pay');
    Route::get('paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
    Route::get('paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/checkout/from-deposit/{id}', [CheckoutController::class, 'fromDeposit'])->name('checkout.fromDeposit');

    // THÊM ROUTE NÀY:
    Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');
    // Danh sách đơn đặt cọc (có thể cho xem mà không đăng nhập, tùy bạn)
    Route::get('/deposit', [DepositController::class, 'list'])->name('deposit.list');
   
    // Route::get('/api/cart-items', [CartController::class, 'getItems'])->name('cart.items');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

   Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

});
 
 // Xem chi tiết sản phẩm yêu thích theo id
Route::get('/wishlistshow/{id}', [ShopController::class, 'wishlistShow'])->name('wishlist.show');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');

// Không cần đổi gì nếu đã dùng fetch trong JS
// Route::middleware('auth')->get('/api/cart-count', [CartController::class, 'countItems'])->name('cart.count');
Route::get('/api/cart-count', [CartController::class, 'countItems'])->name('cart.count');

Route::get('/api/cart-items', [CartController::class, 'getItems'])->name('cart.items');