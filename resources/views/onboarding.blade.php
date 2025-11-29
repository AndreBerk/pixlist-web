<x-guest-layout>
    <form method="POST" action="{{ route('onboarding.store') }}" id="form-onboarding" class="min-h-screen flex flex-col">
        @csrf

        {{-- HEADER / STEPPER ======================================= --}}
        <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-gray-100">
            <div class="container mx-auto px-4 sm:px-6 max-w-3xl">
                <div class="py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="clipboard-list" class="w-5 h-5 text-emerald-700"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-800">Configurar minha lista</p>
                    </div>

                    {{-- indicador de passo --}}
                    <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-gray-600" id="step-label">
                        <span>Passo</span>
                        <span id="step-current" class="inline-block px-1.5 rounded bg-gray-100">1</span>
                        <span>de 4</span>
                    </div>
                </div>

                <div class="pb-4">
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-2 bg-emerald-600 w-[25%] transition-all"></div>
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTEÚDO =============================================== --}}
        <main class="flex-1">
            {{-- PASSO 1 ------------------------------------------------ --}}
            <section id="page-onboarding-1" class="onboarding-step active">
                <div class="container mx-auto px-4 sm:px-6 max-w-3xl">
                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-100 mt-6 sm:mt-10">
                        <p class="text-xs font-medium text-emerald-600 text-center">PASSO 1 DE 4</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 mt-2">
                            Qual é o seu evento?
                        </h2>
                        <p class="text-center text-gray-600 mt-1 text-sm">
                            Isso nos ajuda a sugerir os melhores modelos de lista pra você.
                        </p>

                        <input type="hidden" name="event_type" id="ob-tipo" required value="{{ old('event_type') }}">

                        <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-6 sm:mt-8" id="ob-evento-botoes">
                            @php
                                $eventos = [
                                    ['t' => 'Casamento',     'i' => 'heart',          'd' => 'Lista para a vida a dois'],
                                    ['t' => 'Aniversário',   'i' => 'party-popper',   'd' => 'Celebração com presentes'],
                                    ['t' => 'Chá de Panela', 'i' => 'package',        'd' => 'Enxoval e utensílios'],
                                    ['t' => 'Chá de Bebê',   'i' => 'baby',           'd' => 'Bem-vindo ao mundo!'],
                                ];
                            @endphp

                            @foreach ($eventos as $e)
                                <button type="button"
                                        data-tipo="{{ $e['t'] }}"
                                        class="ob-btn-etapa1 group flex flex-col items-center justify-center p-4 sm:p-6 bg-gray-50 rounded-xl border-2 border-transparent hover:border-emerald-500 hover:bg-emerald-50 transition focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <i data-lucide="{{ $e['i'] }}" class="w-8 h-8 sm:w-10 sm:h-10 text-emerald-600 mb-2 pointer-events-none"></i>
                                    <span class="font-semibold text-base sm:text-lg pointer-events-none">{{ $e['t'] }}</span>
                                    <span class="text-[11px] sm:text-xs text-gray-500 mt-1 pointer-events-none">{{ $e['d'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            {{-- PASSO 2 ------------------------------------------------ --}}
            <section id="page-onboarding-2" class="onboarding-step">
                <div class="container mx-auto px-4 sm:px-6 max-w-3xl">
                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-100 mt-6 sm:mt-10">
                        <p class="text-xs font-medium text-emerald-600 text-center">PASSO 2 DE 4</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 mt-2">
                            Qual nome devemos exibir?
                        </h2>
                        <p class="text-center text-gray-600 mt-1 mb-5 sm:mb-6 text-sm">
                            Ex.: “João e Maria” ou “Aniversário da Maria”.
                        </p>

                        <label for="ob-nome" class="sr-only">Nome de exibição da lista</label>
                        <input
                            type="text"
                            id="ob-nome"
                            name="display_name"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Nome de exibição da lista"
                            required
                            maxlength="80"
                            autocomplete="off"
                            value="{{ old('display_name') }}"
                        >

                        <div class="mt-6 flex items-center justify-between gap-2">
                            <button type="button" data-prev="page-onboarding-1"
                                    class="btn-back inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar
                            </button>

                            <button type="button" data-next="page-onboarding-3"
                                    class="ob-btn-next inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-md hover:bg-emerald-700">
                                Continuar <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PASSO 3 ------------------------------------------------ --}}
            <section id="page-onboarding-3" class="onboarding-step">
                <div class="container mx-auto px-4 sm:px-6 max-w-3xl">
                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-100 mt-6 sm:mt-10">
                        <p class="text-xs font-medium text-emerald-600 text-center">PASSO 3 DE 4</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 mt-2">
                            Qual a data do evento?
                        </h2>
                        <p class="text-center text-gray-600 mt-1 mb-5 sm:mb-6 text-sm">
                            Essa data aparecerá na sua lista.
                        </p>

                        <label for="ob-data" class="sr-only">Data do evento</label>
                        <input
                            type="date"
                            id="ob-data"
                            name="event_date"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                            required
                            min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('event_date') }}"
                        >

                        <div class="mt-6 flex items-center justify-between gap-2">
                            <button type="button" data-prev="page-onboarding-2"
                                    class="btn-back inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar
                            </button>

                            <button type="button" data-next="page-onboarding-4"
                                    class="ob-btn-next inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-md hover:bg-emerald-700">
                                Continuar <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PASSO 4 ------------------------------------------------ --}}
            <section id="page-onboarding-4" class="onboarding-step">
                <div class="container mx-auto px-4 sm:px-6 max-w-3xl">
                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-100 mt-6 sm:mt-10">
                        <p class="text-xs font-medium text-emerald-600 text-center">PASSO 4 DE 4</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 mt-2">
                            Qual estilo de lista prefere?
                        </h2>
                        <p class="text-center text-gray-600 mt-1 mb-5 sm:mb-6 text-sm">
                            Vamos sugerir templates com base nessa escolha. Você pode mudar depois.
                        </p>

                        <input type="hidden" name="style" id="ob-estilo" required value="{{ old('style') }}">

                        <div class="space-y-3 sm:space-y-4" id="ob-estilo-botoes">
                            @php
                                $estilos = [
                                    ['t' => 'Tradicional', 'd' => 'Itens para casa (eletros, enxoval...)'],
                                    ['t' => 'Moderno',     'd' => 'Cotas de experiências (lua de mel, jantares)'],
                                    ['t' => 'Simples',     'd' => 'Um único botão de Pix'],
                                ];
                            @endphp
                            @foreach ($estilos as $s)
                                <button type="button"
                                        data-estilo="{{ $s['t'] }}"
                                        class="ob-btn-etapa4 w-full text-left p-4 sm:p-5 bg-gray-50 rounded-xl border-2 border-transparent hover:border-emerald-500 hover:bg-emerald-50 transition focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <span class="font-semibold text-lg">{{ $s['t'] }}</span>
                                    <p class="text-sm text-gray-600">{{ $s['d'] }}</p>
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-2">
                            <button type="button" data-prev="page-onboarding-3"
                                    class="btn-back inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar
                            </button>

                            <button type="submit" id="btn-submit-final"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-md hover:bg-emerald-700">
                                Finalizar <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- CTA FIXA (MOBILE) ====================================== --}}
        <div class="sm:hidden sticky bottom-0 z-30 bg-white/95 backdrop-blur border-t border-gray-200">
            <div class="container mx-auto px-4 py-3 max-w-3xl flex items-center justify-between gap-3">
                <button type="button" id="mobile-back"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-300 text-gray-400 font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar
                </button>
                <button type="button" id="mobile-next"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold">
                    Continuar <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </form>

    {{-- STYLES ===================================================== --}}
    <style>
        .onboarding-step { display: none; }
        .onboarding-step.active { display: block; animation: pop .18s ease; }
        @keyframes pop {
            from { transform: scale(.985); opacity: 0; }
            to   { transform: scale(1);    opacity: 1; }
        }
        .is-selected {
            border-color: #059669 !important;
            background-color: #ecfdf5 !important;
        }
    </style>

    {{-- SCRIPTS ==================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const steps       = Array.from(document.querySelectorAll('.onboarding-step'));
            const form        = document.getElementById('form-onboarding');
            const progressBar = document.getElementById('progress-bar');
            const stepCurrent = document.getElementById('step-current');

            const btnMobileBack = document.getElementById('mobile-back');
            const btnMobileNext = document.getElementById('mobile-next');

            let currentIndex = 0;
            const ids = ['page-onboarding-1','page-onboarding-2','page-onboarding-3','page-onboarding-4'];

            function updateMobileButtons() {
                if (!btnMobileBack || !btnMobileNext) return;

                const isFirst = currentIndex === 0;
                const isLast  = currentIndex === steps.length - 1;

                btnMobileBack.disabled = isFirst;
                btnMobileBack.classList.toggle('text-gray-400', isFirst);
                btnMobileBack.classList.toggle('text-gray-700', !isFirst);

                btnMobileNext.innerHTML = isLast
                    ? 'Finalizar <i data-lucide="check" class="w-4 h-4"></i>'
                    : 'Continuar <i data-lucide="arrow-right" class="w-4 h-4"></i>';
            }

            function showStep(index) {
                currentIndex = Math.max(0, Math.min(index, steps.length - 1));
                steps.forEach(s => s.classList.remove('active'));
                const activeId = ids[currentIndex];
                const activeStep = document.getElementById(activeId);
                if (activeStep) {
                    activeStep.classList.add('active');
                }

                const pct = ((currentIndex + 1) / steps.length) * 100;
                progressBar.style.width = pct + '%';
                stepCurrent.textContent = (currentIndex + 1);

                updateMobileButtons();

                if (window.lucide) window.lucide.createIcons();
            }

            // Seleção Passo 1 ---------------------------------------
            const btnsEvento = document.getElementById('ob-evento-botoes');
            const inputTipo  = document.getElementById('ob-tipo');

            if (btnsEvento && inputTipo) {
                btnsEvento.addEventListener('click', (e) => {
                    const btn = e.target.closest('.ob-btn-etapa1');
                    if (!btn) return;

                    document.querySelectorAll('.ob-btn-etapa1').forEach(b => b.classList.remove('is-selected'));
                    btn.classList.add('is-selected');

                    inputTipo.value = btn.dataset.tipo || '';
                    showStep(1);
                });
            }

            // Navegação Voltar (botões inline) ----------------------
            document.querySelectorAll('.btn-back').forEach(btn => {
                btn.addEventListener('click', () => {
                    const prevId = btn.dataset.prev;
                    const idx = ids.indexOf(prevId);
                    if (idx >= 0) showStep(idx);
                });
            });

            // Próximo (desktop) -------------------------------------
            document.querySelectorAll('.ob-btn-next').forEach(btn => {
                btn.addEventListener('click', () => {
                    const nextId = btn.dataset.next;
                    const container = btn.closest('.onboarding-step');
                    const input = container ? container.querySelector('input[required]:not([type="hidden"])') : null;

                    if (input && !input.value) {
                        input.focus();
                        input.reportValidity?.();
                        return;
                    }

                    const idx = ids.indexOf(nextId);
                    if (idx >= 0) showStep(idx);
                });
            });

            // Seleção Passo 4 (apenas seleciona, não envia direto) --
            const estilosWrapper = document.getElementById('ob-estilo-botoes');
            const inputEstilo    = document.getElementById('ob-estilo');

            if (estilosWrapper && inputEstilo) {
                estilosWrapper.addEventListener('click', (e) => {
                    const btn = e.target.closest('.ob-btn-etapa4');
                    if (!btn) return;

                    document.querySelectorAll('.ob-btn-etapa4').forEach(b => b.classList.remove('is-selected'));
                    btn.classList.add('is-selected');

                    inputEstilo.value = btn.dataset.estilo || '';
                });
            }

            // Barra móvel (ações) -----------------------------------
            if (btnMobileBack) {
                btnMobileBack.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        showStep(currentIndex - 1);
                    }
                });
            }

            if (btnMobileNext) {
                btnMobileNext.addEventListener('click', () => {
                    // Passo 1: exige tipo de evento
                    if (currentIndex === 0) {
                        const tipo = document.getElementById('ob-tipo')?.value;
                        if (!tipo) {
                            alert('Escolha um tipo de evento para continuar.');
                            return;
                        }
                        showStep(1);
                        return;
                    }

                    // Se ainda não é o último passo, validar input visível e avançar
                    if (currentIndex < steps.length - 1) {
                        const container = document.getElementById(ids[currentIndex]);
                        const input = container?.querySelector('input[required]:not([type="hidden"])');

                        if (input && !input.value) {
                            input.focus();
                            input.reportValidity?.();
                            return;
                        }

                        showStep(currentIndex + 1);
                    } else {
                        // Último passo → valida tudo e envia
                        const requiredIds = ['ob-tipo','ob-nome','ob-data','ob-estilo'];
                        for (const id of requiredIds) {
                            const el = document.getElementById(id);
                            if (!el || !el.value) {
                                alert('Por favor, complete todas as etapas antes de finalizar.');
                                return;
                            }
                        }
                        form.submit();
                    }
                });
            }

            // Enter avança quando fizer sentido ---------------------
            form.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    const container = document.getElementById(ids[currentIndex]);
                    const focused = document.activeElement;

                    if (focused && focused.tagName === 'INPUT' && currentIndex < steps.length - 1) {
                        e.preventDefault();
                        const input = container?.querySelector('input[required]:not([type="hidden"])');
                        if (input && !input.value) {
                            input.reportValidity?.();
                            return;
                        }
                        showStep(currentIndex + 1);
                    }
                }
            });

            // iniciar ------------------------------------------------
            showStep(0);
        });
    </script>
</x-guest-layout>
