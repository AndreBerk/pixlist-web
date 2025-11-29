<x-admin-layout>
    @php
        $hasList = isset($list) && $list;
        $planoAtivo = $hasList ? (bool)$list->plano_pago : false;
        $expiraEm = $hasList && $list->event_date ? \Carbon\Carbon::parse($list->event_date)->addDays(30)->format('d/m/Y') : null;
    @endphp

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">Minha Conta</h2>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 max-w-4xl">

        {{-- Tabs header (acessível) --}}
        <div class="border-b border-gray-200">
            <nav id="config-tabs"
                 class="-mb-px flex gap-2 sm:gap-6 px-2 sm:px-4"
                 role="tablist"
                 aria-label="Configurações da conta">
                <button type="button"
                        role="tab"
                        aria-selected="true"
                        aria-controls="tab-pessoal"
                        id="tab-pessoal-tab"
                        data-tab="tab-pessoal"
                        tabindex="0"
                        class="tab-link active shrink-0 border-b-2 border-emerald-500 px-3 py-4 text-sm font-medium text-emerald-600 focus:outline-none focus-visible:ring focus-visible:ring-emerald-300 rounded-t">
                    Dados Pessoais
                </button>

                <button type="button"
                        role="tab"
                        aria-selected="false"
                        aria-controls="tab-assinatura"
                        id="tab-assinatura-tab"
                        data-tab="tab-assinatura"
                        tabindex="-1"
                        class="tab-link shrink-0 border-b-2 border-transparent px-3 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-emerald-300 rounded-t">
                    Minha Assinatura
                </button>

                <button type="button"
                        role="tab"
                        aria-selected="false"
                        aria-controls="tab-suporte"
                        id="tab-suporte-tab"
                        data-tab="tab-suporte"
                        tabindex="-1"
                        class="tab-link shrink-0 border-b-2 border-transparent px-3 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-emerald-300 rounded-t">
                    Suporte
                </button>
            </nav>
        </div>

        <div class="p-4 sm:p-6 md:p-8">
            {{-- PESSOAL --}}
            <section id="tab-pessoal"
                     role="tabpanel"
                     aria-labelledby="tab-pessoal-tab"
                     class="config-tab-content active space-y-6">
                <div class="p-4 sm:p-8 bg-gray-50 rounded-lg border border-gray-100">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-4 sm:p-8 bg-gray-50 rounded-lg border border-gray-100">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="p-4 sm:p-8 bg-gray-50 rounded-lg border border-gray-100">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

            {{-- ASSINATURA --}}
            <section id="tab-assinatura"
                     role="tabpanel"
                     aria-labelledby="tab-assinatura-tab"
                     tabindex="0"
                     class="config-tab-content space-y-5">
                <h3 class="text-xl font-bold text-gray-900">Plano da Lista</h3>

                @if ($hasList && $planoAtivo)
                    <div class="p-6 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg">
                        <p class="text-lg font-bold flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            Plano: Ativo
                        </p>
                        <p class="mt-1">Sua lista <span class="font-bold">"{{ $list->display_name }}"</span> está ativa.</p>
                        @if($expiraEm)
                            <p>Acesso garantido até: <span class="font-bold">{{ $expiraEm }}</span></p>
                        @endif
                    </div>
                @elseif ($hasList && !$planoAtivo)
                    <div class="p-6 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-lg">
                        <p class="text-lg font-bold flex items-center gap-2">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                            Plano: Pendente
                        </p>
                        <p class="mt-1">Sua lista <span class="font-bold">"{{ $list->display_name }}"</span> ainda não foi ativada.</p>
                        <p>Para ativar e receber presentes, finalize o pagamento da taxa de ativação.</p>
                        <a href="{{ route('plano.index') }}"
                           class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none focus-visible:ring focus-visible:ring-yellow-300">
                            Ativar meu plano agora
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @else
                    <div class="p-6 bg-gray-100 text-gray-700 border border-gray-200 rounded-lg">
                        <p>Você ainda não criou uma lista. Comece pelo Onboarding!</p>
                    </div>
                @endif
            </section>

            {{-- SUPORTE --}}
            <section id="tab-suporte"
                     role="tabpanel"
                     aria-labelledby="tab-suporte-tab"
                     tabindex="0"
                     class="config-tab-content space-y-4">
                <h3 class="text-xl font-bold text-gray-900">Precisa de Ajuda?</h3>
                <p class="text-gray-700">Tem alguma dúvida ou encontrou um problema? Nossa equipe está pronta para ajudar.</p>

                <a href="mailto:suporte@pixlist.com.br"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition focus:outline-none focus-visible:ring focus-visible:ring-emerald-300">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                    Enviar e-mail para o Suporte
                </a>

                <h4 class="text-lg font-bold text-gray-900 pt-4">Perguntas Frequentes (FAQ)</h4>
                <div class="text-gray-700 space-y-3">
                    <p>
                        <strong>P: Como eu recebo o dinheiro?</strong><br>
                        R: O valor é transferido via PIX diretamente para a chave que você cadastrou na página
                        <em>Configurar Página</em>.
                    </p>
                    <p>
                        <strong>P: Qual é a taxa do PixList?</strong><br>
                        R: Cobramos uma taxa de ativação única por lista. Não há nenhuma taxa ou porcentagem sobre os presentes recebidos.
                    </p>
                </div>
            </section>
        </div>
    </div>

    <style>
        .config-tab-content { display: none; }
        .config-tab-content.active { display: block; animation: pop .2s ease; }
        .tab-link.active {
            border-color: #059669; /* emerald-500 */
            color: #047857;        /* emerald-600 */
            font-weight: 600;
        }
        @keyframes pop { from { opacity: 0; transform: translateY(4px) } to { opacity: 1; transform: translateY(0) } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // lucide
            if (window.lucide) window.lucide.createIcons();

            const tablist = document.getElementById('config-tabs');
            const tabButtons = Array.from(tablist.querySelectorAll('.tab-link'));
            const panels = Array.from(document.querySelectorAll('.config-tab-content'));

            function activateTab(btn) {
                // desativar
                tabButtons.forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                    b.setAttribute('tabindex', '-1');
                });
                panels.forEach(p => p.classList.remove('active'));

                // ativar
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
                btn.setAttribute('tabindex', '0');
                document.getElementById(btn.dataset.tab).classList.add('active');
                document.getElementById(btn.dataset.tab).focus({preventScroll:true});
            }

            // clique
            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => activateTab(btn));
            });

            // teclado (setas / Home / End)
            tablist.addEventListener('keydown', (e) => {
                const currentIndex = tabButtons.findIndex(b => b.classList.contains('active'));
                let nextIndex = currentIndex;

                if (e.key === 'ArrowRight') nextIndex = (currentIndex + 1) % tabButtons.length;
                if (e.key === 'ArrowLeft')  nextIndex = (currentIndex - 1 + tabButtons.length) % tabButtons.length;
                if (e.key === 'Home')       nextIndex = 0;
                if (e.key === 'End')        nextIndex = tabButtons.length - 1;

                if (nextIndex !== currentIndex) {
                    e.preventDefault();
                    tabButtons[nextIndex].focus();
                    activateTab(tabButtons[nextIndex]);
                }
            });
        });
    </script>
</x-admin-layout>
