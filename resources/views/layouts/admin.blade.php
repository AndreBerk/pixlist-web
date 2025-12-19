@props(['title' => 'Painel'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'PixList') }}</title>

    {{-- SCRIPT DO TEMA (CRUCIAL: Carrega antes do render para evitar "piscar" branco) --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- CSS e JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- Fontes --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-slate-900 dark:text-slate-300 antialiased transition-colors duration-300">

    <div class="min-h-screen lg:pl-64">

        {{-- SIDEBAR --}}
        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-64
                      bg-white dark:bg-slate-800
                      border-r border-gray-200 dark:border-slate-700
                      shadow-sm transform -translate-x-full lg:translate-x-0
                      transition-transform duration-300 ease-in-out flex flex-col">

            {{-- Brand --}}
            <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 dark:border-slate-700">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <span class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-sm">
                        <i data-lucide="gift" class="w-5 h-5"></i>
                    </span>
                    <span class="text-lg font-extrabold text-gray-900 dark:text-white tracking-tight">PixList</span>
                </a>

                <button type="button" onclick="toggleSidebar(false)"
                        class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-white p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Navigation --}}
            <div class="flex-1 overflow-y-auto py-5 px-3">
                <div class="px-3 pb-3">
                    <p class="text-[11px] font-bold tracking-widest text-gray-400 dark:text-slate-500 uppercase">Menu</p>
                </div>

                {{-- Aqui entra seu menu (Certifique-se que o componente 'nav-link-custom' também suporte dark mode) --}}
                @include('layouts.admin-navigation')
            </div>

            {{-- Logout --}}
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl
                                   text-sm font-semibold text-red-600 dark:text-red-400
                                   hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <span class="flex items-center gap-3">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            Sair
                        </span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-red-400 dark:text-red-500"></i>
                    </button>
                </form>
            </div>
        </aside>

        {{-- OVERLAY (mobile) --}}
        <div id="mobile-overlay"
             class="fixed inset-0 bg-gray-900/50 dark:bg-black/70 z-40 hidden lg:hidden backdrop-blur-[2px]"
             onclick="toggleSidebar(false)"></div>

        {{-- CONTEÚDO --}}
        <main class="min-h-screen flex flex-col">

            {{-- TOPBAR --}}
            <header class="bg-white/90 dark:bg-slate-800/90 backdrop-blur supports-[backdrop-filter]:bg-white/80
                           border-b border-gray-200 dark:border-slate-700 sticky top-0 z-30 transition-colors duration-300">
                <div class="h-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">

                    {{-- Menu button (mobile) --}}
                    <button type="button"
                            onclick="toggleSidebar(true)"
                            class="lg:hidden text-gray-700 dark:text-slate-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    {{-- Title --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold tracking-widest text-gray-400 dark:text-slate-500 uppercase">
                            {{ $title }}
                        </p>
                    </div>

                    {{-- User --}}
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right leading-tight">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400">Conta ativa</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300
                                  flex items-center justify-center font-extrabold border border-emerald-200 dark:border-emerald-700
                                  hover:bg-emerald-200 dark:hover:bg-emerald-800 transition">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </a>
                    </div>
                </div>
            </header>

            {{-- Page --}}
            <div class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-4 transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-right text-xs text-gray-500 dark:text-slate-500">
                    © {{ date('Y') }} PixList — Todos os direitos reservados.
                </div>
            </footer>
        </main>
    </div>

    <script>
        function toggleSidebar(open) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (open) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.documentElement.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.documentElement.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>
