@extends('carts')
@section('cart_content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">

        <div class="order-complete">
            <div class="order-complete__message">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                    <path
                        d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                        fill="white" />
                </svg>
                <h3>Đặt hàng thành công!</h3>
                <p>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đã được ghi nhận.</p>
            </div>

            {{-- Thông tin đơn hàng --}}
            <div class="order-info">
                <div class="order-info__item">
                    <label>Mã đơn hàng</label>
                    <span>{{ $order->id }}</span>
                </div>
                <div class="order-info__item">
                    <label>Ngày đặt</label>
                    <span>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                </div>
                <div class="order-info__item">
                    <label>Tổng tiền</label>
                    <span>{{ number_format($total,0,',','.') }}₫</span>
                </div>
                <div class="order-info__item">
                    <div><label>Trạng thái:</label>
                        </br>
                        <span>
                            @switch($order->status)
                            @case('pending')
                            <span class="badge bg-warning">Chờ xử lý</span>
                            @break
                            @case('approved')
                            <span class="badge bg-info">Đã duyệt</span>
                            @break
                            @case('completed')
                            <span class="badge bg-success">Hoàn thành</span>
                            @break
                            @case('cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                            @break
                            @default
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>


            {{-- Chi tiết sản phẩm --}}
            <div class="checkout__totals-wrapper">
                <div class="checkout__totals">
                    <h3>Chi tiết đơn hàng</h3>
                    <table class="checkout-cart-items">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                            @php
                            $product = $detail->product;
                            // dùng giá đã lưu ở order_detail nếu tồn tại (detail->price)
                            $unitPrice = $detail->price ?? (
                            ($product && $product->sale_price && $product->sale_price > 0)
                            ? $product->sale_price
                            : ($product->regular_price ?? 0)
                            );
                            $lineTotal = $detail->total ?? ($unitPrice * $detail->quantity);
                            @endphp
                            <tr>
                                <td>{{ $product->name ?? 'Sản phẩm' }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>
                                    @if(!empty($product)
                                    && $product->sale_price > 0
                                    && $product->sale_price < $product->regular_price)

                                        <span style="text-decoration: line-through; color:#999;">
                                            {{ number_format($product->regular_price, 0, ',', '.') }}₫
                                        </span><br>
                                        <span style="color:red;">
                                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                                        </span>

                                        @else
                                        {{ number_format($product->regular_price ?? 0, 0, ',', '.') }}₫
                                        @endif
                                </td>

                                <td>{{ number_format($lineTotal,0,',','.') }}₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="checkout-totals">
                        <tbody>
                            <tr>
                                <th>Tạm tính</th>
                                <td>{{ number_format($subtotal,0,',','.') }}₫</td>
                            </tr>
                            <tr>
                                <th>Thuế (VAT)</th>
                                <td>{{ number_format($tax,0,',','.') }}₫</td>
                            </tr>
                            <tr>
                                <th>Tổng cộng</th>
                                <td>{{ number_format($total,0,',','.') }}₫</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div style="margin-top: 20px; text-align: right;">
                <a href="{{ route('orders.print', ['id' => $order->id]) }}" target="_blank" class="btn btn-primary"
                    style="padding: 10px 20px; font-size: 16px;">
                    <i class="bi bi-printer-fill"></i> In hóa đơn
                </a>
            </div>
        </div>
    </section>
</main>

@endsection