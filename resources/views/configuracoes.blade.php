<x-admin-layout title="Configurações">

    {{-- Estilos para esconder barra de rolagem e animações --}}
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .config-tab-content { display: none; }
        .config-tab-content.active { display: block; animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    {{-- Container com margem extra no fundo --}}
    <div class="pb-24">

        {{-- Cabeçalho --}}
        <div class="mb-6 flex flex-col gap-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                Configurações da Lista
            </h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm">Gerencie os detalhes, aparência e funcionalidades.</p>
        </div>

        {{-- Alerta de Sucesso --}}
        @if (session('status') === 'list-updated')
            <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-400 rounded-r-lg shadow-sm flex items-start gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 mt-0.5 text-emerald-600 dark:text-emerald-400"></i>
                <div>
                    <span class="font-bold block text-sm">Sucesso!</span>
                    <span class="text-xs md:text-sm">Suas alterações foram salvas.</span>
                </div>
                <button @click="show = false" class="ml-auto"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        {{-- Lógica PHP para marcar aba com erro --}}
        @php
            $tabWithError = 'tab-detalhes';
            if ($errors->has('pix_key') || $errors->has('meta_goal') || $errors->has('cover_photo')) {
                $tabWithError = 'tab-aparencia';
            }
            if ($errors->has('rsvp_enabled') || $errors->has('gallery_enabled')) {
                $tabWithError = 'tab-funcionalidades';
            }
        @endphp

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

            <form method="POST" action="{{ route('list.config.update') }}" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- NAVEGAÇÃO DE ABAS --}}
                <div class="border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                    <nav class="-mb-px flex overflow-x-auto no-scrollbar" id="config-tabs">
                        <button type="button" data-tab="tab-detalhes"
                            class="tab-link flex-1 min-w-[110px] py-4 px-4 text-center border-b-2 font-medium text-sm transition-colors duration-200 whitespace-nowrap
                            {{ $tabWithError === 'tab-detalhes' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50/50 dark:bg-emerald-900/10' : 'border-transparent text-gray-500 dark:text-slate-400' }}">
                            Detalhes
                        </button>
                        <button type="button" data-tab="tab-aparencia"
                            class="tab-link flex-1 min-w-[110px] py-4 px-4 text-center border-b-2 font-medium text-sm transition-colors duration-200 whitespace-nowrap
                            {{ $tabWithError === 'tab-aparencia' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50/50 dark:bg-emerald-900/10' : 'border-transparent text-gray-500 dark:text-slate-400' }}">
                            Aparência
                        </button>
                        <button type="button" data-tab="tab-funcionalidades"
                            class="tab-link flex-1 min-w-[110px] py-4 px-4 text-center border-b-2 font-medium text-sm transition-colors duration-200 whitespace-nowrap
                            {{ $tabWithError === 'tab-funcionalidades' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50/50 dark:bg-emerald-900/10' : 'border-transparent text-gray-500 dark:text-slate-400' }}">
                            Funcionalidades
                        </button>
                    </nav>
                </div>

                {{-- CONTEÚDO --}}
                <div class="p-5 md:p-8">

                    {{-- ABA 1: DETALHES --}}
                    <div id="tab-detalhes" class="config-tab-content space-y-6 {{ $tabWithError === 'tab-detalhes' ? 'active' : '' }}">

                        {{-- Nome --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nome do Evento</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="type" class="h-5 w-5"></i>
                                </div>
                                <input type="text" name="display_name" value="{{ old('display_name', $list->display_name) }}"
                                    class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-base md:text-sm py-3"
                                    placeholder="Ex: Casamento de João e Maria" required>
                            </div>
                            <x-input-error :messages="$errors->get('display_name')" class="mt-1" />
                        </div>

                        {{-- História --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nossa História / Boas-vindas</label>
                            <textarea name="story" rows="5" maxlength="2000"
                                class="block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-base md:text-sm p-3"
                                placeholder="Conte um pouco sobre vocês ou deixe uma mensagem...">{{ old('story', $list->story) }}</textarea>
                             <p class="text-xs text-gray-400 mt-1 text-right">Máximo 2000 caracteres</p>
                        </div>

                        {{-- Data e Local --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Data --}}
                            <div class="bg-blue-50/50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                                <label class="block text-sm font-bold text-blue-900 dark:text-blue-300 mb-1">Data do Evento</label>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mb-3 flex items-center gap-1">
                                    <i data-lucide="info" class="w-3 h-3"></i> Notificaremos convidados se mudar.
                                </p>
                                <div class="relative">
                                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-blue-400">
                                        <i data-lucide="calendar" class="h-5 w-5"></i>
                                    </div>
                                    <input type="date" name="event_date" value="{{ old('event_date', $list->event_date ? $list->event_date->format('Y-m-d') : '') }}"
                                        class="pl-10 block w-full rounded-lg border-blue-200 dark:border-blue-700 dark:bg-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base md:text-sm py-2.5">
                                </div>
                            </div>

                            {{-- Local --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Local</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i data-lucide="map-pin" class="h-5 w-5"></i>
                                    </div>
                                    <input type="text" name="event_location" value="{{ old('event_location', $list->event_location) }}"
                                        class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-base md:text-sm py-3"
                                        placeholder="Cidade ou Buffet">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ABA 2: APARÊNCIA --}}
                    <div id="tab-aparencia" class="config-tab-content space-y-8 {{ $tabWithError === 'tab-aparencia' ? 'active' : '' }}">

                        {{-- SELETOR DE TEMA --}}
                        <div class="bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl border border-gray-200 dark:border-slate-700">
                            <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">Tema do Painel</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <button type="button" onclick="setTheme('light')" id="btn-light"
                                    class="theme-btn group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all duration-200 active:scale-95 hover:-translate-y-0.5">
                                    <i data-lucide="sun" class="w-5 h-5 transition-transform group-hover:rotate-12"></i>
                                    <span class="text-sm font-bold">Claro</span>
                                </button>

                                <button type="button" onclick="setTheme('dark')" id="btn-dark"
                                    class="theme-btn group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all duration-200 active:scale-95 hover:-translate-y-0.5">
                                    <i data-lucide="moon" class="w-5 h-5 transition-transform group-hover:-rotate-12"></i>
                                    <span class="text-sm font-bold">Escuro</span>
                                </button>

                                <button type="button" onclick="setTheme('system')" id="btn-system"
                                    class="theme-btn group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all duration-200 active:scale-95 hover:-translate-y-0.5">
                                    <i data-lucide="monitor" class="w-5 h-5"></i>
                                    <span class="text-sm font-bold">Auto</span>
                                </button>
                            </div>
                        </div>

                        <hr class="border-gray-100 dark:border-slate-700">

                        {{-- Pix e Meta --}}
                        <div class="space-y-6">
                            {{-- PIX --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Chave PIX (Para receber)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-500">
                                        <i data-lucide="qr-code" class="h-5 w-5"></i>
                                    </div>
                                    <input type="text" name="pix_key" value="{{ old('pix_key', $list->pix_key) }}"
                                        class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-base md:text-sm py-3 font-mono"
                                        placeholder="CPF, E-mail, Telefone..." required>
                                </div>
                                <div class="mt-2 text-xs text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 p-2.5 rounded-lg border border-amber-100 dark:border-amber-800 flex items-start gap-2">
                                    <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
                                    <span><strong>Atenção:</strong> O dinheiro cai direto na sua conta bancária. Verifique a chave!</span>
                                </div>
                            </div>

                            {{-- Meta --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Meta de Arrecadação (Opcional)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold text-sm">R$</span>
                                    </div>
                                    <input type="number" name="meta_goal" step="0.01" value="{{ old('meta_goal', $list->meta_goal) }}"
                                        class="pl-10 block w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-base md:text-sm py-3"
                                        placeholder="0,00">
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Exibiremos uma barra de progresso no site se preenchido.</p>
                            </div>
                        </div>

                        <hr class="border-gray-100 dark:border-slate-700">

                        {{-- Foto de Capa --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-3">Foto de Capa do Site</label>
                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                {{-- Preview --}}
                                <div class="relative w-full sm:w-32 h-40 sm:h-32 rounded-2xl overflow-hidden border-2 border-gray-100 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 shadow-sm">
                                    @if ($list->cover_photo_url)
                                        <img src="{{ Storage::url($list->cover_photo_url) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                            <i data-lucide="image" class="w-8 h-8 mb-1"></i>
                                            <span class="text-[10px]">Sem foto</span>
                                        </div>
                                    @endif
                                </div>
                                {{-- Input --}}
                                <div class="flex-1 w-full">
                                    <input type="file" name="cover_photo" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                     <p class="text-xs text-gray-400 mt-2">Recomendado: JPG ou PNG. Max 2MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ABA 3: FUNCIONALIDADES --}}
                    <div id="tab-funcionalidades" class="config-tab-content space-y-4 {{ $tabWithError === 'tab-funcionalidades' ? 'active' : '' }}">
                        <p class="text-sm text-gray-500 mb-4">Ative recursos extras conforme sua necessidade.</p>

                        {{-- RSVP --}}
                        <div class="flex items-start justify-between p-4 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                            <div class="flex gap-3">
                                <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg text-purple-600">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <label for="rsvp_enabled" class="font-bold text-gray-900 dark:text-white block">RSVP</label>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Exibe formulário de confirmação de presença.</p>
                                </div>
                            </div>
                            {{-- Toggle Deslizante --}}
                            <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer">
                                <input type="checkbox" id="rsvp_enabled" name="rsvp_enabled" value="1" class="peer sr-only" @checked(old('rsvp_enabled', $list->rsvp_enabled))>
                                <label for="rsvp_enabled" class="h-6 w-11 cursor-pointer rounded-full bg-gray-200 dark:bg-slate-600 peer-checked:bg-emerald-600 transition-colors duration-300 relative">
                                    <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white transition-all duration-300 peer-checked:translate-x-5"></span>
                                </label>
                            </div>
                        </div>

                         {{-- Galeria (COM RECOMENDAÇÃO) --}}
                         <div class="flex items-start justify-between p-4 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                            <div class="flex gap-3 flex-1">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg text-blue-600 h-fit">
                                    <i data-lucide="camera" class="w-6 h-6"></i>
                                </div>
                                <div class="flex-1 pr-2">
                                    <label for="gallery_toggle" class="font-bold text-gray-900 dark:text-white block">Galeria</label>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-2">Mural de fotos público para convidados.</p>

                                    {{-- [NOVO] Alerta de Recomendação --}}
                                    <div class="text-xs bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 p-2 rounded-lg border border-blue-100 dark:border-blue-800 inline-flex items-center gap-2">
                                        <i data-lucide="sparkles" class="w-3 h-3"></i>
                                        <strong>Recomendamos ativar na data do casamento!</strong>
                                    </div>
                                </div>
                            </div>
                            {{-- Toggle Deslizante --}}
                            <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer">
                                <input type="checkbox" id="gallery_toggle" name="gallery_enabled" value="1" class="peer sr-only" @checked(old('gallery_enabled', $list->gallery_enabled))>
                                <label for="gallery_toggle" class="h-6 w-11 cursor-pointer rounded-full bg-gray-200 dark:bg-slate-600 peer-checked:bg-blue-600 transition-colors duration-300 relative">
                                    <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white transition-all duration-300 peer-checked:translate-x-5"></span>
                                </label>
                            </div>
                        </div>

                         {{-- Moderação --}}
                         <div id="moderation-container" class="flex items-start justify-between p-4 bg-gray-50 dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-700 transition-all">
                            <div class="flex gap-3">
                                <div class="bg-gray-200 dark:bg-slate-700 p-2 rounded-lg text-gray-600">
                                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <label for="moderation_toggle" class="font-bold text-gray-900 dark:text-white block">Moderação</label>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Aprovar fotos antes de exibir.</p>
                                </div>
                            </div>
                            {{-- Toggle Deslizante --}}
                            <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer">
                                <input type="checkbox" id="moderation_toggle" name="moderation_enabled" value="1" class="peer sr-only" @checked(old('moderation_enabled', $list->moderation_enabled))>
                                <label for="moderation_toggle" class="h-6 w-11 cursor-pointer rounded-full bg-gray-200 dark:bg-slate-600 peer-checked:bg-gray-800 transition-colors duration-300 relative">
                                    <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white transition-all duration-300 peer-checked:translate-x-5"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER / BOTÃO SALVAR (AGORA COM MARGEM mb-24) --}}
                <div class="mt-8 px-4 md:px-0 mb-24 md:mb-0">
                    <div class="flex md:justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 hover:shadow-emerald-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- SCRIPTS (JS PURO) --}}
    <script>
        const activeThemeClass = "bg-white border-emerald-500 text-emerald-600 shadow-md ring-1 ring-emerald-500 dark:bg-slate-800 dark:border-emerald-500 dark:text-emerald-400";
        const inactiveThemeClass = "bg-white border-gray-200 text-gray-500 hover:border-emerald-300 hover:text-emerald-600 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 dark:hover:border-slate-500";

        function setTheme(mode) {
            if (mode === 'system') localStorage.removeItem('theme');
            else localStorage.theme = mode;

            if (mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateButtons(mode);
        }

        function updateButtons(mode) {
            document.querySelectorAll('.theme-btn').forEach(btn => {
                btn.className = `theme-btn group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all duration-200 active:scale-95 hover:-translate-y-0.5 ${inactiveThemeClass}`;
            });
            const activeBtn = document.getElementById(`btn-${mode}`);
            if(activeBtn) {
                activeBtn.className = `theme-btn group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 transition-all duration-200 active:scale-95 ${activeThemeClass}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) window.lucide.createIcons();
            const currentTheme = localStorage.theme || 'system';
            updateButtons(currentTheme);

            const tabLinks = document.querySelectorAll('#config-tabs .tab-link');
            const tabContents = document.querySelectorAll('.config-tab-content');

            function activateTab(targetId) {
                tabLinks.forEach(l => {
                    l.classList.remove('border-emerald-500', 'text-emerald-600', 'bg-emerald-50/50', 'dark:text-emerald-400', 'dark:bg-emerald-900/10');
                    l.classList.add('border-transparent', 'text-gray-500', 'dark:text-slate-400');
                });
                tabContents.forEach(c => c.classList.remove('active'));

                const link = Array.from(tabLinks).find(l => l.dataset.tab === targetId);
                const content = document.getElementById(targetId);

                if (link && content) {
                    link.classList.remove('border-transparent', 'text-gray-500', 'dark:text-slate-400');
                    link.classList.add('border-emerald-500', 'text-emerald-600', 'bg-emerald-50/50', 'dark:text-emerald-400', 'dark:bg-emerald-900/10');
                    content.classList.add('active');
                }
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    activateTab(link.dataset.tab);
                });
            });

            const galleryToggle = document.getElementById('gallery_toggle');
            const moderationToggle = document.getElementById('moderation_toggle');
            const moderationContainer = document.getElementById('moderation-container');

            function toggleModerationState() {
                if (galleryToggle.checked) {
                    moderationToggle.disabled = false;
                    moderationContainer.classList.remove('opacity-50', 'grayscale');
                } else {
                    moderationToggle.disabled = true;
                    moderationContainer.classList.add('opacity-50', 'grayscale');
                }
            }
            if(galleryToggle && moderationToggle) {
                toggleModerationState();
                galleryToggle.addEventListener('change', toggleModerationState);
            }
        });
    </script>
</x-admin-layout>
