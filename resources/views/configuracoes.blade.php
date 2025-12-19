<x-admin-layout title="Configurações">
    {{-- Cabeçalho --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                Configurações da Lista
            </h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Gerencie os detalhes, aparência e funcionalidades do seu evento.</p>
        </div>
    </div>

    {{-- Alerta de Sucesso --}}
    @if (session('status') === 'list-updated')
        <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-400 rounded-r-lg shadow-sm flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 mt-0.5 text-emerald-600 dark:text-emerald-400"></i>
            <div>
                <span class="font-bold block">Sucesso!</span>
                <span class="text-sm">Suas alterações foram salvas. {{ session('success') }}</span>
            </div>
            <button @click="show = false" class="ml-auto text-emerald-600 dark:text-emerald-400 hover:text-emerald-800"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    {{-- Lógica de Erros para Abas --}}
    @php
        $tabWithError = 'tab-detalhes';
        if ($errors->has('pix_key') || $errors->has('meta_goal') || $errors->has('cover_photo')) {
            $tabWithError = 'tab-aparencia';
        }
        if ($errors->has('rsvp_enabled') || $errors->has('gallery_enabled')) {
            $tabWithError = 'tab-funcionalidades';
        }
    @endphp

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">

        <form method="POST" action="{{ route('list.config.update') }}" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- Navegação de Abas --}}
            <div class="border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 px-4 md:px-8">
                <nav class="-mb-px flex space-x-6 overflow-x-auto no-scrollbar" id="config-tabs">
                    <button type="button" data-tab="tab-detalhes"
                        class="tab-link group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm gap-2 whitespace-nowrap transition-all duration-200 {{ $tabWithError === 'tab-detalhes' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Detalhes do Evento
                    </button>
                    <button type="button" data-tab="tab-aparencia"
                        class="tab-link group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm gap-2 whitespace-nowrap transition-all duration-200 {{ $tabWithError === 'tab-aparencia' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                        <i data-lucide="palette" class="w-4 h-4"></i>
                        Aparência & Financeiro
                    </button>
                    <button type="button" data-tab="tab-funcionalidades"
                        class="tab-link group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm gap-2 whitespace-nowrap transition-all duration-200 {{ $tabWithError === 'tab-funcionalidades' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 hover:border-gray-300 dark:hover:border-slate-600' }}">
                        <i data-lucide="settings-2" class="w-4 h-4"></i>
                        Funcionalidades
                    </button>
                </nav>
            </div>

            {{-- Conteúdo das Abas --}}
            <div class="p-6 md:p-8 min-h-[400px]">

                {{-- ABA 1: DETALHES --}}
                <div id="tab-detalhes" class="config-tab-content space-y-6 {{ $tabWithError === 'tab-detalhes' ? 'active' : '' }}">
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Nome --}}
                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nome do Evento</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="type" class="h-5 w-5 text-gray-400"></i>
                                </div>
                                <input type="text" name="display_name" value="{{ old('display_name', $list->display_name) }}"
                                    class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition sm:text-sm py-3"
                                    placeholder="Ex: Casamento de João e Maria" required>
                            </div>
                            <x-input-error :messages="$errors->get('display_name')" class="mt-1" />
                        </div>

                        {{-- História --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nossa História / Boas-vindas</label>
                            <textarea name="story" rows="4" maxlength="2000"
                                class="block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition sm:text-sm p-3"
                                placeholder="Conte um pouco sobre vocês ou deixe uma mensagem de boas-vindas para os convidados...">{{ old('story', $list->story) }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-slate-500 mt-1 text-right">Máximo 2000 caracteres</p>
                        </div>

                        {{-- Grid Data e Local --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Data --}}
                            <div class="bg-blue-50/50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                                <label class="block text-sm font-bold text-blue-900 dark:text-blue-300 mb-1">Data do Evento</label>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mb-3 flex items-center gap-1">
                                    <i data-lucide="info" class="w-3 h-3"></i> Notificaremos convidados se mudar.
                                </p>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="calendar" class="h-5 w-5 text-blue-400 dark:text-blue-500"></i>
                                    </div>
                                    <input type="date" name="event_date" value="{{ old('event_date', $list->event_date ? $list->event_date->format('Y-m-d') : '') }}"
                                        min="{{ now()->format('Y-m-d') }}"
                                        class="pl-10 block w-full rounded-lg border-blue-200 dark:border-blue-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                                </div>
                            </div>

                            {{-- Local --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Local</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="map-pin" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text" name="event_location" value="{{ old('event_location', $list->event_location) }}"
                                        class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition sm:text-sm py-3"
                                        placeholder="Cidade, Estado ou Nome do Buffet">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ABA 2: APARÊNCIA (COM BOTÃO DE MODO ESCURO) --}}
                <div id="tab-aparencia" class="config-tab-content space-y-8 {{ $tabWithError === 'tab-aparencia' ? 'active' : '' }}">

                    {{-- [NOVO] SELETOR DE TEMA --}}
                    <div class="bg-gray-50 dark:bg-slate-900/50 p-5 rounded-xl border border-gray-200 dark:border-slate-700"
                         x-data="{
                            theme: localStorage.theme || 'system',
                            setTheme(val) {
                                this.theme = val;
                                if (val === 'dark') {
                                    document.documentElement.classList.add('dark');
                                    localStorage.theme = 'dark';
                                } else if (val === 'light') {
                                    document.documentElement.classList.remove('dark');
                                    localStorage.theme = 'light';
                                } else {
                                    localStorage.removeItem('theme');
                                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                        document.documentElement.classList.add('dark');
                                    } else {
                                        document.documentElement.classList.remove('dark');
                                    }
                                }
                            }
                         }">
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">Tema do Painel</label>

                        <div class="grid grid-cols-3 gap-3 max-w-md">
                            <button type="button" @click="setTheme('light')"
                                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border transition-all duration-200"
                                :class="theme === 'light'
                                    ? 'bg-white border-emerald-500 text-emerald-600 shadow-sm ring-1 ring-emerald-500 dark:bg-slate-800 dark:border-emerald-500 dark:text-emerald-400'
                                    : 'bg-white border-gray-200 text-gray-500 hover:bg-gray-50 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700'">
                                <i data-lucide="sun" class="w-5 h-5"></i>
                                <span class="text-sm font-bold">Claro</span>
                            </button>

                            <button type="button" @click="setTheme('dark')"
                                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border transition-all duration-200"
                                :class="theme === 'dark'
                                    ? 'bg-slate-800 border-indigo-500 text-indigo-400 shadow-sm ring-1 ring-indigo-500 dark:bg-slate-900 dark:text-indigo-400'
                                    : 'bg-white border-gray-200 text-gray-500 hover:bg-gray-50 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700'">
                                <i data-lucide="moon" class="w-5 h-5"></i>
                                <span class="text-sm font-bold">Escuro</span>
                            </button>

                            <button type="button" @click="setTheme('system')"
                                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border transition-all duration-200"
                                :class="theme === 'system'
                                    ? 'bg-gray-100 border-gray-400 text-gray-900 shadow-inner dark:bg-slate-700 dark:text-white'
                                    : 'bg-white border-gray-200 text-gray-500 hover:bg-gray-50 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700'">
                                <i data-lucide="monitor" class="w-5 h-5"></i>
                                <span class="text-sm font-bold">Auto</span>
                            </button>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-slate-700">

                    {{-- Grid PIX e Meta --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- PIX --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Chave PIX (Para receber os presentes)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="qr-code" class="h-5 w-5 text-emerald-500 group-focus-within:text-emerald-600"></i>
                                </div>
                                <input type="text" name="pix_key" value="{{ old('pix_key', $list->pix_key) }}"
                                    class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition sm:text-sm py-3 font-mono"
                                    placeholder="CPF, E-mail, Telefone..." required>
                            </div>
                            <x-input-error :messages="$errors->get('pix_key')" class="mt-1" />
                            <div class="mt-2 text-xs text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 p-2 rounded border border-amber-100 dark:border-amber-800 flex items-start gap-1">
                                <i data-lucide="alert-triangle" class="w-3 h-3 mt-0.5 shrink-0"></i>
                                <span>O dinheiro cai direto na sua conta bancária. Verifique a chave!</span>
                            </div>
                        </div>

                        {{-- Meta --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Meta de Arrecadação (Opcional)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold sm:text-sm">R$</span>
                                </div>
                                <input type="number" name="meta_goal" step="0.01" value="{{ old('meta_goal', $list->meta_goal) }}"
                                    class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition sm:text-sm py-3"
                                    placeholder="0,00">
                            </div>
                            <p class="text-xs text-gray-500 dark:text-slate-500 mt-1">Exibiremos uma barra de progresso no site se preenchido.</p>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-slate-700">

                    {{-- Foto de Capa --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-3">Foto de Capa do Site</label>
                        <div class="flex items-center gap-6">
                            {{-- Preview --}}
                            <div class="relative w-32 h-32 rounded-2xl overflow-hidden border-2 border-gray-100 dark:border-slate-600 shadow-sm group bg-gray-50 dark:bg-slate-700">
                                @if ($list->cover_photo_url)
                                    <img src="{{ Storage::url($list->cover_photo_url) }}" class="w-full h-full object-cover transition group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500">
                                        <i data-lucide="image" class="w-8 h-8 mb-1"></i>
                                        <span class="text-[10px]">Sem foto</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Input --}}
                            <div class="flex-1">
                                <input type="file" name="cover_photo" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 dark:file:bg-emerald-900 file:text-emerald-700 dark:file:text-emerald-300 hover:file:bg-emerald-100 dark:hover:file:bg-emerald-800 cursor-pointer transition">
                                <p class="text-xs text-gray-400 dark:text-slate-500 mt-2">Recomendado: JPG ou PNG. Max 2MB.</p>
                                <x-input-error :messages="$errors->get('cover_photo')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ABA 3: FUNCIONALIDADES --}}
                <div id="tab-funcionalidades" class="config-tab-content space-y-6 {{ $tabWithError === 'tab-funcionalidades' ? 'active' : '' }}">

                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">Ative ou desative recursos do seu site conforme a necessidade.</p>

                    <div class="space-y-4">
                        {{-- 1. RSVP --}}
                        <div class="relative flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-600 transition duration-300">
                            <div class="flex gap-4">
                                <div class="bg-purple-100 dark:bg-purple-900/30 p-2.5 rounded-lg h-fit text-purple-600 dark:text-purple-400">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <label for="rsvp_enabled" class="font-bold text-gray-900 dark:text-white block cursor-pointer">Confirmação de Presença (RSVP)</label>
                                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Exibe um formulário para os convidados confirmarem presença.</p>
                                </div>
                            </div>
                            <div class="flex items-center h-6">
                                <input type="checkbox" id="rsvp_enabled" name="rsvp_enabled" value="1" class="peer sr-only" @checked(old('rsvp_enabled', $list->rsvp_enabled))>
                                <label for="rsvp_enabled" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-slate-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-emerald-500 peer-checked:bg-emerald-600 cursor-pointer">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform peer-checked:translate-x-6 translate-x-1"></span>
                                </label>
                            </div>
                        </div>

                        {{-- 2. Galeria --}}
                        <div class="relative flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:border-blue-300 dark:hover:border-blue-600 transition duration-300">
                            <div class="flex gap-4">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-2.5 rounded-lg h-fit text-blue-600 dark:text-blue-400">
                                    <i data-lucide="camera" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <label for="gallery_toggle" class="font-bold text-gray-900 dark:text-white block cursor-pointer">Galeria de Fotos (Mural)</label>
                                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Permite que convidados enviem fotos para um mural público.</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 font-medium"><i data-lucide="sparkles" class="w-3 h-3 inline"></i> Ideal para o dia da festa!</p>
                                </div>
                            </div>
                            <div class="flex items-center h-6">
                                <input type="checkbox" id="gallery_toggle" name="gallery_enabled" value="1" class="peer sr-only" @checked(old('gallery_enabled', $list->gallery_enabled))>
                                <label for="gallery_toggle" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-slate-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-blue-500 peer-checked:bg-blue-600 cursor-pointer">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform peer-checked:translate-x-6 translate-x-1"></span>
                                </label>
                            </div>
                        </div>

                        {{-- 3. Moderação --}}
                        <div id="moderation-container" class="relative flex items-center justify-between p-5 bg-gray-50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-700 transition-all duration-300">
                            <div class="flex gap-4">
                                <div class="bg-gray-200 dark:bg-slate-700 p-2.5 rounded-lg h-fit text-gray-600 dark:text-slate-300">
                                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <label for="moderation_toggle" class="font-bold text-gray-900 dark:text-white block cursor-pointer">Moderação de Fotos</label>
                                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Fotos enviadas precisam da sua aprovação antes de aparecer.</p>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium hidden" id="moderation-off-msg">Sem moderação: Fotos aparecem instantaneamente.</p>
                                </div>
                            </div>
                            <div class="flex items-center h-6">
                                <input type="checkbox" id="moderation_toggle" name="moderation_enabled" value="1" class="peer sr-only" @checked(old('moderation_enabled', $list->moderation_enabled))>
                                <label for="moderation_toggle" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-slate-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-gray-500 peer-checked:bg-gray-800 dark:peer-checked:bg-slate-500 cursor-pointer">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform peer-checked:translate-x-6 translate-x-1"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer com Botão --}}
            <div class="bg-gray-50 dark:bg-slate-800/80 px-6 py-5 border-t border-gray-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs text-gray-400 hidden sm:block">Alterações são salvas imediatamente no site público.</span>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 dark:shadow-none hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>

    {{-- Estilos e Scripts --}}
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .config-tab-content { display: none; }
        .config-tab-content.active { display: block; animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa Ícones
            if (window.lucide) window.lucide.createIcons();

            // Lógica de Abas
            const tabLinks = document.querySelectorAll('#config-tabs .tab-link');
            const tabContents = document.querySelectorAll('.config-tab-content');

            function activateTab(targetId) {
                // Remove estado ativo de todos
                tabLinks.forEach(l => {
                    l.classList.remove('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
                    l.classList.add('border-transparent', 'text-gray-500', 'dark:text-slate-400');
                });
                tabContents.forEach(c => c.classList.remove('active'));

                // Ativa o alvo
                const link = Array.from(tabLinks).find(l => l.dataset.tab === targetId);
                const content = document.getElementById(targetId);

                if (link && content) {
                    link.classList.remove('border-transparent', 'text-gray-500', 'dark:text-slate-400');
                    link.classList.add('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
                    content.classList.add('active');
                }
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    activateTab(link.dataset.tab);
                });
            });

            // Lógica de Dependência (Galeria -> Moderação)
            const galleryToggle = document.getElementById('gallery_toggle');
            const moderationToggle = document.getElementById('moderation_toggle');
            const moderationContainer = document.getElementById('moderation-container');
            const msgOff = document.getElementById('moderation-off-msg');

            function toggleModerationState() {
                if (galleryToggle.checked) {
                    moderationToggle.disabled = false;
                    moderationContainer.classList.remove('opacity-50', 'pointer-events-none', 'grayscale');
                    moderationContainer.classList.add('bg-white', 'dark:bg-slate-800');
                    moderationContainer.classList.remove('bg-gray-50', 'dark:bg-slate-900');
                } else {
                    moderationToggle.disabled = true;
                    moderationContainer.classList.add('opacity-50', 'pointer-events-none', 'grayscale');
                    moderationContainer.classList.remove('bg-white', 'dark:bg-slate-800');
                    moderationContainer.classList.add('bg-gray-50', 'dark:bg-slate-900');
                }
            }

            if(galleryToggle && moderationToggle) {
                toggleModerationState();
                galleryToggle.addEventListener('change', toggleModerationState);
            }
        });
    </script>
</x-admin-layout>
