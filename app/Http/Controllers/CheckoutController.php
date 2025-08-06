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

    $shippingFee = 80000000; // ví dụ phí ship cố định
    $tax = round($subtotal * 0.1); // ví dụ thuế VAT 10%
    $total = $subtotal + $shippingFee + $tax;

    return view('checkout', [
        'deposit' => $deposit,
        'items' => collect([$item]),
        'subtotal' => $subtotal,
        'shippingFee' => $shippingFee,
        'tax' => $tax,
        'total' => $total,
        'shippingMethodName' => 'Giao hàng tiêu chuẩn', // nếu cần hiển thị
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