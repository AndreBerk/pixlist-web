<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pixlist') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }

        /* Ajuste para o carrossel */
        .swiper-pagination-bullet-active {
            background-color: #059669 !important; /* Cor Esmeralda */
        }
        .swiper-button-next, .swiper-button-prev {
            color: #059669 !important; /* Cor Esmeralda */
            transform: scale(0.6);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <header id="main-header" class="bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80 border-b border-gray-200 sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">

            <a href="/">
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-emerald-600 flex items-center gap-2">
                    <span class="inline-flex w-7 h-7 rounded-md bg-gradient-to-br from-emerald-600 to-emerald-400"></span>
                    Pixlist
                </h1>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-emerald-600 font-medium">Login</a>
                <a href="{{ route('register') }}" class="px-4 md:px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition">Criar minha lista</a>
            </div>
        </nav>
    </header>

    {{-- O 'container' foi removido daqui para o Banner Hero pegar a largura total --}}
    <main class="mx-auto">
        {{ $slot }}
    </main>

    <footer class="text-center p-10 mt-16 border-t border-gray-200">
        <p class="text-gray-500">Pixlist © 2025 - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</body>
</html>
