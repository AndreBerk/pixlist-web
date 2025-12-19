<x-admin-layout>

    {{-- Container Centralizado --}}
    <div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full">

            {{-- Cartão Principal --}}
            <div class="bg-white rounded-3xl shadow-2xl shadow-emerald-900/10 border border-slate-100 overflow-hidden relative">

                {{-- Barra de Progresso (Visual para o reload) --}}
                <div class="h-1 w-full bg-slate-100">
                    <div class="h-full bg-emerald-500 animate-[progress_5s_linear_infinite]"></div>
                </div>

                {{-- Cabeçalho Estilo "Ticket" --}}
                <div class="bg-slate-900 p-8 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-transparent"></div>

                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 mb-4 ring-1 ring-emerald-500/50">
                            <i data-lucide="qr-code" class="w-6 h-6"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Pagamento via PIX</h2>
                        <p class="text-slate-400 text-sm mt-1">Escaneie ou copie o código abaixo</p>

                        <div class="mt-6">
                            <span class="text-slate-400 text-xs uppercase tracking-wider font-bold">Valor a pagar</span>
                            <div class="text-4xl font-extrabold text-white tracking-tight mt-1">
                                R$ {{ number_format($amount, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Corpo do Cartão --}}
                <div class="p-8">

                    {{-- Área do QR Code --}}
                    <div class="flex justify-center mb-8">
                        <div class="p-3 bg-white border-2 border-slate-100 rounded-2xl shadow-sm relative group">
                            {{-- [Image of QR code scanner overlay] --}}
                            <div class="absolute inset-0 border-[3px] border-emerald-500/0 rounded-xl group-hover:border-emerald-500/10 transition-colors pointer-events-none"></div>
                            <img src="data:image/png;base64, {{ $qrCodeBase64 }}"
                                 alt="QR Code PIX"
                                 class="w-56 h-56 object-contain rounded-lg mix-blend-multiply">
                        </div>
                    </div>

                    {{-- Área Copia e Cola --}}
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">
                            Pix Copia e Cola
                        </label>

                        <div class="relative group">
                            <input type="text" id="pix-copia-cola" readonly value="{{ $qrCodeCopyPaste }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-600 text-xs font-mono rounded-xl px-4 py-3.5 pr-12 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all truncate"
                                onclick="copiarPix()">

                            <button onclick="copiarPix()" class="absolute right-2 top-2 p-1.5 text-slate-400 hover:text-emerald-600 bg-white hover:bg-emerald-50 rounded-lg border border-slate-200 hover:border-emerald-200 transition-all shadow-sm">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>

                        <button id="btn-copy-main" onclick="copiarPix()"
                            class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <i data-lucide="copy" class="w-5 h-5"></i>
                            <span>Copiar Código PIX</span>
                        </button>
                    </div>

                    {{-- Footer / Status --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                        <div class="inline-flex items-center justify-center gap-2 text-emerald-600 bg-emerald-50 py-2 px-4 rounded-full mb-4">
                             <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                             <span class="text-xs font-bold uppercase tracking-wide">Aguardando confirmação automática</span>
                        </div>

                        <div>
                             <a href="{{ route('plano.index') }}" class="text-sm text-slate-400 hover:text-red-500 transition-colors">
                                Cancelar transação
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification (Aviso Bonito) --}}
    <div id="toast-success" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-500 z-50">
        <div class="bg-slate-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <div class="bg-emerald-500 rounded-full p-1">
                <i data-lucide="check" class="w-3 h-3 text-white"></i>
            </div>
            <span class="font-medium text-sm">Código PIX copiado!</span>
        </div>
    </div>

    <style>
        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>

    <script>
        function copiarPix() {
            const input = document.getElementById('pix-copia-cola');
            const btnMain = document.getElementById('btn-copy-main');
            const originalBtnContent = btnMain.innerHTML;

            // Seleciona e copia
            input.select();
            input.setSelectionRange(0, 99999); // Mobile fix

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(input.value);
                showFeedback();
            } else {
                document.execCommand('copy');
                showFeedback();
            }

            function showFeedback() {
                // 1. Muda o botão principal visualmente
                btnMain.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                btnMain.classList.add('bg-slate-800', 'text-white');
                btnMain.innerHTML = '<i data-lucide="check" class="w-5 h-5"></i> <span>Copiado!</span>';

                // 2. Mostra o Toast
                const toast = document.getElementById('toast-success');
                toast.classList.remove('translate-y-20', 'opacity-0');

                // 3. Reseta após 2 segundos
                setTimeout(() => {
                    btnMain.innerHTML = originalBtnContent;
                    btnMain.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                    btnMain.classList.remove('bg-slate-800', 'text-white');

                    toast.classList.add('translate-y-20', 'opacity-0');

                    // Reinicializa ícones Lucide caso eles tenham sido removidos do DOM
                    if(window.lucide) window.lucide.createIcons();
                }, 2000);
            }
        }

        // VERIFICAÇÃO AUTOMÁTICA (Mantida a lógica de reload por enquanto)
        // Adicionamos a barra de progresso CSS para o usuário entender por que a tela recarrega
        setTimeout(function() {
            window.location.reload();
        }, 5000);

        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
