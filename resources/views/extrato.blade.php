<x-admin-layout title="Extrato Financeiro">

    {{-- Cabeçalho e Feedback --}}
    <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
            Extrato Financeiro
        </h2>
        <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Gerencie os presentes recebidos e modere as mensagens do mural.</p>
    </div>

    @if (session('status') === 'transaction-approved')
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 rounded-r-lg shadow-sm flex items-center gap-2 animate-fade-in-up">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-medium">Mensagem aprovada e publicada com sucesso!</span>
        </div>
    @endif

    {{-- 1. MÉTRICAS (Design mais compacto) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        {{-- Card Total --}}
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Total Arrecadado</p>
                <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">
                    R$ {{ number_format($totalArrecadado, 2, ',', '.') }}
                </p>
            </div>
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                <i data-lucide="dollar-sign" class="w-8 h-8"></i>
            </div>
        </div>

        {{-- Card Qtd --}}
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Presentes Recebidos</p>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ $presentesRecebidos }}
                </p>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                <i data-lucide="gift" class="w-8 h-8"></i>
            </div>
        </div>
    </div>

    {{-- 2. LISTAGEM (TABELA PARA DESKTOP) --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hidden md:block transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Convidado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Presente Escolhido</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Mensagem</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Valor</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($transactions as $tx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            {{-- Data --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                {{ $tx->created_at->format('d/m/Y') }} <br>
                                <span class="text-xs text-gray-400 dark:text-slate-500">{{ $tx->created_at->format('H:i') }}</span>
                            </td>

                            {{-- Convidado --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $tx->guest_name ?: 'Anônimo' }}
                                </div>
                            </td>

                            {{-- Presente --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                {{ \Illuminate\Support\Str::limit($tx->gift?->title ?? 'Presente removido', 30) }}
                            </td>

                            {{-- Mensagem e Moderação (Accordion) --}}
                            <td class="px-6 py-4 text-center">
                                @if ($tx->guest_message)
                                    <details class="group relative inline-block text-left">
                                        <summary class="list-none cursor-pointer focus:outline-none">
                                            @if (!$tx->is_approved)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/50 transition">
                                                    <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i> Pendente
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                                                    <i data-lucide="message-square" class="w-3 h-3 mr-1"></i> Ver
                                                </span>
                                            @endif
                                        </summary>

                                        {{-- Dropdown da Mensagem --}}
                                        <div class="absolute right-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-72 bg-white dark:bg-slate-700 rounded-lg shadow-xl border border-gray-200 dark:border-slate-600 z-50 p-4 text-left">
                                            <p class="text-sm text-gray-600 dark:text-slate-300 italic mb-3">"{{ $tx->guest_message }}"</p>

                                            @if (!$tx->is_approved)
                                                <form action="{{ route('extrato.approve', $tx) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full justify-center inline-flex items-center gap-2 px-3 py-2 text-xs font-bold rounded-md bg-emerald-600 text-white hover:bg-emerald-700 transition">
                                                        <i data-lucide="check" class="w-3 h-3"></i> Aprovar Publicação
                                                    </button>
                                                </form>
                                            @else
                                                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1 justify-center border-t pt-2 border-gray-100 dark:border-slate-600">
                                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Publicado no Mural
                                                </p>
                                            @endif
                                        </div>
                                    </details>
                                @else
                                    <span class="text-gray-300 dark:text-slate-600">-</span>
                                @endif
                            </td>

                            {{-- Valor --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                + R$ {{ number_format($tx->amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-slate-400">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-400 dark:text-slate-500"></i>
                                Nenhum lançamento encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação Desktop --}}
        @if ($transactions->hasPages())
            <div class="bg-gray-50 dark:bg-slate-700/50 px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    {{-- 3. LISTAGEM MOBILE (Cards Compactos) --}}
    <div class="md:hidden space-y-4">
        @forelse ($transactions as $tx)
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 transition-colors">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $tx->guest_name ?: 'Anônimo' }}</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $tx->gift?->title ?? 'Presente removido' }}</p>
                    </div>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">R$ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-end mt-3 border-t border-gray-50 dark:border-slate-700 pt-3">
                    <span class="text-xs text-gray-400 dark:text-slate-500">{{ $tx->created_at->format('d/m/Y H:i') }}</span>

                    @if ($tx->guest_message)
                        <details class="group relative">
                            <summary class="list-none focus:outline-none">
                                @if (!$tx->is_approved)
                                    <span class="cursor-pointer inline-flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2 py-1 rounded-md border border-amber-100 dark:border-amber-800">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i> Aprovar Mensagem
                                    </span>
                                @else
                                    <span class="cursor-pointer text-xs font-medium text-gray-500 dark:text-slate-400 flex items-center gap-1 hover:text-gray-700 dark:hover:text-slate-200">
                                        <i data-lucide="message-square" class="w-3 h-3"></i> Ver mensagem
                                    </span>
                                @endif
                            </summary>
                            <div class="mt-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg text-sm text-gray-700 dark:text-slate-300 italic border border-gray-100 dark:border-slate-600">
                                "{{ $tx->guest_message }}"
                                @if (!$tx->is_approved)
                                    <form action="{{ route('extrato.approve', $tx) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="w-full text-center px-3 py-2 text-xs font-bold rounded bg-emerald-600 text-white hover:bg-emerald-700">
                                            Publicar no Mural
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </details>
                    @endif
                </div>
            </div>
        @empty
             <div class="bg-white dark:bg-slate-800 p-8 rounded-xl text-center shadow-sm border border-gray-100 dark:border-slate-700">
                <p class="text-gray-500 dark:text-slate-400">Nenhum lançamento.</p>
            </div>
        @endforelse

        {{-- Paginação Mobile --}}
        <div class="mt-4">
             {{ $transactions->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>

</x-admin-layout>
