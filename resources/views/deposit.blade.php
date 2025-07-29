@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">Danh sách sản phẩm đã đặt cọc</h3>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="text-center">
                <tr>
                    <th>Mã đơn cọc</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Số tiền đã đặt cọc</th>
                    <th>Số tiền còn lại</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt cọc</th>
                    <th>Thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                @php
                $cartItem = $item->cartItem;
                $product = $cartItem?->product;
                $quantity = $cartItem?->quantity ?? 1;
                $price = $cartItem?->price ?? 0;
                $subtotal = $price * $quantity;
                $remaining = $subtotal - $item->deposit_amount;
                @endphp
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $product->name ?? 'Sản phẩm' }}</td>
                    <td class="text-center">{{ $quantity }}</td>
                    <td class="text-end">{{ number_format($price, 0, ',', '.') }}₫</td>
                    <td class="text-end">{{ number_format($item->deposit_amount, 0, ',', '.') }}₫</td>
                    <td class="text-end">{{ number_format($remaining, 0, ',', '.') }}₫</td>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->deposit_date)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('checkout.fromDeposit', $item->id) }}" class="btn btn-danger btn-sm">
                            Thanh toán
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">Chưa có sản phẩm nào được đặt cọc</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* Màu tiêu đề bảng */
.table-responsive table.table>thead,
.table-responsive table.table>thead>tr,
.table-responsive table.table>thead>tr>th {
    background-color: #cfe2ff !important;
    color: #000 !important;
    white-space: nowrap;
}

/* Nút Thanh toán màu đỏ sẫm và chữ trắng */
.btn-danger {
    background-color: #8B0000 !important;
    /* đỏ sẫm */
    border-color: #8B0000 !important;
    color: #fff !important;
    /* chữ trắng */
}

.btn-danger:hover {
    background-color: #a00000 !important;
    /* đỏ sáng khi hover */
    border-color: #a00000 !important;
    color: #fff !important;
}
</style>
@endsection