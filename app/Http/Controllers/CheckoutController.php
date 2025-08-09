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
    $product = $item->product;

    // Lấy quantity, phòng trường hợp null
    $quantity = $item->quantity ?? 1;

    // Lấy giá: ưu tiên sale_price nếu có > 0, ngược lại lấy regular_price
    if ($product) {
        $price = ($product->sale_price && $product->sale_price > 0)
            ? $product->sale_price
            : ($product->regular_price ?? 0);
    } else {
        $price = 0;
    }

    // Tính subtotal
    $subtotal = $price * $quantity;

    // Tính remaining (cố gắng không âm)
    $remaining = max(0, $subtotal - $deposit->deposit_amount);

    // Tính thuế VAT 10%
    $tax = round($subtotal * 0.1);

    // Phí vận chuyển cố định ví dụ
    $shippingFee = 80000000;

    // Tổng cộng
    $total = $remaining + $shippingFee + $tax;

    return view('checkout', [
        'deposit' => $deposit,
        'items' => collect([$item]),
        'subtotal' => $subtotal,
        'shippingFee' => $shippingFee,
        'tax' => $tax,
        'total' => $total,
        'shippingMethodName' => 'Giao hàng tiêu chuẩn',
        'isFromDeposit' => true,
        'remaining' => $remaining,
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