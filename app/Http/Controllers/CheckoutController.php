<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function fromDeposit($id)
    {
        // Lấy thông tin deposit kèm cartItem và product
        $deposit = Deposit::with('cartItem.product')->findOrFail($id);

        // Truyền sang view checkout.blade.php
        return view('checkout', [
            'deposit' => $deposit,
            'items'   => collect([$deposit->cartItem]), // lấy item để hiển thị giỏ
            'total'   => $deposit->cartItem->price * $deposit->cartItem->quantity
        ]);
    }
}