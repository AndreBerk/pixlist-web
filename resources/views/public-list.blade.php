<x-guest-layout>
    {{-- ===========================
         HERO (Capa + headline)
    ============================ --}}
    <section id="page-lista-publica" class="relative">

        {{-- Alertas (pós-ação) --}}
        <div class="container mx-auto px-4 sm:px-6 mt-4 sm:mt-6 fixed top-0 inset-x-0 z-50 pointer-events-none">
            <div class="max-w-4xl mx-auto space-y-3 pointer-events-auto">
                @if (session('status') === 'pagamento-sucesso')
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-lg flex items-center gap-3 animate-bounce-in">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                        <div>
                            <p class="font-bold">Obrigado!</p>
                            <p class="text-sm">Seu presente foi registrado com sucesso.</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'foto-enviada')
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl shadow-lg flex items-center gap-3 animate-bounce-in">
                        <i data-lucide="camera" class="w-6 h-6 text-blue-600"></i>
                        <div>
                            <p class="font-bold">Foto enviada!</p>
                            <p class="text-sm">Ela aparecerá na galeria assim que os noivos aprovarem.</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'rsvp-success')
                    <div class="bg-purple-50 border border-purple-200 text-purple-800 p-4 rounded-xl shadow-lg flex items-center gap-3 animate-bounce-in">
                        <i data-lucide="party-popper" class="w-6 h-6 text-purple-600"></i>
                        <div>
                            <p class="font-bold">Presença confirmada!</p>
                            <p class="text-sm">Esperamos você lá.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Hero com imagem de fundo --}}
        <div class="relative w-full h-[420px] md:h-[580px] overflow-hidden">
            @if($list->cover_photo_url)
                <img src="{{ asset('storage/' . $list->cover_photo_url) }}"
                     alt="Foto de capa da lista"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 hover:scale-105">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-600 to-teal-500"></div>
            @endif

            {{-- Gradiente Overlay para leitura --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>

            <div class="relative z-10 h-full flex items-center justify-center text-center">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="max-w-4xl mx-auto text-white">

                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-1.5 mb-6 shadow-sm">
                            <i data-lucide="gift" class="w-4 h-4 text-emerald-300"></i>
                            <span class="text-xs font-bold tracking-widest uppercase text-emerald-100">Lista de Presentes</span>
                        </div>

                        <h1 id="tituloPublico" class="text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight tracking-tight drop-shadow-lg">
                            {{ $list->display_name }}
                        </h1>

                        <p class="text-lg sm:text-xl text-gray-200 mt-6 max-w-2xl mx-auto leading-relaxed font-light">
                            {{ $list->story ?: 'Obrigado por celebrar conosco este momento tão especial.' }}
                        </p>

                        {{-- BOTÕES DE AÇÃO DO HERO --}}
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="#presentes" class="w-full sm:w-auto px-8 py-4 rounded-full bg-emerald-500 text-white font-bold text-lg shadow-lg shadow-emerald-500/30 hover:bg-emerald-400 hover:scale-105 transition transform flex items-center justify-center gap-2">
                                <i data-lucide="gift" class="w-5 h-5"></i>
                                Presentear
                            </a>

                            {{-- [REGRA] Botão de Foto (Estilo Glass) - Só se ativado --}}
                            @if($list->gallery_enabled)
                                <button type="button" onclick="document.getElementById('modalFoto').showModal()"
                                    class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold text-lg hover:bg-white/20 hover:scale-105 transition transform flex items-center justify-center gap-2">
                                    <i data-lucide="camera" class="w-5 h-5"></i>
                                    Postar Foto
                                </button>
                            @endif

                            @if ($list->rsvp_enabled)
                                <a href="#rsvp" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white text-emerald-900 font-bold text-lg shadow-lg hover:bg-gray-100 hover:scale-105 transition transform flex items-center justify-center gap-2">
                                    <i data-lucide="calendar-check" class="w-5 h-5"></i>
                                    RSVP
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO DO EVENTO (Cards flutuantes) --}}
        @if ($list->event_date || $list->event_location)
            <div class="container mx-auto px-4 sm:px-6 -mt-16 relative z-20">
                <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if ($list->event_date)
                        @php
                            $eventDate = \Carbon\Carbon::parse($list->event_date);
                            $googleLink = "https://www.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($list->display_name) . "&dates=" . $eventDate->format('Ymd') . "/" . (clone $eventDate)->addDay()->format('Ymd');
                        @endphp
                        <a href="{{ $googleLink }}" target="_blank"
                           class="group bg-white p-6 rounded-2xl shadow-xl border border-gray-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition">
                                <i data-lucide="calendar" class="w-7 h-7 text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Data</p>
                                <p class="text-lg font-bold text-gray-900">{{ $eventDate->translatedFormat('d \d\e F \d\e Y') }}</p>
                                <p class="text-xs text-emerald-600 font-medium mt-1 group-hover:underline">Adicionar à agenda →</p>
                            </div>
                        </a>
                    @endif

                    @if ($list->event_location)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($list->event_location) }}" target="_blank"
                           class="group bg-white p-6 rounded-2xl shadow-xl border border-gray-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition">
                                <i data-lucide="map-pin" class="w-7 h-7 text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Local</p>
                                <p class="text-lg font-bold text-gray-900 line-clamp-1">{{ $list->event_location }}</p>
                                <p class="text-xs text-emerald-600 font-medium mt-1 group-hover:underline">Ver no mapa →</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- BARRA DE META --}}
        @if($list->meta_goal > 0)
            @php
                $percentual = ($list->meta_goal > 0) ? min(100, ($totalArrecadado / $list->meta_goal) * 100) : 0;
            @endphp
            <div class="container mx-auto px-4 sm:px-6 mt-12">
                <div class="max-w-2xl mx-auto">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                            {{ number_format($percentual, 0) }}% da meta
                        </span>
                        <span class="text-sm font-medium text-gray-500">
                            {{ number_format($totalArrecadado, 2, ',', '.') }} / {{ number_format($list->meta_goal, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentual }}%"></div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ========================================================
             A CÁPSULA DA GALERIA (SÓ APARECE SE ATIVADO)
        ======================================================== --}}
        @if($list->gallery_enabled)
        <div class="container mx-auto px-4 mt-12 mb-6" id="galeria-teaser">
            <div class="max-w-3xl mx-auto">
                <div class="bg-gray-900 rounded-2xl shadow-xl p-1 flex items-center justify-between transform transition hover:scale-[1.01] hover:shadow-2xl">

                    <a href="{{ route('list.gallery', $list) }}" class="flex items-center gap-4 px-4 py-3 flex-1 group">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition">
                                <i data-lucide="camera" class="w-5 h-5"></i>
                            </div>
                            @if(isset($photos) && $photos->count() > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-pink-500"></span>
                                </span>
                            @endif
                        </div>
                        <div class="text-left">
                            <h3 class="text-white font-bold text-sm leading-tight group-hover:text-pink-200 transition">Galeria da Festa</h3>
                            <p class="text-gray-400 text-xs">Veja fotos ou poste a sua</p>
                        </div>
                    </a>

                    <div class="flex items-center gap-1 pr-1">
                         <button type="button" onclick="document.getElementById('modalFoto').showModal()"
                            class="hidden sm:flex px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl transition items-center gap-2">
                            <i data-lucide="plus" class="w-3 h-3"></i> Postar
                        </button>

                        <a href="{{ route('list.gallery', $list) }}"
                           class="px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-xl hover:bg-gray-100 transition flex items-center gap-2">
                            Ver Fotos <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- LISTA DE PRESENTES (Grid) --}}
        <div class="container mx-auto px-4 sm:px-6 pb-16" id="presentes">
            <div class="max-w-6xl mx-auto">

                {{-- Filtros (Compactos) --}}
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    @php
                        $urlParams = ['list' => $list->id, 'slug' => \Illuminate\Support\Str::slug($list->display_name)];
                        $filtroParams  = array_merge($urlParams, ['ordenar' => $ordenar_ativo ?? null]);
                    @endphp
                    <a href="{{ route('list.public.show', array_merge($filtroParams, ['filtro' => 'todos'])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ $filtro_ativo == 'todos' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">Todos</a>
                    <a href="{{ route('list.public.show', array_merge($filtroParams, ['filtro' => 'disponiveis'])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ $filtro_ativo == 'disponiveis' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">Disponíveis</a>
                </div>

                <div id="gradeDePresentes" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                    @forelse($gifts as $gift)
                        @php
                            $esgotado = $gift->quantity_paid >= $gift->quantity;
                            $cotasRestantes = max(0, $gift->quantity - $gift->quantity_paid);
                        @endphp
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full overflow-hidden group">
                            <div class="relative aspect-square overflow-hidden bg-gray-50">
                                @if ($gift->image_url)
                                    @if (\Illuminate\Support\Str::startsWith($gift->image_url, 'gift_images/'))
                                        <img src="{{ asset('storage/' . $gift->image_url) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-emerald-200 group-hover:text-emerald-300 transition">
                                            <i data-lucide="{{ $gift->image_url }}" class="w-12 h-12"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold text-[10px] uppercase tracking-widest">Sem Foto</div>
                                @endif

                                <div class="absolute top-2 right-2">
                                    @if($esgotado)
                                        <span class="bg-gray-900/80 backdrop-blur text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm uppercase">Esgotado</span>
                                    @elseif($gift->quantity > 1)
                                        <span class="bg-emerald-600/90 backdrop-blur text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm uppercase">{{ $cotasRestantes }} cotas</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-3 flex flex-col flex-1">
                                <h3 class="font-bold text-gray-800 text-sm line-clamp-2 leading-tight mb-1 min-h-[2.5rem]">{{ $gift->title }}</h3>
                                <div class="mt-auto pt-2">
                                    <p class="text-lg font-extrabold text-emerald-600">R$ {{ number_format($gift->value, 2, ',', '.') }}</p>

                                    @if($esgotado)
                                        <button disabled class="mt-2 w-full py-2 rounded-lg bg-gray-100 text-gray-400 font-bold text-xs cursor-not-allowed">Indisponível</button>
                                    @else
                                        <button
                                            class="mt-2 w-full py-2 rounded-lg bg-gray-900 text-white font-bold text-xs hover:bg-gray-800 active:scale-95 transition flex items-center justify-center gap-1.5"
                                            data-presentear="{{ $gift->id }}"
                                            data-titulo="{{ $gift->title }}"
                                            data-valor="{{ $gift->value }}">
                                            Presentear
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="inline-flex p-4 rounded-full bg-gray-50 mb-3 text-gray-400">
                                <i data-lucide="search-x" class="w-8 h-8"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Nenhum presente encontrado.</p>
                            <a href="{{ route('list.public.show', $urlParams) }}" class="text-emerald-600 text-sm font-bold hover:underline mt-1 inline-block">Limpar filtros</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- MURAL DE RECADOS (Simples) --}}
        @if($transactions->count() > 0)
        <div class="bg-gray-50 py-12 border-t border-gray-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Mural de Recados</h3>
                </div>
                <div class="swiper-container max-w-xl mx-auto relative pb-8">
                    <div class="swiper-wrapper">
                        @foreach ($transactions as $tx)
                            <div class="swiper-slide px-4">
                                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm text-center">
                                    <p class="text-gray-600 text-sm italic leading-relaxed mb-3">"{{ $tx->guest_message ?: 'Um presente enviado com muito carinho!' }}"</p>
                                    <p class="font-bold text-emerald-700 text-xs uppercase tracking-wide">— {{ $tx->guest_name ?: 'Anônimo' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        @endif

        {{-- RSVP (Seção Final) --}}
        @if ($list->rsvp_enabled)
            <div class="bg-white py-16 border-t border-gray-100" id="rsvp">
                <div class="container mx-auto px-4 max-w-md">
                    <div class="text-center mb-6">
                        <span class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest">RSVP</span>
                        <h3 class="text-2xl font-extrabold text-gray-900">Confirmar Presença</h3>
                    </div>

                    <form action="{{ route('list.public.rsvp', $list) }}" method="POST" class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        @csrf
                        <input type="text" name="guest_name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Seu Nome Completo">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white p-2 rounded-xl border border-gray-200">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase ml-1 mb-1">Adultos</label>
                                <input type="number" name="adults" value="1" min="1" required class="w-full border-none p-0 text-center focus:ring-0 font-bold text-gray-800">
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-gray-200">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase ml-1 mb-1">Crianças</label>
                                <input type="number" name="children" value="0" min="0" required class="w-full border-none p-0 text-center focus:ring-0 font-bold text-gray-800">
                            </div>
                        </div>
                        <input type="text" name="contact" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="E-mail ou Telefone (Opcional)">
                        <button type="submit" class="w-full py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg">
                            Enviar Confirmação
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- BARRA FIXA MOBILE --}}
        <div class="fixed bottom-0 inset-x-0 z-40 bg-white/90 backdrop-blur-md border-t border-gray-200 pb-safe sm:hidden">
            <div class="grid {{ $list->gallery_enabled ? 'grid-cols-4' : 'grid-cols-2' }} h-16">

                {{-- Link Lista (Sempre presente) --}}
                <a href="#presentes" class="flex flex-col items-center justify-center text-gray-500 hover:text-emerald-600">
                    <i data-lucide="gift" class="w-5 h-5 mb-0.5"></i>
                    <span class="text-[9px] font-bold uppercase">Lista</span>
                </a>

                {{-- [REGRA] Botões da Galeria só se ativado --}}
                @if($list->gallery_enabled)
                    <a href="{{ route('list.gallery', $list) }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-purple-600 relative">
                        <i data-lucide="grid" class="w-5 h-5 mb-0.5"></i>
                        <span class="text-[9px] font-bold uppercase">Galeria</span>
                    </a>

                    <button type="button" onclick="document.getElementById('modalFoto').showModal()" class="flex flex-col items-center justify-center text-gray-500 hover:text-blue-600">
                        <i data-lucide="camera" class="w-5 h-5 mb-0.5"></i>
                        <span class="text-[9px] font-bold uppercase">Postar</span>
                    </button>
                @endif

                {{-- Link RSVP (Sempre presente se ativado) --}}
                @if ($list->rsvp_enabled)
                    <a href="#rsvp" class="flex flex-col items-center justify-center text-gray-500 hover:text-emerald-600">
                        <i data-lucide="calendar-check" class="w-5 h-5 mb-0.5"></i>
                        <span class="text-[9px] font-bold uppercase">RSVP</span>
                    </a>
                @endif
            </div>
        </div>

    </section>

    {{-- MODAL PIX --}}
    @include('public-modal-pix', ['pix_key' => $list->pix_key])

    {{-- MODAL UPLOAD FOTO (Apenas se galeria ativa) --}}
    @if($list->gallery_enabled)
    <dialog id="modalFoto" class="rounded-3xl p-0 w-full max-w-sm shadow-2xl backdrop:bg-black/80">
        <form method="POST" action="{{ route('public.photos.store', $list) }}" enctype="multipart/form-data" class="bg-white p-6 sm:p-8">
            @csrf
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Postar Foto</h3>
                <button type="button" onclick="document.getElementById('modalFoto').close()" class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                    <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
                </button>
            </div>

            <div class="space-y-5">
                <div class="border-2 border-dashed border-emerald-100 bg-emerald-50/30 rounded-2xl p-8 text-center cursor-pointer relative group hover:bg-emerald-50 transition">
                    <input type="file" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                    <div id="upload-placeholder" class="transition group-hover:scale-105">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="image-plus" class="w-6 h-6"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-700">Toque para escolher</p>
                    </div>
                    <img id="image-preview" class="hidden w-full h-40 object-contain rounded-xl mx-auto shadow-md">
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Seu Nome</label>
                        <input type="text" name="guest_name" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition" placeholder="Ex: Carol">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Legenda</label>
                        <input type="text" name="message" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition" placeholder="Ex: Amamos a festa!">
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition shadow-lg flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i> Enviar para Galeria
                </button>
            </div>
        </form>
    </dialog>
    @endif

    <script>
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

        // Lógica Modal PIX
        document.getElementById('gradeDePresentes')?.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-presentear]');
            if (!btn) return;
            const giftId = btn.dataset.presentear;
            const giftTitle = btn.dataset.titulo;
            const modal = document.getElementById('modalPix');
            const form = document.getElementById('formPixPagamento');
            const url = `{{ url('/pagar') }}/${giftId}`;
            form.action = url;
            modal.querySelector('#modalTitle').textContent = `Presentear: ${giftTitle}`;
            const pixKeyInput = modal.querySelector('#pixChave');
            if (pixKeyInput) pixKeyInput.value = "{{ $list->pix_key ?? 'CHAVE_PIX_NAO_CONFIGURADA' }}";
            modal.showModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
            if (window.Swiper) {
                new Swiper('.swiper-container', {
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    loop: true,
                    autoHeight: true,
                    slidesPerView: 1,
                    spaceBetween: 20,
                    pagination: { el: '.swiper-pagination', clickable: true }
                });
            }
        });
    </script>
    <style>
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>

</x-guest-layout>
