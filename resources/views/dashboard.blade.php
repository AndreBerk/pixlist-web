<x-admin-layout>
    @php
        $planoAtivo = (bool) $list->plano_pago;
    @endphp

    {{-- HEADER ==================================================== --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">
                Dashboard
            </h2>
            <p class="mt-1 text-base text-gray-500">
                Acompanhe aqui o resumo da sua lista <strong class="text-gray-700">"{{ $list->display_name }}"</strong>.
            </p>
        </div>

        {{-- Botão "Ver minha lista" (Ação principal) --}}
        <div>
            @php
                $publicUrl = route('list.public.show', ['list' => $list->id, 'slug' => Illuminate\Support\Str::slug($list->display_name)]);
            @endphp
            <a href="{{ $publicUrl }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition">
                <i data-lucide="eye" class="w-5 h-5"></i>
                Ver minha lista (público)
            </a>
        </div>
    </div>

    {{-- Layout Principal (2 Colunas) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- COLUNA DA ESQUERDA (Métricas e Extrato) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- MÉTRICAS TOP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Total arrecadado --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Recebido</h3>
                    </div>
                    <p class="text-4xl font-extrabold text-emerald-600 mt-1">
                        R$ {{ number_format($totalArrecadado, 2, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Valor líquido, direto na sua conta.</p>
                </div>

                {{-- Presentes recebidos --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="gift" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Presentes Recebidos</h3>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">
                        {{ $presentesRecebidos }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Total de presentes confirmados.</p>
                </div>
            </div>

            {{-- ÚLTIMOS PRESENTES / EXTRATO --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <h3 class="text-xl font-extrabold text-gray-900">Últimos presentes recebidos</h3>
                    <a href="{{ route('extrato.index') }}"
                       class="inline-flex items-center gap-2 text-sm font-medium text-emerald-600 hover:text-emerald-500">
                        Ver extrato completo
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($latestTransactions as $tx)
                        <div class="flex items-center justify-between gap-2 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center">
                                    <i data-lucide="badge-check" class="w-5 h-5 text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $tx->guest_name ?? 'Convidado anônimo' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Presenteou com:
                                        <span class="font-medium text-gray-700">
                                            {{ $tx->gift->title ?? 'Presente' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <span class="font-bold text-lg text-emerald-600">
                                + R$ {{ number_format($tx->amount, 2, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3"></i>
                            <p class="font-medium text-gray-800">Nenhum presente recebido ainda.</p>
                            <p class="text-sm">Assim que receber, eles aparecerão aqui.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- COLUNA DA DIREITA (Ações e Tutorial) --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- [NOVO] O MINI-TREINAMENTO / BOAS-VINDAS --}}
            @if($showTutorial)
                <div class="bg-emerald-600 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-extrabold text-white mb-3">👋 Bem-vindo(a)!</h3>
                    <p class="text-emerald-100 mb-4">
                        Este é o seu painel! Preparamos um guia rápido para você começar:
                    </p>
                    <ul class="space-y-3 mb-5">
                        <li class="flex items-center gap-3 text-white">
                            <i data-lucide="gift" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="text-sm">
                                <strong>1. Adicione seus Presentes:</strong> Vá em <a href="{{ route('presentes.index') }}" class="font-bold underline">"Gerenciar Presentes"</a> para criar seus itens (ex: "Jantar - R$ 100").
                            </span>
                        </li>
                        <li class="flex items-center gap-3 text-white">
                            <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="text-sm">
                                <strong>2. Configure sua Chave PIX:</strong> Em <a href="{{ route('list.config.edit') }}" class="font-bold underline">"Configurar Página"</a>, insira a chave PIX que receberá o dinheiro.
                            </span>
                        </li>
                        <li class="flex items-center gap-3 text-white">
                            <i data-lucide="share-2" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="text-sm">
                                <strong>3. Compartilhe:</strong> Use o link em <a href="{{ route('list.share') }}" class="font-bold underline">"Compartilhar"</a> para enviar aos seus convidados.
                            </span>
                        </li>
                    </ul>

                    {{-- Formulário para dispensar o tutorial --}}
                    <form action="{{ route('dashboard.dismiss-tutorial') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-emerald-700 bg-white rounded-lg hover:bg-emerald-50">
                            Entendi, fechar tutorial
                        </button>
                    </form>
                </div>
            @endif

            {{-- Acesso Rápido (Simplificado) --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('presentes.index') }}"
                       class="flex items-center justify-between gap-3 p-4 bg-gray-50 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 rounded-lg transition">
                        <span class="flex items-center gap-3 font-medium">
                            <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>
                            Adicionar/Editar presentes
                        </span>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('list.share') }}"
                       class="flex items-center justify-between gap-3 p-4 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition">
                        <span class="flex items-center gap-3 font-medium">
                            <i data-lucide="share-2" class="w-5 h-5 text-gray-500"></i>
                            Compartilhar link / QR Code
                        </span>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('rsvp.index') }}"
                       class="flex items-center justify-between gap-3 p-4 bg-gray-50 hover:bg-purple-50 text-gray-700 hover:text-purple-700 rounded-lg transition">
                        <span class="flex items-center gap-3 font-medium">
                            <i data-lucide="users" class="w-5 h-5 text-purple-600"></i>
                            Convidados e confirmações (RSVP)
                        </span>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            {{-- Status do Plano (Caixa menor) --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Status do Plano</h3>
                @if ($planoAtivo)
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        Plano Pixlist Ativo
                    </span>
                    <p class="text-sm text-gray-600 mt-2">
                        Sua lista está 100% funcional.
                    </p>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-sm font-semibold">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        Em teste gratuito (7 dias)
                    </span>
                    <p class="text-sm text-gray-600 mt-2">
                        Ative seu plano para garantir que sua lista fique no ar até depois do evento.
                    </p>
                    <a href="{{ route('plano.index') }}"
                       class="inline-flex items-center justify-center gap-2 w-full mt-4 px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                        Ativar plano agora (R$ 49,90)
                    </a>
                @endif
            </div>

        </div>
    </div>

    {{-- JS para ícones --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
