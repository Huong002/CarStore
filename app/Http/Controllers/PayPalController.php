<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalController extends Controller
{
    private $apiContext;
    private $rate;

    public function __construct()
    {
        $paypalConf = config('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConf['sandbox']['client_id'],
                $paypalConf['sandbox']['client_secret']
            )
        );
        $this->apiContext->setConfig(['mode' => $paypalConf['mode']]);

        $this->rate = env('PAYPAL_RATE', 24000); // tỷ giá VND -> USD
    }

    // Hiển thị trang chọn thanh toán
    public function index()
    {
        return view('paypal.index'); // tạo view sau
    }

    // Gọi khi nhấn nút Thanh toán PayPal
    public function payWithPayPal(Request $request)
    {
        // Lấy số tiền VNĐ từ form
        $vnd = $request->input('amount');
        $usd = round($vnd / $this->rate, 2);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal($usd);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription("Thanh toán $vnd VNĐ (quy đổi $usd USD)");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success'))
                     ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }

        return redirect()->away($payment->getApprovalLink());
    }

    public function success(Request $request)
    {
        $paymentId = $request->paymentId;
        $payerId = $request->PayerID;

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        // Có thể lưu thông tin vào DB ở đây
        return "Thanh toán thành công! Mã giao dịch: " . $result->getId();
    }

    public function cancel()
    {
        return "Thanh toán đã bị hủy.";
    }
}