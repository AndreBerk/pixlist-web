<x-admin-layout title="Convidados (RSVP)">

    {{-- Cabeçalho da Página --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
            Convidados (RSVP)
        </h2>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            {{-- Botão Baixar PDF --}}
            <a href="{{ route('rsvp.export.pdf') }}" target="_blank"
               class="px-5 py-3 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-white font-bold rounded-xl shadow-sm hover:bg-gray-50 dark:hover:bg-slate-600 transition flex items-center justify-center gap-2">
                <i data-lucide="file-down" class="w-5 h-5 text-gray-500 dark:text-slate-300"></i>
                <span>Baixar PDF</span>
            </a>

            {{-- Botão Novo Convidado --}}
            <button
                type="button"
                onclick="document.getElementById('modalNovoConvidado').showModal()"
                class="px-5 py-3 bg-emerald-600 dark:bg-emerald-500 text-white font-bold rounded-xl shadow-md hover:bg-emerald-700 dark:hover:bg-emerald-600 transition flex items-center justify-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Novo Convidado</span>
            </button>
        </div>
    </div>

    {{-- Alertas --}}
    @if (session('status') === 'rsvp-admin-added')
        <div class="mb-4 p-4 text-sm font-bold text-green-800 dark:text-green-300 bg-green-100 dark:bg-green-900/30 rounded-xl border border-green-200 dark:border-green-800 flex items-center gap-2">
            <i data-lucide="check" class="w-4 h-4"></i> Adicionado com sucesso!
        </div>
    @endif
    @if (session('status') === 'rsvp-admin-updated')
        <div class="mb-4 p-4 text-sm font-bold text-blue-800 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800 flex items-center gap-2">
            <i data-lucide="check" class="w-4 h-4"></i> Atualizado com sucesso!
        </div>
    @endif
    @if (session('status') === 'rsvp-admin-deleted')
        <div class="mb-4 p-4 text-sm font-bold text-red-800 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-xl border border-red-200 dark:border-red-800 flex items-center gap-2">
            <i data-lucide="trash" class="w-4 h-4"></i> Removido com sucesso.
        </div>
    @endif

    {{-- Cards de Resumo (Grid Responsivo) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 transition-colors duration-300">
            <h3 class="text-xs font-bold uppercase text-gray-400 dark:text-slate-500 tracking-wider">Total</h3>
            <p class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalAdults + $totalChildren }}</p>
            <p class="text-xs text-gray-400 dark:text-slate-500">Pessoas</p>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 transition-colors duration-300">
            <h3 class="text-xs font-bold uppercase text-gray-400 dark:text-slate-500 tracking-wider">Adultos</h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $totalAdults }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 transition-colors duration-300">
            <h3 class="text-xs font-bold uppercase text-gray-400 dark:text-slate-500 tracking-wider">Crianças</h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $totalChildren }}</p>
        </div>
    </div>

    {{-- Filtros (Stack no Mobile) --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 mb-6 transition-colors duration-300">
        <form action="{{ route('rsvp.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search"
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-colors"
                       placeholder="Buscar nome..." value="{{ $search_term ?? '' }}">
            </div>
            <div class="flex-none">
                <select name="status"
                        class="w-full md:w-auto px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 transition-colors">
                    <option value="">Todos</option>
                    <option value="Confirmado" @selected($status_filter == 'Confirmado')>Confirmado</option>
                    <option value="Pendente" @selected($status_filter == 'Pendente')>Pendente</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-gray-900 dark:bg-slate-600 text-white font-bold rounded-xl hover:bg-black dark:hover:bg-slate-500 transition flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i> Filtrar
            </button>
            <a href="{{ route('rsvp.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition text-center">
                Limpar
            </a>
        </form>
    </div>

    {{--
        ==========================================
        VISÃO MOBILE: CARTÕES (Aparece só no celular)
        ==========================================
    --}}
    <div class="block md:hidden space-y-4">
        @forelse ($rsvps as $rsvp)
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 transition-colors duration-300">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $rsvp->guest_name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">{{ $rsvp->contact ?? 'Sem contato' }}</p>
                    </div>
                    @if ($rsvp->status == 'Confirmado')
                        <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold px-2 py-1 rounded-lg">Confirmado</span>
                    @else
                        <span class="bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 text-xs font-bold px-2 py-1 rounded-lg">Pendente</span>
                    @endif
                </div>

                <div class="flex gap-4 text-sm text-gray-700 dark:text-slate-300 mb-4 bg-gray-50 dark:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-600">
                    <div class="flex items-center gap-1">
                        <i data-lucide="user" class="w-4 h-4 text-gray-400 dark:text-slate-500"></i>
                        <b>{{ $rsvp->adults }}</b> Adultos
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="baby" class="w-4 h-4 text-gray-400 dark:text-slate-500"></i>
                        <b>{{ $rsvp->children }}</b> Crianças
                    </div>
                </div>

                <div class="flex gap-2 border-t border-gray-100 dark:border-slate-700 pt-3">
                    <a href="{{ route('rsvp.edit', $rsvp) }}" class="flex-1 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold rounded-lg text-center text-sm hover:bg-blue-100 dark:hover:bg-blue-900/50 transition">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Remover este convidado?');" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-lg text-sm hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                            Apagar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500 dark:text-slate-400 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-gray-200 dark:border-slate-700">
                Nenhum convidado encontrado.
            </div>
        @endforelse
    </div>

    {{--
        ==========================================
        VISÃO DESKTOP: TABELA (Aparece só no PC)
        ==========================================
    --}}
    <div class="hidden md:block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                <tr>
                    <th class="text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Convidado</th>
                    <th class="text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Status</th>
                    <th class="text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Adultos</th>
                    <th class="text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Crianças</th>
                    <th class="text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Contato</th>
                    <th class="text-right text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider p-4">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse ($rsvps as $rsvp)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition">
                        <td class="p-4 font-bold text-gray-800 dark:text-white">{{ $rsvp->guest_name }}</td>
                        <td class="p-4 text-center">
                            @if ($rsvp->status == 'Confirmado')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                    <i data-lucide="check" class="w-3 h-3"></i> Confirmado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300">
                                    <i data-lucide="clock" class="w-3 h-3"></i> Pendente
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center font-medium text-gray-700 dark:text-slate-300">{{ $rsvp->adults }}</td>
                        <td class="p-4 text-center font-medium text-gray-700 dark:text-slate-300">{{ $rsvp->children }}</td>
                        <td class="p-4 text-sm text-gray-500 dark:text-slate-400">{{ $rsvp->contact ?? '-' }}</td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('rsvp.edit', $rsvp) }}" class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition" title="Editar">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Remover?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition" title="Apagar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-500 dark:text-slate-400">Nenhum convidado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if ($rsvps->hasPages())
        <div class="mt-4">
            {{ $rsvps->links() }}
        </div>
    @endif

    @include('rsvp-modal-novo')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
