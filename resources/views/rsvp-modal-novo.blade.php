<dialog id="modalNovoConvidado"
        class="rounded-2xl shadow-2xl w-[92vw] max-w-lg p-0 overflow-hidden border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 transition-colors duration-300">

    <div class="bg-white dark:bg-slate-800 transition-colors duration-300">
        {{-- HEADER --}}
        <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-100 dark:border-slate-700">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white leading-tight">Adicionar Convidado</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                    Adicione manualmente um convidado. Ele entrará como <b>Pendente</b>.
                </p>
            </div>

            <button type="button"
                    class="shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    aria-label="Fechar"
                    onclick="document.getElementById('modalNovoConvidado').close()">
                <i data-lucide="x" class="w-5 h-5 text-gray-600 dark:text-slate-400"></i>
            </button>
        </div>

        {{-- BODY (scrollável no mobile / teclado) --}}
        <div class="px-6 py-5 max-h-[75vh] overflow-auto">
            <form method="POST" action="{{ route('rsvp.admin.store') }}" class="space-y-5">
                @csrf

                {{-- Nome --}}
                <div>
                    <label for="rsvp-nome" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                        Nome / Família
                    </label>
                    <input id="rsvp-nome"
                           type="text"
                           name="guest_name"
                           required
                           autocomplete="name"
                           placeholder="Ex: Família Silva"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  outline-none transition-colors placeholder:text-gray-400 dark:placeholder:text-slate-500">
                </div>

                {{-- Adultos e Crianças --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="rsvp-adultos" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Adultos
                        </label>
                        <input id="rsvp-adultos"
                               type="number"
                               min="0"
                               inputmode="numeric"
                               name="adults"
                               value="1"
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                                      focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                      outline-none transition-colors">
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Inclui o responsável pelo grupo.</p>
                    </div>

                    <div>
                        <label for="rsvp-criancas" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Crianças
                        </label>
                        <input id="rsvp-criancas"
                               type="number"
                               min="0"
                               inputmode="numeric"
                               name="children"
                               value="0"
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                                      focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                      outline-none transition-colors">
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Se não houver, deixe 0.</p>
                    </div>
                </div>

                {{-- Contato --}}
                <div>
                    <label for="rsvp-contato" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-1">
                        Contato (opcional)
                    </label>
                    <input id="rsvp-contato"
                           type="text"
                           name="contact"
                           autocomplete="tel"
                           placeholder="WhatsApp ou e-mail"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                  outline-none transition-colors placeholder:text-gray-400 dark:placeholder:text-slate-500">
                </div>

                {{-- FOOTER --}}
                <div class="pt-2 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                    <button type="button"
                            class="w-full sm:w-auto px-5 py-3 rounded-xl border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-bold
                                   hover:bg-gray-50 dark:hover:bg-slate-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            onclick="document.getElementById('modalNovoConvidado').close()">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 dark:bg-emerald-500 text-white font-extrabold
                                   hover:bg-emerald-700 dark:hover:bg-emerald-600 transition shadow-lg shadow-emerald-200 dark:shadow-none
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        Salvar convidado
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Backdrop (mais estável que classes) */
        #modalNovoConvidado::backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(6px);
        }

        /* Animação suave */
        #modalNovoConvidado[open] {
            animation: modalIn .18s ease-out;
        }

        @keyframes modalIn {
            from { transform: translateY(10px) scale(.98); opacity: 0; }
            to   { transform: translateY(0) scale(1); opacity: 1; }
        }
    </style>

    <script>
        (function () {
            const modal = document.getElementById('modalNovoConvidado');
            if (!modal) return;

            // Clique fora fecha (UX premium)
            modal.addEventListener('click', (e) => {
                const rect = modal.getBoundingClientRect();
                const isInDialog =
                    e.clientX >= rect.left && e.clientX <= rect.right &&
                    e.clientY >= rect.top  && e.clientY <= rect.bottom;

                if (!isInDialog) modal.close();
            });

            modal.addEventListener('close', () => {
                // opcional: reset do form ao fechar
                // modal.querySelector('form')?.reset();
            });

            modal.addEventListener('shown', () => {});

            // Ao abrir via showModal(), foca no input
            const originalShowModal = modal.showModal.bind(modal);
            modal.showModal = function () {
                originalShowModal();
                setTimeout(() => {
                    modal.querySelector('#rsvp-nome')?.focus();
                    if (window.lucide) window.lucide.createIcons();
                }, 50);
            };
        })();
    </script>
</dialog>
