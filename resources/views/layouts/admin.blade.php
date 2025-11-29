<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PixList') }}</title>

    {{-- Fonte --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- CSS e JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    {{-- APLICAÇÃO PRINCIPAL --}}
    <div class="min-h-screen flex lg:pl-64">

        {{-- SIDEBAR (fixa no desktop, off-canvas no mobile) --}}
        <nav id="sidebar"
             class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-100 shadow-md p-6 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">

            {{-- LOGO --}}
            <div class="flex items-center justify-between pb-6 mb-6 border-b border-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <span class="text-2xl font-extrabold text-emerald-600 tracking-tight group-hover:text-emerald-700">
                        PixList
                    </span>
                </a>

                {{-- Botão fechar (mobile) --}}
                <button type="button"
                        class="lg:hidden text-gray-500 hover:text-gray-700"
                        onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('overlay')?.classList.add('hidden')">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            {{-- NAVEGAÇÃO --}}
            <div class="flex-grow overflow-y-auto">
                @include('layouts.admin-navigation')
            </div>

            {{-- LOGOUT --}}
            <div class="pt-6 mt-6 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 font-medium hover:bg-red-50 hover:text-red-700 transition">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </nav>

        {{-- OVERLAY (só aparece no mobile) --}}
        <div id="overlay"
             class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"
             onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')">
        </div>

        {{-- CONTEÚDO PRINCIPAL --}}
        <div class="flex-1 flex flex-col relative z-0">

            {{-- HEADER SUPERIOR --}}
            <header class="bg-white shadow-sm p-4 border-b border-gray-100 flex items-center justify-between lg:justify-end">
                {{-- Botão abrir sidebar (mobile) --}}
                <button type="button"
                        class="lg:hidden text-gray-600 hover:text-gray-900"
                        onclick="document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('overlay')?.classList.remove('hidden')">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                {{-- Usuário --}}
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-700 hidden md:block">
                        Olá, {{ Auth::user()->name }}!
                    </span>
                    <a href="{{ route('profile.edit') }}"
                       class="w-10 h-10 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center font-bold text-lg hover:bg-emerald-200 transition">
                        {{ Str::substr(Auth::user()->name, 0, 1) }}
                    </a>
                </div>
            </header>

            {{-- CONTEÚDO DA PÁGINA --}}
            <main class="flex-1 p-6 lg:p-10">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Inicializa ícones Lucide --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });
    </script>
</body>
</html>
