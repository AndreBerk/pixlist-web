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

    // Helper para classes de link
    $linkClass = 'group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200';

    // Classes Light / Dark
    $inactiveClass = 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200';
    $activeClass = 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-bold shadow-sm ring-1 ring-emerald-100 dark:ring-emerald-800';
@endphp

{{--
    =========================================================
    STATUS DO PLANO (Compacto & Premium)
    =========================================================
--}}
@if($list)
    <div class="px-4 mb-6">
        <div class="p-4 rounded-2xl border transition-colors duration-300
                    {{ $planoAtivo
                        ? 'border-emerald-100 dark:border-emerald-900/50 bg-emerald-50/50 dark:bg-emerald-900/20'
                        : ($emTrial
                            ? 'border-amber-100 dark:border-amber-900/50 bg-amber-50/50 dark:bg-amber-900/20'
                            : 'border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-900/20')
                    }}">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-1.5 rounded-lg bg-white dark:bg-slate-800 shadow-sm">
                    @if ($planoAtivo)
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400"></i>
                    @elseif ($emTrial)
                        <i data-lucide="clock" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
                    @else
                        <i data-lucide="shield-alert" class="w-4 h-4 text-red-600 dark:text-red-400"></i>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide
                              {{ $planoAtivo
                                  ? 'text-emerald-800 dark:text-emerald-300'
                                  : ($emTrial
                                      ? 'text-amber-800 dark:text-amber-300'
                                      : 'text-red-800 dark:text-red-300')
                              }}">
                        {{ $planoAtivo ? 'Plano Premium' : ($emTrial ? 'Período Teste' : 'Expirado') }}
                    </p>
                    @if($emTrial)
                        <p class="text-[10px] text-amber-600 dark:text-amber-400 font-medium">Expira em breve</p>
                    @endif
                </div>
            </div>

            @unless($planoAtivo)
                <a href="{{ route('plano.index') }}" class="block w-full py-1.5 text-xs text-center font-bold text-white rounded-lg shadow-sm transition-transform hover:scale-[1.02] active:scale-95
                   {{ $emTrial ? 'bg-amber-500 hover:bg-amber-600' : 'bg-red-500 hover:bg-red-600' }}">
                    Ativar Agora
                </a>
            @endunless
        </div>
    </div>
@endif

{{--
    =========================================================
    MENU DE NAVEGAÇÃO PRINCIPAL
    =========================================================
--}}
<div class="px-4 space-y-8">

    {{-- Grupo 1: Gestão do Evento --}}
    <div>
        <p class="px-2 mb-2 text-xs font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
            Gestão do Evento
        </p>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Visão Geral</span>
                </a>
            </li>

            <li>
                <a href="{{ route('presentes.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('presentes.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="gift" class="w-5 h-5 {{ request()->routeIs('presentes.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Presentes (Cotas)</span>
                </a>
            </li>

            <li>
                <a href="{{ route('extrato.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('extrato.index') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="receipt-text" class="w-5 h-5 {{ request()->routeIs('extrato.index') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Extrato Financeiro</span>
                </a>
            </li>

            <li>
                <a href="{{ route('despesas.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('despesas.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="receipt" class="w-5 h-5 {{ request()->routeIs('despesas.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Gestão de Despesas</span>
                </a>
            </li>

            <li>
                <a href="{{ route('rsvp.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('rsvp.index') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('rsvp.index') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Convidados (RSVP)</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Grupo 2: Extras & Configuração --}}
    <div>
        <p class="px-2 mb-2 text-xs font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
            Personalização
        </p>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('photos.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('photos.index') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="camera" class="w-5 h-5 {{ request()->routeIs('photos.index') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Galeria de Fotos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('gravata.edit') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('gravata.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="dices" class="w-5 h-5 {{ request()->routeIs('gravata.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Roleta da Gravata</span>
                </a>
            </li>

            <li>
                <a href="{{ route('vows.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('vows.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="book-heart" class="w-5 h-5 {{ request()->routeIs('vows.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Meus Votos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('list.config.edit') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('list.config.edit') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="settings-2" class="w-5 h-5 {{ request()->routeIs('list.config.edit') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Configurar Página</span>
                </a>
            </li>

            <li>
                <a href="{{ route('list.share') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('list.share') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="share-2" class="w-5 h-5 {{ request()->routeIs('list.share') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Compartilhar</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Grupo 3: Minha Conta (Rodapé do menu) --}}
    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('plano.index') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('plano.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="credit-card" class="w-5 h-5 {{ request()->routeIs('plano.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span class="flex-1">Plano e Fatura</span>
                    @if(!$planoAtivo && $emTrial)
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="user-circle" class="w-5 h-5 {{ request()->routeIs('profile.edit') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Minha Conta</span>
                </a>
            </li>
             <li>
                <a href="{{ route('feedback.create') }}"
                   class="{{ $linkClass }} {{ request()->routeIs('feedback.create') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="message-square-plus" class="w-5 h-5 {{ request()->routeIs('feedback.create') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}"></i>
                    <span>Ajuda & Feedback</span>
                </a>
            </li>
        </ul>
    </div>

</div>
