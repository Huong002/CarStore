@extends('carts')

@section('cart_content')




{{-- Hiển thị thông báo flash dưới dạng toast --}}
@if(session('success') || session('error'))
<div id="toast-message" style="
    position: fixed;
    top: 80px; /* trước là 20px, giờ hạ xuống */
    right: 20px;
    min-width: 280px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    border-radius: 8px;
    color: #fff;
    font-weight: 500;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    background-color: #5E83AE;
">

    {{-- Icon đẹp --}}
    @if(session('success'))
    <span style="font-size:22px;">&#10003;</span> {{-- checkmark --}}
    @else
    <span style="font-size:22px;">&#9888;</span> {{-- warning icon --}}
    @endif

    <span>{{ session('success') ?? session('error') }}</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const toast = document.getElementById('toast-message');
        if (toast) {
            toast.style.transition = 'opacity 0.5s';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 10);
        }
    }, 2000);
});
</script>
@endif

<div class="shopping-cart">
    <div class="cart-table__wrapper">
        <table class="cart-table">
            <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" id="select-all" class="form-check-input">
                    </th>
                    <th>Sản phẩm</th>
                    <th></th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tạm tính</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                @php
                $hasSale = $item->product->sale_price && $item->product->sale_price > 0;
                $price = $hasSale ? $item->product->sale_price : $item->product->regular_price;
                $subtotal = $price * $item->quantity;
                @endphp
                <tr class="cart-item" data-product-id="{{ $item->product->id }}"
                    data-regular-price="{{ $item->product->regular_price }}"
                    data-sale-price="{{ $hasSale ? $item->product->sale_price : 0 }}"
                    data-subtotal="{{ $item->quantity * ($item->product->sale_price ?: $item->product->regular_price) }}">

                    <td class="text-center align-middle" style="width: 40px;">
                        <input type="checkbox" class="form-check-input select-item" name="selected_products[]"
                            value="{{ $item->id }}" checked>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item">
                            <img loading="lazy"
                                src="{{ $item->product && $item->product->primaryImage ? asset('uploads/products/'.$item->product->primaryImage->imageName) : asset('assets/images/no-image.png') }}"
                                width="120" height="120" alt="{{ $item->product->name ?? 'Sản phẩm' }}"
                                style="border-radius: 10px; object-fit: cover;">
                        </div>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item__detail">
                            <h4>{{ $item->product->name ?? 'Sản phẩm' }}</h4>
                            <ul class="shopping-cart__product-item__options">
                                <li>Số lượng còn: {{ $item->product->quantity ?? 0 }}</li>
                                <li>Màu sắc: {{ $item->product->color->name ?? 'Không có' }}</li>
                                <li>Thương hiệu: {{ $item->product->brand->name ?? 'Không có' }}</li>
                                <li>Danh mục: {{ $item->product->category->name ?? 'Không có' }}</li>
                            </ul>
                            <li>
                                <a href="#" class="deposit-link text-primary" style="text-decoration: underline;"
                                    data-product="{{ $item->product->name ?? 'Sản phẩm' }}"
                                    data-qty="{{ $item->quantity }}" data-total="{{ $subtotal }}"
                                    data-item-id="{{ $item->id }}" data-bs-toggle="modal"
                                    data-bs-target="#depositModal">
                                    Nhận đặt cọc
                                </a>
                            </li>
                        </div>
                    </td>
                    <td>
                        <span class="shopping-cart__product-price">
                            @if ($hasSale)
                            <del class="text-muted">
                                {{ number_format($item->product->regular_price, 0, ',', '.') }}₫
                            </del><br>
                            <span class="text-danger fw-bold">
                                {{ number_format($item->product->sale_price, 0, ',', '.') }}₫
                            </span>
                            @else
                            <span class="fw-bold">
                                {{ number_format($item->product->regular_price, 0, ',', '.') }}₫
                            </span>
                            @endif
                        </span>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center qty-input"
                            style="width:70px" min="1" value="{{ $item->quantity }}">
                    </td>
                    <td>
                        <span class="shopping-cart__subtotal item-subtotal">
                            {{ number_format($subtotal, 0, ',', '.') }}₫
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
                    <td colspan="6" class="text-center">Giỏ hàng trống</td>
                </tr>
                @endforelse
            </tbody>

        </table>

        <div class="cart-table-footer">
            <form action="{{ route('deposit.list') }}" class="position-relative bg-body">
                <input class="form-control" type="text" name="search_deposit" placeholder="Tìm kiếm đơn đã đặt cọc">
                <button type="submit" class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                    style="border: none; background: none; color: #0d6efd;">
                    Đơn đặt cọc
                </button>
            </form>

            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-light" style="border-radius: 6px;">
                    Xóa toàn bộ
                </button>
            </form>
        </div>
    </div>

    <div class="shopping-cart__totals-wrapper mt-4">
        <div class="sticky-content">
            <div class="shopping-cart__totals">
                <h3>Tổng giỏ hàng</h3>
                <table class="cart-totals">
                    <tbody>
                        <tr>
                            <th>Tạm tính</th>
                            <td id="cart-subtotal">0₫</td>
                        </tr>
                        <tr>
                            <th>Phí vận chuyển</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="shipping_method" id="free_shipping" value="0" checked
                                        data-method-name="Miễn phí (Nội thành tỉnh Đồng Tháp)" data-shipping-fee="0">
                                    <label class="form-check-label" for="free_shipping">
                                        Miễn phí (Nội thành tỉnh Đồng Tháp)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="shipping_method" id="standard_shipping" value="100000000"
                                        data-method-name="Giao hàng tiêu chuẩn" data-shipping-fee="100000000">
                                    <label class="form-check-label" for="standard_shipping">
                                        Giao hàng tiêu chuẩn (100.000.000₫) Khu vực khác
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="shipping_method" id="store_pickup" value="50000000"
                                        data-method-name="Nhận tại cửa hàng" data-shipping-fee="50000000">
                                    <label class="form-check-label" for="store_pickup">
                                        Nhận tại cửa hàng (50.000.000₫)
                                    </label>
                                </div>

                                <div class="mt-3">
                                    <strong>Giao đến:</strong>
                                    <span id="current-address">123 Đường ABC, TP. Cao Lãnh, Đồng Tháp</span>
                                </div>

                                <div class="mt-2">
                                    <a href="#" id="change-address-link" class="menu-link menu-link_us-s text-primary"
                                        style="text-decoration: underline; cursor: pointer;">
                                        THAY ĐỔI ĐỊA CHỈ
                                    </a>
                                </div>

                                <div class="mt-2 d-none" id="address-input-wrapper">
                                    <input type="text" id="new-address" class="form-control mb-2"
                                        placeholder="Nhập địa chỉ mới">
                                    <button type="button" id="update-address" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-save"></i> Cập nhật địa chỉ
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Thuế (10%)</th>
                            <td id="cart-tax">0₫</td>
                        </tr>
                        <tr>
                            <th>Tổng cộng</th>
                            <td id="cart-total">0₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mobile_fixed-btn_wrapper">
                <div class="button-wrapper container">
                    <form action="{{ route('cart.checkout') }}" method="GET" id="checkoutForm">
                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                        <input type="hidden" name="tax" value="{{ $tax }}">
                        <input type="hidden" name="shipping_fee" id="shipping_fee" value="{{ $shippingFee }}">
                        <input type="hidden" name="shipping_method_name" id="shipping_method_name"
                            value="{{ $shippingMethodName }}">
                        <!-- <input type="hidden" name="total" value="{{ $total }}"> -->
                        <button type="submit" class="btn btn-primary btn-checkout"
                            style="padding: 10px 20px; border-radius: 5px;">
                            TIẾN HÀNH THANH TOÁN
                        </button>
                    </form>


                </div>

            </div>
        </div>
    </div>
