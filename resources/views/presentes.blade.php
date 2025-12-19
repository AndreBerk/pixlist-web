<x-admin-layout title="Presentes">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Gerenciar Presentes</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Adicione itens para os convidados presentearem.</p>
        </div>

        <button
            id="btnAbrirModalNovoPresente"
            class="px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-md shadow-emerald-200 dark:shadow-none hover:bg-emerald-700 transition inline-flex items-center gap-2"
        >
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Novo presente</span>
        </button>
    </div>

    {{-- Alerts de status --}}
    @if (session('status') === 'presente-criado')
        <div class="mb-6 p-4 text-sm font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-900/30 border-l-4 border-emerald-500 rounded-r-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i> Presente adicionado com sucesso!
        </div>
    @endif
    @if (session('status') === 'presente-deletado')
        <div class="mb-6 p-4 text-sm font-medium text-red-800 dark:text-red-300 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 rounded-r-lg flex items-center gap-2">
            <i data-lucide="trash-2" class="w-5 h-5"></i> Presente removido com sucesso.
        </div>
    @endif
    @if (session('status') === 'presente-atualizado')
        <div class="mb-6 p-4 text-sm font-medium text-blue-800 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 border-l-4 border-blue-500 rounded-r-lg flex items-center gap-2">
            <i data-lucide="check" class="w-5 h-5"></i> Presente atualizado com sucesso.
        </div>
    @endif

    {{-- Templates sugeridos --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 mb-8 transition-colors duration-300">
        <div class="flex items-center gap-2 mb-4">
            <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <p class="text-base md:text-lg font-bold text-gray-900 dark:text-white">
                Sugestões Rápidas
                <span class="text-sm font-normal text-gray-500 dark:text-slate-400 ml-1">(Estilo: {{ $list->style }})</span>
            </p>
        </div>

        <div id="areaTemplates" class="flex flex-wrap gap-2">
            @foreach ($templatesSugeridos as $template)
                <button
                    type="button"
                    class="btn-template px-4 py-2 bg-gray-50 dark:bg-slate-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                           text-gray-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400
                           border border-gray-200 dark:border-slate-600 hover:border-emerald-200 dark:hover:border-emerald-700
                           rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-1"
                    data-titulo="{{ $template['title'] }}"
                    data-valor="{{ $template['value'] }}"
                    data-desc="{{ $template['desc'] ?? '' }}"
                >
                    <i data-lucide="plus" class="w-3 h-3"></i> {{ $template['title'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Lista de presentes cadastrados --}}
    <div class="flex items-center gap-2 mb-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Meus presentes</h3>
        <span class="px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-xs font-bold">
            {{ count($gifts) }}
        </span>
    </div>

    <div id="listaAdminPresentes" class="space-y-3">
        @forelse ($gifts as $gift)
            @php
                $hasUpload = $gift->image_url && \Illuminate\Support\Str::contains($gift->image_url, '/');
            @endphp

            <div class="group flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-700 transition-all duration-200">

                <div class="flex items-start gap-4 w-full">
                    {{-- Miniatura --}}
                    <div class="w-16 h-16 rounded-xl border border-gray-100 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 overflow-hidden flex items-center justify-center text-gray-400 dark:text-slate-500 flex-shrink-0">
                        @if ($hasUpload)
                            <img
                                src="{{ asset('storage/'.$gift->image_url) }}"
                                alt="Imagem {{ $gift->title }}"
                                class="w-full h-full object-cover"
                            />
                        @else
                            <i data-lucide="image" class="w-8 h-8"></i>
                        @endif
                    </div>

                    {{-- Texto --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white truncate pr-4">{{ $gift->title }}</p>

                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-emerald-600 dark:text-emerald-400 font-bold">
                                R$ {{ number_format($gift->value, 2, ',', '.') }}
                            </p>
                            @if($gift->quantity > 1)
                                <span class="text-xs text-gray-400 dark:text-slate-500 border-l border-gray-200 dark:border-slate-600 pl-2">
                                    {{ $gift->quantity_paid }} / {{ $gift->quantity }} pagos
                                </span>
                            @endif
                        </div>

                        @if ($gift->description)
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 line-clamp-1">
                                {{ $gift->description }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Ações --}}
                <div class="flex items-center gap-1 mt-4 sm:mt-0 sm:ml-4 self-end sm:self-center opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                    <a
                        href="{{ route('presentes.edit', $gift) }}"
                        class="p-2 text-gray-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition"
                        title="Editar"
                    >
                        <i data-lucide="pencil" class="w-5 h-5"></i>
                    </a>

                    <form
                        method="POST"
                        action="{{ route('presentes.destroy', $gift) }}"
                        onsubmit="return confirm('Tem certeza que quer apagar este presente?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="p-2 text-gray-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition"
                            title="Deletar"
                        >
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="flex flex-col items-center justify-center p-12 text-center bg-gray-50 dark:bg-slate-800/50 border border-dashed border-gray-300 dark:border-slate-700 rounded-2xl">
                <div class="w-12 h-12 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center text-gray-400 dark:text-slate-500 mb-3">
                    <i data-lucide="gift" class="w-6 h-6"></i>
                </div>
                <p class="text-gray-900 dark:text-white font-medium">Sua lista está vazia.</p>
                <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Adicione presentes ou use as sugestões acima.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal de novo presente --}}
    @include('presentes-modal-novo')

</x-admin-layout>

{{-- SCRIPTS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal      = document.getElementById('modalNovoPresente');
        if (!modal) return;

        const form       = modal.querySelector('form');
        const inputTitle = modal.querySelector('#npTitulo');
        const inputValor = modal.querySelector('#npValor');
        const inputQtd   = modal.querySelector('#npQtd');
        const inputDesc  = modal.querySelector('#npDesc');
        const inputImg   = modal.querySelector('input[name="image"]');

        // Botão "Novo presente" → limpa o form
        document.getElementById('btnAbrirModalNovoPresente')?.addEventListener('click', () => {
            form.reset();
            if (inputTitle) inputTitle.value = '';
            if (inputValor) inputValor.value = '';
            if (inputDesc)  inputDesc.value  = '';
            if (inputQtd)   inputQtd.value   = 1;
            if (inputImg)   inputImg.value   = null;

            modal.showModal();
        });

        // Clique em template → preenche campos do formulário
        document.getElementById('areaTemplates')?.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-template');
            if (!btn) return;

            if (inputTitle) inputTitle.value = btn.dataset.titulo || '';
            if (inputValor) inputValor.value = btn.dataset.valor || '';
            if (inputDesc)  inputDesc.value  = btn.dataset.desc || '';
            if (inputQtd)   inputQtd.value   = 1;
            if (inputImg)   inputImg.value   = null;

            modal.showModal();
        });

        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
