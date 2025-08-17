<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\CartItem;
use App\Models\Deposit;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy user hiện tại
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng.');
        }

        // Lấy tất cả orders của user hiện tại thông qua email
        $orders = Order::with([
            'customer',
            'orderDetails.product.primaryImage',
            'deposit',
            'employee'
        ])
            ->whereHas('customer', function ($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính toán thông tin cho mỗi order
        $orders->each(function ($order) {
            // Tính subtotal từ order details
            $order->subtotal = $order->orderDetails->sum(function ($detail) {
                return $detail->price * $detail->quantity;
            });

            // Tính tax (10% của subtotal)
            $order->calculated_tax = round($order->subtotal * 0.1, 2);

            // Tính total
            $order->calculated_total = $order->subtotal + $order->calculated_tax;

            // Format status
            $order->status_badge = $this->getStatusBadge($order->status);
        });

        return view('account-order', compact('orders'));
    }
    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            // 1. Xác định khách hàng
            if ($user && $user->customer_id) {
                // Lấy lại instance user từ DB để có thể cập nhật được
                $userModel = \App\Models\User::find($user->id);
                $customer = Customer::find($userModel->customer_id);
                if (!$customer) {
                    throw new \Exception('Không tìm thấy thông tin khách hàng.');
                }
            } else {
                // Kiểm tra customer theo email
                $customer = Customer::where('email', $request->email)->first();

                if (!$customer) {
                    $customer = Customer::create([
                        'customerName' => $request->customerName,
                        'email'        => $request->email,
                        'address'      => $request->address,
                        'phone'        => $request->phone,
                        'gender'       => $request->gender,
                        'birthDay'     => $request->birthDay,
                    ]);
                }

                // Cập nhật customer_id cho user nếu đăng nhập mà chưa có customer_id
                if ($user) {
                    $userModel = \App\Models\User::find($user->id);
                    if ($userModel && !$userModel->customer_id) {
                        $userModel->customer_id = $customer->id;
                        $userModel->save();
                    }
                }
            }

            // 2. Lấy các item từ giỏ hàng (với relation product)
            $selectedItems = CartItem::with('product')->whereIn('id', $request->selected_items)->get();

            // 3. Tính subtotal
            $subtotal = 0.0;
            foreach ($selectedItems as $item) {
                $product = $item->product;
                $unitPrice = 0;
                if ($product) {
                    $unitPrice = (!empty($product->sale_price) && $product->sale_price > 0)
                        ? (float) $product->sale_price
                        : (float) $product->regular_price;
                }
                $subtotal += $unitPrice * (int)$item->quantity;
            }

            // 4. Thuế và tổng
            $tax = round($subtotal * 0.1, 0);
            $total = $subtotal + $tax;

            // 5. Xử lý deposit
            $depositId = $request->input('deposit_id');
            $depositAmount = 0;
            $remainingAmount = 0;
            if (!empty($depositId)) {
                $deposit = Deposit::findOrFail($depositId);
                $depositAmount = (float) $deposit->deposit_amount;
                $remainingAmount = max(0, $subtotal - $depositAmount);
            } else {
                $depositId = null;
                $remainingAmount = $subtotal;
            }

            // 6. Tạo order
            $employeeId = 1;
            if ($user) {
                $userModel = $userModel ?? \App\Models\User::find($user->id); // dùng lại nếu đã lấy
                if ($userModel && $userModel->employee_id) {
                    $employeeId = $userModel->employee_id;
                }
            }

            $order = new Order();
            $order->customer_id = $customer->id;
            $order->deposit_id = $depositId;
            $order->employee_id = $employeeId;
            $order->tax = $tax;
            $order->total = $total;
            $order->status = 'pending';
            $order->order_date = now();
            $order->total_item = $selectedItems->count();
            $order->deposit_amount = $depositAmount;
            $order->remaining_amount = $remainingAmount;
            $order->save();

            // 7. Lưu chi tiết order
            foreach ($selectedItems as $item) {
                $product = $item->product;
                $unitPrice = 0;
                if ($product) {
                    $unitPrice = (!empty($product->sale_price) && $product->sale_price > 0)
                        ? (float) $product->sale_price
                        : (float) $product->regular_price;
                }

                $lineSubtotal = $unitPrice * (int)$item->quantity;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $unitPrice,
                    'total'      => $lineSubtotal,
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
    public function orderByUser($id)
    {
        // Lấy tất cả orders của user hiện tại với các relationship cần thiết
        $orders = Order::with([
            'customer',
            'orderDetails.product.primaryImage',
            'deposit',
            'employee'
        ])
            ->whereHas('customer', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính toán thông tin cho mỗi order
        $orders->each(function ($order) {
            // Tính subtotal từ order details
            $order->subtotal = $order->orderDetails->sum(function ($detail) {
                return $detail->price * $detail->quantity;
            });

            // Tính tax (10% của subtotal)
            $order->calculated_tax = round($order->subtotal * 0.1, 2);

            // Tính total
            $order->calculated_total = $order->subtotal + $order->calculated_tax;

            // Format status
            $order->status_badge = $this->getStatusBadge($order->status);
        });

        return view('account-order', compact('orders'));
    }

    private function getStatusBadge($status)
    {
        switch (strtolower($status)) {
            case 'pending':
                return '<span class="badge bg-warning">Pending</span>';
            case 'approved':
            case 'ordered':
                return '<span class="badge bg-warning">Ordered</span>';
            case 'delivered':
                return '<span class="badge bg-success">Delivered</span>';
            case 'canceled':
            case 'cancelled':
                return '<span class="badge bg-danger">Canceled</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
        }
    }
    // Lấy lịch sử đơn hàng của user đăng nhập
    public function history()
    {
        $user = Auth::user();

        if (!$user || !$user->customer_id) {
            return response()->json(['orders' => []]);
        }

        // Lấy đơn hàng cùng các thông tin liên quan (customers, employees, deposits)
        $orders = DB::table('orders')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
            ->leftJoin('deposits', 'orders.deposit_id', '=', 'deposits.id')
            ->where('orders.customer_id', $user->customer_id)
            ->select(
                'orders.*',
                'customers.customerName as customer_name',
                'employees.name as employee_name',
                'deposits.deposit_amount',
                'deposits.deposit_date',
                'deposits.cart_item_id'
            )
            ->orderBy('orders.order_date', 'desc')
            ->get();

        // Lấy tất cả cart_item_ids từ deposits (của các order trên) để lấy tên sản phẩm
        $cartItemIds = $orders->pluck('cart_item_id')->filter()->unique()->values();

        // Lấy tên sản phẩm qua join cart_items và products
        $cartItemsWithProducts = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->whereIn('cart_items.id', $cartItemIds)
            ->select('cart_items.id', 'products.name as product_name')
            ->get()
            ->keyBy('id');

        // Gắn tên sản phẩm tương ứng vào mỗi order nếu có cart_item_id
        $orders = $orders->map(function ($order) use ($cartItemsWithProducts) {
            $order->product_name = $order->cart_item_id && isset($cartItemsWithProducts[$order->cart_item_id])
                ? $cartItemsWithProducts[$order->cart_item_id]->product_name
                : null;
            return $order;
        });

        return response()->json(['orders' => $orders]);
    }
    public function orderDetails($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem chi tiết đơn hàng.');
        }

        // Lấy order với tất cả thông tin chi tiết
        $order = Order::with([
            'customer',
            'orderDetails.product.primaryImage',
            'orderDetails.product.galleryImages',
            'deposit',
            'employee'
        ])
            ->whereHas('customer', function ($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->findOrFail($id);

        // Tính toán các thông tin tài chính
        $subtotal = $order->orderDetails->sum(function ($detail) {
            return $detail->price * $detail->quantity;
        });

        $tax = round($subtotal * 0.1, 2);
        $total = $subtotal + $tax;

        return view('order-details', compact('order', 'subtotal', 'tax', 'total'));
    }

    // public function orderDetail($orderId)
    // {
    //     // Lấy chi tiết đơn hàng với tên sản phẩm thông qua join product_id với bảng products
    //     $details = DB::table('order_details')
    //         ->join('products', 'order_details.product_id', '=', 'products.id')
    //         ->where('order_details.order_id', $orderId)
    //         ->select(
    //             'order_details.id',
    //             'order_details.order_id',
    //             'products.name as product_name',
    //             'order_details.quantity',
    //             'order_details.price',
    //             DB::raw('order_details.quantity * order_details.price as total'),
    //             'order_details.created_at',
    //             'order_details.updated_at'
    //         )
    //         ->get();

    //     if ($details->isEmpty()) {
    //         return response()->json([
    //             'error' => 'Không tìm thấy chi tiết đơn hàng.'
    //         ]);
    //     }

    //     return response()->json([
    //         'details' => $details
    //     ]);
    // }
    public function printInvoice($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);

        $subtotal = $order->orderDetails->sum(function ($detail) {
            return $detail->total ?? ($detail->price * $detail->quantity);
        });

        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        $pdf = PDF::loadView('invoice', compact('order', 'subtotal', 'tax', 'total'));

        return $pdf->stream("hoadon_{$order->id}.pdf");
    }
    public function printInvoiceAdmin($id)
    {
        // Lấy đơn hàng với chi tiết sản phẩm
        $order = Order::with('orderDetails.product')->findOrFail($id);

        // Tính tạm tính (subtotal)
        $subtotal = $order->orderDetails->sum(function ($detail) {
            return $detail->total ?? ($detail->price * $detail->quantity);
        });

        // Thuế (10% của tạm tính)
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        // Sử dụng giao diện invoice.blade.php (có thể tạo view riêng nếu muốn giao diện khác cho admin)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice', compact('order', 'subtotal', 'tax', 'total'));

        // Stream file PDF ra trình duyệt
        return $pdf->stream("hoadon_admin_{$order->id}.pdf");
    }
}
