<dialog id="modalPix" class="rounded-2xl p-0 w-[95%] sm:w-full max-w-md shadow-2xl backdrop:bg-black/60 backdrop:backdrop-blur-sm open:animate-fade-in" data-pix-key="{{ $list->pix_key ?? 'Chave não informada' }}">

    <form method="POST" action="" id="formPixPagamento" class="bg-white rounded-2xl p-5 sm:p-8">
        @csrf
        
        {{-- Cabeçalho do Modal --}}
        <div class="text-center sm:text-left mb-5">
            <h3 id="modalTitle" class="text-lg sm:text-2xl font-extrabold text-gray-900 mb-1 leading-tight">
                Presentear com: ...
            </h3>
            <p class="text-sm text-gray-500">
                Preencha seus dados e realize o pagamento.
            </p>
        </div>

        {{-- Campos de Nome e Mensagem --}}
        <div class="space-y-4 mb-6">
            <div>
                <label for="guest_name" class="block text-xs font-bold text-gray-700 uppercase mb-1">Seu nome (opcional)</label>
                <input type="text" id="guest_name" name="guest_name" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition" 
                       placeholder="Ex: Maria e João">
            </div>
            <div>
                <label for="guest_message" class="block text-xs font-bold text-gray-700 uppercase mb-1">Mensagem aos noivos (opcional)</label>
                <textarea id="guest_message" name="guest_message" rows="2" 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition resize-none" 
                          placeholder="Ex: Muitas felicidades nessa nova etapa!"></textarea>
            </div>
        </div>

        {{-- Área do PIX (Destacada) --}}
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6">
            <p class="text-xs font-semibold text-center text-gray-600 mb-2 uppercase tracking-wide">
                 Copie a chave abaixo para pagar no seu banco
            </p>

            <div class="relative">
                <input id="pixChave" readonly
                       value="{{ $list->pix_key ?? 'Chave não informada' }}"
                       class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg bg-white text-gray-600 font-mono text-sm text-center focus:outline-none" />
            </div>

            <button type="button" onclick="copiarChavePix()" class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-emerald-100 text-emerald-700 text-sm font-bold hover:bg-emerald-200 transition">
                <i data-lucide="copy" class="w-4 h-4"></i> Copiar Chave PIX
            </button>
        </div>

        {{-- Botões de Ação (Empilhados no Mobile, Lado a Lado no PC) --}}
        <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
            {{-- Botão Fechar (Ordem 2 no mobile, 1 no PC) --}}
            <button type="button" onclick="document.getElementById('modalPix').close()" 
                    class="order-2 sm:order-1 w-full sm:w-auto px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-50 transition">
                Fechar
            </button>

            {{-- Botão Confirmar (Ordem 1 no mobile, 2 no PC) --}}
            <button type="submit" id="pixConfirmar" 
                    class="order-1 sm:order-2 w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition flex items-center justify-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Já fiz o PIX, Confirmar
            </button>
        </div>
    </form>

    <script>
        function copiarChavePix() {
            const inputChave = document.getElementById('pixChave');
            inputChave.select();
            inputChave.setSelectionRange(0, 99999); // Para mobile

            try {
                navigator.clipboard.writeText(inputChave.value);
                // Feedback visual simples
                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Copiado!';
                btn.classList.add('bg-emerald-600', 'text-white');
                btn.classList.remove('bg-emerald-100', 'text-emerald-700');
                if(window.lucide) window.lucide.createIcons();
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('bg-emerald-600', 'text-white');
                    btn.classList.add('bg-emerald-100', 'text-emerald-700');
                    if(window.lucide) window.lucide.createIcons();
                }, 2000);

            } catch (err) {
                document.execCommand('copy');
                alert('Chave PIX copiada!');
            }
        }

        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>

    <style>
        /* Animação suave ao abrir */
        dialog[open] {
            animation: zoom-in 0.3s ease-out;
        }
        @keyframes zoom-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        /* Fundo escuro (backdrop) */
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }
    </style>
</dialog>