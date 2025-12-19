<x-admin-layout title="Editar Convidado">

    {{-- Cabeçalho --}}
    <div class="max-w-3xl mx-auto mb-6">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
            Editar Convidado
        </h2>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
            Atualize as informações do convidado abaixo.
        </p>

        <div class="mt-2 text-lg font-bold text-emerald-600 dark:text-emerald-400">
            {{ $rsvp->guest_name }}
        </div>
    </div>

    {{-- Card do Formulário --}}
    <div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">

        <form method="POST" action="{{ route('rsvp.update', $rsvp) }}" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Nome --}}
            <div>
                <label for="guest_name" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                    Nome do Convidado
                </label>
                <input
                    id="guest_name"
                    type="text"
                    name="guest_name"
                    value="{{ old('guest_name', $rsvp->guest_name) }}"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                           outline-none transition-colors"
                >
            </div>

            {{-- Adultos / Crianças --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="adults" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                        Adultos
                    </label>
                    <input
                        id="adults"
                        type="number"
                        min="0"
                        inputmode="numeric"
                        name="adults"
                        value="{{ old('adults', $rsvp->adults) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                               outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="children" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                        Crianças
                    </label>
                    <input
                        id="children"
                        type="number"
                        min="0"
                        inputmode="numeric"
                        name="children"
                        value="{{ old('children', $rsvp->children) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                               outline-none transition-colors"
                    >
                </div>
            </div>

            {{-- Contato --}}
            <div>
                <label for="contact" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                    Contato (opcional)
                </label>
                <input
                    id="contact"
                    type="text"
                    name="contact"
                    value="{{ old('contact', $rsvp->contact) }}"
                    placeholder="WhatsApp ou e-mail"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                           outline-none transition-colors placeholder:text-gray-400 dark:placeholder:text-slate-500"
                >
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                    Status do Convidado
                </label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                           outline-none transition-colors">
                    <option value="Pendente" @selected(old('status', $rsvp->status) === 'Pendente')>
                        ⏳ Pendente
                    </option>
                    <option value="Confirmado" @selected(old('status', $rsvp->status) === 'Confirmado')>
                        ✅ Confirmado
                    </option>
                </select>
            </div>

            {{-- Ações --}}
            <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 dark:border-slate-700">

                <a href="{{ route('rsvp.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-xl
                          border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-bold
                          hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>

                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl
                               bg-emerald-600 dark:bg-emerald-500 text-white font-extrabold
                               hover:bg-emerald-700 dark:hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200 dark:shadow-none">
                    Salvar alterações
                </button>
            </div>

        </form>
    </div>

</x-admin-layout>
