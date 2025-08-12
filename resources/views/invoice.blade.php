<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Hóa đơn đơn hàng #{{ $order->id }}</title>
    <style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 14px;
        color: #333;
        max-width: 800px;
        margin: 10px auto;
        background: #fff;
        padding: 15px 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    header img {
        max-height: 80px;
        /* giữ logo cao tối đa 80px */
    }

    header div {
        flex: 1;
    }

    header h2 {
        margin: 0;
        color: #B9A16B;
        letter-spacing: 1.5px;
    }

    header p {
        margin: 2px 0;
        font-size: 13px;
        color: #555;
    }

    h1,
    h3 {
        color: #B9A16B;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    h1 {
        font-size: 28px;
        border-bottom: 3px solid #B9A16B;
        padding-bottom: 6px;
    }

    h3 {
        font-size: 22px;
        margin-top: 30px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 5px;
    }

    .order-info,
    .customer-info,
    .notes {
        margin: 20px 0;
        font-size: 15px;
    }

    .order-info div,
    .customer-info div {
        margin-bottom: 6px;
    }

    .order-info label,
    .customer-info label {
        font-weight: 700;
        width: 160px;
        display: inline-block;
        color: #555;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
    }

    table thead tr {
        background-color: #f7f2d9;
        color: #6f5e16;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 14px;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        vertical-align: middle;
        transition: background-color 0.25s ease;
    }

    table tbody tr:hover {
        background-color: #fcf8e3;
    }

    .text-right {
        text-align: right;
    }

    /* Bảng tổng tiền - bỏ float */
    table.summary {
        margin-top: 30px;
        width: 100%;
        font-size: 16px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 6px 20px rgba(185, 161, 107, 0.15);
        border: 1px solid #b9a16b;
    }

    table.summary th,
    table.summary td {
        border: none;
        padding: 12px 15px;
    }

    table.summary th {
        font-weight: 700;
        color: #5a5130;
        width: 65%;
    }

    table.summary td {
        font-weight: 700;
        color: #b9a16b;
    }

    table.summary tr:last-child td {
        font-size: 20px;
        font-weight: 900;
        color: #8c7600;
        border-top: 3px solid #b9a16b;
        padding-top: 14px;
    }

    /* Xoá float sau bảng tổng */
    .clearfix::after {
        content: "";
        display: block;
        clear: both;
    }



    footer div p {
        margin: 5px 0 0 0;
        /* giảm margin top để tránh xuống dòng */
        font-style: italic;
        color: #999;
    }


    /* Responsive */
    @media screen and (max-width: 640px) {
        body {
            margin: 15px 10px;
            padding: 20px 15px;
        }

        table.summary {
            width: 100%;
            float: none;
            margin-top: 30px;
        }

        .order-info label,
        .customer-info label {
            width: 140px;
        }

        footer {
            flex-direction: column;
        }

        footer div {
            width: 100%;
            margin-bottom: 30px;
            text-align: center !important;
        }
    }

    /* CSS cho in ấn - gom 1 trang */
    @media print {
        body {
            max-width: 100%;
            margin: 0;
            padding: 10px;
            box-shadow: none;
            border: none;
        }

        header,
        h1,
        h3,
        .order-info,
        .customer-info,
        table,
        .notes,
        /* footer {
            page-break-inside: avoid;
            page-break-before: auto;
            page-break-after: auto;
        } */

        table.summary {
            width: 100% !important;
            float: none !important;
        }


    }

    footer {
        margin-top: 40px;
        display: flex;
        flex-direction: row;
        /* Luôn nằm ngang */
        justify-content: space-between;
        /* Đẩy ra 2 bên */
        align-items: flex-start;
        font-size: 14px;
        gap: 40px;
        /* Khoảng cách giữa 2 khối */
    }

    footer div {
        width: auto;
        /* Không chiếm toàn bộ chiều ngang */
    }

    footer div:first-child {
        text-align: left;
    }

    footer div:last-child {
        text-align: right;
    }

    /* Khi in vẫn giữ nguyên layout */
    @media print {
        footer {
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            gap: 40px !important;
        }
    }
    </style>
</head>

<body>

    <!-- Header công ty với logo bên trái -->
    <header style="display: table; width: 100%;">
        <div style="display: table-cell; vertical-align: middle; text-align: left;">
            <h2 style="margin: 0;">Showroom HTAutoStore</h2>
            <p style="margin: 0;">Địa chỉ: Cao Lãnh, Đồng Tháp</p>
            <p style="margin: 0;">Điện thoại: 0909 123 456</p>
            <p style="margin: 0;"> Email: htauto.store@gmail.com</p>
            <p style="margin: 0;">Mã số thuế: 0123456789</p>
        </div>
        <div style="display: table-cell; vertical-align: middle; text-align: right;">
            <img src="{{ public_path('assets/images/logo.png') }}" alt="Logo công ty" style="max-height: 80px;">
        </div>
    </header>


    <h1>Hóa đơn #{{ $order->id }}</h1>

    <!-- Thông tin đơn hàng -->
    <div class="order-info">
        <div><label>Ngày đặt:</label> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</div>
        <div><label>Trạng thái:</label> {{ ucfirst($order->status) }}</div>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="customer-info">
        <h3>Thông tin khách hàng</h3>
        <div><label>Họ tên:</label> {{ $order->customer->customerName ?? 'Khách hàng' }}</div>
        <div><label>Địa chỉ:</label> {{ $order->customer->address ?? 'Chưa cập nhật' }}</div>
        <div><label>Điện thoại:</label> {{ $order->customer->phone ?? 'Chưa cập nhật' }}</div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <h3>Chi tiết sản phẩm</h3>

    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th class="text-right">Đơn giá</th>
                <th class="text-right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            @php
            $product = $detail->product;
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
                <td class="text-right">{{ number_format($unitPrice, 0, ',', '.') }}₫</td>
                <td class="text-right">{{ number_format($lineTotal, 0, ',', '.') }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tổng tiền -->
    <table class="summary clearfix">
        <tbody>
            <tr>
                <th>Tạm tính</th>
                <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}₫</td>
            </tr>
            <tr>
                <th>Thuế (VAT 10%)</th>
                <td class="text-right">{{ number_format($tax, 0, ',', '.') }}₫</td>
            </tr>
            <tr>
                <th>Tổng cộng</th>
                <td class="text-right" style="font-weight: bold;">{{ number_format($total, 0, ',', '.') }}₫</td>
            </tr>
        </tbody>
    </table>

    <!-- Ghi chú -->
    <div class="notes">
        <p><em>Lưu ý: Hóa đơn này có giá trị khi có chữ ký hoặc đóng dấu của Showroom HTAutoStore.</em></p>
    </div>

    <!-- Chữ ký -->
    <footer style="display: table; width: 100%; margin-top: 50px;">
        <div style="display: table-cell; width: 50%; text-align: center;">
            <strong>Người bán hàng</strong>
            <p>(Ký, ghi rõ họ tên)</p>
        </div>
        <div style="display: table-cell; width: 50%; text-align: center;">
            <strong>Khách hàng</strong>
            <p>(Ký, ghi rõ họ tên)</p>
        </div>
    </footer>




</body>

</html>