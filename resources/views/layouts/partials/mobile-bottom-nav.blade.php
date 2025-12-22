<nav class="md:hidden fixed bottom-4 inset-x-0 z-50 flex justify-center pointer-events-none">
    {{-- Container Flutuante (Ilha) --}}
    <div class="pointer-events-auto bg-white/90 dark:bg-slate-800/95 backdrop-blur-xl border border-gray-200/50 dark:border-slate-700 rounded-full shadow-xl shadow-slate-200/50 dark:shadow-black/50 px-6 py-3 mx-4 max-w-sm w-full">

        <div class="flex items-center justify-between">
            @php
                // Estilo Base
                $itemBase = "relative flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-300 group";

                // Ativo: Sobe um pouco o ícone, cor principal
                $active = "text-emerald-600 dark:text-emerald-400 scale-110 -translate-y-1";

                // Inativo: Cinza, hover leve
                $inactive = "text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300";
            @endphp

            {{-- Home --}}
            <a href="{{ route('dashboard') }}" class="{{ $itemBase }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                <i data-lucide="layout-grid" class="w-6 h-6 stroke-[1.5]"></i>
                @if(request()->routeIs('dashboard'))
                    <span class="absolute -bottom-2 w-1 h-1 bg-emerald-500 rounded-full"></span>
                @endif
            </a>

            {{-- Extrato --}}
            <a href="{{ route('extrato.index') }}" class="{{ $itemBase }} {{ request()->routeIs('extrato.*') ? $active : $inactive }}">
                <i data-lucide="wallet" class="w-6 h-6 stroke-[1.5]"></i>
                @if(request()->routeIs('extrato.*'))
                    <span class="absolute -bottom-2 w-1 h-1 bg-emerald-500 rounded-full"></span>
                @endif
            </a>

            {{-- Ação Principal (Botão Central de destaque - Opcional, ou Presentes) --}}
            <a href="{{ route('presentes.index') }}"
               class="flex items-center justify-center w-12 h-12 bg-emerald-600 text-white rounded-full shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 hover:scale-105 transition active:scale-95 -mt-4 border-4 border-gray-50 dark:border-slate-900">
                <i data-lucide="gift" class="w-6 h-6"></i>
            </a>

            {{-- RSVP --}}
            <a href="{{ route('rsvp.index') }}" class="{{ $itemBase }} {{ request()->routeIs('rsvp.*') ? $active : $inactive }}">
                <i data-lucide="users" class="w-6 h-6 stroke-[1.5]"></i>
                @if(request()->routeIs('rsvp.*'))
                    <span class="absolute -bottom-2 w-1 h-1 bg-emerald-500 rounded-full"></span>
                @endif
            </a>

            {{-- Menu (Mais) --}}
            <button type="button" class="{{ $itemBase }} {{ $inactive }}" @click="$dispatch('mobile-drawer:open')">
                <i data-lucide="menu" class="w-6 h-6 stroke-[1.5]"></i>
            </button>
        </div>
    </div>
</nav>
