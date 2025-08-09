@extends('carts')

@section('cart_content')

<style>
/* Giữ readonly không bị xám */
.form-control[readonly] {
    background-color: #fff !important;
    opacity: 1;
    cursor: default;
}

/* Fix label */
.form-floating>label::after {
    background: none !important;
    content: "" !important;
}

.form-floating>label {
    background: transparent !important;
    padding: 0 .75rem;
}

.form-floating>.form-control,
.form-floating>.form-select {
    padding: 1rem .75rem;
}

.form-floating>label::after {
    all: unset !important;
}

.form-floating>label {
    background-color: #fff !important;
    padding: 0 0.3rem !important;
    z-index: 3 !important;
    height: auto;
    line-height: 1;
}
</style>

<form action="{{ route('order.place') }}" method="POST" id="checkoutForm">
    @csrf

    {{-- Truyền deposit_id (nếu có) --}}
    @if(isset($deposit))
    <input type="hidden" name="deposit_id" value="{{ $deposit->id }}">
    @endif

    <div class="checkout-form">
        <div class="billing-info__wrapper">
            <div class="row">
                <div class="col-6">
                    <h4>THÔNG TIN KHÁCH HÀNG</h4>
                </div>
            </div>

            <div class="row mt-5">
                <!-- customerName -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="customerName" name="customerName" placeholder=" "
                            value="{{ $deposit->customer_name ?? '' }}" required>
                        <label for="customerName">Họ và tên *</label>
                    </div>
                </div>

                <!-- email -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder=" "
                            value="{{ $deposit->email ?? '' }}" required>
                        <label for="email">Email *</label>
                    </div>
                </div>

                <!-- address -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="address" name="address" placeholder=" "
                            value="{{ $deposit->address ?? '' }}" required>
                        <label for="address">Địa chỉ *</label>
                    </div>
                </div>

                <!-- phone -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder=" "
                            value="{{ $deposit->phone ?? '' }}" required>
                        <label for="phone">Số điện thoại *</label>
                    </div>
                </div>

                <!-- gender -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">--Chọn--</option>
                            <option value="Nam" {{ (isset($deposit) && $deposit->gender == 'Nam') ? 'selected' : '' }}>
                                Nam</option>
                            <option value="Nữ" {{ (isset($deposit) && $deposit->gender == 'Nữ') ? 'selected' : '' }}>Nữ
                            </option>
                        </select>
                        <label for="gender">Giới tính *</label>
                    </div>
                </div>

                <!-- birthDay -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="date" class="form-control" id="birthDay" name="birthDay" placeholder=" "
                            value="{{ $deposit->birthDay ?? '' }}" required>
                        <label for="birthDay">Ngày sinh *</label>
                    </div>
                </div>

                <!-- order_date -->
                <div class="col-md-6">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="order_date" name="order_date"
                            value="{{ date('d/m/Y') }}" readonly placeholder=" ">
                        <label for="order_date">Ngày đặt hàng</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐƠN HÀNG -->
        <div class="checkout__totals-wrapper">
            <div class="sticky-content">
                <div class="checkout__totals">
                    <h3>Đơn hàng của bạn</h3>
                    <table class="checkout-cart-items">
                        <thead>
                            <tr>
                                <th>SẢN PHẨM</th>
                                <th align="right">TẠM TÍNH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            @php
                            $product = $item->product;
                            $hasSale = $product->sale_price !== null && $product->sale_price < $product->regular_price;
                                $price = $hasSale ? $product->sale_price : $product->regular_price;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $product->name ?? 'Sản phẩm' }} x {{ $item->quantity }}
                                        <br>
                                        @if($hasSale)
                                        <span style="text-decoration: line-through; color: gray;">
                                            {{ number_format($product->regular_price, 0, ',', '.') }}₫
                                        </span>
                                        <br>
                                        <span style="color: red;">
                                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                                        </span>
                                        @else
                                        <span>
                                            {{ number_format($product->regular_price, 0, ',', '.') }}₫
                                        </span>
                                        @endif
                                    </td>
                                    <td align="right">
                                        {{ number_format($price * $item->quantity, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                                @endforeach
                        </tbody>
                    </table>

                    <table class="checkout-totals">
                        <tbody>
                            <tr>
                                <th>PHÍ VẬN CHUYỂN</th>
                                <td align="right">{{ $shippingMethodName ?? 'Không rõ' }}
                                    ({{ number_format($shippingFee, 0, ',', '.') }}₫)
                                </td>
                            </tr>
                            <tr>
                                <th>THUẾ VAT</th>
                                <td align="right">{{ number_format($tax, 0, ',', '.') }}₫</td>
                            </tr>
                            @isset($remaining)
                            <tr>
                                <th>SỐ TIỀN CÒN LẠI</th>
                                <td align="right">{{ number_format($remaining, 0, ',', '.') }}₫</td>
                            </tr>
                            @endisset
                            <tr>
                                <th>TỔNG CỘNG</th>
                                <td align="right" class="text-danger">{{ number_format($total, 0, ',', '.') }}₫</td>
                            </tr>


                        </tbody>
                    </table>


                </div>

                <!-- PHƯƠNG THỨC THANH TOÁN -->
                <div class="checkout__payment-methods">
                    <div class="form-check">
                        <input class="form-check-input form-check-input_fill" type="radio"
                            name="checkout_payment_method" id="checkout_payment_method_3" value="cod">
                        <label class="form-check-label" for="checkout_payment_method_3">
                            Thanh toán tiền mặt
                            <p class="option-detail">Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng.</p>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input form-check-input_fill" type="radio"
                            name="checkout_payment_method" id="checkout_payment_method_4" value="paypal">
                        <label class="form-check-label" for="checkout_payment_method_4">
                            Paypal
                            <p class="option-detail">Thanh toán trực tuyến thông qua tài khoản Paypal của bạn.</p>
                        </label>
                    </div>
                    <!-- Nút thanh toán -->
                    <div class="checkout__submit mt-4" id="checkout_submit_btn">
                        <button type="submit" class="btn btn-primary w-100">
                            Thanh toán
                        </button>
                    </div>

                    <!-- Nút PayPal -->
                    <div id="paypal-button-container" style="display:none; margin-top:15px;"></div>

                    <div class="policy-text">
                        Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="depositAmount" value="{{ $total * 1.1 }}">
</form>

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>
<script>
// Kiểm tra thông tin trước khi hiển thị PayPal
function validateCustomerInfo() {
    const requiredFields = ['customerName', 'email', 'address', 'phone', 'gender', 'birthDay'];
    for (let id of requiredFields) {
        const field = document.getElementById(id);
        if (!field || !field.value.trim()) {
            return false;
        }
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const paypalContainer = document.getElementById('paypal-button-container');
    const submitBtn = document.getElementById('checkout_submit_btn');

    // Ẩn PayPal và nút thanh toán mặc định
    if (paypalContainer) paypalContainer.style.display = 'none';
    if (submitBtn) submitBtn.style.display = 'none';

    document.querySelectorAll('input[name="checkout_payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const isPaypal = this.value === 'paypal';

            if (isPaypal) {
                if (validateCustomerInfo()) {
                    // Hiện nút PayPal, ẩn nút thanh toán thường
                    if (paypalContainer) {
                        paypalContainer.style.display = 'block';
                        renderPayPalButton();
                    }
                    if (submitBtn) submitBtn.style.display = 'none';
                } else {
                    alert('Vui lòng điền đầy đủ thông tin trước khi thanh toán qua PayPal!');
                    this.checked = false;

                    if (paypalContainer) paypalContainer.style.display = 'none';
                    if (submitBtn) submitBtn.style.display = 'none';
                }
            } else {
                // Nếu chọn COD hoặc phương thức khác
                if (paypalContainer) paypalContainer.style.display = 'none';
                if (submitBtn) submitBtn.style.display = 'block';
            }
        });
    });
});

function renderPayPalButton() {
    const container = document.getElementById('paypal-button-container');
    if (!container) return;

    container.innerHTML = '';

    let depositAmount = document.getElementById('depositAmount')?.value || 0;
    const rate = 24000;
    let usdAmount = (depositAmount / rate).toFixed(2);

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: usdAmount
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Thanh toán PayPal thành công: ' + details.id);

                const form = document.getElementById('checkoutForm');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            alert('Lỗi: ' + data.message);
                        }
                    })
                    .catch(err => alert('Có lỗi xảy ra: ' + err));
            });
        }
    }).render('#paypal-button-container');
}
</script>



@endsection