<x-admin-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">

            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Quase lá!</h2>
            <p class="text-gray-600 text-lg mb-6">
                Escaneie o QR Code ou use o "Copia e Cola" para ativar o plano de R$ {{ number_format($amount, 2, ',', '.') }}.
            </p>

            {{-- QR Code --}}
            <div class="p-4 border border-gray-200 rounded-lg inline-block bg-white">
                <img src="data:image/png;base64, {{ $qrCodeBase64 }}" alt="QR Code PIX" class="w-64 h-64">
            </div>

            {{-- Copia e Cola --}}
            <div class="mt-6">
                <label for="pix-copia-cola" class="text-sm font-medium text-gray-700">PIX Copia e Cola</label>
                <div class="relative mt-1">
                    <textarea id="pix-copia-cola" rows="3" readonly class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-xs text-gray-600 focus:ring-0 focus:border-gray-300 resize-none">{{ $qrCodeCopyPaste }}</textarea>
                </div>
                
                <button onclick="copiarPix()" class="mt-3 w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-emerald-100 text-emerald-700 font-bold hover:bg-emerald-200 transition text-sm">
                    <i data-lucide="copy" class="w-4 h-4"></i> Copiar Código
                </button>
            </div>

             <div class="mt-8 text-center">
                 <a href="{{ route('plano.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Cancelar</a>
             </div>
             
             <div class="mt-4 text-xs text-gray-400">
                 A página atualizará automaticamente assim que o pagamento for confirmado.
             </div>
        </div>
    </div>

    <script>
        function copiarPix() {
            const textarea = document.getElementById('pix-copia-cola');
            textarea.select();
            textarea.setSelectionRange(0, 99999); // Mobile
            try {
                navigator.clipboard.writeText(textarea.value);
                alert('Código PIX copiado!');
            } catch (err) {
                document.execCommand('copy');
                alert('Código PIX copiado!');
            }
        }

        // VERIFICAÇÃO AUTOMÁTICA (A cada 10 segundos)
        // Simplesmente recarrega a página. Se pagou, o middleware manda pro Dashboard.
        setTimeout(function() {
            window.location.reload();
        }, 10000);

        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>