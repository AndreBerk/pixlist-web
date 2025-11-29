<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Credenciais do Mercado Pago
    |--------------------------------------------------------------------------
    | Esses valores vêm do .env
    */

    'access_token' => env('MP_ACCESS_TOKEN'),
    'public_key'   => env('MP_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret (opcional)
    |--------------------------------------------------------------------------
    | Se você quiser validar a origem do webhook depois
    */

    'webhook_secret' => env('MP_WEBHOOK_SECRET'),
];
