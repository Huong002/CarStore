<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShopController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

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
});
