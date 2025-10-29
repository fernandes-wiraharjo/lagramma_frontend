<?php

return [
    'bank_accounts' => [
        [
            'bank' => env('LAGRAMMA_BANK', ''),
            'account_name' => env('LAGRAMMA_BANK_ACCOUNT_NAME', ''),
            'account_number' => env('LAGRAMMA_BANK_ACCOUNT_NUMBER', ''),
            // 'branch' => 'Jakarta'
        ],
        // [
        //     'bank' => 'Mandiri',
        //     'account_name' => 'PT. Example Shop',
        //     'account_number' => '9876543210',
        //     'branch' => 'Jakarta'
        // ],
    ],
    // default how many days to set expiry for manual payments
    // 'expiry_days' => env('PAYMENT_EXPIRY_DAYS', 3),
];
