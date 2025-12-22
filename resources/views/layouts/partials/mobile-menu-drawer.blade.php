<div
    x-data="{ open: false }"
    x-on:mobile-drawer:open.window="open = true"
    x-on:keydown.escape.window="open = false"
    class="md:hidden"
>
    {{-- Overlay Escuro (Fundo) --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Drawer (Menu Lateral) --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed left-0 top-0 bottom-0 z-50 w-[85%] max-w-xs bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col shadow-2xl"
    >
        {{-- 1. CABEÇALHO (Fixo no topo) --}}
        <div class="h-20 px-6 flex items-center justify-between border-b border-slate-100 dark:border-slate-800 shrink-0">

            {{-- NOVO LOGO (Editável aqui) --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-emerald-200 shadow-lg">
                    P
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-800 dark:text-white">
                    Pixlist
                </span>
            </a>

            <button
                type="button"
                class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-500 flex items-center justify-center transition-colors"
                @click="open = false"
                aria-label="Fechar menu"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- 2. CONTEÚDO (Scrollável) --}}
        {{-- A classe 'flex-1' faz essa div ocupar todo o espaço restante, permitindo o scroll --}}
        <div class="flex-1 overflow-y-auto py-6 custom-scrollbar">
            @include('layouts.partials.sidebar')
        </div>

        {{-- 3. RODAPÉ (Fixo na parte inferior - Opcional) --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-bold
                               text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/10 dark:hover:bg-red-900/20
                               rounded-xl transition-all active:scale-95">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Sair da Conta
                </button>
            </form>

            <p class="mt-3 text-center text-[10px] text-slate-400 font-medium">
                Versão 1.0.0
            </p>
        </div>
    </div>
</div>
