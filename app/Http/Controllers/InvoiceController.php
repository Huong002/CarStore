<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class InvoiceController extends Controller
{
    // tao tin hoa don'
    public function printInvoice($id)
    {
        $invoice = Order::with('orderDetails')->findOrFail($id);
        $html = $this->generateInvoiceHtml($invoice);
        return response($html)->header('Content-Type', 'text/html');
    }
    // tao noi dung html hoa don
    public function generateInvoiceHtml($invoice)
    {
        // Định dạng tiền tệ
        $formatCurrency = function ($amount) {
            return number_format($amount, 0, ',', '.') . ' VNĐ';
        };

        // Chuyển số tiền thành chữ (hàm đơn giản, có thể dùng thư viện khác)
        $convertToWords = function ($number) {
            $words = [
                '',
                'một',
                'hai',
                'ba',
                'bốn',
                'năm',
                'sáu',
                'bảy',
                'tám',
                'chín'
            ];
            return $words[$number] ?? 'không'; 
        };

        // Dữ liệu mẫu cho thông tin cửa hàng
        $storeInfo = [
            'name' => 'Sirdà Song Thắng',
            'address' => 'p.Cao Lãnh, Phạm Hữu Lầu, Đồng Tháp',
            'phone' => '0123 456 789',
            'email' => 'info@songthang.com'
        ];

        // Tạo nội dung HTML
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="vi">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hóa Đơn <?= $invoice->id ?></title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f9f1e7;
                }

                .invoice {
                    width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #000;
                }

                .logo {
                    width: 50px;
                    height: 50px;
                    background: #000;
                    border-radius: 50%;
                    float: left;
                }

                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .store-info {
                    font-size: 12px;
                    color: #555;
                }

                .items-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }

                .items-table th,
                .items-table td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }

                .items-table th {
                    background: #f2f2f2;
                }

                .total {
                    text-align: right;
                    font-weight: bold;
                }

                .footer {
                    text-align: center;
                    color: #ff0000;
                    margin-top: 20px;
                }

                @media print {
                    body {
                        margin: 0;
                    }
                }
            </style>
        </head>

        <body onload="window.print()">
            <div class="invoice">
                <div style="overflow: hidden;">
                    <div class="logo" style="background-image: url('/images/logo.png');"></div>
                    <div class="header">
                        <h2 style="color: #ff0000;">HÓA ĐƠN</h2>
                        <p><?= $storeInfo['name'] ?></p>
                        <p class="store-info"><?= $storeInfo['address'] ?> | <?= $storeInfo['phone'] ?> | <?= $storeInfo['email'] ?></p>
                        <p>Khách hàng: <?= $invoice->customer_name ?? '' ?> | Mã hóa đơn: <?= $invoice->id ?></p>
                        <p>Ngày: <?= isset($invoice->date) ? \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') : '' ?></p>
                    </div>
                </div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>ẢNH</th>
                            <th>MỤC</th>
                            <th>SỐ LƯỢNG</th>
                            <th>ĐƠN GIÁ</th>
                            <th>THÀNH TIỀN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoice->orderDetails as $item): ?>
                            <tr>
                                <td><img src="<?= $item->image_url ?? '/images/default.png' ?>" width="50" height="50"></td>
                                <td><?= $item->product_name ?? '' ?></td>
                                <td><?= $item->quantity ?></td>
                                <td><?= $formatCurrency($item->price) ?></td>
                                <td><?= $formatCurrency($item->quantity * $item->price) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total">
                    <p>Tổng cộng: <?= $formatCurrency($invoice->total) ?></p>
                    <p>(Bằng chữ: <?= $convertToWords((int)$invoice->total) ?> triệu đồng)</p>
                </div>
                <div class="footer">
                    <p style="color: #ff0000;">XIN CẢM ƠN!</p>
                    <p>Thời gian thanh toán: <?= \Carbon\Carbon::now()->format('d/m/Y H:i') ?></p>
                </div>
            </div>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
