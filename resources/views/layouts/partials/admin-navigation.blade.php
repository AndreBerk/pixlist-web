@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $user = Auth::user();
    $list = $user?->list;

    // Lógica de "plano ativo" e "trial" mantida
    $planoAtivo = false;
    if ($list) {
        $planoAtivo = $list->plano_pago && $list->plano_expires_at && Carbon::parse($list->plano_expires_at)->isFuture();
    }
    $emTrial = false;
    if ($list && !$planoAtivo) {
        $emTrial = $list->trial_expires_at && Carbon::parse($list->trial_expires_at)->isFuture();
    }

    // Design: Classes base para os links
    $baseLink = 'group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200';

    // Estado Inativo: Cinza suave, escurece no hover
    $inactive = 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200';

    // Estado Ativo: Fundo sutil + Texto da cor da marca + Ícone preenchido
    $active = 'bg-emerald-50/80 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400';
@endphp

{{--
    WIDGET DE PLANO (Redesenhado)
--}}
@if($list)
    <div class="px-4 mb-8">
        <div class="relative overflow-hidden p-4 rounded-xl border border-slate-100 dark:border-slate-700
                    {{ $planoAtivo ? 'bg-gradient-to-br from-emerald-50 to-white dark:from-slate-800 dark:to-slate-800' : 'bg-white dark:bg-slate-800 shadow-sm' }}">

            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</p>
                    <h3 class="font-bold text-sm {{ $planoAtivo ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-200' }}">
                        {{ $planoAtivo ? 'Premium Ativo' : ($emTrial ? 'Período Teste' : 'Plano Expirado') }}
                    </h3>
                </div>
                <div class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ $planoAtivo ? 'bg-emerald-100 text-emerald-600' : ($emTrial ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600') }}">
                    <i data-lucide="{{ $planoAtivo ? 'crown' : 'clock' }}" class="w-4 h-4"></i>
                </div>
            </div>

            @if(!$planoAtivo)
                <div class="mt-3">
                    <a href="{{ route('plano.index') }}"
                       class="block w-full py-2 px-3 text-xs font-semibold text-center text-white rounded-lg shadow-sm shadow-emerald-200/50 dark:shadow-none transition-transform active:scale-95
                       {{ $emTrial ? 'bg-gradient-to-r from-amber-500 to-amber-600' : 'bg-gradient-to-r from-red-500 to-red-600' }}">
                       {{ $emTrial ? 'Assinar Agora' : 'Renovar Acesso' }}
                    </a>
                </div>
            @else
                <p class="text-[10px] text-emerald-600/80 font-medium mt-1">
                    Você tem acesso total.
                </p>
            @endif
        </div>
    </div>
@endif

{{--
    MENU DE NAVEGAÇÃO
--}}
<div class="px-3 space-y-8">

    {{-- Seção: Gestão --}}
    <div>
        <p class="px-3 mb-3 text-[11px] font-bold tracking-widest text-slate-400 uppercase opacity-80">
            Painel Principal
        </p>
        <ul class="space-y-0.5">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ $baseLink }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                    <i data-lucide="layout-grid" class="w-[18px] h-[18px]"></i>
                    <span>Visão Geral</span>
                </a>
            </li>
            <li>
                <a href="{{ route('presentes.index') }}" class="{{ $baseLink }} {{ request()->routeIs('presentes.*') ? $active : $inactive }}">
                    <i data-lucide="gift" class="w-[18px] h-[18px]"></i>
                    <span>Presentes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('extrato.index') }}" class="{{ $baseLink }} {{ request()->routeIs('extrato.*') ? $active : $inactive }}">
                    <i data-lucide="wallet" class="w-[18px] h-[18px]"></i>
                    <span>Extrato</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rsvp.index') }}" class="{{ $baseLink }} {{ request()->routeIs('rsvp.*') ? $active : $inactive }}">
                    <i data-lucide="users-2" class="w-[18px] h-[18px]"></i>
                    <span>Lista de Convidados</span>
                </a>
            </li>
             <li>
                <a href="{{ route('despesas.index') }}" class="{{ $baseLink }} {{ request()->routeIs('despesas.*') ? $active : $inactive }}">
                    <i data-lucide="receipt" class="w-[18px] h-[18px]"></i>
                    <span>Despesas</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Seção: Personalização --}}
    <div>
        <p class="px-3 mb-3 text-[11px] font-bold tracking-widest text-slate-400 uppercase opacity-80">
            Experiência
        </p>
        <ul class="space-y-0.5">
            <li>
                <a href="{{ route('photos.index') }}" class="{{ $baseLink }} {{ request()->routeIs('photos.*') ? $active : $inactive }}">
                    <i data-lucide="image" class="w-[18px] h-[18px]"></i>
                    <span>Galeria</span>
                </a>
            </li>
            <li>
                <a href="{{ route('gravata.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('gravata.*') ? $active : $inactive }}">
                    <i data-lucide="dices" class="w-[18px] h-[18px]"></i>
                    <span>Gravata</span>
                </a>
            </li>
            <li>
                <a href="{{ route('vows.index') }}" class="{{ $baseLink }} {{ request()->routeIs('vows.*') ? $active : $inactive }}">
                    <i data-lucide="heart-handshake" class="w-[18px] h-[18px]"></i>
                    <span>Votos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list.config.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('list.config.edit') ? $active : $inactive }}">
                    <i data-lucide="sliders-horizontal" class="w-[18px] h-[18px]"></i>
                    <span>Configurações</span>
                </a>
            </li>
        </ul>
    </div>

</div>

{{-- Rodapé do Menu --}}
<div class="px-3 mt-auto pt-6 pb-4">
    <div class="border-t border-slate-100 dark:border-slate-800 pt-4 space-y-1">
        <a href="{{ route('plano.index') }}" class="{{ $baseLink }} {{ request()->routeIs('plano.*') ? $active : $inactive }}">
            <i data-lucide="credit-card" class="w-[18px] h-[18px]"></i>
            <span>Assinatura</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('profile.edit') ? $active : $inactive }}">
            <i data-lucide="user-circle-2" class="w-[18px] h-[18px]"></i>
            <span>Minha Conta</span>
        </a>
    </div>
</div>
