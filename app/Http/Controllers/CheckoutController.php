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
        // Lấy thông tin deposit kèm cartItem và product
        $deposit = Deposit::with('cartItem.product')->findOrFail($id);

        // Truyền sang view checkout.blade.php
        return view('checkout', [
            'deposit' => $deposit,
            'items'   => collect([$deposit->cartItem]), // lấy item để hiển thị giỏ
            'total'   => $deposit->cartItem->price * $deposit->cartItem->quantity
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