<x-admin-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Editar Convidado:
        <span class="text-emerald-600 block sm:inline text-xl sm:text-3xl">{{ $rsvp->guest_name }}</span>
    </h2>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-5 md:p-8 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('rsvp.update', $rsvp) }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nome --}}
            <div>
                <label for="guest_name" class="block text-sm font-bold text-gray-700 mb-1">Nome do Convidado</label>
                <input
                    id="guest_name"
                    type="text"
                    name="guest_name"
                    value="{{ old('guest_name', $rsvp->guest_name) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                    required
                >
            </div>

            {{-- Adultos e Crianças --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="adults" class="block text-sm font-bold text-gray-700 mb-1">Adultos</label>
                    <input
                        id="adults"
                        type="number"
                        min="0"
                        name="adults"
                        value="{{ old('adults', $rsvp->adults) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
                        required
                    >
                </div>
                <div>
                    <label for="children" class="block text-sm font-bold text-gray-700 mb-1">Crianças</label>
                    <input
                        id="children"
                        type="number"
                        min="0"
                        name="children"
                        value="{{ old('children', $rsvp->children) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
                        required
                    >
                </div>
            </div>

            {{-- Contato --}}
            <div>
                <label for="contact" class="block text-sm font-bold text-gray-700 mb-1">Contato (opcional)</label>
                <input
                    id="contact"
                    type="text"
                    name="contact"
                    value="{{ old('contact', $rsvp->contact) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
                    placeholder="Email ou WhatsApp"
                >
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="Pendente"  @selected(old('status', $rsvp->status) === 'Pendente')>⏳ Pendente</option>
                    <option value="Confirmado" @selected(old('status', $rsvp->status) === 'Confirmado')>✅ Confirmado</option>
                </select>
            </div>

            {{-- Ações --}}
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4">
                <a href="{{ route('rsvp.index') }}"
                   class="w-full sm:w-auto text-center px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="w-full sm:w-auto px-5 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>