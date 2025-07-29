<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Deposit;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartId = 1; // sau này sẽ lấy theo user đăng nhập

        // Lọc bỏ các cart_item đã có deposit
        $items = CartItem::with(['product.primaryImage'])
            ->where('cart_id', $cartId)
            ->whereDoesntHave('deposit') // chỉ lấy item chưa đặt cọc
            ->get();

        $total = $items->sum(fn($item) => $item->price * $item->quantity);

        return view('cart-bag', compact('items', 'total'));
    }

    public function bag()
    {
        return $this->index();
    }

    public function checkout(Request $request)
    {
        $cartId = 1;
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')
                ->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        // Chỉ lấy các cart_item được chọn
        $items = CartItem::with(['product.primaryImage'])
            ->where('cart_id', $cartId)
            ->whereIn('id', $selectedIds)
            ->get();

        $total = $items->sum(fn($item) => $item->price * $item->quantity);

        return view('checkout', compact('items', 'total'));
    }

    public function confirm()
    {
        return view('order-confirm');
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $cartId = 1;

        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->regular_price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, $productId)
    {
        $cartId = 1;
        $quantity = max(1, (int)$request->input('quantity'));

        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công.');
    }

    public function updateAjax(Request $request, $productId)
    {
        $cartId = 1;
        $quantity = max(1, (int)$request->input('quantity'));

        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $itemSubtotalRaw = $cartItem->price * $cartItem->quantity;
        $cartTotalRaw = CartItem::where('cart_id', $cartId)
            ->whereDoesntHave('deposit') // tính tổng chỉ cho sản phẩm chưa đặt cọc
            ->get()
            ->sum(fn($item) => $item->price * $item->quantity);

        return response()->json([
            'success' => true,
            'item_subtotal_raw' => $itemSubtotalRaw,
            'item_subtotal'     => number_format($itemSubtotalRaw, 0, ',', '.'),
            'cart_total_raw'    => $cartTotalRaw,
            'cart_total'        => number_format($cartTotalRaw, 0, ',', '.'),
        ]);
    }

    public function remove($productId)
    {
        $cartId = 1;
        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        $cartId = 1;
        CartItem::where('cart_id', $cartId)->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    public function submitDeposit(Request $request)
    {
        $validated = $request->validate([
            'cart_item_id' => 'required|integer',
            'deposit_amount' => 'required|numeric',
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'deposit_date' => 'required|date',
        ]);

        Deposit::create($validated);

        return redirect()->route('deposit.list')->with('success', 'Đặt cọc thành công');
    }

    public function listDeposits()
    {
        $items = Deposit::latest()->get();
        return view('deposit', compact('items'));
    }

    public function checkoutFromDeposit($depositId)
    {
        $deposit = \App\Models\Deposit::with('cartItem.product')->findOrFail($depositId);

        // Lấy item từ deposit để truyền sang view checkout
        $items = collect([$deposit->cartItem]);
        $total = ($deposit->cartItem->price * $deposit->cartItem->quantity) - $deposit->deposit_amount;

        return view('checkout', compact('items', 'total', 'deposit'));
    }
}