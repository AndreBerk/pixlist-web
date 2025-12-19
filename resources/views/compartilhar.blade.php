<x-admin-layout title="Compartilhar">
    {{-- Cabeçalho --}}
    <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
            Central de Compartilhamento
        </h2>
        <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Divulgue sua lista e o mural de fotos para os convidados.</p>
    </div>

    @php
        $slug = Illuminate\Support\Str::slug($list->display_name);
        $publicUrl = route('list.public.show', ['list' => $list->id, 'slug' => $slug]);
        $galleryUrl = route('list.gallery', ['list' => $list->id]);
        $nomeEvento = $list->display_name;

        // --- MENSAGEM WHATSAPP ---
        $textoLista = "✨ *Olá!* \n\nEstamos muito felizes em compartilhar com você a Lista de Presentes do evento *{$nomeEvento}*! 🎁\n\nPara conferir, acesse:\n👉 $publicUrl\n\nAgradecemos pelo carinho! ❤️";
        $whatsAppText = rawurlencode($textoLista);

        $textoGaleria = "📸 *Mural de Fotos - {$nomeEvento}*\n\nAcesse o link para ver as fotos e postar as suas em tempo real:\n👉 $galleryUrl\n\nCompartilhe seus cliques! ✨";
        $whatsAppGalleryText = rawurlencode($textoGaleria);
    @endphp

    <div class="space-y-10">

        {{-- =========================================================
             1. CARTÃO: LISTA DE PRESENTES (CONVITE)
             ========================================================= --}}
        <section class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
            <div class="p-6 md:p-8 border-b border-gray-100 dark:border-slate-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-lg text-emerald-700 dark:text-emerald-400">
                        <i data-lucide="gift" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lista de Presentes</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">Link principal para enviar no convite ou WhatsApp.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- LADO ESQUERDO: Visualização do QR Code (MANTÉM VISUAL CLARO PARA EXPORTAÇÃO) --}}
                <div class="lg:col-span-4 flex flex-col items-center">

                    {{-- ÁREA DE EXPORTAÇÃO --}}
                    <div id="div-convite-exportar" class="w-full max-w-sm aspect-[3/4] rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 relative overflow-hidden flex flex-col items-center justify-center text-center p-6 shadow-sm">
                        {{-- Elementos Decorativos --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-200/20 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-teal-200/20 rounded-full blur-2xl -ml-10 -mb-10 pointer-events-none"></div>

                        <div class="relative z-10 w-full flex flex-col items-center">
                            <span class="inline-block px-3 py-1 rounded-full bg-white/80 border border-white/50 text-[10px] font-bold tracking-widest text-emerald-800 uppercase mb-3 backdrop-blur-sm">
                                Convite Digital
                            </span>
                            <h4 class="text-2xl font-black text-gray-800 leading-tight mb-1">{{ $list->display_name }}</h4>
                            <p class="text-gray-500 text-xs mb-6 font-medium">{{ $list->event_type }}</p>

                            {{-- QR CODE COM FUNDO BRANCO --}}
                            <div class="p-4 bg-white rounded-xl shadow-lg border border-gray-100 inline-block">
                                {!! QrCode::size(150)->color(6, 78, 59)->backgroundColor(255, 255, 255)->generate($publicUrl) !!}
                            </div>

                            <p class="text-emerald-800 text-xs font-bold mt-4">Escaneie para ver a lista</p>
                        </div>
                    </div>

                    <button type="button" id="btn-baixar-convite" class="mt-4 w-full max-w-sm flex items-center justify-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 hover:border-gray-300 dark:hover:border-slate-500 transition text-sm shadow-sm">
                        <i data-lucide="download" class="w-4 h-4"></i> <span id="btn-baixar-convite-label">Baixar Imagem (PNG)</span>
                    </button>
                </div>

                {{-- LADO DIREITO: Ações --}}
                <div class="lg:col-span-8 flex flex-col justify-center space-y-6">

                    {{-- Input de Cópia --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Link da sua Página</label>
                        <div class="flex rounded-xl shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i data-lucide="link" class="h-4 w-4 text-gray-400 dark:text-slate-500"></i>
                                </div>
                                <input type="text" readonly value="{{ $publicUrl }}" class="block w-full rounded-l-xl border-gray-300 dark:border-slate-600 pl-10 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-3 text-gray-600 dark:text-slate-300 bg-gray-50/50 dark:bg-slate-900">
                            </div>
                            <button type="button" onclick="copiarTexto('{{ $publicUrl }}', this)" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 px-4 py-2 text-sm font-bold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-slate-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition">
                                <i data-lucide="copy" class="h-4 w-4"></i>
                                <span>Copiar</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 dark:shadow-none hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            <span>Enviar no WhatsApp</span>
                        </a>

                        <a href="{{ $publicUrl }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-4 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 hover:border-gray-300 transition shadow-sm">
                            <i data-lucide="external-link" class="w-5 h-5"></i>
                            <span>Abrir Página</span>
                        </a>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-4 flex gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            <strong>Dica:</strong> Copie o link acima e coloque na bio do seu Instagram ou envie individualmente para os padrinhos.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
             2. CARTÃO: GALERIA DE FOTOS (MURAL)
             ========================================================= --}}
        @if($list->gallery_enabled)
        <section class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
            <div class="p-6 md:p-8 border-b border-gray-100 dark:border-slate-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg text-indigo-700 dark:text-indigo-400">
                        <i data-lucide="camera" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Mural de Fotos (Para a Festa)</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">Imprima e coloque nas mesas para os convidados postarem fotos.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- LADO ESQUERDO: QR Code Dark (MANTÉM VISUAL DARK PARA EXPORTAÇÃO) --}}
                <div class="lg:col-span-4 flex flex-col items-center">

                    {{-- ÁREA DE EXPORTAÇÃO --}}
                    <div id="div-galeria-exportar" class="w-full max-w-sm aspect-[3/4] rounded-2xl bg-slate-900 border border-slate-800 relative overflow-hidden flex flex-col items-center justify-center text-center p-6 shadow-xl">
                        {{-- Luzes Decorativas --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-40 h-40 bg-indigo-500/30 rounded-full blur-3xl -mt-20 pointer-events-none"></div>

                        <div class="relative z-10 text-white w-full flex flex-col items-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em] mb-2">Compartilhe o Momento</p>
                            <h4 class="text-2xl font-black mb-4 leading-tight">{{ $list->display_name }}</h4>

                            {{-- QR CODE COM FUNDO BRANCO --}}
                            <div class="p-3 bg-white rounded-xl shadow-[0_0_20px_rgba(255,255,255,0.1)] inline-block mb-4">
                                {!! QrCode::size(150)->color(15, 23, 42)->backgroundColor(255, 255, 255)->generate($galleryUrl) !!}
                            </div>

                            <p class="text-slate-400 text-xs font-medium max-w-[200px] mx-auto leading-relaxed">
                                Escaneie para ver as fotos e postar as suas! 📸
                            </p>
                        </div>
                    </div>

                    <button type="button" id="btn-baixar-galeria" class="mt-4 w-full max-w-sm flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 dark:bg-slate-700 border border-slate-700 dark:border-slate-600 text-white font-bold rounded-xl hover:bg-slate-900 dark:hover:bg-slate-600 transition text-sm shadow-sm">
                        <i data-lucide="download" class="w-4 h-4"></i> <span id="btn-baixar-galeria-label">Baixar Placa de Mesa (PNG)</span>
                    </button>
                </div>

                {{-- LADO DIREITO: Ações --}}
                <div class="lg:col-span-8 flex flex-col justify-center space-y-6">

                     {{-- Input de Cópia --}}
                     <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Link Direto da Galeria</label>
                        <div class="flex rounded-xl shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i data-lucide="link" class="h-4 w-4 text-gray-400 dark:text-slate-500"></i>
                                </div>
                                <input type="text" readonly value="{{ $galleryUrl }}" class="block w-full rounded-l-xl border-gray-300 dark:border-slate-600 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 text-gray-600 dark:text-slate-300 bg-gray-50/50 dark:bg-slate-900">
                            </div>
                            <button type="button" onclick="copiarTexto('{{ $galleryUrl }}', this)" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 px-4 py-2 text-sm font-bold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition">
                                <i data-lucide="copy" class="h-4 w-4"></i>
                                <span>Copiar</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="https://api.whatsapp.com/send?text={{ $whatsAppGalleryText }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            <span>Enviar Link da Galeria</span>
                        </a>

                        <a href="{{ $galleryUrl }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-4 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 hover:border-gray-300 transition shadow-sm">
                            <i data-lucide="external-link" class="w-5 h-5"></i>
                            <span>Testar Galeria</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @else
        {{-- CARD: GALERIA DESATIVADA --}}
        <section class="bg-gradient-to-br from-gray-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl shadow-sm border border-dashed border-gray-300 dark:border-slate-600 p-8 md:p-12 text-center transition-colors duration-300">
            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="camera-off" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">A Galeria de Fotos está desativada</h3>
            <p class="text-gray-500 dark:text-slate-400 max-w-lg mx-auto mb-6">
                A Galeria permite que seus convidados postem fotos em tempo real durante o evento.
                Ative este recurso para gerar o QR Code exclusivo da festa.
            </p>
            <a href="{{ route('list.config.edit') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-slate-900 font-bold rounded-xl hover:bg-black dark:hover:bg-gray-200 transition shadow-lg">
                <i data-lucide="settings-2" class="w-4 h-4"></i>
                Ir para Configurações e Ativar
            </a>
        </section>
        @endif

    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            // Lógica para baixar IMAGEM
            function baixarImagem(elementId, btnId, labelId, filename) {
                const btn = document.getElementById(btnId);
                const element = document.getElementById(elementId);
                const label = document.getElementById(labelId);
                const originalText = label ? label.textContent : 'Baixar';

                if (btn && element && window.html2canvas) {
                    btn.addEventListener('click', () => {
                        if (label) label.textContent = 'Gerando...';
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-wait');

                        html2canvas(element, {
                            useCORS: true,
                            scale: 4,
                            backgroundColor: null,
                            logging: false
                        }).then(canvas => {
                            const link = document.createElement('a');
                            link.href = canvas.toDataURL('image/png');
                            link.download = filename;
                            link.click();

                            if (label) label.textContent = 'Baixado!';
                            setTimeout(() => {
                                if (label) label.textContent = originalText;
                                btn.disabled = false;
                                btn.classList.remove('opacity-75', 'cursor-wait');
                            }, 2000);
                        }).catch(err => {
                            console.error(err);
                            if (label) label.textContent = 'Erro ao gerar';
                            btn.disabled = false;
                        });
                    });
                }
            }

            baixarImagem('div-convite-exportar', 'btn-baixar-convite', 'btn-baixar-convite-label', 'convite-digital.png');
            baixarImagem('div-galeria-exportar', 'btn-baixar-galeria', 'btn-baixar-galeria-label', 'placa-festa.png');
        });

        async function copiarTexto(texto, btn) {
            try {
                await navigator.clipboard.writeText(texto);
                const originalContent = btn.innerHTML;
                btn.innerHTML = `<i data-lucide="check" class="h-4 w-4"></i><span>Copiado!</span>`;
                btn.classList.add('text-emerald-600', 'bg-emerald-50', 'border-emerald-200');
                if(window.lucide) window.lucide.createIcons();

                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.classList.remove('text-emerald-600', 'bg-emerald-50', 'border-emerald-200');
                    if(window.lucide) window.lucide.createIcons();
                }, 2000);
            } catch (err) {
                alert('Erro ao copiar');
            }
        }
    </script>
</x-admin-layout>
