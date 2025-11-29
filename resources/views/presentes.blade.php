<x-admin-layout>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Gerenciar Presentes</h2>
        <button
            id="btnAbrirModalNovoPresente"
            class="px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition inline-flex items-center gap-2"
        >
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Novo presente</span>
        </button>
    </div>

    {{-- Alerts de status --}}
    @if (session('status') === 'presente-criado')
        <div class="mb-4 p-4 text-sm font-medium text-green-800 bg-green-100 rounded-lg">
            Presente adicionado com sucesso!
        </div>
    @endif
    @if (session('status') === 'presente-deletado')
        <div class="mb-4 p-4 text-sm font-medium text-red-800 bg-red-100 rounded-lg">
            Presente removido com sucesso.
        </div>
    @endif
    @if (session('status') === 'presente-atualizado')
        <div class="mb-4 p-4 text-sm font-medium text-blue-800 bg-blue-100 rounded-lg">
            Presente atualizado com sucesso.
        </div>
    @endif

    {{-- Templates sugeridos --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <p class="text-base md:text-lg font-semibold mb-3">
            Templates sugeridos (baseado no estilo:
            <span class="font-bold text-emerald-700">{{ $list->style }}</span>)
        </p>

        <div id="areaTemplates" class="flex flex-wrap gap-2">
            @foreach ($templatesSugeridos as $template)
                <button
                    type="button"
                    class="btn-template px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium hover:bg-emerald-200"
                    data-titulo="{{ $template['title'] }}"
                    data-valor="{{ $template['value'] }}"
                    data-desc="{{ $template['desc'] ?? '' }}"
                >
                    + {{ $template['title'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Lista de presentes cadastrados --}}
    <h3 class="text-xl font-extrabold text-gray-800 mb-3">Meus presentes</h3>

    <div id="listaAdminPresentes" class="space-y-3">
        @forelse ($gifts as $gift)
            @php
                // Caso ainda existam registros antigos com "ícone" no image_url,
                // tratamos como "sem imagem" e mostramos apenas o placeholder.
                $hasUpload = $gift->image_url && \Illuminate\Support\Str::contains($gift->image_url, '/');
            @endphp

            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-gray-200 shadow-sm">

                <div class="flex items-start gap-4">
                    {{-- Miniatura da imagem do presente --}}
                    <div class="w-16 h-16 rounded-lg border bg-gray-100 overflow-hidden flex items-center justify-center text-gray-400 flex-shrink-0">
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
                    <div>
                        <p class="font-bold text-gray-800">{{ $gift->title }}</p>
                        <p class="text-emerald-600 font-semibold">
                            R$ {{ number_format($gift->value, 2, ',', '.') }}
                            <span class="text-xs text-gray-500 font-normal ml-1">
                                • pagos: {{ $gift->quantity_paid }}/{{ $gift->quantity }}
                            </span>
                        </p>
                        @if ($gift->description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ $gift->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a
                        href="{{ route('presentes.edit', $gift) }}"
                        class="text-gray-600 hover:text-blue-700"
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
                            class="text-gray-600 hover:text-red-700"
                            title="Deletar"
                        >
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="p-4 text-gray-500 bg-gray-100 rounded-lg">
                Nenhum presente adicionado ainda.
            </div>
        @endforelse
    </div>

    {{-- Modal de novo presente --}}
    @include('presentes-modal-novo')

</x-admin-layout>

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
