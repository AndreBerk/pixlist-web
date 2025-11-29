<dialog id="modalNovoConvidado"
        class="backdrop:bg-black/60 backdrop:backdrop-blur-sm rounded-2xl shadow-2xl w-[95%] max-w-lg p-0 open:animate-fade-in">

    <div class="p-6 bg-white">
        <form method="POST"
              action="{{ route('rsvp.admin.store') }}"
              class="space-y-5">
            @csrf

            <div class="flex justify-between items-center mb-2">
                <h2 class="text-xl font-extrabold text-gray-900">Adicionar Convidado</h2>
                <button type="button"
                        class="p-2 rounded-full hover:bg-gray-100 transition"
                        onclick="document.getElementById('modalNovoConvidado').close()">
                    <i data-lucide="x" class="w-6 h-6 text-gray-500"></i>
                </button>
            </div>

            <p class="text-sm text-gray-500 leading-relaxed">
                Adicione manualmente um convidado. Ele entrará como "Pendente".
            </p>

            {{-- Nome --}}
            <div>
                <label for="rsvp-nome" class="block text-sm font-bold text-gray-700 mb-1">Nome Completo</label>
                <input
                    id="rsvp-nome"
                    type="text"
                    name="guest_name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    placeholder="Ex: Família Silva"
                    required
                >
            </div>

            {{-- Adultos e Crianças --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rsvp-adultos" class="block text-sm font-bold text-gray-700 mb-1">Adultos</label>
                    <input
                        id="rsvp-adultos"
                        type="number"
                        min="0"
                        name="adults"
                        value="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required
                    >
                </div>
                 <div>
                    <label for="rsvp-criancas" class="block text-sm font-bold text-gray-700 mb-1">Crianças</label>
                    <input
                        id="rsvp-criancas"
                        type="number"
                        min="0"
                        name="children"
                        value="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required
                    >
                </div>
            </div>

            {{-- Contato --}}
            <div>
                <label for="rsvp-contato" class="block text-sm font-bold text-gray-700 mb-1">Contato (opcional)</label>
                <input
                    id="rsvp-contato"
                    type="text"
                    name="contact"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    placeholder="Email ou Telefone"
                >
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-2">
                <button type="button"
                        class="w-full sm:w-auto px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition"
                        onclick="document.getElementById('modalNovoConvidado').close()">
                    Cancelar
                </button>

                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
    <style>
        dialog[open] { animation: zoom-in 0.2s ease-out; }
        @keyframes zoom-in { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</dialog>