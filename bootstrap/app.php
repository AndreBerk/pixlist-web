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

        // 1. REGISTRA OS APELIDOS (ALIASES)
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // O nosso alias (este está correto)
            'checklist' => \App\Http\Middleware\CheckListStatus::class,
        ]);

        // =========================================================
        // 2. A CORREÇÃO ESTÁ AQUI
        // Adicionamos a exceção do CSRF para o Webhook
        // =========================================================
        $middleware->validateCsrfTokens(except: [
            '/webhook/mercadopago'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