</div>

<!-- <div class="shopping-cart">

    <div class="cart-table__wrapper">
        <table class="cart-table table">
            <thead>
                <tr>
                    <th style="white-space: nowrap;"><input type="checkbox" id="select-all"></th>
                    <th style="white-space: nowrap;">Sản phẩm</th>
                    <th style="white-space: nowrap;"></th>
                    <th style="white-space: nowrap;">Giá</th>
                    <th style="white-space: nowrap;">Số lượng</th>
                    <th style="white-space: nowrap;">Tạm tính</th>
                    <th style="white-space: nowrap;"></th>
                    <th style="white-space: nowrap;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr data-product-id="{{ $item->product_id }}" data-price="{{ $item->price }}"
                    data-subtotal="{{ $item->price * $item->quantity }}">
                    <td>
                        <input type="checkbox" class="select-item" value="{{ $item->id }}">
                    </td>
                    <td>
                        <div class="shopping-cart__product-item text-center">
                            @if($item->product && $item->product->primaryImage)
                            <img loading="lazy"
                                src="{{ asset('uploads/products/'.$item->product->primaryImage->imageName) }}"
                                width="120" height="120" alt="{{ $item->product->name }}"
                                style="border-radius: 10px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            @else
                            <img loading="lazy" src="{{ asset('assets/images/no-image.png') }}" width="120" height="120"
                                alt="Không có hình"
                                style="border-radius: 10px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            @endif
                        </div>
                    </td>


                    <td>
                        <div class="shopping-cart__product-item__detail">
                           
                            <h4
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                {{ $item->product->name ?? 'Sản phẩm' }}
                            </h4>

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
                <a href="{{ route('deposit.list') }}"
                    class="position-relative p-3 fw-medium d-flex align-items-center gap-2" style="border: 1px solid #5E83AE; 
              background-color: #5E83AE; 
              border-radius: 5px; 
              text-decoration: none; 
              color: #fff;">
                    <i class="bi bi-journal-text" style="font-size: 1.2rem;"></i>
                    Đơn đặt cọc
                </a>

            </div>


            <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: -10px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1"
                    style="border-radius: 8px; padding: 6px 12px;">
                    <i class="bi bi-trash"></i> Xóa toàn bộ
                </button>
            </form>

        </div>
    </div>

    <div class="shopping-cart__totals-wrapper mt-4">
        <div class="sticky-content">
            <div class="shopping-cart__totals">
                <h3>Tổng giỏ hàng</h3>
                <table class="cart-totals table">
                    <tbody>
                        <tr>
                            <th>Tạm tính</th>
                            <td id="cart-subtotal">0₫</td>
                        </tr>
                        <tr>
                            <th>Phí vận chuyển</th>
                            <td>Miễn phí</td>
                        </tr>
                        <tr>
                            <th>Tổng cộng</th>
                            <td id="cart-total">0₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mobile_fixed-btn_wrapper">
                <div class="button-wrapper container">
                    <form action="{{ route('cart.checkout') }}" method="GET" id="checkoutForm">
                        <button type="submit" class="btn btn-checkout"
                            style="background-color:#5E83AE; border:none; color:white; padding:10px 20px; border-radius:5px;">
                            TIẾN HÀNH THANH TOÁN
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div> -->

