<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <--- ESTA LINHA ERA A QUE FALTAVA

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Aqui registramos que quando usares <x-admin-layout>
        // o Laravel deve buscar o arquivo em resources/views/layouts/admin.blade.php
        Blade::component('layouts.admin', 'admin-layout');
    }
}
