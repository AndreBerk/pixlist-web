<x-admin-layout>

    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Central de Compartilhamento
    </h2>

    @php
        $slug = Illuminate\Support\Str::slug($list->display_name);
        $publicUrl = route('list.public.show', ['list' => $list->id, 'slug' => $slug]);
        $whatsAppText = rawurlencode("Olá! Estamos compartilhando nossa lista de presentes com você: " . $publicUrl);
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- COLUNA QR CODE E "CONVITE" --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6 flex flex-col items-center">
            <h3 class="text-xl font-extrabold text-gray-800 mb-2 text-center">Seu Convite QR Code</h3>
            <p class="text-gray-600 mb-4 text-sm text-center">
                Use este visual para convites ou baixe o QR Code puro para a sua gráfica.
            </p>

            <div id="div-convite-exportar" class="w-full p-6 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 border border-gray-300 relative overflow-hidden text-center flex flex-col items-center">
                <i data-lucide="flower-2" class="w-24 h-24 text-gray-300/50 absolute -top-8 -right-8 rotate-12"></i>
                <p class="text-sm font-semibold text-gray-500 z-10">{{ $list->event_type }}</p>
                <h4 class="text-2xl font-bold text-gray-800 mt-1 z-10">{{ $list->display_name }}</h4>
                <p class="text-gray-600 mt-2 z-10 text-sm">Escaneie para ver nossa lista de presentes!</p>
                <div class="mt-4 p-2 bg-white rounded-lg border-2 border-white shadow-md inline-block z-10">
                    {!! QrCode::size(180)->generate($publicUrl) !!}
                </div>
            </div>

            <button
               type="button"
               id="btn-baixar-convite"
               class="w-full mt-4 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition inline-flex items-center justify-center gap-2"
               aria-label="Baixar o convite como uma imagem PNG">
                <i data-lucide="image" class="w-5 h-5"></i>
                <span id="btn-baixar-convite-label">Baixar Convite (PNG)</span>
            </button>

            <a href="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(300)->generate($publicUrl)) }}"
               download="qrcode-lista-{{ $slug }}.svg"
               class="w-full mt-3 px-6 py-3 bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:bg-gray-800 transition inline-flex items-center justify-center gap-2"
               aria-label="Baixar QR Code da sua lista em SVG">
                <i data-lucide="download" class="w-5 h-5"></i>
                <span>Baixar (Apenas o QR Code)</span>
            </a>
        </div>

        {{-- COLUNA LINKS E COMPARTILHAMENTO --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
            <h3 class="text-xl font-extrabold text-gray-800 mb-3">Compartilhe seu link</h3>
            <p class="text-gray-600 mb-4 text-sm">
                Envie este link para seus convidados por WhatsApp, e-mail ou redes sociais.
            </p>

            <div class="flex items-center gap-2 p-4 bg-gray-100 border border-gray-200 rounded-lg">
                <input
                    type="text"
                    id="publicUrl"
                    readonly
                    class="flex-1 bg-transparent border-none text-gray-700 text-sm sm:text-base focus:ring-0 focus:outline-none cursor-text"
                    value="{{ $publicUrl }}"
                    aria-label="Link público da sua lista"
                >
                <button
                    id="btnCopiar"
                    type="button"
                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition inline-flex items-center gap-2"
                >
                    <i data-lucide="copy" class="w-4 h-4"></i>
                    <span>Copiar</span>
                </button>
            </div>
            <span id="copy-feedback" class="sr-only" aria-live="polite"></span>

            <div class="flex flex-col sm:flex-row gap-4 mt-6">
                <a href="{{ $publicUrl }}" target="_blank" id="linkPreview"
                   class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition inline-flex items-center justify-center gap-2">
                    <i data-lucide="eye" class="w-5 h-5"></i>
                    <span>Ver como convidado</span>
                </a>

                <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank"
                   class="flex-1 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition inline-flex items-center justify-center gap-2">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    <span>Compartilhar no WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    {{-- [MUDANÇA AQUI] ADICIONAMOS A BIBLIOTECA E O NOVO SCRIPT --}}

    {{-- 1. A Biblioteca (CDN) - [CORREÇÃO: Removemos o 'integrity' hash] --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    {{-- 2. O seu script antigo (de copiar) + o novo (de baixar) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            if (window.lucide) {
                window.lucide.createIcons();
            }

            // --- LÓGICA ANTIGA (COPIAR LINK) ---
            const inputUrl      = document.getElementById('publicUrl');
            const btnCopiar     = document.getElementById('btnCopiar');
            const feedback      = document.getElementById('copy-feedback');
            const btnLabelSpan  = btnCopiar ? btnCopiar.querySelector('span') : null;
            const originalLabel = btnLabelSpan ? btnLabelSpan.textContent : 'Copiar';

            if (inputUrl) {
                const selectAll = () => { inputUrl.focus(); inputUrl.select(); };
                inputUrl.addEventListener('focus', selectAll);
                inputUrl.addEventListener('click', selectAll);
            }

            async function copiarTexto(texto) {
                try {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        await navigator.clipboard.writeText(texto);
                        return true;
                    }
                    const textarea = document.createElement('textarea');
                    textarea.value = texto;
                    textarea.setAttribute('readonly', '');
                    textarea.style.position = 'absolute';
                    textarea.style.left = '-9999px';
                    document.body.appendChild(textarea);
                    textarea.select();
                    const sucesso = document.execCommand('copy');
                    document.body.removeChild(textarea);
                    return sucesso;
                } catch (e) {
                    console.error('Erro ao copiar:', e);
                    return false;
                }
            }

            if (btnCopiar && inputUrl) {
                btnCopiar.addEventListener('click', async () => {
                    const texto = inputUrl.value;
                    if (!texto) return;
                    const ok = await copiarTexto(texto);
                    if (ok) {
                        if (btnLabelSpan) btnLabelSpan.textContent = 'Copiado!';
                        btnCopiar.classList.add('bg-emerald-700');
                        btnCopiar.disabled = true;
                        if (feedback) feedback.textContent = 'Link copiado.';
                        setTimeout(() => {
                            if (btnLabelSpan) btnLabelSpan.textContent = originalLabel;
                            btnCopiar.classList.remove('bg-emerald-700');
                            btnCopiar.disabled = false;
                            if (feedback) feedback.textContent = '';
                        }, 2000);
                    }
                });
            }


            // --- [NOVA LÓGICA] BAIXAR O CONVITE (PNG) ---

            const btnBaixarConvite = document.getElementById('btn-baixar-convite');
            const conviteElement = document.getElementById('div-convite-exportar');
            const btnBaixarLabel = document.getElementById('btn-baixar-convite-label');
            const originalBtnLabel = btnBaixarLabel ? btnBaixarLabel.textContent : 'Baixar Convite (PNG)';

            if (btnBaixarConvite && conviteElement && window.html2canvas) {
                btnBaixarConvite.addEventListener('click', () => {

                    if (btnBaixarLabel) btnBaixarLabel.textContent = 'Gerando imagem...';
                    btnBaixarConvite.disabled = true;

                    html2canvas(conviteElement, {
                        useCORS: true,
                        scale: 2 // Dobro da resolução
                    }).then(canvas => {
                        const imageURL = canvas.toDataURL('image/png');
                        const downloadLink = document.createElement('a');
                        downloadLink.href = imageURL;
                        downloadLink.download = 'convite-pixlist-{{ $slug }}.png';
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                        if (btnBaixarLabel) btnBaixarLabel.textContent = originalBtnLabel;
                        btnBaixarConvite.disabled = false;

                    }).catch(err => {
                        console.error('Erro ao gerar imagem do convite:', err);
                        if (btnBaixarLabel) btnBaixarLabel.textContent = 'Erro ao gerar';
                        btnBaixarConvite.disabled = false;
                    });
                });
            }
        });
    </script>

</x-admin-layout>
