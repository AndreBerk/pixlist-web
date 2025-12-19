<x-admin-layout title="Dashboard">

    {{--
        ========================================================================
        1. HERO / TUTORIAL DE ONBOARDING
        ========================================================================
    --}}
    @if(isset($showTutorial) && $showTutorial)
    <div class="relative overflow-hidden rounded-3xl border border-emerald-100 dark:border-emerald-900/50 shadow-xl shadow-emerald-900/5 mb-10 bg-white dark:bg-slate-800 group animate-fade-in-up transition-colors duration-300">

        {{-- Background Premium Sutil (Adaptado para Dark) --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 via-white to-slate-50 dark:from-emerald-900/20 dark:via-slate-800 dark:to-slate-900 opacity-100"></div>
        {{-- Blob decorativo para profundidade --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-emerald-100/50 dark:bg-emerald-500/10 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="relative z-10 p-6 md:p-10">
            {{-- Cabeçalho do Tutorial + Botão Fechar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider">
                        <i data-lucide="map" class="w-3 h-3"></i>
                        <span>Guia Rápido</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                        Seu evento em 3 passos
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-base max-w-xl">
                        Complete as etapas abaixo para ativar sua lista de presentes e começar a receber.
                    </p>
                </div>

                {{-- [AQUI] Botão de Fechar (Desktop) --}}
                <div class="hidden md:block">
                     <x-tutorial-dismiss-button />
                </div>
            </div>

            {{-- Grid de Passos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- PASSO 1: Configuração (Foto e Pix) --}}
                <a href="{{ route('list.config.edit') }}" class="relative p-5 rounded-2xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm hover:shadow-md hover:border-emerald-500 dark:hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 group/card flex flex-col h-full">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover/card:bg-emerald-600 group-hover/card:text-white transition-colors">
                            <i data-lucide="settings-2" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded border border-emerald-100 dark:border-emerald-800">Passo 01</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 group-hover/card:text-emerald-700 dark:group-hover/card:text-emerald-400 transition-colors">Dados & Pix</h3>
                    <p class="text-slate-500 dark:text-slate-300 text-sm leading-relaxed mb-4 flex-grow">
                        Fundamental: adicione a foto do casal e cadastre sua <strong>Chave PIX</strong> para receber os pagamentos.
                    </p>
                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 flex items-center mt-auto">
                        Configurar agora <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </span>
                </a>

                {{-- PASSO 2: Criar Lista --}}
                <a href="{{ route('presentes.index') }}" class="relative p-5 rounded-2xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm hover:shadow-md hover:border-emerald-500 dark:hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 group/card flex flex-col h-full">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-slate-50 dark:bg-slate-600 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-300 group-hover/card:bg-emerald-600 group-hover/card:text-white transition-colors">
                             <i data-lucide="gift" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-300 bg-slate-50 dark:bg-slate-600 px-2 py-1 rounded border border-slate-100 dark:border-slate-500">Passo 02</span>
                    </div>
                     <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 group-hover/card:text-emerald-700 dark:group-hover/card:text-emerald-400 transition-colors">Criar Presentes</h3>
                    <p class="text-slate-500 dark:text-slate-300 text-sm leading-relaxed mb-4 flex-grow">
                        Crie presentes virtuais (cotas). Use nossos exemplos prontos para preencher sua lista rapidamente.
                    </p>
                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 flex items-center mt-auto">
                        Adicionar presentes <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </span>
                </a>

                 {{-- PASSO 3: Compartilhar --}}
                <div class="relative p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 border-dashed flex flex-col h-full">
                      <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 dark:text-slate-500 border border-slate-100 dark:border-slate-600">
                            <i data-lucide="share-2" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-700 px-2 py-1 rounded border border-slate-100 dark:border-slate-600">Passo 03</span>
                    </div>
                     <h3 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-2">Compartilhar</h3>
                    <p class="text-slate-500 dark:text-slate-500 text-sm leading-relaxed flex-grow">
                        Tudo pronto? Sua página terá um link exclusivo e QR Code para enviar aos convidados no WhatsApp.
                    </p>
                </div>
            </div>

            {{-- [AQUI] Botão Fechar (Mobile) --}}
            <div class="mt-6 md:hidden">
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
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Dashboard</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Visão geral e atalhos do seu evento.</p>
        </div>

        {{-- CTA Principal: Ver a página como o convidado vê --}}
        <a href="{{ route('list.public.show', ['list' => $list->id ?? 0, 'slug' => \Illuminate\Support\Str::slug($list->display_name ?? 'lista')]) }}" target="_blank"
           class="inline-flex items-center justify-center px-6 py-3 bg-slate-900 dark:bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 dark:hover:bg-emerald-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shadow-md group">
            <span>Ver Página Pública</span>
            <i data-lucide="external-link" class="w-4 h-4 ml-2 text-slate-400 dark:text-emerald-200 group-hover:text-white transition-colors"></i>
        </a>
    </div>

    {{--
        ========================================================================
        3. CARDS DE ESTATÍSTICAS (Highlight no dinheiro)
        ========================================================================
    --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        {{-- Card 1: Total Arrecadado (Destaque Visual) --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 shadow-[0_4px_20px_-4px_rgba(16,185,129,0.1)] relative overflow-hidden group transition-colors duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity duration-500">
                <i data-lucide="wallet" class="w-24 h-24 text-emerald-600 dark:text-emerald-400 transform translate-x-4 -translate-y-4"></i>
            </div>

            <div class="relative z-10">
                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide mb-1">Total Arrecadado</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-slate-400 dark:text-slate-500 text-2xl font-medium">R$</span>
                    <h3 class="text-4xl font-bold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalArrecadado ?? 0, 2, ',', '.') }}</h3>
                </div>
                <div class="mt-4 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium border border-emerald-100 dark:border-emerald-800">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Presentes Recebidos --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-600 transition-colors duration-300">
            <div>
                 <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-slate-50 dark:bg-slate-700 rounded-lg text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-600">
                        <i data-lucide="gift" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Presentes Recebidos</p>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white ml-1">{{ $presentesRecebidos ?? 0 }}</h3>
            </div>
        </div>

        {{-- Card 3: RSVP (Confirmados) --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-600 transition-colors duration-300">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-slate-50 dark:bg-slate-700 rounded-lg text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-600">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Confirmados (RSVP)</p>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white ml-1">
                    {{ $list->rsvps()->where('status', 'Confirmado')->count() ?? 0 }}
                </h3>
            </div>
        </div>
    </div>

    {{--
        ========================================================================
        4. GRID DE ACESSO RÁPIDO (Visual Unificado)
        ========================================================================
    --}}
    <div class="flex items-center gap-3 mb-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Acesso Rápido</h3>
        <div class="h-px bg-slate-200 dark:bg-slate-700 flex-1"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

        {{-- 1. Gerenciar Presentes --}}
        <a href="{{ route('presentes.index') }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-3">
                <i data-lucide="gift" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Gerenciar<br>Presentes</span>
        </a>

        {{-- 2. Configurar Roleta --}}
        <a href="{{ route('gravata.edit') }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
             <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-3">
                <i data-lucide="dices" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Configurar<br>Roleta</span>
        </a>

        {{-- 3. Meus Votos --}}
        <a href="{{ route('vows.index') }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-indigo-500 dark:hover:border-indigo-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/30 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-3">
               <i data-lucide="book-heart" class="w-6 h-6"></i>
           </div>
           <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Meus<br>Votos</span>
        </a>

        {{-- 4. Editar Página --}}
        <a href="{{ route('list.config.edit') }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
             <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-3">
                <i data-lucide="settings" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Editar<br>Página</span>
        </a>

        {{-- 5. Extrato --}}
        <a href="{{ route('extrato.index') }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
             <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-3">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Ver<br>Extrato</span>
        </a>

        {{-- 6. Galeria Pública --}}
        <a href="{{ route('list.gallery', $list) }}" target="_blank" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
           <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-300 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-3">
               <i data-lucide="images" class="w-6 h-6"></i>
           </div>
           <span class="text-sm font-semibold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white text-center leading-tight">Galeria<br>Pública</span>
       </a>

    </div>

</x-admin-layout>
