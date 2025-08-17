@extends('layouts.app')

@section('content')
<style>
    th {
        font-weight: bold;
    }

    .description-container {
        line-height: 1.5;
    }

    /* Ghi đè mọi nền tiêu đề bảng */
    .wishlist-table th {
        background-color: transparent !important;
        color: #000 !important;
        font-weight: 600;
        text-align: left;
        padding: 14px 12px;
        white-space: nowrap;
    }

    /* Đường kẻ màu xám phân cách thead và tbody */
    .wishlist-table thead tr {
        border-bottom: 2px solid #999;
        /* bạn có thể dùng #ccc nếu muốn nhạt hơn */
    }


    .wishlist-img {
        width: 100px;
        height: auto;
        object-fit: cover;
        border-radius: 4px;
    }

    .btn-buy-now {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
    }

    .wishlist-table td {
        vertical-align: middle;
        text-align: center;
    }

    /* .wishlist-table th {
    background-color: #0d3b66;
    color: #fff;
    text-align: center;
    vertical-align: middle;
}

.wishlist-table td {
    vertical-align: middle;
    text-align: center;
} */

    .wishlist-img {
        width: 100px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .btn-buy-now {
        background-color: #198754;
        color: white;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .btn-buy-now:hover {
        background-color: #145c3d;
    }

    .table-container {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        overflow: hidden;
    }

    .table td,
    .table th {
        padding: 12px;
    }

    .btn-buy-now {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        /* khoảng cách giữa icon và chữ */
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 16px;
        white-space: nowrap;
        /* Ngăn xuống dòng */
        transition: all 0.3s ease;
    }

    .btn-buy-now i {
        font-size: 18px;
    }

    .btn-buy-now:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .wishlist-heading {
        font-weight: bold;
        font-size: 1.8rem;
        color: #343a40;
    }

    .wishlist-icon {
        color: #dc3545;
        /* Màu đỏ nổi bật */
        margin-right: 10px;
        font-size: 1.4rem;
        vertical-align: middle;
    }
</style>

<div class="container">
    <h2 class="mb-4 text-center text-primary wishlist-heading">
        <i class="bi bi-cart wishlist-icon"></i>

        Thông tin sản phẩm yêu thích
    </h2>




    <div class="table-container">
        <table class="table table-bordered wishlist-table">
            <thead>
                <tr>
                    <th class="fw-bold">Ảnh</th>
                    <th class="fw-bold">Tên sản phẩm</th>
                    <th class="fw-bold">Mô tả ngắn</th>
                    <th class="fw-bold">Giá</th>
                    <th class="fw-bold">Giá khuyến mãi</th>
                    <th class="fw-bold">Mô tả chi tiết</th>
                    <th class="fw-bold">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        @if ($product->primaryImage)
                        <img src="{{ asset('uploads/products/' . $product->primaryImage->imageName) }}"
                            alt="{{ $product->name }}" class="wishlist-img">
                        @else
                        <img src="{{ asset('uploads/products/default.jpg') }}" alt="No image" class="wishlist-img">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->short_description }}</td>
                    <td>{{ number_format($product->regular_price, 0, ',', '.') }}₫</td>
                    <td>
                        @if ($product->sale_price)
                        {{ number_format($product->sale_price, 0, ',', '.') }}₫
                        @else
                        <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td style="max-width: 300px;">
                        <div class="description-container text-start">
                            <div class="description-short">
                                {!! Str::limit(strip_tags($product->description), 100) !!}
                            </div>
                            <div class="description-full d-none">
                                {!! $product->description !!}
                            </div>
                            <a href="#" class="toggle-description text-primary" style="font-size: 14px;">Xem
                                thêm</a>
                        </div>
                    </td>
                    <td>
                        @auth
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-buy-now">
                                <i class="bi bi-cart-plus"></i>
                                <span>Mua ngay</span>
                            </button>


                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-secondary">Đăng nhập để mua</a>
                        @endauth
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleLinks = document.querySelectorAll('.toggle-description');

        toggleLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const container = e.target.closest('.description-container');
                const shortDesc = container.querySelector('.description-short');
                const fullDesc = container.querySelector('.description-full');

                if (fullDesc.classList.contains('d-none')) {
                    shortDesc.classList.add('d-none');
                    fullDesc.classList.remove('d-none');
                    e.target.textContent = 'Thu gọn';
                } else {
                    shortDesc.classList.remove('d-none');
                    fullDesc.classList.add('d-none');
                    e.target.textContent = 'Xem thêm';
                }
            });
        });
    });
</script>

@endsection