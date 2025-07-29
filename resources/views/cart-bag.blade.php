@extends('carts')

@section('cart_content')
<div class="shopping-cart">
    <div class="cart-table__wrapper">
        <table class="cart-table table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Product</th>
                    <th></th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr data-product-id="{{ $item->product_id }}" data-subtotal="{{ $item->price * $item->quantity }}">
                    <td>
                        <input type="checkbox" class="select-item" value="{{ $item->id }}">
                    </td>
                    <td>
                        <div class="shopping-cart__product-item">
                            @if($item->product && $item->product->primaryImage)
                            <img loading="lazy" src="{{ asset('storage/'.$item->product->primaryImage->image_path) }}"
                                width="120" height="120" alt="">
                            @else
                            <img loading="lazy" src="{{ asset('assets/images/no-image.png') }}" width="120" height="120"
                                alt="">
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item__detail">
                            <h4>{{ $item->product->name ?? 'Sản phẩm' }}</h4>
                            <a href="#" class="deposit-link text-primary"
                                style="text-decoration: underline; cursor: pointer;"
                                data-product="{{ $item->product->name ?? 'Sản phẩm' }}" data-qty="{{ $item->quantity }}"
                                data-total="{{ $item->price * $item->quantity }}" data-item-id="{{ $item->id }}"
                                data-bs-toggle="modal" data-bs-target="#depositModal">
                                Nhận đặt cọc
                            </a>
                        </div>
                    </td>
                    <td>
                        <span class="shopping-cart__product-price">
                            {{ number_format($item->price, 0, ',', '.') }}₫
                        </span>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center qty-input"
                            style="width:70px" min="1" value="{{ $item->quantity }}">
                    </td>
                    <td>
                        <span class="shopping-cart__subtotal">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-cart btn btn-link p-0">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                    <path
                                        d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Giỏ hàng trống</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="cart-table-footer d-flex justify-content-between mt-3">
            <div class="position-relative bg-body">
                <a href="{{ route('deposit.list') }}" class="position-relative bg-body p-3 fw-medium d-block"
                    style="border: 1px solid #ddd; border-radius: 5px; text-align: left; text-decoration:none;">
                    Đơn đặt cọc
                </a>


            </div>

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-light">XÓA TOÀN BỘ</button>
            </form>
        </div>
    </div>

    <div class="shopping-cart__totals-wrapper mt-4">
        <div class="sticky-content">
            <div class="shopping-cart__totals">
                <h3>Cart Totals</h3>
                <table class="cart-totals table">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td id="cart-subtotal">0₫</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>Miễn phí</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td id="cart-total">0₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mobile_fixed-btn_wrapper">
                <div class="button-wrapper container">
                    <form action="{{ route('cart.checkout') }}" method="GET" id="checkoutForm">
                        <button type="submit" class="btn btn-primary btn-checkout">
                            PROCEED TO CHECKOUT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal đặt cọc -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cart.submitDeposit') }}" method="POST" id="depositForm">
            @csrf
            <input type="hidden" name="cart_item_id" id="depositItemId">
            <input type="hidden" name="deposit_amount" id="depositAmount">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">Thông tin đặt cọc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Sản phẩm:</strong> <span id="depositProductName"></span></p>
                    <p><strong>Số lượng:</strong> <span id="depositProductQty"></span></p>
                    <p><strong>Giá trị đơn:</strong> <span id="depositProductTotal"></span> VND</p>

                    <div class="mb-3">
                        <label>Tỷ lệ đặt cọc</label>
                        <select class="form-select" id="depositPercentage" required>
                            <option value="">-- Chọn tỷ lệ --</option>
                            <option value="10">10%</option>
                            <option value="15">15%</option>
                            <option value="20">20%</option>
                            <option value="50">50%</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Số tiền đặt cọc</label>
                        <input type="text" id="depositAmountDisplay" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Tên người đặt</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Địa chỉ</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Ngày đặt cọc</label>
                        <input type="date" name="deposit_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phương thức thanh toán</label>
                        <select name="payment_method" id="paymentMethod" class="form-select" required>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>

                    <div id="paypal-button-container" style="display:none; margin-top:15px;"></div>
                </div>
                <div class="modal-footer">
                    <!-- Thêm nút submit để gửi form khi chọn COD -->
                    <!-- <button type="submit" class="btn btn-primary" id="confirmDepositBtn"> -->
                    <!-- Xác nhận đặt cọc -->
                    <!-- </button> -->
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.cart-totals.table th,
.cart-totals.table td {
    background-color: #fff !important;
    color: #000 !important;
    border: none !important;
    padding: 10px 15px;
    vertical-align: middle;
}

