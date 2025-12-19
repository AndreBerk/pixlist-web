<x-admin-layout title="Editar Presente">

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
        Editar presente:
        <span class="text-emerald-600 dark:text-emerald-400">{{ $presente->title }}</span>
    </h2>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 md:p-8 max-w-2xl transition-colors duration-300">

        <form
            method="POST"
            action="{{ route('presentes.update', $presente) }}"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <label for="npTitulo" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                    Título do presente
                </label>
                <input
                    id="npTitulo"
                    name="title"
                    type="text"
                    required
                    autocomplete="off"
                    class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm
                           focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="Ex.: Jantar romântico"
                    value="{{ old('title', $presente->title) }}"
                />
            </div>

            {{-- Valor e Quantidade --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="npValor" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Valor por cota (R$)
                    </label>
                    <input
                        id="npValor"
                        name="value"
                        type="number"
                        min="0"
                        step="0.01"
                        required
                        class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm
                               focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        placeholder="150,00"
                        value="{{ old('value', $presente->value) }}"
                    />
                </div>

                <div>
                    <label for="npQtd" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                        Quantidade de cotas
                    </label>
                    <input
                        id="npQtd"
                        name="quantity"
                        type="number"
                        min="1"
                        step="1"
                        required
                        class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm
                               focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        value="{{ old('quantity', $presente->quantity) }}"
                    />
                </div>
            </div>

            {{-- Descrição --}}
            <div>
                <label for="npDesc" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                    Descrição (opcional)
                </label>
                <textarea
                    id="npDesc"
                    name="description"
                    rows="3"
                    class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm
                           focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="Ex.: Jantar especial em restaurante italiano."
                >{{ old('description', $presente->description) }}</textarea>
            </div>

            {{-- Upload de Imagem --}}
            @php
                $hasImage = $presente->image_url && \Illuminate\Support\Str::startsWith($presente->image_url, 'gift_images/');
            @endphp

            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                    Imagem do presente (opcional)
                </label>

                @if ($hasImage)
                    <div class="mt-1">
                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">Imagem atual:</p>
                        <img
                            src="{{ asset('storage/' . $presente->image_url) }}"
                            alt="Imagem atual"
                            class="w-24 h-24 object-cover rounded-lg border dark:border-slate-600"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    name="image"
                    accept="image/png,image/jpeg,image/webp"
                    class="w-full text-sm text-gray-600 dark:text-slate-400
                           file:mr-3 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-emerald-50 dark:file:bg-emerald-900/30 file:text-emerald-700 dark:file:text-emerald-400
                           hover:file:bg-emerald-100 dark:hover:file:bg-emerald-900/50 cursor-pointer
                           rounded-lg border border-gray-300 dark:border-slate-600 shadow-sm dark:bg-slate-900"
                >
                <p class="text-xs text-gray-500 dark:text-slate-500">
                    Se enviar uma nova imagem, ela substituirá a atual.
                </p>
            </div>

            {{-- Ações --}}
            <div class="flex items-center justify-end gap-3 pt-4">
                <a
                    href="{{ route('presentes.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-emerald-600 dark:bg-emerald-500 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 dark:hover:bg-emerald-600 transition-colors"
                >
                    Salvar alterações
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
