<x-admin-layout>

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Central de Compartilhamento
    </h2>

    @php
        $slug = Illuminate\Support\Str::slug($list->display_name);

        // Links Principais
        $publicUrl = route('list.public.show', ['list' => $list->id, 'slug' => $slug]);
        $galleryUrl = route('list.gallery', ['list' => $list->id]);

        // Mensagens WhatsApp
        $whatsAppText = rawurlencode("Olá! Estamos compartilhando nossa lista de presentes com você: " . $publicUrl);
        $whatsAppGalleryText = rawurlencode("Olá! Veja e poste fotos da nossa festa aqui: " . $galleryUrl);
    @endphp

    {{-- =========================================================
         1. COMPARTILHAR LISTA DE PRESENTES (CONVITE)
         ========================================================= --}}
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-emerald-100 text-emerald-700 rounded-lg">
                <i data-lucide="gift" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Lista de Presentes</h3>
                <p class="text-sm text-gray-500">Para enviar no convite ou WhatsApp antes da festa.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- COLUNA QR CODE (CONVITE) --}}
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6 flex flex-col items-center">
                <div id="div-convite-exportar" class="w-full p-6 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 border border-gray-300 relative overflow-hidden text-center flex flex-col items-center">
                    <i data-lucide="flower-2" class="w-24 h-24 text-gray-300/50 absolute -top-8 -right-8 rotate-12"></i>
                    <p class="text-sm font-semibold text-gray-500 z-10">{{ $list->event_type }}</p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1 z-10">{{ $list->display_name }}</h4>
                    <p class="text-gray-600 mt-2 z-10 text-sm">Escaneie para ver nossa lista de presentes!</p>
                    <div class="mt-4 p-2 bg-white rounded-lg border-2 border-white shadow-md inline-block z-10">
                        {!! QrCode::size(150)->generate($publicUrl) !!}
                    </div>
                </div>

                <button type="button" id="btn-baixar-convite" class="w-full mt-4 px-4 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg shadow hover:bg-emerald-700 transition flex items-center justify-center gap-2 text-sm">
                    <i data-lucide="image" class="w-4 h-4"></i> <span id="btn-baixar-convite-label">Baixar Imagem (PNG)</span>
                </button>
            </div>

            {{-- COLUNA LINK --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Link da Lista</label>
                <div class="flex items-center gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg mb-6">
                    <input type="text" id="publicUrl" readonly class="flex-1 bg-transparent border-none text-gray-600 text-sm focus:ring-0" value="{{ $publicUrl }}">
                    <button onclick="copiarTexto('{{ $publicUrl }}', this)" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-xs font-bold text-gray-700 hover:bg-gray-100 transition">Copiar</button>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ $publicUrl }}" target="_blank" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="eye" class="w-4 h-4"></i> Ver página
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank" class="flex-1 px-4 py-2.5 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> Enviar no WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         2. COMPARTILHAR GALERIA DE FOTOS (MURAL) [NOVO]
         ========================================================= --}}
    @if($list->gallery_enabled)
    <div class="mb-12 border-t border-gray-200 pt-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-blue-100 text-blue-700 rounded-lg">
                <i data-lucide="camera" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Galeria de Fotos (Para a Festa)</h3>
                <p class="text-sm text-gray-500">Imprima este QR Code e coloque nas mesas para os convidados postarem fotos.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- COLUNA QR CODE (GALERIA) --}}
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6 flex flex-col items-center">
                <div id="div-galeria-exportar" class="w-full p-6 rounded-lg bg-slate-900 border border-slate-800 relative overflow-hidden text-center flex flex-col items-center text-white">
                    <p class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-1">Mural de Fotos</p>
                    <h4 class="text-xl font-bold text-white mb-3">{{ $list->display_name }}</h4>
                    <p class="text-slate-400 text-xs mb-4">Escaneie para ver e postar fotos!</p>
                    <div class="p-2 bg-white rounded-lg inline-block">
                        {!! QrCode::size(150)->generate($galleryUrl) !!}
                    </div>
                </div>

                <button type="button" id="btn-baixar-galeria" class="w-full mt-4 px-4 py-2.5 bg-slate-800 text-white font-semibold rounded-lg shadow hover:bg-slate-900 transition flex items-center justify-center gap-2 text-sm">
                    <i data-lucide="image" class="w-4 h-4"></i> <span id="btn-baixar-galeria-label">Baixar Placa de Mesa (PNG)</span>
                </button>
            </div>

            {{-- COLUNA LINK (GALERIA) --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Direto da Galeria</label>
                <div class="flex items-center gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg mb-6">
                    <input type="text" readonly class="flex-1 bg-transparent border-none text-gray-600 text-sm focus:ring-0" value="{{ $galleryUrl }}">
                    <button onclick="copiarTexto('{{ $galleryUrl }}', this)" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-xs font-bold text-gray-700 hover:bg-gray-100 transition">Copiar</button>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ $galleryUrl }}" target="_blank" class="flex-1 px-4 py-2.5 bg-slate-700 text-white font-semibold rounded-lg shadow hover:bg-slate-800 transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="eye" class="w-4 h-4"></i> Ver Galeria
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ $whatsAppGalleryText }}" target="_blank" class="flex-1 px-4 py-2.5 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> Enviar Link da Galeria
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="mt-8 p-6 bg-blue-50 rounded-xl border border-blue-100 text-center">
            <i data-lucide="camera-off" class="w-8 h-8 text-blue-400 mx-auto mb-2"></i>
            <h3 class="text-lg font-bold text-blue-900">A Galeria está desativada</h3>
            <p class="text-sm text-blue-700 mb-4">Ative a "Galeria de Fotos" nas configurações para gerar o QR Code e o link exclusivo para compartilhar.</p>
            <a href="{{ route('list.config.edit') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Ir para Configurações</a>
        </div>
    @endif


    {{-- SCRIPTS E BIBLIOTECAS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            // Lógica para baixar IMAGEM (Genérica)
            function baixarImagem(elementId, btnId, labelId, filename) {
                const btn = document.getElementById(btnId);
                const element = document.getElementById(elementId);
                const label = document.getElementById(labelId);
                const originalText = label ? label.textContent : 'Baixar';

                if (btn && element && window.html2canvas) {
                    btn.addEventListener('click', () => {
                        if (label) label.textContent = 'Gerando...';
                        btn.disabled = true;

                        html2canvas(element, { useCORS: true, scale: 2 }).then(canvas => {
                            const link = document.createElement('a');
                            link.href = canvas.toDataURL('image/png');
                            link.download = filename;
                            link.click();
                            if (label) label.textContent = originalText;
                            btn.disabled = false;
                        }).catch(err => {
                            console.error(err);
                            if (label) label.textContent = 'Erro';
                            btn.disabled = false;
                        });
                    });
                }
            }

            // Ativa os dois botões de download
            baixarImagem('div-convite-exportar', 'btn-baixar-convite', 'btn-baixar-convite-label', 'convite-pixlist.png');
            baixarImagem('div-galeria-exportar', 'btn-baixar-galeria', 'btn-baixar-galeria-label', 'placa-mesa-galeria.png');
        });

        // Função Global de Copiar
        async function copiarTexto(texto, btn) {
            try {
                await navigator.clipboard.writeText(texto);
                const originalText = btn.textContent;
                btn.textContent = 'Copiado!';
                btn.classList.add('bg-emerald-100', 'text-emerald-700');
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.classList.remove('bg-emerald-100', 'text-emerald-700');
                }, 2000);
            } catch (err) {
                alert('Erro ao copiar: ' + err);
            }
        }
    </script>

</x-admin-layout>
