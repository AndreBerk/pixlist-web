<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Os URIs que devem ser ignorados pelo CSRF.
     *
     * IMPORTANTE: Mercado Pago vai fazer POST nessa rota,
     * e não tem como mandar o token _token do Laravel.
     */
    protected $except = [
        'webhook/mercadopago',
    ];
}