<!-- Modal đặt cọc -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cart.submitDeposit') }}" method="POST" id="depositForm">
            @csrf
            <input type="hidden" name="cart_item_id" id="depositItemId">
            <input type="hidden" name="deposit_amount" id="depositAmount">

            <div class="modal-content">
                <div class="modal-header" style="background-color: #f9f9f9;">
                    <h5 class="modal-title d-flex align-items-center" id="depositModalLabel"
                        style="color:#5E83AE; font-weight:600;">
                        <i class="bi bi-cash-coin me-2"></i> Thông tin đặt cọc
                    </h5>
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
                        <input type="text" name="phone" class="form-control" required pattern="^[0-9]{10}$"
                            title="Số điện thoại phải đúng 10 chữ số và không chứa ký tự đặc biệt">
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
                            <option value="cod">Thanh toán tiền mặt</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>


                    <!-- Nút Thanh toán -->
                    <button id="cash-payment-button" class="btn btn-primary mt-3" style="display: none;">
                        Thanh toán
                    </button>

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
<!-- 
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

    /* Khung bảng tổng thể */
    .cart-table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        border-radius: 10px;
        /* Bo góc */
        overflow: hidden;
        font-size: 15px;

        /* Làm bảng nổi lên */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    /* Header */
    .cart-table thead {
        background-color: #5E83AE !important;
    }

    .cart-table thead th {
        color: #fff !important;
        font-weight: 600;
        padding: 14px 10px;
        text-align: center;
        border: none !important;
    }

    /* Dòng dữ liệu */
    .cart-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.25s ease;
    }

    .cart-table tbody tr:hover {
        background-color: #f7faff;
        /* nền nhạt khi hover */
    }

    /* Cột tên sản phẩm */
    .shopping-cart__product-item__detail h4 {
        font-size: 15px;
        margin-bottom: 4px;
        color: #333;
        transition: color 0.3s ease;
    }

    .cart-table tbody tr:hover .shopping-cart__product-item__detail h4 {
        color: #5E83AE;
    }

    /* Ảnh sản phẩm */
    .shopping-cart__product-item img {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    /* Canh giữa các cột */
    .cart-table td,
    .cart-table th {
        vertical-align: middle;
        padding: 12px 10px;
    }

    .cart-table td:nth-child(1),
    .cart-table td:nth-child(4),
    .cart-table td:nth-child(5),
    .cart-table td:nth-child(6),
    .cart-table th:nth-child(1),
    .cart-table th:nth-child(4),
    .cart-table th:nth-child(5),
    .cart-table th:nth-child(6) {
        text-align: center;
    }
</style> -->

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

<script>
function formatCurrency(num) {
    return new Intl.NumberFormat('vi-VN').format(num) + '₫';
}

function updateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.select-item:checked').forEach(cb => {
        const tr = cb.closest('tr');
        subtotal += parseFloat(tr.dataset.subtotal || 0);
    });

    const taxRate = 0.1;
    const taxAmount = Math.round(subtotal * taxRate);

    let shippingFee = 0;
    const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
    if (selectedShipping) {
        shippingFee = parseFloat(selectedShipping.dataset.shippingFee || 0);
    }

    const total = subtotal + taxAmount + shippingFee;

    document.getElementById('cart-subtotal').innerText = formatCurrency(subtotal);
    document.getElementById('cart-tax').innerText = formatCurrency(taxAmount);
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.innerText = formatCurrency(total);
}

