<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Gateway Configuration
    |--------------------------------------------------------------------------
    | Supports: Fonnte, Wablas, or custom gateway
    */

    'fonnte' => [
        'api_url' => env('FONNTE_API_URL', 'https://api.fonnte.com/send'),
        'api_token' => env('FONNTE_API_TOKEN', ''),
    ],

    'enabled' => env('WHATSAPP_ENABLED', false),

    'admin_phone' => env('WHATSAPP_ADMIN_PHONE', ''),
];
