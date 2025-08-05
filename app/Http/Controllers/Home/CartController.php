<?php

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class CartController extends Controller
{
 public function index()
{
    $userId = Auth::id() ; // Nếu chưa login thì tạm fix 1 để test

    // Lấy các item trong giỏ
    $items = CartItem::with(['product.primaryImage'])
        ->whereHas('cart', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereDoesntHave('deposit')
        ->get();

    // Tính tổng tiền
    $total = $items->sum(function ($item) {
        $price = $item->product->sale_price ?? $item->product->regular_price;
        return $price * $item->quantity;
    });

    return view('cart-bag', compact('items', 'total'));
}

    public function bag()
    {
        return $this->index();
    }

   public function checkout(Request $request)
{
    $userId = Auth::id();

    // Lấy cart của user hiện tại
    $cart = Cart::where('user_id', $userId)->first();

    if (!$cart) {
        return redirect()->route('cart.index')
            ->with('error', 'Không tìm thấy giỏ hàng.');
    }

    $selectedIds = $request->input('selected_items', []);

    if (empty($selectedIds)) {
        return redirect()->route('cart.index')
            ->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
    }

    // Lấy các cart_item thuộc cart_id của user và nằm trong selectedIds
    $items = CartItem::with(['product.primaryImage'])
        ->where('cart_id', $cart->id)
        ->whereIn('id', $selectedIds)
        ->get();

    if ($items->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Không có sản phẩm hợp lệ để thanh toán.');
    }

    $total = $items->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    return view('checkout', compact('items', 'total'));
}

    public function confirm()
    {
        return view('order-confirm');
    }

public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);

    $userId = Auth::id();

    try {
        // Lấy thông tin sản phẩm
        $product = \App\Models\Product::findOrFail($request->product_id);

        // Lấy hoặc tạo giỏ hàng của user
        $cart = \App\Models\Cart::firstOrCreate(
            ['user_id' => $userId],
            ['created_at' => now()]
        );

        // Kiểm tra item có sẵn trong giỏ chưa
        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Không cộng dồn, thông báo
            return redirect()->route('cart.index')
                ->with('error', 'Sản phẩm này đã có trong giỏ hàng');
        }

        // Tính giá: nếu có sale_price thì lấy sale_price, không thì lấy regular_price
        $price = $product->sale_price ?? $product->regular_price;

        // Thêm sản phẩm mới vào giỏ
        \App\Models\CartItem::create([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
            'quantity'   => 1,
            'price'      => $price,
        ]);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');

    } catch (\Exception $e) {
        return redirect()->route('cart.index')
            ->with('error', 'Thêm vào giỏ hàng không thành công. Vui lòng thử lại!');
    }
}




    public function update(Request $request, $productId)
{
    $userId = Auth::id();

    // Lấy cart của user
    $cart = Cart::where('user_id', $userId)->first();
    if (!$cart) {
        return redirect()->route('cart.index')->with('error', 'Không tìm thấy giỏ hàng.');
    }

    $quantity = max(1, (int)$request->input('quantity'));

    $cartItem = CartItem::where('cart_id', $cart->id)
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
    $userId = Auth::id();

    // Lấy cart của user
    $cart = Cart::where('user_id', $userId)->first();
    if (!$cart) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy giỏ hàng'], 404);
    }

    $quantity = max(1, (int)$request->input('quantity'));

    $cartItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $productId)
        ->first();

    if (!$cartItem) {
        return response()->json(['success' => false], 404);
    }

    // Cập nhật số lượng
    $cartItem->quantity = $quantity;
    $cartItem->save();

    // Tính lại subtotal và tổng
    $itemSubtotalRaw = $cartItem->price * $cartItem->quantity;
    $cartTotalRaw = CartItem::where('cart_id', $cart->id)
        ->whereDoesntHave('deposit')
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
    $userId = Auth::id();

    $cart = \App\Models\Cart::where('user_id', $userId)->first();

    if (!$cart) {
        return redirect()->route('cart.index')
            ->with('error', 'Không tìm thấy giỏ hàng.');
    }

    $cartItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $productId)
        ->first();

    if ($cartItem) {
        $cartItem->delete();
    }

    return redirect()->route('cart.index')
        ->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
}

public function clear()
{
    $userId = Auth::id();

    $cart = \App\Models\Cart::where('user_id', $userId)->first();

    if ($cart) {
        CartItem::where('cart_id', $cart->id)->delete();
    }

    return redirect()->route('cart.index')
        ->with('success', 'Đã xóa toàn bộ giỏ hàng.');
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
      public function getItems()
    {
        // Nếu chưa đăng nhập, gán user_id tạm để test
        $userId = Auth::id();

        // Lấy item giỏ hàng kèm theo sản phẩm và ảnh chính
        $items = CartItem::with(['product.primaryImage'])
            ->whereHas('cart', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();

        return response()->json($items);
    }

    // API trả tổng số lượng sản phẩm
public function getCartCount()
{
    // Lấy user đăng nhập
    $userId = Auth::id();

    if (!$userId) {
        return response()->json(['count' => 0]);
    }

    // Lấy cart của user
    $cart = \App\Models\Cart::where('user_id', $userId)->first();

    $count = 0;
    if ($cart) {
        // Đếm tổng quantity (hoặc số dòng tuỳ yêu cầu)
        $count = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
    }

    return response()->json(['count' => $count]);


}
public function countItems()
{
    // Lấy user đang đăng nhập
    $userId = Auth::id();

    if (!$userId) {
        // Nếu chưa đăng nhập thì giỏ hàng = 0
        return response()->json(['count' => 0]);
    }

   $count = CartItem::whereHas('cart', function ($q) use ($userId) {
        $q->where('user_id', $userId);
    })
    ->count();


    return response()->json(['count' => $count]);
}



}