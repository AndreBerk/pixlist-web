<dialog id="modalNovoPresente"
        class="backdrop:bg-black/50 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg p-6 transition-colors duration-300">

    <form
        method="POST"
        action="{{ route('presentes.store') }}"
        enctype="multipart/form-data"
        class="space-y-4"
    >
        @csrf

        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2">Adicionar presente</h2>

        {{-- Título --}}
        <div class="flex flex-col gap-1">
            <label for="npTitulo" class="text-sm font-medium text-gray-700 dark:text-slate-300">
                Nome do presente
            </label>
            <input
                id="npTitulo"
                type="text"
                name="title"
                class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                placeholder="Ex.: Jogo de panelas inox"
                required
            >
        </div>

        {{-- Valor --}}
        <div class="flex flex-col gap-1">
            <label for="npValor" class="text-sm font-medium text-gray-700 dark:text-slate-300">
                Valor por cota (R$)
            </label>
            <input
                id="npValor"
                type="number"
                step="0.01"
                min="0"
                name="value"
                class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                placeholder="Ex.: 299.90"
                required
            >
        </div>

        {{-- Descrição --}}
        <div class="flex flex-col gap-1">
            <label for="npDesc" class="text-sm font-medium text-gray-700 dark:text-slate-300">
                Descrição (opcional)
            </label>
            <textarea
                id="npDesc"
                name="description"
                rows="3"
                class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                placeholder="Por que esse presente é especial? Onde vocês vão usar?"
            ></textarea>
        </div>

        {{-- Quantidade de cotas --}}
        <div class="flex flex-col gap-1">
            <label for="npQtd" class="text-sm font-medium text-gray-700 dark:text-slate-300">
                Quantidade de cotas
            </label>
            <input
                id="npQtd"
                type="number"
                name="quantity"
                min="1"
                value="1"
                class="w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                required
            >
            <p class="text-xs text-gray-500 dark:text-slate-500 leading-tight">
                Ex.: Viagem de Lua de Mel (10 cotas de R$ 500).
            </p>
        </div>

        {{-- Imagem do presente (apenas upload) --}}
        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-gray-700 dark:text-slate-300">
                Imagem do presente (opcional)
            </label>

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
                       border border-gray-300 dark:border-slate-600 rounded-lg shadow-sm dark:bg-slate-900 transition-colors"
            >
            <p class="text-xs text-gray-500 dark:text-slate-500 leading-tight">
                Se você enviar uma imagem, ela será exibida na sua lista de presentes.
            </p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <button
                type="button"
                class="text-sm font-medium text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 transition-colors"
                onclick="document.getElementById('modalNovoPresente').close()"
            >
                Cancelar
            </button>

            <button
                type="submit"
                class="px-4 py-2 bg-emerald-600 dark:bg-emerald-500 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 dark:hover:bg-emerald-600 transition-colors shadow-md"
            >
                Salvar presente
            </button>
        </div>
    </form>
</dialog>