// Chọn tất cả
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    updateTotals();
});

document.querySelectorAll('.select-item').forEach(cb => cb.addEventListener('change', updateTotals));

// Cập nhật số lượng
document.querySelectorAll('.qty-input').forEach(input => {
    ['input', 'change'].forEach(evt => {
        input.addEventListener(evt, function() {
            const row = this.closest('tr');
            const productId = row.dataset.productId;
            const quantity = parseInt(this.value);

            // const salePrice = parseFloat(row.dataset.salePrice);
            // const regularPrice = parseFloat(row.dataset.regularPrice);

            const salePrice = parseFloat(row.dataset.salePrice || 0);
            const regularPrice = parseFloat(row.dataset.regularPrice || 0);
            // const unitPrice = (!isNaN(salePrice) && salePrice > 0) ? salePrice : regularPrice;

            // Ưu tiên salePrice nếu có, nếu không thì dùng regularPrice
            let unitPrice = 0;
            if (!isNaN(salePrice) && salePrice > 0) {
                unitPrice = salePrice;
            } else if (!isNaN(regularPrice) && regularPrice > 0) {
                unitPrice = regularPrice;
            }

            const newSubtotal = unitPrice * quantity;

            // const newSubtotal = unitPrice * quantity;
            row.dataset.subtotal = newSubtotal;

            row.querySelector('.shopping-cart__subtotal').innerText = formatCurrency(
                newSubtotal);

            // Cập nhật modal đặt cọc (nếu có)
            const depositLink = row.querySelector('.deposit-link');
            if (depositLink) {
                depositLink.dataset.qty = quantity;
                depositLink.dataset.total = newSubtotal;
            }

            updateTotals(); // Gọi ngay với subtotal mới

            // Gửi AJAX cập nhật
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
                            formatCurrency(data.item_subtotal_raw);
                        updateTotals();
                    }
                })
                .catch(err => console.error('Lỗi cập nhật số lượng:', err));
        });
    });
});

