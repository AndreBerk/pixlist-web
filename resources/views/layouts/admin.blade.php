<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pixlist') }}</title>

    {{-- Fontes Otimizadas --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        /* Remove o highlight azul no mobile ao clicar */
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 h-full antialiased" x-data>
<div class="min-h-screen flex">

    {{-- SIDEBAR DESKTOP --}}
    <aside class="hidden md:flex flex-col w-[260px] bg-white dark:bg-slate-900 border-r border-slate-200/60 dark:border-slate-800 fixed inset-y-0 z-40 shadow-sm">

        {{-- Logo Area --}}
        <div class="flex items-center h-20 px-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-105 transition">P</div>
                <span class="text-2xl font-extrabold tracking-tight text-emerald-600">Pixlist</span>
            </a>
        </div>

        {{-- Scrollable Nav --}}
        <div class="flex-1 overflow-y-auto py-2 custom-scrollbar">
            @include('layouts.partials.sidebar')
        </div>

        {{-- Logout Footer --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-2 text-sm font-medium text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors group">
                    <i data-lucide="log-out" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                    Sair da conta
                </button>
            </form>
        </div>
    </aside>

    {{-- ÁREA DE CONTEÚDO --}}
    <div class="flex-1 flex flex-col md:pl-[260px] min-h-screen transition-all">

        {{-- Header Mobile --}}
        <header class="md:hidden sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
            <div class="px-4 h-16 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="font-bold text-lg text-emerald-600"><span>Pixlist</span></a>

                <div class="flex items-center gap-3">
                     <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </a>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 px-4 py-8 md:px-8 md:py-10 pb-32 md:pb-10 max-w-7xl mx-auto w-full">
            {{ $slot }}
        </main>

    </div>

</div>

{{-- Mobile Components --}}
@include('layouts.partials.mobile-bottom-nav')
@include('layouts.partials.mobile-menu-drawer')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) window.lucide.createIcons();
    });
</script>
</body>
</html>