.cart-totals.table tr+tr th,
.cart-totals.table tr+tr td {
    border-top: 1px solid #ddd !important;
}

.cart-totals.table {
    border: none !important;
}
</style>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

<script>
function formatCurrency(num) {
    return new Intl.NumberFormat('vi-VN').format(num) + '₫';
}

function updateTotals() {
    let total = 0;
    document.querySelectorAll('.select-item:checked').forEach(cb => {
        const tr = cb.closest('tr');
        total += parseFloat(tr.dataset.subtotal);
    });
    document.getElementById('cart-subtotal').innerText = formatCurrency(total);
    document.getElementById('cart-total').innerText = formatCurrency(total);
}

document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    updateTotals();
});
document.querySelectorAll('.select-item').forEach(cb => cb.addEventListener('change', updateTotals));

document.querySelectorAll('.qty-input').forEach(input => {
    ['input', 'change'].forEach(evt => {
        input.addEventListener(evt, function() {
            const row = this.closest('tr');
            const productId = row.dataset.productId;
            const quantity = parseInt(this.value);

            fetch(`/cart/update-ajax/${productId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.dataset.subtotal = data.item_subtotal_raw;
                        row.querySelector('.shopping-cart__subtotal').innerText =
                            new Intl.NumberFormat('vi-VN').format(data.item_subtotal_raw) +
                            '₫';
                        updateTotals();
                    }
                });
        });
    });
});

let currentOrderTotal = 0;
document.querySelectorAll('.deposit-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('depositProductName').innerText = this.dataset.product;
        document.getElementById('depositProductQty').innerText = this.dataset.qty;
        document.getElementById('depositProductTotal').innerText = this.dataset.total;
        document.getElementById('depositItemId').value = this.dataset.itemId;
        currentOrderTotal = parseFloat(this.dataset.total);

        document.getElementById('depositPercentage').value = "";
        document.getElementById('depositAmountDisplay').value = "";
        document.getElementById('depositAmount').value = "";

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        document.querySelector('input[name="deposit_date"]').value = `${yyyy}-${mm}-${dd}`;
    });
});

document.getElementById('depositPercentage').addEventListener('change', function() {
    const percent = parseFloat(this.value);
    if (!isNaN(percent) && currentOrderTotal > 0) {
        const amount = Math.round(currentOrderTotal * percent / 100);
        document.getElementById('depositAmountDisplay').value = new Intl.NumberFormat('vi-VN').format(amount) +
            '₫';
        document.getElementById('depositAmount').value = amount;

        if (document.getElementById('paymentMethod').value === 'paypal') {
            document.getElementById('paypal-button-container').innerHTML = '';
            renderPayPalButton();
        }
    } else {
        document.getElementById('depositAmountDisplay').value = "";
        document.getElementById('depositAmount').value = "";
    }
});

// Hiển thị nút PayPal khi chọn PayPal
document.getElementById('paymentMethod').addEventListener('change', function() {
    if (this.value === 'paypal') {
        document.getElementById('paypal-button-container').style.display = 'block';
        renderPayPalButton();
    } else {
        document.getElementById('paypal-button-container').style.display = 'none';
    }
});

function renderPayPalButton() {
    let depositAmount = document.getElementById('depositAmount').value;
    if (!depositAmount || depositAmount <= 0) {
        alert('Bạn cần chọn tỷ lệ đặt cọc trước.');
        return;
    }
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

                // Kiểm tra các trường bắt buộc trước khi submit
                const name = document.querySelector('input[name="customer_name"]').value.trim();
                const phone = document.querySelector('input[name="phone"]').value.trim();
                const address = document.querySelector('input[name="address"]').value.trim();
                const depositAmount = document.getElementById('depositAmount').value;

                if (!name || !phone || !address || !depositAmount) {
                    alert('Vui lòng nhập đầy đủ thông tin trước khi thanh toán.');
                    return;
                }

                document.getElementById('depositForm').submit();
            });
        }
    }).render('#paypal-button-container');
}

document.getElementById('checkoutForm')?.addEventListener('submit', function() {
    this.querySelectorAll('input[name="selected_items[]"]').forEach(el => el.remove());
    document.querySelectorAll('.select-item:checked').forEach(cb => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'selected_items[]';
        hidden.value = cb.value;
        this.appendChild(hidden);
    });
});

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('select-all').checked = true;
    document.querySelectorAll('.select-item').forEach(cb => cb.checked = true);
    updateTotals();
});
</script>

@endsection