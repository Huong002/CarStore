<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AppController extends Controller
{
    // Hàm trả về view chính app.blade.php
    public function index()
    {
        $user = Auth::user();
        $orders = collect();

        if ($user && $user->customer_id) {
            // Lấy tất cả đơn hàng của user theo customer_id, sắp xếp mới nhất trước
            $orders = Order::where('customer_id', $user->customer_id)
                ->orderBy('order_date', 'desc')
                ->get();
        }

        // Trả về view app với biến orders
        return view('app', compact('orders'));
    }
}