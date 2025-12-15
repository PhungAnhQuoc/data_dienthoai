<?php

return [
    'vnpay' => [
        'tmncode' => env('VNPAY_TMN_CODE', '2QXER94V'),
        'hashsecret' => env('VNPAY_HASH_SECRET', 'SFWIRVNSMN7ZFULWBKQNVianuarie'),
        'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymen/vpcpay.html'),
    ],

    'momo' => [
        'partnerid' => env('MOMO_PARTNER_ID'),
        'accesskey' => env('MOMO_ACCESS_KEY'),
        'secretkey' => env('MOMO_SECRET_KEY'),
    ],
];
