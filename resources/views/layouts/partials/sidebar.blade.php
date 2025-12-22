@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $user = Auth::user();
    $list = $user?->list;

    // Lógica de "plano ativo"
    $planoAtivo = false;
    if ($list) {
        $planoAtivo = $list->plano_pago &&
                      $list->plano_expires_at &&
                      Carbon::parse($list->plano_expires_at)->isFuture();
    }

    // Lógica de "trial"
    $emTrial = false;
    if ($list && !$planoAtivo) {
        $emTrial = $list->trial_expires_at &&
                   Carbon::parse($list->trial_expires_at)->isFuture();
    }

    // --- ESTILOS PADRONIZADOS ---
    // Link base
    $baseLink = 'group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200';

    // Inativo (Cinza sutil)
    $inactive = 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200';

    // Ativo (Verde Emerald com fundo suave)
    $active = 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold';
@endphp

{{--
    1. WIDGET DE STATUS DO PLANO
    Destaque visual para incentivar upgrade ou confirmar status
--}}
@if($list)
    <div class="px-3 mb-6">
        <div class="relative overflow-hidden p-4 rounded-xl border border-slate-100 dark:border-slate-700
                    {{ $planoAtivo ? 'bg-gradient-to-br from-emerald-50/50 to-white dark:from-slate-800 dark:to-slate-800' : 'bg-white dark:bg-slate-800 shadow-sm' }}">

            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Seu Plano</p>
                    <h3 class="font-bold text-sm {{ $planoAtivo ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200' }}">
                        {{ $planoAtivo ? 'Premium Ativo' : ($emTrial ? 'Período de Teste' : 'Plano Expirado') }}
                    </h3>
                </div>
                {{-- Ícone de Status --}}
                <div class="w-7 h-7 rounded-full flex items-center justify-center
                            {{ $planoAtivo ? 'bg-emerald-100 text-emerald-600' : ($emTrial ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600') }}">
                    <i data-lucide="{{ $planoAtivo ? 'crown' : ($emTrial ? 'clock' : 'alert-circle') }}" class="w-4 h-4"></i>
                </div>
            </div>

            {{-- Botão de Ação (Aparece se não for Premium) --}}
            @if(!$planoAtivo)
                <div class="mt-3">
                    <a href="{{ route('plano.index') }}"
                       class="block w-full py-2 px-3 text-xs font-bold text-center text-white rounded-lg shadow-sm transition-transform active:scale-95
                       {{ $emTrial ? 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-200' : 'bg-gradient-to-r from-red-500 to-red-600 shadow-red-200' }}">
                       {{ $emTrial ? 'Assinar Agora' : 'Renovar Acesso' }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif

{{--
    2. NAVEGAÇÃO PRINCIPAL
--}}
<div class="px-3 space-y-8">

    {{-- GRUPO: GESTÃO --}}
    <div>
        <p class="px-3 mb-2 text-[11px] font-bold tracking-widest text-slate-400 uppercase opacity-70">
            Painel
        </p>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ $baseLink }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                    <i data-lucide="layout-grid" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Visão Geral</span>
                </a>
            </li>
            <li>
                <a href="{{ route('presentes.index') }}" class="{{ $baseLink }} {{ request()->routeIs('presentes.*') ? $active : $inactive }}">
                    <i data-lucide="gift" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Presentes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('extrato.index') }}" class="{{ $baseLink }} {{ request()->routeIs('extrato.*') ? $active : $inactive }}">
                    <i data-lucide="wallet" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Extrato</span>
                </a>
            </li>
             <li>
                <a href="{{ route('despesas.index') }}" class="{{ $baseLink }} {{ request()->routeIs('despesas.*') ? $active : $inactive }}">
                    <i data-lucide="receipt" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Despesas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rsvp.index') }}" class="{{ $baseLink }} {{ request()->routeIs('rsvp.*') ? $active : $inactive }}">
                    <i data-lucide="users-2" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Convidados</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- GRUPO: PERSONALIZAÇÃO --}}
    <div>
        <p class="px-3 mb-2 text-[11px] font-bold tracking-widest text-slate-400 uppercase opacity-70">
            Site & Evento
        </p>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('photos.index') }}" class="{{ $baseLink }} {{ request()->routeIs('photos.*') ? $active : $inactive }}">
                    <i data-lucide="image" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Galeria de Fotos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('gravata.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('gravata.*') ? $active : $inactive }}">
                    <i data-lucide="dices" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Gravata</span>
                </a>
            </li>
            <li>
                <a href="{{ route('vows.index') }}" class="{{ $baseLink }} {{ request()->routeIs('vows.*') ? $active : $inactive }}">
                    <i data-lucide="heart-handshake" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Votos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list.config.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('list.config.edit') ? $active : $inactive }}">
                    <i data-lucide="settings-2" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Configurar Site</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list.share') }}" class="{{ $baseLink }} {{ request()->routeIs('list.share') ? $active : $inactive }}">
                    <i data-lucide="share-2" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Compartilhar</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- GRUPO: CONTA (Separador) --}}
    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('plano.index') }}" class="{{ $baseLink }} {{ request()->routeIs('plano.*') ? $active : $inactive }}">
                    <i data-lucide="credit-card" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Assinatura</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('profile.edit') ? $active : $inactive }}">
                    <i data-lucide="user-circle" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Minha Conta</span>
                </a>
            </li>
            <li>
                <a href="{{ route('feedback.create') }}" class="{{ $baseLink }} {{ request()->routeIs('feedback.create') ? $active : $inactive }}">
                    <i data-lucide="message-square-plus" class="w-[18px] h-[18px] stroke-[1.5]"></i>
                    <span>Ajuda & Feedback</span>
                </a>
            </li>
        </ul>
    </div>
</div>
