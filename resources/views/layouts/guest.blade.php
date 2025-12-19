<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pixlist') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- Fonte --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80 border-b border-gray-200 sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                <span class="inline-flex w-7 h-7 rounded-md bg-gradient-to-br from-emerald-600 to-emerald-400"></span>
                <span class="text-2xl md:text-3xl font-extrabold tracking-tight text-emerald-600">
                    Pixlist
                </span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('login') }}"
                   class="text-gray-600 hover:text-emerald-700 font-medium transition focus:outline-none focus:ring-2 focus:ring-emerald-500/40 rounded-md px-2 py-1">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="px-4 md:px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:bg-emerald-700 transition
                          focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:ring-offset-2">
                    Criar minha lista
                </a>
            </div>
        </nav>
    </header>

    {{-- Conteúdo --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center space-y-3">
            <p class="text-sm text-gray-500">
                © {{ now()->year }} Pixlist. Todos os direitos reservados.
            </p>

            @php
                // Fallback seguro: se 'terms' não existir por algum motivo, usa 'termos'
                $termsRoute = \Illuminate\Support\Facades\Route::has('terms')
                    ? route('terms')
                    : (\Illuminate\Support\Facades\Route::has('termos') ? route('termos') : url('/termos'));
            @endphp

            <div class="flex flex-wrap justify-center items-center gap-3 text-sm">
                <a href="{{ $termsRoute }}"
                   class="font-semibold text-emerald-600 hover:underline focus:outline-none focus:ring-2 focus:ring-emerald-500/40 rounded-md px-1">
                    Termos de Uso
                </a>

                <span class="text-gray-300 hidden sm:inline">|</span>

                <a href="{{ $termsRoute }}#privacidade"
                   class="font-semibold text-emerald-600 hover:underline focus:outline-none focus:ring-2 focus:ring-emerald-500/40 rounded-md px-1">
                    Política de Privacidade
                </a>
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
