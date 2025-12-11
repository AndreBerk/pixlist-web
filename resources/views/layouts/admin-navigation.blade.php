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
@endphp

{{-- Seção de status do plano --}}
@if($list)
    <div class="px-4 py-3 mb-3 rounded-lg border border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if ($planoAtivo)
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span class="text-sm font-medium text-emerald-700">Plano Ativo</span>
                @elseif ($emTrial)
                    <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                    <span class="text-sm font-medium text-amber-700">Em teste (7 dias)</span>
                @else
                    <i data-lucide="shield-off" class="w-4 h-4 text-red-600"></i>
                    <span class="text-sm font-medium text-red-700">Plano Expirado</span>
                @endif
            </div>

            @unless($planoAtivo)
                <a href="{{ route('plano.index') }}"
                   class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 underline underline-offset-2">
                    Ativar
                </a>
            @endunless
        </div>
    </div>
@endif

{{-- Título de seção --}}
<p class="px-4 mb-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
    Navegação
</p>

<ul class="space-y-2">
    <li>
        <a href="{{ route('dashboard') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li>
        <a href="{{ route('presentes.index') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('presentes.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="gift" class="w-5 h-5"></i>
            <span>Gerenciar Presentes</span>
        </a>
    </li>

    <li>
        <a href="{{ route('extrato.index') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('extrato.index') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="receipt-text" class="w-5 h-5"></i>
            <span>Extrato & Mensagens</span>
        </a>
    </li>

    <li>
        <a href="{{ route('rsvp.index') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('rsvp.index') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span>Lista de Convidados</span>
        </a>
    </li>

    <li>
        <a href="{{ route('photos.index') }}"
        class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                hover:bg-emerald-50 hover:text-emerald-700 transition
                {{ request()->routeIs('photos.index') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="camera" class="w-5 h-5"></i>
            <span>Galeria de Fotos</span>
        </a>
    </li>

    {{-- [CORRIGIDO] O LINK DA ROLETA AGORA TEM ESTILO --}}
    <li>
        <a href="{{ route('gravata.edit') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('gravata.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="dices" class="w-5 h-5"></i>
            <span>Roleta da Gravata</span>
        </a>
    </li>

    <li>
        <a href="{{ route('list.config.edit') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('list.config.edit') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>Configurar Página</span>
        </a>
    </li>

    <li>
        <a href="{{ route('list.share') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('list.share') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="share-2" class="w-5 h-5"></i>
            <span>Compartilhar</span>
        </a>
    </li>
</ul>

{{-- Segunda seção (Conta) --}}
<p class="px-4 mt-6 mb-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
    Conta
</p>

<ul class="space-y-2">
    <li>
        <a href="{{ route('profile.edit') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('profile.edit') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="user-cog" class="w-5 h-5"></i>
            <span>Minha Conta</span>
        </a>
    </li>
    <li>
        <a href="{{ route('plano.index') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('plano.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
            <span>Plano e Pagamento</span>

            @if(!$planoAtivo && $emTrial)
                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-bold">Em Teste</span>
            @elseif(!$planoAtivo && !$emTrial)
                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-bold">Pendente</span>
            @endif
        </a>
    </li>

    <li>
        <a href="{{ route('feedback.create') }}"
           class="admin-nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium
                  hover:bg-emerald-50 hover:text-emerald-700 transition
                  {{ request()->routeIs('feedback.create') ? 'bg-emerald-50 text-emerald-700' : '' }}">
            <i data-lucide="message-square-plus" class="w-5 h-5"></i>
            <span>Enviar Feedback</span>
        </a>
    </li>
</ul>
