<?php
return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'client_id'     => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
        'app_id'        => '',
    ],
    'live' => [
        'client_id'     => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
        'app_id'        => '',
    ],

    'payment_action' => 'Sale',
    'currency'       => 'USD', // PayPal không hỗ trợ VND
    'notify_url'     => '',
    'locale'         => 'en_US',
];