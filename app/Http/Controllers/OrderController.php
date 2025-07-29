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
    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Tạo khách hàng mới
            $customer = Customer::create([
                'customerName' => $request->customerName,
                'email'        => $request->email,
                'address'      => $request->address,
                'phone'        => $request->phone,
                'gender'       => $request->gender,
                'birthDay'     => $request->birthDay,
            ]);

            // 2. Lấy các item từ giỏ hàng
            $selectedItems = CartItem::whereIn('id', $request->selected_items)->get();

            // 3. Tính toán subtotal, tax và total
            $subtotal = $selectedItems->sum(fn($i) => $i->price * $i->quantity);
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            // 4. Xác định phương thức thanh toán
            $method = $request->checkout_payment_method ?? 'cod';

            // ===============================
            // XỬ LÝ LOGIC ĐẶT CỌC
            // ===============================
            $depositId = $request->input('deposit_id'); // có thể null

            // Mặc định giá trị
            $depositAmount = 0;
            $remainingAmount = 0;

            // 1. Nếu có deposit_id (thanh toán tiếp số còn lại của đơn đã đặt cọc)
            if (!empty($depositId)) {
                $deposit = Deposit::findOrFail($depositId);
                $depositAmount = (float) $deposit->deposit_amount;
                $remainingAmount = max(0, $subtotal - $depositAmount);

            // 2. Nếu phương thức thanh toán là 'deposit' mà chưa có deposit_id -> tạo mới đặt cọc
            // } elseif ($method === 'deposit') {
                // $depositAmount = $subtotal * 0.3; // ví dụ đặt cọc 30%
                // $remainingAmount = $subtotal - $depositAmount;

            // 3. Các phương thức khác (COD, PayPal) -> thanh toán toàn bộ, không đặt cọc
            } else {
                $depositId = null;
                $depositAmount = 0;
                $remainingAmount = 0;
            }

            // 5. Tạo order
            $order = Order::create([
                'customer_id'      => $customer->id,
                'deposit_id'       => $depositId, // null nếu không đặt cọc
                'employee_id'      => 1,
                'tax'              => $tax,
                'total'            => $total,
                'status'           => 'approved',
                'order_date'       => now(),
                'total_item'       => $selectedItems->count(),
                'deposit_amount'   => $depositAmount,
                'remaining_amount' => $remainingAmount,
            ]);

            // 6. Lưu chi tiết order
            foreach ($selectedItems as $item) {
                $lineSubtotal = $item->price * $item->quantity;

                // Phân bổ VAT theo tỷ lệ
                $taxForThisItem = ($subtotal > 0)
                    ? $tax * ($lineSubtotal / $subtotal)
                    : 0;

                $lineTotal = $lineSubtotal + $taxForThisItem;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $lineTotal,
                ]);

                // Cập nhật trạng thái giỏ hàng
                $item->update(['status' => 'approved']);
            }

            DB::commit();

            // Nếu là AJAX (PayPal)
            if ($request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('order.success', $order->id),
                ]);
            }

            // Nếu submit form bình thường
            return redirect()->route('order.success', $order->id)
                             ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Có lỗi khi xử lý: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $order = Order::with('orderDetails.product', 'customer', 'deposit')
            ->findOrFail($id);

        return view('success', compact('order'));
    }
}