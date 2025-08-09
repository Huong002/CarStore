<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    public function index($id)
{
    $deposit = Deposit::find($id);

    return view('checkout', [
        'deposit' => $deposit,
        'isFromDeposit' => true
    ]);
}
public function fromDeposit($id)
{
    $deposit = Deposit::with('cartItem.product')->findOrFail($id);
    $item = $deposit->cartItem;

    $subtotal = $item->price * $item->quantity;
    $tax = round($subtotal * 0.1); // ✅ Tính thuế đúng cách
    $remaining = $subtotal - $deposit->deposit_amount;
    $shippingFee = 80000000;
    $total = $remaining + $shippingFee + $tax; // ✅ Tổng cộng đúng

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


// public function checkout(Request $request)
// {
//     $shippingFee = (float) $request->input('shipping_fee', 0);
//     $shippingMethodName = $request->input('shipping_method_name', 'Không rõ');

//     $selectedItems = $request->input('selected_items', []);
//     if (empty($selectedItems)) {
//         return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
//     }

//     $cartItems = CartItem::whereIn('id', $selectedItems)->with('product')->get();

//     $subtotal = $cartItems->sum(function($item) {
//         $price = $item->product->sale_price ?? $item->product->regular_price;
//         return $price * $item->quantity;
//     });

//     $tax = $subtotal * 0.1;
//     $total = $subtotal + $tax + $shippingFee;

//     // Truyền đủ biến sang view checkout
//     return view('checkout', compact(
//         'cartItems',
//         'subtotal',
//         'tax',
//         'total',
//         'shippingFee',
//         'shippingMethodName'
//     ));
// }



}