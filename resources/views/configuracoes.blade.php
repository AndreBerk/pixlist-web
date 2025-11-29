<x-admin-layout>

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Configurações da Lista
    </h2>

    @if (session('status') === 'list-updated')
        <div class="mb-4 p-4 text-sm font-medium text-green-800 bg-green-100 rounded-lg">
            Configurações salvas com sucesso!
        </div>
    @endif

    @php
        // qual aba deve iniciar aberta (se tiver erro de validação)
        $tabWithError = 'tab-detalhes';

        if ($errors->has('pix_key') || $errors->has('meta_goal') || $errors->has('cover_photo')) {
            $tabWithError = 'tab-aparencia';
        }

        // se um dia tiver mais campos em funcionalidades, já fica preparado
        if ($errors->has('rsvp_enabled')) {
            $tabWithError = 'tab-funcionalidades';
        }
    @endphp

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 max-w-3xl">

        <form method="POST" action="{{ route('list.config.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- TABS HEADER --}}
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex gap-6" id="config-tabs">
                    <button
                        type="button"
                        data-tab="tab-detalhes"
                        class="tab-link shrink-0 border-b-2 px-1 py-4 text-sm font-medium
                               {{ $tabWithError === 'tab-detalhes'
                                    ? 'active border-emerald-500 text-emerald-600'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                    >
                        Detalhes do Evento
                    </button>

                    <button
                        type="button"
                        data-tab="tab-aparencia"
                        class="tab-link shrink-0 border-b-2 px-1 py-4 text-sm font-medium
                               {{ $tabWithError === 'tab-aparencia'
                                    ? 'active border-emerald-500 text-emerald-600'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                    >
                        Aparência e PIX
                    </button>

                    <button
                        type="button"
                        data-tab="tab-funcionalidades"
                        class="tab-link shrink-0 border-b-2 px-1 py-4 text-sm font-medium
                               {{ $tabWithError === 'tab-funcionalidades'
                                    ? 'active border-emerald-500 text-emerald-600'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                    >
                        Funcionalidades
                    </button>
                </nav>
            </div>

            {{-- TABS CONTENT --}}
            <div class="p-6 md:p-8">

                {{-- ABA 1: DETALHES --}}
                <div
                    id="tab-detalhes"
                    class="config-tab-content space-y-5 {{ $tabWithError === 'tab-detalhes' ? 'active' : '' }}"
                >
                    <div>
                        <label for="config-historia" class="block text-sm font-medium text-gray-700">
                            Nossa história
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Um texto curto apresentando vocês. Ele aparece no topo da página da lista.
                        </p>
                        <textarea
                            id="config-historia"
                            name="story"
                            rows="5"
                            maxlength="1000"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                   focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Conte um pouco sobre vocês, o momento atual e o que esse evento significa..."
                        >{{ old('story', $list->story) }}</textarea>
                        <x-input-error :messages="$errors->get('story')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="config-local" class="block text-sm font-medium text-gray-700">
                            Local do evento
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Ex.: buffet, salão, chácara ou cidade/UF. Será exibido na página pública.
                        </p>
                        <input
                            type="text"
                            id="config-local"
                            name="event_location"
                            value="{{ old('event_location', $list->event_location) }}"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                   focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Buffet, cidade, UF"
                        >
                        <x-input-error :messages="$errors->get('event_location')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                {{-- ABA 2: APARÊNCIA E PIX --}}
                <div
                    id="tab-aparencia"
                    class="config-tab-content space-y-5 {{ $tabWithError === 'tab-aparencia' ? 'active' : '' }}"
                >
                    <div>
                        <label for="config-pix" class="block text-sm font-medium text-gray-700">
                            Sua chave PIX
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Essa é a chave que aparecerá para os convidados ao presentear. O PIX cai direto na sua conta.
                        </p>
                        <input
                            type="text"
                            id="config-pix"
                            name="pix_key"
                            value="{{ old('pix_key', $list->pix_key) }}"
                            class="mt-2 block w-full px-4 py-3 border rounded-lg shadow-sm
                                   focus:outline-none focus:ring-emerald-500 focus:border-emerald-500
                                   {{ $errors->has('pix_key') ? 'border-red-300' : 'border-gray-300' }}"
                            placeholder="sua-chave@provedor.com"
                            required
                        >
                        <x-input-error :messages="$errors->get('pix_key')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="meta" class="block text-sm font-medium text-gray-700">
                            Meta de arrecadação (R$)
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Opcional. Usamos apenas para mostrar o progresso da sua meta no painel.
                        </p>
                        <input
                            type="number"
                            id="meta"
                            name="meta_goal"
                            min="0"
                            step="0.01"
                            value="{{ old('meta_goal', $list->meta_goal) }}"
                            class="mt-2 block w-full px-4 py-3 border rounded-lg shadow-sm
                                   focus:outline-none focus:ring-emerald-500 focus:border-emerald-500
                                   {{ $errors->has('meta_goal') ? 'border-red-300' : 'border-gray-300' }}"
                            placeholder="15000"
                        >
                        <x-input-error :messages="$errors->get('meta_goal')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Foto de capa
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Essa imagem aparece no topo da sua lista pública. Dê preferência a uma foto horizontal.
                        </p>

                        <div class="mt-3 flex items-center gap-4">
                            @if ($list->cover_photo_url)
                                <img
                                    src="{{ Storage::url($list->cover_photo_url) }}"
                                    alt="Foto de capa atual"
                                    class="w-20 h-20 rounded-full object-cover"
                                >
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i data-lucide="image" class="w-10 h-10"></i>
                                </div>
                            @endif

                            <input
                                type="file"
                                id="cover_photo"
                                name="cover_photo"
                                accept="image/*"
                                class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-emerald-50 file:text-emerald-700
                                       hover:file:bg-emerald-100"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('cover_photo')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                {{-- ABA 3: FUNCIONALIDADES --}}
                <div
                    id="tab-funcionalidades"
                    class="config-tab-content space-y-5 {{ $tabWithError === 'tab-funcionalidades' ? 'active' : '' }}"
                >
                    <div>
                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="pr-4">
                                <span class="block text-sm font-medium text-gray-700">
                                    Ativar confirmação de presença (RSVP)
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Exibe o formulário de RSVP na página pública para os convidados confirmarem presença.
                                </span>
                            </div>

                            {{-- padrão Laravel para boolean --}}
                            <div class="flex items-center">
                                <input type="hidden" name="rsvp_enabled" value="0">
                                <input
                                    type="checkbox"
                                    name="rsvp_enabled"
                                    value="1"
                                    class="relative w-11 h-6 bg-gray-200 rounded-full cursor-pointer transition-colors duration-200 ease-in-out
                                           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2
                                           checked:bg-emerald-600
                                           peer"
                                    @checked(old('rsvp_enabled', $list->rsvp_enabled))
                                >
                                {{-- bolinha do toggle usando peer --}}
                                <span
                                    class="pointer-events-none -ml-7 inline-block w-4 h-4 bg-white rounded-full shadow-md
                                           transform translate-x-1 transition-transform duration-200 ease-in-out
                                           peer-checked:translate-x-6"
                                ></span>
                            </div>
                        </label>
                        <x-input-error :messages="$errors->get('rsvp_enabled')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

            </div>{{-- /p-6 md:p-8 --}}

            <div class="p-6 bg-gray-50 rounded-b-xl border-t border-gray-200 flex justify-end">
                <button
                    type="submit"
                    class="w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow-md
                           hover:bg-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                >
                    Salvar alterações
                </button>
            </div>

        </form>
    </div>

    <style>
        .config-tab-content { display: none; }
        .config-tab-content.active { display: block; animation: pop .2s ease; }

        .tab-link.active {
            border-color: #059669; /* emerald-500 */
            color: #047857;        /* emerald-600 */
            font-weight: 600;
        }

        @keyframes pop {
            from { opacity: 0; transform: translateY(4px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks    = document.querySelectorAll('#config-tabs .tab-link');
            const tabContents = document.querySelectorAll('.config-tab-content');

            function activateTab(targetId) {
                tabLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                const link = Array.from(tabLinks).find(l => l.dataset.tab === targetId);
                const content = document.getElementById(targetId);

                if (link && content) {
                    link.classList.add('active');
                    content.classList.add('active');
                }

                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', () => {
                    activateTab(link.dataset.tab);
                });
            });

            // garante que os ícones sejam renderizados na aba inicial
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</x-admin-layout>