// Đặt cọc
let currentOrderTotal = 0;
document.querySelectorAll('.deposit-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('depositProductName').innerText = this.dataset.product;
        document.getElementById('depositProductQty').innerText = this.dataset.qty;
        document.getElementById('depositProductTotal').innerText = formatCurrency(this.dataset.total);
        document.getElementById('depositItemId').value = this.dataset.itemId;
        currentOrderTotal = parseFloat(this.dataset.total);
        document.getElementById('depositPercentage').value = "";
        document.getElementById('depositAmountDisplay').value = "";
        document.getElementById('depositAmount').value = "";

        const today = new Date();
        document.querySelector('input[name="deposit_date"]').value = today.toISOString().split('T')[0];
    });
});

document.getElementById('depositPercentage')?.addEventListener('change', function() {
    const percent = parseFloat(this.value);
    if (!isNaN(percent) && currentOrderTotal > 0) {
        const amount = Math.round(currentOrderTotal * percent / 100);
        document.getElementById('depositAmountDisplay').value = formatCurrency(amount);
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

document.getElementById('paymentMethod')?.addEventListener('change', function() {
    const paypalContainer = document.getElementById('paypal-button-container');
    const cashButton = document.getElementById('cash-payment-button');

    if (this.value === 'paypal') {
        paypalContainer.style.display = 'block';
        cashButton.style.display = 'none';
        renderPayPalButton();
    } else {
        paypalContainer.style.display = 'none';
        cashButton.style.display = 'inline-block';
    }
});

function renderPayPalButton() {
    let depositAmount = document.getElementById('depositAmount').value;
    if (!depositAmount || depositAmount <= 0) {
        alert('Bạn cần chọn tỷ lệ đặt cọc trước.');
        return;
    }

    const paypalContainer = document.getElementById('paypal-button-container');
    paypalContainer.innerHTML = "";

    const usdAmount = (depositAmount / 24000).toFixed(2);

    paypal.Buttons({
        createOrder: (data, actions) => actions.order.create({
            purchase_units: [{
                amount: {
                    value: usdAmount
                }
            }]
        }),
        onApprove: (data, actions) => actions.order.capture().then(details => {
            alert('Thanh toán PayPal thành công: ' + details.id);

            const name = document.querySelector('input[name="customer_name"]').value.trim();
            const phone = document.querySelector('input[name="phone"]').value.trim();
            const address = document.querySelector('input[name="address"]').value.trim();
            const depositAmount = document.getElementById('depositAmount').value;

            if (!name || !phone || !address || !depositAmount) {
                alert('Vui lòng nhập đầy đủ thông tin trước khi thanh toán.');
                return;
            }

            document.getElementById('depositForm').submit();
        })
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

    const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
    if (selectedShipping) {
        document.getElementById('shipping_fee').value = selectedShipping.value;
        document.getElementById('shipping_method_name').value = selectedShipping.dataset.methodName;
    }
});

// Tải trang
window.addEventListener('DOMContentLoaded', () => {
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.checked = false;
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = false);
    }
    updateTotals();
});

// Cập nhật khi thay đổi phương thức giao hàng
document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', updateTotals);
});

// Đổi địa chỉ
const changeLink = document.getElementById("change-address-link");
const inputWrapper = document.getElementById("address-input-wrapper");
const updateButton = document.getElementById("update-address");
const currentAddress = document.getElementById("current-address");
const newAddressInput = document.getElementById("new-address");

