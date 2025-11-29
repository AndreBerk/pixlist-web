<x-admin-layout>

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Extrato de Presentes & Mensagens
    </h2>

    {{-- [NOVO] Feedback de aprovação --}}
    @if (session('status') === 'Mensagem aprovada com sucesso!')
        <div class="mb-4 p-4 text-sm font-medium text-green-800 bg-green-100 rounded-lg">
            Mensagem aprovada e publicada no mural!
        </div>
    @endif

    {{-- MÉTRICAS RESUMO --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">
                    Total arrecadado
                </h3>
            </div>
            <p class="text-4xl font-extrabold text-emerald-600 mt-1">
                R$ {{ number_format($totalArrecadado, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="gift" class="w-5 h-5"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">
                    Total de presentes recebidos
                </h3>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mt-1">
                {{ $presentesRecebidos }}
            </p>
        </div>
    </div>

    {{-- LISTA DE TRANSAÇÕES / MENSAGENS --}}
    <div class="space-y-4 max-w-3xl">

        @forelse ($transactions as $tx)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 transition-all hover:shadow-xl">

                {{-- Cabeçalho: nome + data + valor --}}
                <div class="flex justify-between items-start mb-3 gap-4">
                    <div>
                        <p class="font-extrabold text-xl text-emerald-700 leading-snug">
                            {{ $tx->guest_name ?: 'Convidado anônimo' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $tx->created_at->format('d/m/Y \à\s H:i') }}
                        </p>
                    </div>

                    <span class="text-xl font-bold text-emerald-600 whitespace-nowrap">
                        + R$ {{ number_format($tx->amount, 2, ',', '.') }}
                    </span>
                </div>

                {{-- [MUDANÇA] Lógica de Moderação de Mensagem --}}
                @if ($tx->guest_message)
                    {{-- Se tem mensagem E NÃO está aprovada, mostra o botão --}}
                    @if (!$tx->is_approved)
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-amber-700 mb-1">
                                MENSAGEM PENDENTE DE APROVAÇÃO
                            </p>
                            <p class="text-gray-700 italic">
                                “{{ $tx->guest_message }}”
                            </p>

                            {{-- Formulário de Aprovação --}}
                            <form action="{{ route('extrato.approve', $tx) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-md bg-emerald-600 text-white hover:bg-emerald-700">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                    Aprovar e publicar no mural
                                </button>
                            </form>
                        </div>
                    {{-- Se tem mensagem E JÁ está aprovada --}}
                    @else
                         <div class="bg-gray-50 border-l-4 border-gray-300 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold text-gray-500 mb-1">
                                    Mensagem do convidado
                                </p>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Publicado no mural
                                </span>
                            </div>
                            <p class="text-gray-700 italic mt-1">
                                “{{ $tx->guest_message }}”
                            </p>
                        </div>
                    @endif
                {{-- Se não tem mensagem, não mostra nada --}}
                @else
                    <div class="bg-gray-50 border-l-4 border-gray-300 p-4 rounded-lg">
                         <p class="text-sm text-gray-500">
                            O convidado não deixou uma mensagem.
                         </p>
                    </div>
                @endif
                {{-- [FIM DA MUDANÇA] --}}


                {{-- Info do presente --}}
                <p class="text-sm text-gray-500 mt-4">
                    Presente:
                    <span class="font-medium text-gray-800">
                        {{ $tx->gift?->title ?? 'Presente removido' }}
                    </span>
                </p>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">
                <i data-lucide="inbox" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-1">
                    Nenhum presente recebido ainda
                </h3>
                <p class="text-gray-500 text-sm">
                    Assim que seus convidados começarem a presentear, o histórico de presentes e mensagens aparecerá aqui.
                </p>
            </div>
        @endforelse

        {{-- Paginação --}}
        @if ($transactions instanceof \Illuminate\Contracts\Pagination\Paginator && $transactions->hasPages())
            <div class="pt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>

</x-admin-layout>
