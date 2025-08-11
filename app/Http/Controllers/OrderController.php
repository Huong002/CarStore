<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\CartItem;
use App\Models\Deposit;

class OrderController extends Controller
{
    public function index(){
        return view('account-order');
    }
    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Tạo khách hàng
            $customer = Customer::create([
                'customerName' => $request->customerName,
                'email'        => $request->email,
                'address'      => $request->address,
                'phone'        => $request->phone,
                'gender'       => $request->gender,
                'birthDay'     => $request->birthDay,
            ]);

            // 2. Lấy các item từ giỏ hàng (với relation product)
            $selectedItems = CartItem::with('product')->whereIn('id', $request->selected_items)->get();

            // 3. Tính subtotal (dựa trên product: sale_price nếu có và >0, ngược lại regular_price)
            $subtotal = 0.0;
            foreach ($selectedItems as $item) {
                $product = $item->product;
                // phòng trường hợp product null
                $unitPrice = 0;
                if ($product) {
                    $unitPrice = (!empty($product->sale_price) && $product->sale_price > 0)
                        ? (float) $product->sale_price
                        : (float) $product->regular_price;
                }
                $subtotal += $unitPrice * (int)$item->quantity;
            }

            // 4. Thuế và tổng
            $tax = round($subtotal * 0.1, 0); // nếu muốn làm tròn
            $total = $subtotal + $tax;

            // 5. Xử lý deposit (giữ nguyên logic của bạn)
            $depositId = $request->input('deposit_id');
            $depositAmount = 0;
            $remainingAmount = 0;
            if (!empty($depositId)) {
                $deposit = Deposit::findOrFail($depositId);
                $depositAmount = (float) $deposit->deposit_amount;
                $remainingAmount = max(0, $subtotal - $depositAmount);
            } else {
                $depositId = null;
            }

            // 6. Tạo order — gán trực tiếp tránh mass-assignment
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->deposit_id = $depositId;
            $order->employee_id = 1;
            $order->tax = $tax;
            $order->total = $total;
            $order->status = 'approved';
            $order->order_date = now();
            $order->total_item = $selectedItems->count();
            $order->deposit_amount = $depositAmount;
            $order->remaining_amount = $remainingAmount;
            $order->save();

            // 7. Lưu chi tiết order: lưu price = đơn giá, total = price * quantity (KHÔNG cộng thuế)
            foreach ($selectedItems as $item) {
                $product = $item->product;
                $unitPrice = 0;
                if ($product) {
                    $unitPrice = (!empty($product->sale_price) && $product->sale_price > 0)
                        ? (float) $product->sale_price
                        : (float) $product->regular_price;
                }

                $lineSubtotal = $unitPrice * (int)$item->quantity; // không cộng thuế

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $unitPrice,
                    'total'      => $lineSubtotal, // lưu subtotal (không có VAT)
                ]);

                // cập nhật trạng thái giỏ hàng
                $item->update(['status' => 'approved']);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('order.success', $order->id),
                ]);
            }

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Có lỗi khi xử lý: ' . $e->getMessage());
        }
    }

    // public function success($id)
    // {
    //     $order = Order::with('orderDetails.product', 'customer', 'deposit')->findOrFail($id);

    //     // Tính subtotal từ dữ liệu đã lưu trong orderDetails (đã lưu subtotal per-item)
    //     $subtotal = (float) $order->orderDetails->sum('total');
    //     // nếu bạn đã lưu tax vào order->tax thì dùng: $tax = (float) $order->tax;
    //     // nếu muốn lại tính: $tax = round($subtotal * 0.1, 0);
    //     $tax = (float) $order->tax;
    //     $total = (float) $order->total;

    //     return view('success', compact('order', 'subtotal', 'tax', 'total'));
    // }

    public function success($orderId)
    {
        $order = Order::with('orderDetails.product')->findOrFail($orderId);

        // Tính tạm tính
        $subtotal = $order->orderDetails->sum(function ($detail) {
            $unitPrice = $detail->price ?? (
                ($detail->product && $detail->product->sale_price && $detail->product->sale_price > 0)
                ? $detail->product->sale_price
                : ($detail->product->regular_price ?? 0)
            );
            return $unitPrice * $detail->quantity;
        });

        // Thuế = 10% của tạm tính
        $tax = $subtotal * 0.1;

        // Tổng cộng
        $total = $subtotal + $tax;

        return view('success', compact('order', 'subtotal', 'tax', 'total'));
    }
}
