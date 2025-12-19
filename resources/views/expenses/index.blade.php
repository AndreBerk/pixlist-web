<x-admin-layout title="Despesas">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Gestão de Despesas</h2>
            <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 mt-1">Controle o orçamento e formas de pagamento.</p>
        </div>
        <button x-data @click="$dispatch('open-expense-modal')" class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 bg-slate-900 dark:bg-emerald-600 text-white font-bold rounded-xl hover:bg-slate-800 dark:hover:bg-emerald-700 transition shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i> Nova Despesa
        </button>
    </div>

    {{-- Cards de Resumo (Grid Responsivo) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8">
        {{-- Card Total --}}
        <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden group transition-colors duration-300">
            <div class="absolute right-0 top-0 w-20 h-20 md:w-24 md:h-24 bg-slate-50 dark:bg-slate-700 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-xs md:text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Orçamento Total</p>
                <h3 class="text-xl md:text-3xl font-black text-slate-800 dark:text-white">R$ {{ number_format($totalBudget, 2, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Card Pago --}}
        <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 shadow-sm relative overflow-hidden group transition-colors duration-300">
            <div class="absolute right-0 top-0 w-20 h-20 md:w-24 md:h-24 bg-emerald-50 dark:bg-emerald-900/30 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-xs md:text-sm font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Já Pago</p>
                <h3 class="text-xl md:text-3xl font-black text-emerald-700 dark:text-emerald-400">R$ {{ number_format($totalPaid, 2, ',', '.') }}</h3>
                <div class="w-full bg-emerald-100 dark:bg-emerald-900/50 h-1.5 rounded-full mt-3 overflow-hidden">
                    <div class="bg-emerald-500 dark:bg-emerald-400 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>

        {{-- Card A Pagar --}}
        <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-2xl border border-rose-100 dark:border-rose-900/50 shadow-sm relative overflow-hidden group transition-colors duration-300">
            <div class="absolute right-0 top-0 w-20 h-20 md:w-24 md:h-24 bg-rose-50 dark:bg-rose-900/30 rounded-bl-full -mr-4 -mt-4 transition group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-xs md:text-sm font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-1">A Pagar</p>
                <h3 class="text-xl md:text-3xl font-black text-rose-700 dark:text-rose-400">R$ {{ number_format($totalPending, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    @if($expenses->isEmpty())
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-12 text-center transition-colors duration-300">
            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="receipt" class="w-8 h-8 text-slate-400 dark:text-slate-500"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Nenhuma despesa lançada</h3>
            <p class="text-slate-500 dark:text-slate-400">Comece adicionando os custos do buffet, decoração, etc.</p>
        </div>
    @else

        {{--
            ==============================================
            VISÃO DESKTOP (TABELA)
            ==============================================
        --}}
        <div class="hidden md:block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Descrição / Categoria</th>
                            <th class="px-6 py-4">Pagamento</th>
                            <th class="px-6 py-4">Vencimento</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Valor</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($expenses as $expense)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                            {{-- Descrição --}}
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 dark:text-white">{{ $expense->description }}</p>
                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md">{{ $expense->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @include('expenses.partials.payment-badge', ['method' => $expense->payment_method])
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                @if($expense->due_date)
                                    <div class="flex items-center gap-1.5 {{ $expense->status !== 'paid' && $expense->due_date < now() ? 'text-rose-600 dark:text-rose-400 font-bold' : '' }}">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                        {{ $expense->due_date->format('d/m/Y') }}
                                    </div>
                                @else - @endif
                            </td>
                            <td class="px-6 py-4">
                                @include('expenses.partials.status-badge', ['status' => $expense->status])
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm text-slate-900 dark:text-white font-bold">R$ {{ number_format($expense->amount, 2, ',', '.') }}</p>
                                @if($expense->amount_paid > 0)
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Pago: {{ number_format($expense->amount_paid, 2, ',', '.') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @include('expenses.partials.actions', ['expense' => $expense])
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{--
            ==============================================
            VISÃO MOBILE (CARDS)
            ==============================================
        --}}
        <div class="md:hidden space-y-4">
            @foreach($expenses as $expense)
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm transition-colors duration-300">

                {{-- Linha 1 --}}
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-lg">{{ $expense->description }}</h4>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md">{{ $expense->category }}</span>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900 dark:text-white">R$ {{ number_format($expense->amount, 2, ',', '.') }}</p>
                        @if($expense->amount_paid > 0)
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">Pago: {{ number_format($expense->amount_paid, 2, ',', '.') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Linha 2 --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @include('expenses.partials.status-badge', ['status' => $expense->status])
                    @include('expenses.partials.payment-badge', ['method' => $expense->payment_method])
                </div>

                {{-- Linha 3 --}}
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                    <div class="text-sm text-slate-500 dark:text-slate-400">
                        @if($expense->due_date)
                            <div class="flex items-center gap-1.5 {{ $expense->status !== 'paid' && $expense->due_date < now() ? 'text-rose-600 dark:text-rose-400 font-bold' : '' }}">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                {{ $expense->due_date->format('d/m') }}
                            </div>
                        @else
                            <span class="text-xs italic">Sem data</span>
                        @endif
                    </div>

                    <div class="flex gap-1">
                        @include('expenses.partials.actions', ['expense' => $expense])
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    @endif

    {{--
        =================================================================
        MODAIS (Dark Mode Ready)
        =================================================================
    --}}

    {{-- MODAL: NOVA DESPESA --}}
    <div x-data="{ open: false }"
         @open-expense-modal.window="open = true"
         x-show="open" x-cloak class="relative z-50">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" x-show="open" x-transition.opacity></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto transition-colors duration-300" @click.away="open = false" x-show="open" x-transition.scale>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Nova Despesa</h3>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <form action="{{ route('despesas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Descrição</label>
                        <input type="text" name="description" placeholder="Ex: Buffet" required
                               class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Categoria</label>
                            <select name="category" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                                <option value="Buffet">Buffet</option>
                                <option value="Decoração">Decoração</option>
                                <option value="Local">Local</option>
                                <option value="Foto e Vídeo">Foto e Vídeo</option>
                                <option value="Música">Música/DJ</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Valor (R$)</label>
                            <input type="number" step="0.01" name="amount" placeholder="0,00" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Pagamento</label>
                        <select name="payment_method" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                            <option value="">Selecione...</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="pix">PIX</option>
                            <option value="cash">Dinheiro</option>
                            <option value="boleto">Boleto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Vencimento</label>
                        <input type="date" name="due_date" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-slate-900 dark:bg-emerald-600 text-white font-bold rounded-xl hover:bg-slate-800 dark:hover:bg-emerald-700 transition active:scale-95">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: EDITAR DESPESA --}}
    <div x-data="{ open: false, data: { id: null, description: '', category: '', amount: 0, payment_method: '', due_date: '' } }"
         @open-edit-expense-modal.window="open = true; data = $event.detail;"
         x-show="open" x-cloak class="relative z-50">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" x-show="open" x-transition.opacity></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto transition-colors duration-300" @click.away="open = false" x-show="open" x-transition.scale>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Editar Despesa</h3>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <form x-bind:action="'/despesas/' + data.id" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Descrição</label>
                        <input type="text" name="description" x-model="data.description" required
                               class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Categoria</label>
                            <select name="category" x-model="data.category" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                                <option value="Buffet">Buffet</option>
                                <option value="Decoração">Decoração</option>
                                <option value="Local">Local</option>
                                <option value="Foto e Vídeo">Foto e Vídeo</option>
                                <option value="Música">Música/DJ</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Valor Total (R$)</label>
                            <input type="number" step="0.01" name="amount" x-model="data.amount" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Pagamento</label>
                        <select name="payment_method" x-model="data.payment_method" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                            <option value="">Selecione...</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="pix">PIX</option>
                            <option value="cash">Dinheiro</option>
                            <option value="boleto">Boleto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Vencimento</label>
                        <input type="date" name="due_date" x-model="data.due_date"
                               class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 py-3">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-blue-600 dark:bg-blue-500 text-white font-bold rounded-xl hover:bg-blue-700 transition active:scale-95">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: PAGAMENTO RÁPIDO --}}
    <div x-data="{ open: false, expenseId: null, expenseDesc: '', totalAmount: 0, currentPaid: 0 }"
         @open-payment-modal.window="open = true; expenseId = $event.detail.id; expenseDesc = $event.detail.description; totalAmount = $event.detail.total; currentPaid = $event.detail.paid"
         x-show="open" x-cloak class="relative z-50">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" x-show="open" x-transition.opacity></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md p-6 transition-colors duration-300" @click.away="open = false" x-show="open" x-transition.scale>
                <div class="mb-6">
                    <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Atualizar Pagamento</p>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white" x-text="expenseDesc"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Total: R$ <span x-text="totalAmount.toFixed(2)"></span></p>
                </div>
                <form x-bind:action="'/despesas/' + expenseId" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Quanto já pagou?</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-slate-400">R$</span>
                            <input type="number" step="0.01" name="amount_paid" x-model="currentPaid"
                                   class="w-full pl-10 rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 font-bold text-lg py-3">
                        </div>
                    </div>
                    <div class="pt-2 flex gap-3">
                        <button type="button" @click="open = false" class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition">Cancelar</button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- PARTIALS INTERNOS --}}
    @php
        // Apenas para o Blade não reclamar que os arquivos não existem se você não criou
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
