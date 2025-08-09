<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CheckoutController extends Controller
{
public function fromDeposit($id)
{
    $deposit = Deposit::with('cartItem.product')->findOrFail($id);
    $item = $deposit->cartItem;

    $subtotal = $item->price * $item->quantity;
    $tax = round($subtotal * 0.1); //  Tính thuế đúng cách
    $remaining = $subtotal - $deposit->deposit_amount;
    $shippingFee = 80000000;
    $total = $remaining + $shippingFee + $tax; //  Tổng cộng đúng

    return view('checkout', [
        'deposit' => $deposit,
        'items' => collect([$item]),
        'subtotal' => $subtotal,
        'shippingFee' => $shippingFee,
        'tax' => $tax,
        'total' => $total,
        'shippingMethodName' => 'Giao hàng tiêu chuẩn',
        'isFromDeposit' => true,
        'remaining' => $remaining, //  Truyền đúng remaining
    ]);
}





}