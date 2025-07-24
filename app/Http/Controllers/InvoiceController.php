<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function printInvoice($id)
    {
        $invoice = Order::with('orderDetails')->findOrFail($id);
        $html = $this->generateInvoiceHtml($invoice);
        $pdf = Pdf::loadHTML($html)->setPaper('a5', 'portrait');
        return $pdf->download('hoa-don-' . $invoice->id . '.pdf');
    }
    public function generateInvoiceHtml($invoice)
    {

        $formatCurrency = function ($amount) {
            return number_format($amount, 0, ',', '.') . ' VNĐ';
        };

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


        $storeInfo = [
            'name' => 'HT Auto Store',
            'address' => 'p.Cao Lãnh, Phạm Hữu Lầu, Đồng Tháp',
            'phone' => '0123 456 789',
            'email' => 'info@songthang.com'
        ];

        ob_start();
?>
        <!DOCTYPE html>
        <html lang="vi">

        <head>
            <meta charset="UTF-8">
            <title>Hóa Đơn <?= $invoice->id ?></title>
            <style>
                @font-face {
                    font-family: 'DejaVu Sans';
                    font-style: normal;
                    font-weight: normal;
                    src: url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/fonts/DejaVuSans.ttf') format('truetype');
                }

                body {
                    font-family: 'DejaVu Sans', sans-serif;
                    background: #f9f1e7;
                    color: #222;
                }

                .invoice {
                    width: 400px;
                    margin: 10px auto;
                    padding: 8px 8px;
                    background: #fff;
                    border: 1px solid #bbb;
                    border-radius: 8px;
                }

                .logo {
                    width: 48px;
                    height: 48px;
                    background: #000;
                    border-radius: 50%;
                    float: left;
                    margin-right: 16px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 12px;
                }

                .header h2 {
                    color: #e53935;
                    margin: 0 0 8px 0;
                    letter-spacing: 2px;
                }

                .store-info {
                    font-size: 13px;
                    color: #555;
                    margin-bottom: 8px;
                }

                .info-row {
                    font-size: 14px;
                    margin-bottom: 8px;
                }

                .items-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 18px 0;
                }

                .items-table th,
                .items-table td {
                    border: 1px solid #bbb;
                    padding: 7px 5px;
                    text-align: center;
                    font-size: 13px;
                }

                .items-table th {
                    background: #f2f2f2;
                }

                .total {
                    text-align: right;
                    font-weight: bold;
                    font-size: 15px;
                    margin-top: 10px;
                }

                .footer {
                    text-align: center;
                    color: #e53935;
                    margin-top: 18px;
                    font-size: 14px;
                }
            </style>
        </head>

        <body>
            <div class="invoice">
                <div style="overflow: hidden;">
                    <div class="logo"></div>
                    <div class="header">
                        <h2>HÓA ĐƠN</h2>
                        <div class="store-info"><?= $storeInfo['name'] ?> | <?= $storeInfo['address'] ?> | <?= $storeInfo['phone'] ?> | <?= $storeInfo['email'] ?></div>
                    </div>
                    <div class="info-row">
                        Khách hàng: <?= $invoice->customer_name ?? '' ?> &nbsp; | &nbsp; Mã hóa đơn: <?= $invoice->id ?>
                    </div>
                    <div class="info-row">
                        Ngày: <?= isset($invoice->date) ? \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') : '' ?>
                    </div>
                </div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Mục</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoice->orderDetails as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item->image_url)): ?>
                                        <img src="<?= $item->image_url ?>" width="38" height="38">
                                    <?php else: ?>
                                        <span style="color:#bbb;">Không có</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item->product_name ?? '' ?></td>
                                <td><?= $item->quantity ?></td>
                                <td><?= $formatCurrency($item->price) ?></td>
                                <td><?= $formatCurrency($item->quantity * $item->price) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total">
                    Tổng cộng: <?= $formatCurrency($invoice->total) ?><br>
                    (Bằng chữ: <?= $convertToWords((int)$invoice->total) ?> đồng)
                </div>
                <div class="footer">
                    <p>XIN CẢM ƠN!</p>
                    <p>Thời gian thanh toán: <?= \Carbon\Carbon::now()->format('d/m/Y H:i') ?></p>
                </div>
            </div>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
