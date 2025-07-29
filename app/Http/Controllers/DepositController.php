<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;

class DepositController extends Controller
{
    /**
     * Hiển thị danh sách đơn đặt cọc (từ bảng deposits)
     */
    public function list()
    {
        // Chỉ lấy những deposit chưa được thanh toán xong (chưa có order approved)
        $items = Deposit::with('cartItem.product')
            ->whereDoesntHave('order', function ($q) {
                $q->where('status', 'approved');
            })
            ->get();

        return view('deposit', compact('items'));
    }

    // Nếu ai đó vẫn gọi index(), ta redirect về list
    public function index()
    {
        return redirect()->route('deposit.list');
    }
}