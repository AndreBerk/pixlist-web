<x-admin-layout title="Dashboard">

    {{--
        ========================================================================
        1. HERO / TUTORIAL (Empilhado no Mobile)
        ========================================================================
    --}}
    @if(isset($showTutorial) && $showTutorial)
    <div class="relative overflow-hidden rounded-3xl border border-emerald-100 dark:border-emerald-900/50 shadow-xl shadow-emerald-900/5 mb-8 bg-white dark:bg-slate-800 group animate-fade-in-up transition-colors duration-300">

        {{-- Background Premium --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 via-white to-slate-50 dark:from-emerald-900/20 dark:via-slate-800 dark:to-slate-900 opacity-100"></div>
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-emerald-100/50 dark:bg-emerald-500/10 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="relative z-10 p-5 md:p-8">
            {{-- Cabeçalho do Tutorial --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-[10px] md:text-xs font-bold uppercase tracking-wider">
                        <i data-lucide="map" class="w-3 h-3"></i>
                        <span>Guia Rápido</span>
                    </div>
                    <h2 class="text-xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                        Seu evento em 3 passos
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base max-w-xl">
                        Complete as etapas abaixo para ativar sua lista.
                    </p>
                </div>

                {{-- Botão Fechar (Desktop) --}}
                <div class="hidden md:block">
                     <x-tutorial-dismiss-button />
                </div>
            </div>

            {{--
                GRID: Agora é grid-cols-1 no mobile (empilhado) e grid-cols-3 no desktop
            --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- PASSO 1 --}}
                <a href="{{ route('list.config.edit') }}" class="relative p-5 rounded-2xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm flex flex-col active:scale-98 transition-transform hover:border-emerald-500 dark:hover:border-emerald-500">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i data-lucide="settings-2" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded border border-emerald-100 dark:border-emerald-800">01</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white mb-1">Dados & Pix</h3>
                    <p class="text-slate-500 dark:text-slate-300 text-xs leading-relaxed mb-4">
                        Cadastre sua chave PIX e foto do casal.
                    </p>
                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center mt-auto uppercase tracking-wide">
                        Configurar <i data-lucide="arrow-right" class="w-3 h-3 ml-1"></i>
                    </span>
                </a>

                {{-- PASSO 2 --}}
                <a href="{{ route('presentes.index') }}" class="relative p-5 rounded-2xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm flex flex-col active:scale-98 transition-transform hover:border-emerald-500 dark:hover:border-emerald-500">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-10 h-10 bg-slate-50 dark:bg-slate-600 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300">
                             <i data-lucide="gift" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-300 bg-slate-50 dark:bg-slate-600 px-2 py-1 rounded border border-slate-100 dark:border-slate-500">02</span>
                    </div>
                     <h3 class="text-base font-bold text-slate-800 dark:text-white mb-1">Criar Presentes</h3>
                    <p class="text-slate-500 dark:text-slate-300 text-xs leading-relaxed mb-4">
                        Adicione presentes virtuais para os convidados.
                    </p>
                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center mt-auto uppercase tracking-wide">
                        Adicionar <i data-lucide="arrow-right" class="w-3 h-3 ml-1"></i>
                    </span>
                </a>

                 {{-- PASSO 3 --}}
                <div class="relative p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 border-dashed flex flex-col">
                      <div class="flex justify-between items-start mb-3">
                        <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 dark:text-slate-500 border border-slate-100 dark:border-slate-600">
                            <i data-lucide="share-2" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-700 px-2 py-1 rounded border border-slate-100 dark:border-slate-600">03</span>
                    </div>
                     <h3 class="text-base font-bold text-slate-600 dark:text-slate-400 mb-1">Compartilhar</h3>
                    <p class="text-slate-500 dark:text-slate-500 text-xs leading-relaxed">
                        Envie o link exclusivo para os convidados.
                    </p>
                </div>
            </div>

            {{-- Botão Fechar (Mobile) --}}
            <div class="mt-4 md:hidden">
                <x-tutorial-dismiss-button fullWidth="true" />
            </div>
        </div>
    </div>
    @endif


    {{--
        ========================================================================
        2. CABEÇALHO DA PÁGINA
        ========================================================================
    --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Dashboard</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Visão geral do seu evento.</p>
        </div>

        <a href="{{ route('list.public.show', ['list' => $list->id ?? 0, 'slug' => \Illuminate\Support\Str::slug($list->display_name ?? 'lista')]) }}" target="_blank"
           class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-slate-900 dark:bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 dark:hover:bg-emerald-700 shadow-lg shadow-slate-200 dark:shadow-none transition-all duration-300 active:scale-95">
            <span>Ver Página Pública</span>
            <i data-lucide="external-link" class="w-4 h-4 ml-2 opacity-70"></i>
        </a>
    </div>

    {{--
        ========================================================================
        3. CARDS DE ESTATÍSTICAS (Empilhados no Mobile)
        ========================================================================
    --}}
    {{-- Grid vertical no mobile (grid-cols-1) e horizontal no desktop (md:grid-cols-3) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

        {{-- Card 1: Total Arrecadado --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 shadow-[0_4px_20px_-4px_rgba(16,185,129,0.1)] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i data-lucide="wallet" class="w-24 h-24 text-emerald-600 dark:text-emerald-400 transform translate-x-4 -translate-y-4"></i>
            </div>

            <div class="relative z-10">
                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide mb-1">Total Arrecadado</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-slate-400 dark:text-slate-500 text-xl font-medium">R$</span>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalArrecadado ?? 0, 2, ',', '.') }}</h3>
                </div>
                <div class="mt-3 inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[10px] font-bold border border-emerald-100 dark:border-emerald-800">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                    <span>EM TEMPO REAL</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Presentes Recebidos --}}
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-slate-50 dark:bg-slate-700 rounded-lg text-slate-600 dark:text-slate-300">
                    <i data-lucide="gift" class="w-5 h-5"></i>
                </div>
                <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Presentes</p>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white ml-1">{{ $presentesRecebidos ?? 0 }}</h3>
        </div>

        {{-- Card 3: RSVP --}}
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-slate-50 dark:bg-slate-700 rounded-lg text-slate-600 dark:text-slate-300">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Confirmados</p>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white ml-1">
                {{ $list->rsvps()->where('status', 'Confirmado')->count() ?? 0 }}
            </h3>
        </div>
    </div>

    {{--
        ========================================================================
        4. GRID DE ACESSO RÁPIDO
        ========================================================================
    --}}
    <div class="flex items-center gap-3 mb-4">
        <h3 class="text-base font-bold text-slate-900 dark:text-white">Acesso Rápido</h3>
        <div class="h-px bg-slate-200 dark:bg-slate-700 flex-1"></div>
    </div>

    {{-- Grid de 2 colunas no mobile e 6 no desktop --}}
    <div class="grid grid-cols-2 md:grid-cols-6 gap-3 md:gap-4 pb-10">

        @php
            // Estilo padrão dos cards de atalho
            $shortcutClass = "group flex flex-col items-center justify-center p-4 md:p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 active:scale-95 transition-all duration-200";
            $iconBgClass = "w-10 h-10 md:w-12 md:h-12 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-2 md:mb-3";
            $textClass = "text-xs md:text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight";
        @endphp

        <a href="{{ route('presentes.index') }}" class="{{ $shortcutClass }}">
            <div class="{{ $iconBgClass }}">
                <i data-lucide="gift" class="w-5 h-5 md:w-6 md:h-6"></i>
            </div>
            <span class="{{ $textClass }}">Gerenciar<br>Presentes</span>
        </a>

        <a href="{{ route('gravata.edit') }}" class="{{ $shortcutClass }}">
             <div class="{{ $iconBgClass }}">
                <i data-lucide="dices" class="w-5 h-5 md:w-6 md:h-6"></i>
            </div>
            <span class="{{ $textClass }}">Roleta da<br>Gravata</span>
        </a>

        <a href="{{ route('vows.index') }}" class="{{ $shortcutClass }}">
            <div class="{{ $iconBgClass }}">
               <i data-lucide="book-heart" class="w-5 h-5 md:w-6 md:h-6"></i>
           </div>
           <span class="{{ $textClass }}">Meus<br>Votos</span>
        </a>

        <a href="{{ route('list.config.edit') }}" class="{{ $shortcutClass }}">
             <div class="{{ $iconBgClass }}">
                <i data-lucide="settings" class="w-5 h-5 md:w-6 md:h-6"></i>
            </div>
            <span class="{{ $textClass }}">Editar<br>Página</span>
        </a>

        <a href="{{ route('extrato.index') }}" class="{{ $shortcutClass }}">
             <div class="{{ $iconBgClass }}">
                <i data-lucide="file-text" class="w-5 h-5 md:w-6 md:h-6"></i>
            </div>
            <span class="{{ $textClass }}">Ver<br>Extrato</span>
        </a>

        <a href="{{ route('list.gallery', $list) }}" target="_blank" class="{{ $shortcutClass }}">
           <div class="{{ $iconBgClass }}">
               <i data-lucide="images" class="w-5 h-5 md:w-6 md:h-6"></i>
           </div>
           <span class="{{ $textClass }}">Galeria<br>Pública</span>
       </a>

    </div>

</x-admin-layout>
