<dialog id="modalPix" class="rounded-3xl p-0 w-[90%] sm:w-full max-w-md shadow-2xl backdrop:bg-black/80 open:animate-fade-in" data-pix-key="{{ $list->pix_key ?? 'Chave não informada' }}">

    <div class="bg-white p-6 sm:p-8 overflow-y-auto max-h-[90vh]">
        <form method="POST" action="" id="formPixPagamento">
            @csrf

            {{-- CABEÇALHO COM BOTÃO FECHAR --}}
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-gray-900 leading-tight">
                        Presentear
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Dados para identificação.
                    </p>
                </div>
                {{-- Botão X para fechar rápido no mobile --}}
                <button type="button" onclick="document.getElementById('modalPix').close()" class="p-2 -mr-2 -mt-2 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- CAMPOS (Inputs maiores para evitar zoom no iOS) --}}
            <div class="space-y-4 mb-6">
                <div>
                    <label for="guest_name" class="block text-xs font-bold text-gray-700 uppercase mb-1.5 ml-1">Seu Nome</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="guest_name" name="guest_name"
                               class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-base shadow-sm transition"
                               placeholder="Maria e João">
                    </div>
                </div>
                <div>
                    <label for="guest_message" class="block text-xs font-bold text-gray-700 uppercase mb-1.5 ml-1">Mensagem (Opcional)</label>
                    <div class="relative">
                        <div class="absolute top-3.5 left-0 pl-4 pointer-events-none text-gray-400">
                            <i data-lucide="message-square" class="w-5 h-5"></i>
                        </div>
                        <textarea id="guest_message" name="guest_message" rows="2"
                                  class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-base shadow-sm transition resize-none"
                                  placeholder="Muitas felicidades!"></textarea>
                    </div>
                </div>
            </div>

            {{-- ÁREA DO PIX (Cartão Destacado) --}}
            <div class="bg-emerald-50/50 border border-emerald-100 p-5 rounded-2xl mb-6 text-center relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-2 opacity-10">
                    <i data-lucide="qr-code" class="w-16 h-16 text-emerald-600"></i>
                </div>

                <p class="text-xs font-bold text-emerald-700 uppercase tracking-wide mb-3">
                    Copie a chave para pagar
                </p>

                <div class="relative mb-3">
                    <input id="pixChave" readonly
                           value="{{ $list->pix_key ?? 'Chave não informada' }}"
                           class="w-full py-3 px-4 rounded-xl border border-emerald-200 bg-white text-gray-600 font-mono text-sm text-center focus:outline-none select-all cursor-text shadow-sm" />
                </div>

                <button type="button" onclick="copiarChavePix(this)" class="w-full py-3.5 rounded-xl bg-emerald-100 text-emerald-700 font-bold text-sm hover:bg-emerald-200 transition flex items-center justify-center gap-2 active:scale-95">
                    <i data-lucide="copy" class="w-4 h-4"></i>
                    <span>Toque para Copiar</span>
                </button>
            </div>

            {{-- BOTÕES DE AÇÃO (Empilhados no Mobile) --}}
            <div class="flex flex-col gap-3">
                {{-- Botão Principal (Confirmar) --}}
                <button type="submit" id="pixConfirmar"
                        class="w-full py-4 rounded-xl bg-gray-900 text-white font-bold text-base shadow-lg shadow-gray-200 hover:bg-black active:scale-95 transition flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    Já fiz o PIX, Confirmar
                </button>

                {{-- Botão Secundário (Cancelar) --}}
                <button type="button" onclick="document.getElementById('modalPix').close()"
                        class="w-full py-3 rounded-xl text-gray-500 font-bold text-sm hover:bg-gray-50 transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function copiarChavePix(btn) {
            const inputChave = document.getElementById('pixChave');
            const originalText = btn.innerHTML; // Salva o ícone e texto originais

            // Seleciona o texto (UX visual)
            inputChave.select();
            inputChave.setSelectionRange(0, 99999); // Para mobile

            // Tenta copiar
            try {
                navigator.clipboard.writeText(inputChave.value).then(() => {
                    sucessoCopia(btn, originalText);
                }).catch(() => {
                    // Fallback para navegadores antigos
                    document.execCommand('copy');
                    sucessoCopia(btn, originalText);
                });
            } catch (err) {
                // Fallback final
                document.execCommand('copy');
                sucessoCopia(btn, originalText);
            }
        }

        function sucessoCopia(btn, originalContent) {
            // Muda visual para feedback
            btn.classList.remove('bg-emerald-100', 'text-emerald-700');
            btn.classList.add('bg-emerald-500', 'text-white');
            btn.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> <span>Copiado!</span>';

            if(window.lucide) window.lucide.createIcons();

            // Restaura após 2 segundos
            setTimeout(() => {
                btn.classList.remove('bg-emerald-500', 'text-white');
                btn.classList.add('bg-emerald-100', 'text-emerald-700');
                btn.innerHTML = originalContent;
                if(window.lucide) window.lucide.createIcons();
            }, 2000);
        }
    </script>

    <style>
        /* Animação suave ao abrir */
        dialog[open] { animation: modal-pop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes modal-pop {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        dialog::backdrop { background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px); }
    </style>
</dialog>
