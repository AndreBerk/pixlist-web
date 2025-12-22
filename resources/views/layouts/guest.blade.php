<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pixlist') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest" defer></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
</head>

<body class="font-sans bg-gray-50 text-gray-800 min-h-screen flex flex-col">

<header class="bg-white/80 backdrop-blur border-b border-gray-200 sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
        <a href="{{ route('welcome') }}" class="flex items-center gap-2">
            <span class="inline-flex w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-400"></span>
            <span class="text-2xl font-extrabold tracking-tight text-emerald-600">Pixlist</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('login') }}"
               class="text-gray-600 hover:text-emerald-700 font-semibold transition px-3 py-2 rounded-lg">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="px-4 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-sm hover:bg-emerald-700 transition">
                Criar minha lista
            </a>
        </div>
    </nav>
</header>

<main class="flex-1">
    {{ $slot }}
</main>

<footer class="border-t border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center space-y-3">
        <p class="text-sm text-gray-500">© {{ now()->year }} Pixlist. Todos os direitos reservados.</p>

        @php
            $termsRoute = \Illuminate\Support\Facades\Route::has('terms')
                ? route('terms')
                : (\Illuminate\Support\Facades\Route::has('termos') ? route('termos') : url('/termos'));
        @endphp

        <div class="flex flex-wrap justify-center items-center gap-3 text-sm">
            <a href="{{ $termsRoute }}" class="font-semibold text-emerald-600 hover:underline px-1">Termos de Uso</a>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <a href="{{ $termsRoute }}#privacidade" class="font-semibold text-emerald-600 hover:underline px-1">Política de Privacidade</a>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) window.lucide.createIcons();
    });
</script>
</body>
</html>
