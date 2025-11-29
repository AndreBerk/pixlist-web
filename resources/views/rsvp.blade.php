<x-admin-layout>

    {{-- Cabeçalho da Página --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">
            Convidados (RSVP)
        </h2>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            {{-- [NOVO] Botão Baixar PDF --}}
            <a href="{{ route('rsvp.export.pdf') }}" target="_blank"
               class="px-5 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                <i data-lucide="file-down" class="w-5 h-5 text-gray-500"></i>
                <span>Baixar PDF</span>
            </a>

            {{-- Botão Novo Convidado --}}
            <button
                type="button"
                onclick="document.getElementById('modalNovoConvidado').showModal()"
                class="px-5 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-md hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Novo Convidado</span>
            </button>
        </div>
    </div>

    {{-- Alertas --}}
    @if (session('status') === 'rsvp-admin-added')
        <div class="mb-4 p-4 text-sm font-bold text-green-800 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2">
            <i data-lucide="check" class="w-4 h-4"></i> Adicionado com sucesso!
        </div>
    @endif
    @if (session('status') === 'rsvp-admin-updated')
        <div class="mb-4 p-4 text-sm font-bold text-blue-800 bg-blue-100 rounded-xl border border-blue-200 flex items-center gap-2">
            <i data-lucide="check" class="w-4 h-4"></i> Atualizado com sucesso!
        </div>
    @endif
    @if (session('status') === 'rsvp-admin-deleted')
        <div class="mb-4 p-4 text-sm font-bold text-red-800 bg-red-100 rounded-xl border border-red-200 flex items-center gap-2">
            <i data-lucide="trash" class="w-4 h-4"></i> Removido com sucesso.
        </div>
    @endif

    {{-- Cards de Resumo (Grid Responsivo) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider">Total</h3>
            <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $totalAdults + $totalChildren }}</p>
            <p class="text-xs text-gray-400">Pessoas</p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider">Adultos</h3>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalAdults }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider">Crianças</h3>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalChildren }}</p>
        </div>
    </div>

    {{-- Filtros (Stack no Mobile) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('rsvp.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none"
                       placeholder="Buscar nome..." value="{{ $search_term ?? '' }}">
            </div>
            <div class="flex-none">
                <select name="status" class="w-full md:w-auto px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="">Todos</option>
                    <option value="Confirmado" @selected($status_filter == 'Confirmado')>Confirmado</option>
                    <option value="Pendente" @selected($status_filter == 'Pendente')>Pendente</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i> Filtrar
            </button>
            <a href="{{ route('rsvp.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition text-center">
                Limpar
            </a>
        </form>
    </div>

    {{-- ==========================================
         VISÃO MOBILE: CARTÕES (Aparece só no celular)
         ========================================== --}}
    <div class="block md:hidden space-y-4">
        @forelse ($rsvps as $rsvp)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $rsvp->guest_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $rsvp->contact ?? 'Sem contato' }}</p>
                    </div>
                    @if ($rsvp->status == 'Confirmado')
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-lg">Confirmado</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded-lg">Pendente</span>
                    @endif
                </div>

                <div class="flex gap-4 text-sm text-gray-700 mb-4 bg-gray-50 p-3 rounded-xl">
                    <div class="flex items-center gap-1">
                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        <b>{{ $rsvp->adults }}</b> Adultos
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="baby" class="w-4 h-4 text-gray-400"></i>
                        <b>{{ $rsvp->children }}</b> Crianças
                    </div>
                </div>

                <div class="flex gap-2 border-t border-gray-100 pt-3">
                    <a href="{{ route('rsvp.edit', $rsvp) }}" class="flex-1 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg text-center text-sm hover:bg-blue-100">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Remover este convidado?');" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 text-red-600 font-bold rounded-lg text-sm hover:bg-red-100">
                            Apagar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">Nenhum convidado encontrado.</div>
        @endforelse
    </div>

    {{-- ==========================================
         VISÃO DESKTOP: TABELA (Aparece só no PC)
         ========================================== --}}
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Convidado</th>
                    <th class="text-center text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Status</th>
                    <th class="text-center text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Adultos</th>
                    <th class="text-center text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Crianças</th>
                    <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Contato</th>
                    <th class="text-right text-xs font-bold text-gray-500 uppercase tracking-wider p-4">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($rsvps as $rsvp)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $rsvp->guest_name }}</td>
                        <td class="p-4 text-center">
                            @if ($rsvp->status == 'Confirmado')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <i data-lucide="check" class="w-3 h-3"></i> Confirmado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                    <i data-lucide="clock" class="w-3 h-3"></i> Pendente
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center font-medium">{{ $rsvp->adults }}</td>
                        <td class="p-4 text-center font-medium">{{ $rsvp->children }}</td>
                        <td class="p-4 text-sm text-gray-500">{{ $rsvp->contact ?? '-' }}</td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('rsvp.edit', $rsvp) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Editar">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Remover?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Apagar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-500">Nenhum convidado.</td></tr>
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