changeLink?.addEventListener("click", function(e) {
    e.preventDefault();
    inputWrapper.classList.toggle("d-none");
});

updateButton?.addEventListener("click", function() {
    const newAddress = newAddressInput.value.trim();
    if (newAddress !== "") {
        currentAddress.textContent = newAddress;
        inputWrapper.classList.add("d-none");
        newAddressInput.value = "";
    } else {
        alert("Vui lòng nhập địa chỉ mới.");
    }
});
</script>









<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const changeLink = document.getElementById("change-address-link");
    const inputWrapper = document.getElementById("address-input-wrapper");
    const updateButton = document.getElementById("update-address");
    const currentAddress = document.getElementById("current-address");
    const newAddressInput = document.getElementById("new-address");

    changeLink?.addEventListener("click", function(e) {
        e.preventDefault();
        inputWrapper.classList.toggle("d-none");
    });

    updateButton?.addEventListener("click", function() {
        const newAddress = newAddressInput.value.trim();
        if (newAddress !== "") {
            currentAddress.textContent = newAddress;
            inputWrapper.classList.add("d-none");
            newAddressInput.value = "";
        } else {
            alert("Vui lòng nhập địa chỉ mới.");
        }
    });

    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(number);
    }

    function updateCartTotals() {
        let subtotal = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const checkbox = row.querySelector('.product-select-checkbox');
            if (checkbox && checkbox.checked) {
                const itemSubtotal = parseFloat(row.dataset.subtotal || 0);
                subtotal += itemSubtotal;
            }
        });

        const tax = subtotal * 0.1;
        const shipping = parseFloat(document.querySelector('input[name="shipping_method"]:checked')?.value ||
            0);
        const total = subtotal + tax + shipping;

        const cartSubtotalEl = document.getElementById('cart-subtotal');
        if (cartSubtotalEl) {
            cartSubtotalEl.textContent = formatCurrency(subtotal);
            cartSubtotalEl.dataset.value = subtotal;
        }

        document.getElementById('cart-tax').textContent = formatCurrency(tax);
        document.getElementById('cart-total').textContent = formatCurrency(total);
    }

    // Gọi lúc đầu
    updateCartTotals();

    // Checkbox sản phẩm – cập nhật lại tổng tiền
    document.querySelectorAll('.product-select-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCartTotals();
        });
    });

    // Phương thức vận chuyển – cập nhật lại tổng tiền
    document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
        input.addEventListener('change', updateCartTotals);
    });

    // -------- THÊM CHỨC NĂNG "CHỌN TẤT CẢ" -------- //
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const productCheckboxes = document.querySelectorAll('.product-select-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateCartTotals();
        });
    }

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!checkbox.checked) {
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = false;
                }
            } else {
                const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
            }
            updateCartTotals();
        });
    });

});
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('depositForm');

    form.addEventListener('submit', function(e) {
        const phone = form.querySelector('input[name="phone"]').value;
        const email = form.querySelector('input[name="email"]')?.value;

        const phoneRegex = /^\d{10}$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            showToast(
                'Số điện thoại không hợp lệ. Phải gồm đúng 10 chữ số và không chứa ký tự đặc biệt.',
                'danger');
            return;
        }

        // if (email && !emailRegex.test(email)) {
        //     e.preventDefault();
        //     showToast('Email không đúng định dạng.', 'danger');
        //     return;
        // }
    });

    // Hiển thị nút tương ứng khi chọn phương thức thanh toán
    const method = document.getElementById('paymentMethod');
    const cashBtn = document.getElementById('cash-payment-button');
    const paypalBtn = document.getElementById('paypal-button-container');

    method.addEventListener('change', function() {
        if (method.value === 'cod') {
            cashBtn.style.display = 'block';
            paypalBtn.style.display = 'none';
        } else {
            cashBtn.style.display = 'none';
            paypalBtn.style.display = 'block';
        }
    });
});
</script>


@endsection