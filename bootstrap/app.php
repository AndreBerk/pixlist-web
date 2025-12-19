<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        /*
        |--------------------------------------------------------------------------
        | ALIASES DE MIDDLEWARE (substitui o antigo Kernel.php)
        |--------------------------------------------------------------------------
        */
        $middleware->alias([

            // Auth padrão
            'auth'               => \Illuminate\Auth\Middleware\Authenticate::class,
            'auth.session'       => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'guest'              => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'verified'           => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'password.confirm'   => \Illuminate\Auth\Middleware\RequirePassword::class,
            'can'                => \Illuminate\Auth\Middleware\Authorize::class,
            'throttle'           => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'cache.headers'      => \Illuminate\Http\Middleware\SetCacheHeaders::class,

            // Seus middlewares customizados
            'terms.accepted' => \App\Http\Middleware\EnsureTermsAccepted::class,
            'checklist' => \App\Http\Middleware\CheckListStatus::class, // Suponho que este já exista
        ]);

        /*
        |--------------------------------------------------------------------------
        | EXCEÇÕES DE CSRF
        |--------------------------------------------------------------------------
        */
        $middleware->validateCsrfTokens(except: [
            '/webhook/mercadopago',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })


    ->create();
