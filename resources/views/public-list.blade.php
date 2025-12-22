<x-guest-layout>
    {{--
       BIBLIOTECAS E ESTILOS GERAIS
    --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Esconde header padrão do layout */
        header, nav, .navbar { display: none !important; }
        body { padding-top: 0 !important; background-color: #f9fafb; }

        /* Ajustes Swiper (Carrossel) */
        .swiper-pagination-bullet-active { background-color: #059669 !important; }

        /* Previne zoom em inputs no iOS */
        input, textarea, select { font-size: 16px !important; }

        /* Rolagem suave */
        html { scroll-behavior: smooth; }
    </style>

    <section id="page-lista-publica" class="relative pb-24"> {{-- Padding bottom para não esconder conteúdo atrás do menu fixo --}}

        {{--
           1. ALERTAS FLUTUANTES (Toast Notifications)
        --}}
        <div class="fixed top-4 left-0 right-0 z-[60] px-4 pointer-events-none">
            <div class="max-w-md mx-auto space-y-2 pointer-events-auto">
                @if (session('status') === 'pagamento-sucesso')
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-xl flex items-center gap-3 animate-bounce-in">
                        <div class="bg-emerald-100 p-2 rounded-full"><i data-lucide="check" class="w-5 h-5 text-emerald-600"></i></div>
                        <div>
                            <p class="font-bold text-sm">Sucesso!</p>
                            <p class="text-xs">Seu presente foi registrado.</p>
                        </div>
                    </div>
                @endif
                @if (session('status') === 'foto-enviada')
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl shadow-xl flex items-center gap-3 animate-bounce-in">
                        <div class="bg-blue-100 p-2 rounded-full"><i data-lucide="camera" class="w-5 h-5 text-blue-600"></i></div>
                        <div>
                            <p class="font-bold text-sm">Foto enviada!</p>
                            <p class="text-xs">Aguardando aprovação.</p>
                        </div>
                    </div>
                @endif
                @if (session('status') === 'rsvp-success')
                    <div class="bg-purple-50 border border-purple-200 text-purple-800 p-4 rounded-xl shadow-xl flex items-center gap-3 animate-bounce-in">
                        <div class="bg-purple-100 p-2 rounded-full"><i data-lucide="party-popper" class="w-5 h-5 text-purple-600"></i></div>
                        <div>
                            <p class="font-bold text-sm">Confirmado!</p>
                            <p class="text-xs">Esperamos você lá.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{--
           2. HERO SECTION (CAPA)
           - Altura dinâmica (min-h) para caber bem em celulares.
           - Título responsivo.
        --}}
        <div class="relative w-full h-[65vh] md:h-[600px] overflow-hidden">
            @if($list->cover_photo_url)
                <img src="{{ asset('storage/' . $list->cover_photo_url) }}"
                     class="absolute inset-0 w-full h-full object-cover animate-fade-in">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-600 to-teal-500"></div>
            @endif

            {{-- Gradiente Escuro para Leitura --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-black/10"></div>

            <div class="relative z-10 h-full flex flex-col items-center justify-end pb-16 md:justify-center text-center px-6">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-3 py-1 mb-4 shadow-sm">
                    <i data-lucide="gift" class="w-3 h-3 text-emerald-300"></i>
                    <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-100">Lista de Presentes</span>
                </div>

                {{-- Título e História --}}
                <h1 class="text-3xl sm:text-5xl md:text-7xl font-black leading-tight tracking-tight text-white drop-shadow-lg mb-3">
                    {{ $list->display_name }}
                </h1>

                <p class="text-sm sm:text-lg text-gray-200 max-w-lg mx-auto leading-relaxed font-light line-clamp-3 md:line-clamp-none">
                    {{ $list->story ?: 'Bem-vindos à nossa lista de presentes virtual.' }}
                </p>

                {{-- Botão CTA Principal (Mobile) --}}
                <div class="mt-8 w-full max-w-xs md:hidden">
                    <a href="#presentes" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-500 py-3.5 font-bold text-white shadow-lg shadow-emerald-900/20 active:scale-95 transition">
                        <i data-lucide="arrow-down" class="w-5 h-5"></i>
                        Ver Presentes
                    </a>
                </div>
            </div>
        </div>

        {{--
           3. BARRA DE INFORMAÇÕES (Data e Local)
        --}}
        @if ($list->event_date || $list->event_location)
            <div class="bg-white border-b border-gray-100 py-3 shadow-sm sticky z-20 top-0">
                <div class="container mx-auto px-4 flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-6 text-xs sm:text-sm text-gray-600">

                    @if ($list->event_date)
                        @php $eventDate = \Carbon\Carbon::parse($list->event_date); @endphp
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-emerald-500"></i>
                            <span class="font-semibold text-gray-800">{{ $eventDate->translatedFormat('d \d\e F \d\e Y') }}</span>
                        </div>
                    @endif

                    @if ($list->event_location)
                        <div class="flex items-center gap-2 text-center line-clamp-1">
                            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                            <a href="https://maps.google.com/?q={{ urlencode($list->event_location) }}" target="_blank" class="underline decoration-dotted decoration-gray-400">
                                {{ $list->event_location }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{--
           4. BARRA DE PROGRESSO (Meta)
        --}}
        @if($list->meta_goal > 0)
            @php $percentual = min(100, ($totalArrecadado / $list->meta_goal) * 100); @endphp
            <div class="container mx-auto px-4 mt-8">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Meta dos Noivos</span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">{{ number_format($percentual, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $percentual }}%"></div>
                    </div>
                </div>
            </div>
        @endif

        {{--
           5. TEASER DA GALERIA (Só aparece se tiver galeria)
        --}}
        @if($list->gallery_enabled)
        <div class="container mx-auto px-4 mt-6">
            <div class="max-w-2xl mx-auto bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl shadow-lg p-4 flex items-center justify-between text-white relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12"></div>

                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i data-lucide="camera" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm leading-tight">Galeria da Festa</h3>
                        <p class="text-[10px] text-gray-300">Poste sua foto aqui!</p>
                    </div>
                </div>

                <a href="{{ route('list.gallery', $list) }}" class="relative z-10 px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-lg active:scale-95 transition">
                    Ver Fotos
                </a>
            </div>
        </div>
        @endif

        {{--
           6. LISTA DE PRESENTES (GRID)
        --}}
        <div id="presentes" class="container mx-auto px-4 mt-8 scroll-mt-24">

            {{-- Filtros (Estilo "Pílula") --}}
            <div class="flex justify-center gap-2 mb-6 overflow-x-auto no-scrollbar pb-2">
                @php
                    $params = ['list' => $list->id, 'slug' => \Illuminate\Support\Str::slug($list->display_name), 'ordenar' => $ordenar_ativo ?? null];
                @endphp
                <a href="{{ route('list.public.show', array_merge($params, ['filtro' => 'todos'])) }}"
                   class="px-5 py-2 rounded-full text-xs font-bold border transition whitespace-nowrap {{ $filtro_ativo == 'todos' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200' }}">
                   Todos
                </a>
                <a href="{{ route('list.public.show', array_merge($params, ['filtro' => 'disponiveis'])) }}"
                   class="px-5 py-2 rounded-full text-xs font-bold border transition whitespace-nowrap {{ $filtro_ativo == 'disponiveis' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200' }}">
                   Disponíveis
                </a>
            </div>

            {{-- Grid Responsivo (2 colunas no mobile, 3/4 no desktop) --}}
            <div id="gradeDePresentes" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                @forelse($gifts as $gift)
                    @php
                        $esgotado = $gift->quantity_paid >= $gift->quantity;
                        $restantes = max(0, $gift->quantity - $gift->quantity_paid);
                    @endphp

                    {{-- Card do Presente --}}
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col overflow-hidden relative group">

                        {{-- Imagem (Aspect Ratio 1:1) --}}
                        <div class="relative aspect-square bg-gray-50 overflow-hidden">
                            @if ($gift->image_url)
                                @if (\Illuminate\Support\Str::startsWith($gift->image_url, 'gift_images/'))
                                    <img src="{{ asset('storage/' . $gift->image_url) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-200">
                                        <i data-lucide="{{ $gift->image_url }}" class="w-10 h-10"></i>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-[10px] font-bold uppercase">Sem Foto</div>
                            @endif

                            {{-- Badges --}}
                            @if($esgotado)
                                <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                    <span class="bg-gray-900 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Esgotado</span>
                                </div>
                            @elseif($gift->quantity > 1)
                                <span class="absolute top-2 right-2 bg-emerald-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm">
                                    restam {{ $restantes }}
                                </span>
                            @endif
                        </div>

                        {{-- Conteúdo --}}
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-800 line-clamp-2 leading-snug min-h-[2.5em] mb-1">
                                {{ $gift->title }}
                            </h3>

                            <div class="mt-auto pt-2 border-t border-gray-50">
                                <p class="text-base sm:text-lg font-extrabold text-emerald-600">
                                    R$ {{ number_format($gift->value, 2, ',', '.') }}
                                </p>

                                @if(!$esgotado)
                                    <button
                                        class="mt-2 w-full py-2.5 rounded-lg bg-gray-900 text-white text-xs font-bold active:scale-95 transition hover:bg-gray-800"
                                        data-presentear="{{ $gift->id }}"
                                        data-titulo="{{ $gift->title }}"
                                        data-valor="{{ $gift->value }}">
                                        Presentear
                                    </button>
                                @else
                                    <button disabled class="mt-2 w-full py-2.5 rounded-lg bg-gray-100 text-gray-400 text-xs font-bold cursor-not-allowed">
                                        Indisponível
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="inline-flex p-3 rounded-full bg-gray-100 mb-3 text-gray-400">
                            <i data-lucide="search-x" class="w-6 h-6"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Nenhum presente nesta categoria.</p>
                        <a href="{{ route('list.public.show', $urlParams) }}" class="text-emerald-600 text-sm font-bold mt-2 inline-block">Ver todos</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{--
           7. MURAL DE RECADOS (Swiper)
        --}}
        @if($transactions->count() > 0)
        <div class="bg-gray-50 py-12 border-t border-gray-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Mural de Recados</h3>
                    <p class="text-xs text-gray-500">Mensagens de quem já presenteou</p>
                </div>

                <div class="swiper mySwiper pb-10">
                    <div class="swiper-wrapper">
                        @foreach ($transactions as $tx)
                            <div class="swiper-slide">
                                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center relative mx-2">
                                    <i data-lucide="quote" class="w-6 h-6 text-emerald-100 absolute top-4 left-4"></i>
                                    <p class="text-gray-600 text-sm italic mb-4 relative z-10 pt-2">
                                        "{{ $tx->guest_message ?: 'Um presente enviado com carinho!' }}"
                                    </p>
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px] flex items-center justify-center">
                                            {{ strtoupper(substr($tx->guest_name ?: 'A', 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-bold text-gray-900">{{ $tx->guest_name ?: 'Anônimo' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        @endif

        {{--
           8. RSVP (Formulário)
        --}}
        @if ($list->rsvp_enabled)
            <div class="bg-white py-12 border-t border-gray-100 scroll-mt-20" id="rsvp">
                <div class="container mx-auto px-4 max-w-lg">
                    <div class="text-center mb-6">
                        <span class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded">Confirmação</span>
                        <h3 class="text-2xl font-black text-gray-900 mt-2">Você vai ao evento?</h3>
                        <p class="text-sm text-gray-500">Ajude os noivos a organizar a festa.</p>
                    </div>

                    <form action="{{ route('list.public.rsvp', $list) }}" method="POST" class="space-y-3 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        @csrf
                        <input type="text" name="guest_name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Nome Completo">

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white p-2 rounded-xl border border-gray-200">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase text-center mb-1">Adultos</label>
                                <div class="flex items-center justify-center">
                                    <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-6 h-6 bg-gray-100 rounded text-gray-600">-</button>
                                    <input type="number" name="adults" value="1" min="1" required class="w-12 border-none p-0 text-center focus:ring-0 font-bold text-gray-800 text-lg bg-transparent">
                                    <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-6 h-6 bg-gray-100 rounded text-gray-600">+</button>
                                </div>
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-gray-200">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase text-center mb-1">Crianças</label>
                                <div class="flex items-center justify-center">
                                    <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-6 h-6 bg-gray-100 rounded text-gray-600">-</button>
                                    <input type="number" name="children" value="0" min="0" required class="w-12 border-none p-0 text-center focus:ring-0 font-bold text-gray-800 text-lg bg-transparent">
                                    <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-6 h-6 bg-gray-100 rounded text-gray-600">+</button>
                                </div>
                            </div>
                        </div>

                        <input type="text" name="contact" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Telefone ou E-mail (Opcional)">

                        <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg active:scale-95">
                            Confirmar Presença
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </section>

    {{--
       9. NAVEGAÇÃO INFERIOR FIXA (MOBILE)
       Essa barra garante acesso rápido às funções principais.
    --}}
    <div class="fixed bottom-0 inset-x-0 z-50 bg-white/95 backdrop-blur-md border-t border-gray-200 pb-safe sm:hidden">
        <div class="grid {{ ($list->gallery_enabled && $list->rsvp_enabled) ? 'grid-cols-4' : 'grid-cols-2' }} h-14">

            {{-- Botão Lista (Padrão) --}}
            <a href="#presentes" class="flex flex-col items-center justify-center text-gray-500 hover:text-emerald-600 active:text-emerald-700">
                <i data-lucide="gift" class="w-5 h-5 mb-0.5"></i>
                <span class="text-[9px] font-bold uppercase tracking-wide">Lista</span>
            </a>

            @if($list->gallery_enabled)
                {{-- Botão Galeria --}}
                <a href="{{ route('list.gallery', $list) }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-purple-600 active:text-purple-700">
                    <i data-lucide="grid" class="w-5 h-5 mb-0.5"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wide">Galeria</span>
                </a>

                {{-- Botão Postar Foto (Abre Modal) --}}
                <button type="button" onclick="document.getElementById('modalFoto').showModal()" class="flex flex-col items-center justify-center text-gray-500 hover:text-blue-600 active:text-blue-700">
                    <i data-lucide="camera" class="w-5 h-5 mb-0.5"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wide">Postar</span>
                </button>
            @endif

            @if($list->rsvp_enabled)
                {{-- Botão RSVP --}}
                <a href="#rsvp" class="flex flex-col items-center justify-center text-gray-500 hover:text-emerald-600 active:text-emerald-700">
                    <i data-lucide="calendar-check" class="w-5 h-5 mb-0.5"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wide">RSVP</span>
                </a>
            @endif
        </div>
    </div>

    {{-- INCLUDES: MODALS --}}
    @include('public-modal-pix', ['pix_key' => $list->pix_key])

    @if($list->gallery_enabled)
    <dialog id="modalFoto" class="rounded-3xl p-0 w-full max-w-sm shadow-2xl backdrop:bg-black/80 m-auto">
        <form method="POST" action="{{ route('public.photos.store', $list) }}" enctype="multipart/form-data" class="bg-white p-6">
            @csrf
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Postar Foto</h3>
                <button type="button" onclick="document.getElementById('modalFoto').close()" class="p-2 bg-gray-100 rounded-full">
                    <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
                </button>
            </div>

            <div class="space-y-4">
                {{-- Input Customizado de Arquivo --}}
                <div class="border-2 border-dashed border-gray-200 rounded-xl h-40 relative bg-gray-50 flex items-center justify-center group overflow-hidden">
                    <input type="file" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer" onchange="previewImage(this)">
                    <div id="upload-placeholder" class="text-center group-hover:scale-105 transition">
                        <i data-lucide="image-plus" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                        <p class="text-xs font-bold text-gray-500">Toque para escolher</p>
                    </div>
                    <img id="image-preview" class="hidden w-full h-full object-cover">
                </div>

                <input type="text" name="guest_name" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Seu Nome">
                <input type="text" name="message" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Legenda (opcional)">

                <button type="submit" class="w-full py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition">
                    Enviar Foto
                </button>
            </div>
        </form>
    </dialog>
    @endif

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Preview da imagem no modal
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Lógica do Modal PIX (Preenche dados dinâmicos)
        document.getElementById('gradeDePresentes')?.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-presentear]');
            if (!btn) return;
            const giftId = btn.dataset.presentear;
            const giftTitle = btn.dataset.titulo;
            const modal = document.getElementById('modalPix');
            const form = document.getElementById('formPixPagamento');

            // Ajusta a URL para o presente específico
            const url = `{{ url('/pagar') }}/${giftId}`;
            form.action = url;

            modal.querySelector('#modalTitle').textContent = giftTitle;
            const pixKeyInput = modal.querySelector('#pixChave');
            if (pixKeyInput) pixKeyInput.value = "{{ $list->pix_key ?? 'CHAVE_PIX_NAO_CONFIGURADA' }}";

            modal.showModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            // Swiper Mural
            new Swiper(".mySwiper", {
                slidesPerView: 1.1, // Mostra um pouco do próximo slide para incentivar rolagem
                spaceBetween: 16,
                centeredSlides: true,
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 30 }
                }
            });
        });
    </script>

    <style>
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fadeIn 1s ease-out; }
    </style>
</x-guest-layout>
