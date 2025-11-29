<x-guest-layout>
    {{-- ===========================
          HERO (Capa + headline - SEU LAYOUT ORIGINAL MANTIDO)
    ============================ --}}
    <section id="page-lista-publica" class="relative bg-gray-50 pb-20">

        {{-- Alertas (pós-ação) --}}
        <div class="container mx-auto px-4 sm:px-6 mt-4 sm:mt-6 absolute top-0 z-50 left-0 right-0 pointer-events-none">
            <div class="max-w-4xl mx-auto space-y-3 pointer-events-auto">
                @if (session('status') === 'pagamento-sucesso')
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 sm:p-4 rounded-xl shadow-sm text-sm sm:text-base flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Obrigado! Seu presente foi registrado com sucesso.
                    </div>
                @endif

                @if (session('status') === 'rsvp-success')
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 sm:p-4 rounded-xl shadow-sm text-sm sm:text-base flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Presença confirmada! Esperamos você lá.
                    </div>
                @endif
            </div>
        </div>

        {{-- Hero com imagem de fundo --}}
        <div class="relative w-full h-[360px] sm:h-[420px] md:h-[520px] overflow-hidden">
            @if($list->cover_photo_url)
                <img src="{{ asset('storage/' . $list->cover_photo_url) }}" alt="Foto de capa da lista" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-700 to-emerald-500"></div>
            @endif

            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 h-full flex items-center">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="max-w-3xl text-white">
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 mb-3 sm:mb-4">
                            <i data-lucide="gift" class="w-4 h-4"></i>
                            <span class="text-xs sm:text-sm">Lista de Presentes dos Noivos</span>
                        </div>

                        <h1 id="tituloPublico" class="text-3xl sm:text-4xl md:text-6xl font-extrabold leading-tight">
                            {{ $list->display_name }}
                        </h1>

                        <p class="text-base sm:text-lg md:text-xl text-gray-100 mt-3 sm:mt-4 leading-relaxed">
                            {{ $list->story ?: 'Obrigado por celebrar conosco este momento tão especial.' }}
                        </p>

                        <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-2 sm:gap-3">
                            <a href="#presentes" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 sm:px-5 py-3 rounded-lg bg-white text-emerald-700 font-semibold shadow hover:shadow-md transition">
                                <i data-lucide="shopping-bag" class="w-5 h-5"></i> Ver presentes
                            </a>
                            @if ($list->rsvp_enabled)
                                <a href="#rsvp" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 sm:px-5 py-3 rounded-lg bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition">
                                    <i data-lucide="calendar-check" class="w-5 h-5"></i> Confirmar presença
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===========================
             INFO DO EVENTO (cards)
        ============================ --}}
        @if ($list->event_date || $list->event_location)
            <div class="container mx-auto px-4 sm:px-6 -mt-8 sm:-mt-10 md:-mt-12 relative z-20">
                <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    {{-- CARD: Data --}}
                    @if ($list->event_date)
                        @php
                            $eventDate = \Carbon\Carbon::parse($list->event_date);
                            $googleLink = "https://www.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($list->display_name) . "&dates=" . $eventDate->format('Ymd') . "/" . (clone $eventDate)->addDay()->format('Ymd');
                        @endphp
                        <a href="{{ $googleLink }}" target="_blank"
                           class="group bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition flex items-center gap-3 sm:gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <i data-lucide="calendar-plus" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-600"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs uppercase tracking-wide text-gray-500">Data do evento</p>
                                <p class="font-bold text-gray-900 text-sm sm:text-base">
                                    {{ $eventDate->translatedFormat('d \\d\\e F \\d\\e Y') }}
                                </p>
                            </div>
                        </a>
                    @endif

                    {{-- CARD: Local --}}
                    @if ($list->event_location)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($list->event_location) }}" target="_blank"
                           class="group bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition flex items-center gap-3 sm:gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <i data-lucide="map-pin" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-600"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs uppercase tracking-wide text-gray-500">Local</p>
                                <p class="font-bold text-gray-900 text-sm sm:text-base truncate">{{ $list->event_location }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- ===========================
             BARRA DE META / PROGRESSO
        ============================ --}}
        @if($list->meta_goal > 0)
            @php
                $percentual = $list->meta_goal > 0 ? min(100, ($totalArrecadado / $list->meta_goal) * 100) : 0;
            @endphp
            <div class="container mx-auto px-4 sm:px-6 mt-8 sm:mt-10">
                <div class="max-w-3xl mx-auto bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-lg">
                    <div class="flex items-start sm:items-center justify-between gap-3">
                        <p class="text-sm font-semibold text-gray-800">Meta de arrecadação</p>
                        <span class="text-[11px] sm:text-xs text-gray-500">{{ number_format($percentual, 0) }}% da meta</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 sm:h-3 mt-3 sm:mt-4 overflow-hidden">
                        <div class="bg-emerald-600 h-2.5 sm:h-3 rounded-full" style="width: {{ $percentual }}%"></div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===========================
                 LISTA DE PRESENTES (CORRIGIDA E RESPONSIVA)
        ============================ --}}
        <div class="container mx-auto px-4 sm:px-6 py-10 sm:py-12" id="presentes">
            <div class="max-w-6xl mx-auto">

                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">Lista de Presentes</h2>
                    <p class="text-gray-600 mt-2 text-sm sm:text-base">Escolha um item para presentear</p>
                </div>

                {{-- Filtros --}}
                @php
                    $urlParams = ['list' => $list->id, 'slug' => \Illuminate\Support\Str::slug($list->display_name)];
                    $filtroParams  = array_merge($urlParams, ['ordenar' => $ordenar_ativo ?? null]);
                    $ordenarParams = array_merge($urlParams, ['filtro'  => $filtro_ativo  ?? null]);
                @endphp

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex gap-2 w-full sm:w-auto overflow-x-auto pb-2 sm:pb-0">
                        <a href="{{ route('list.public.show', array_merge($filtroParams, ['filtro' => 'todos'])) }}"
                           class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide whitespace-nowrap transition {{ $filtro_ativo == 'todos' ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Todos
                        </a>
                        <a href="{{ route('list.public.show', array_merge($filtroParams, ['filtro' => 'disponiveis'])) }}"
                           class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide whitespace-nowrap transition {{ $filtro_ativo == 'disponiveis' ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Disponíveis
                        </a>
                        <a href="{{ route('list.public.show', array_merge($filtroParams, ['filtro' => 'esgotados'])) }}"
                           class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide whitespace-nowrap transition {{ $filtro_ativo == 'esgotados' ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Esgotados
                        </a>
                    </div>

                    <select id="ordenar" onchange="window.location = this.value;" class="w-full sm:w-auto border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="{{ route('list.public.show', array_merge($ordenarParams, ['ordenar' => 'preco_asc'])) }}" @selected($ordenar_ativo == 'preco_asc')>Menor Preço</option>
                        <option value="{{ route('list.public.show', array_merge($ordenarParams, ['ordenar' => 'preco_desc'])) }}" @selected($ordenar_ativo == 'preco_desc')>Maior Preço</option>
                    </select>
                </div>

                {{-- GRID: 2 colunas (Mobile) | 3 colunas (Tablet) | 4 colunas (PC) --}}
                <div id="gradeDePresentes" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                    @forelse($gifts as $gift)
                        @php
                            $esgotado = $gift->quantity_paid >= $gift->quantity;
                            $cotasRestantes = max(0, $gift->quantity - $gift->quantity_paid);
                        @endphp

                        {{-- CARD ORGANIZADO --}}
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-lg transition flex flex-col h-full">
                            
                            {{-- 1. FOTO NO TOPO (Quadrada e Isolada - Ninguém pisa aqui) --}}
                            <div class="relative w-full aspect-square bg-gray-100 flex-shrink-0">
                                @if ($gift->image_url)
                                    @if (\Illuminate\Support\Str::startsWith($gift->image_url, 'gift_images/'))
                                        <img src="{{ asset('storage/' . $gift->image_url) }}" class="w-full h-full object-cover" loading="lazy" alt="{{ $gift->title }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-emerald-200">
                                            <i data-lucide="{{ $gift->image_url }}" class="w-14 h-14"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="text-[10px] font-bold text-gray-300 uppercase">Sem Foto</span>
                                    </div>
                                @endif

                                {{-- ETIQUETAS (No rodapé da foto, pequenas) --}}
                                <div class="absolute bottom-0 left-0 right-0 p-2 flex justify-end bg-gradient-to-t from-black/50 to-transparent">
                                    @if($esgotado)
                                        <span class="bg-gray-900 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">Esgotado</span>
                                    @elseif($gift->quantity > 1)
                                        <span class="bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">
                                            Restam {{ $cotasRestantes }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- 2. TEXTO EM BAIXO (Separado da foto) --}}
                            <div class="p-3 flex flex-col flex-1 justify-between">
                                <div>
                                    {{-- Título com altura fixa (2 linhas) para alinhar a grade --}}
                                    <h3 class="text-xs sm:text-sm font-medium text-gray-900 leading-snug line-clamp-2 h-8 sm:h-10 mb-1" title="{{ $gift->title }}">
                                        {{ $gift->title }}
                                    </h3>
                                    <div class="text-emerald-700 font-bold text-sm sm:text-lg">
                                        R$ {{ number_format($gift->value, 2, ',', '.') }}
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @if($esgotado)
                                        <button disabled class="w-full py-2 rounded-lg bg-gray-100 text-gray-400 text-[10px] sm:text-xs font-bold uppercase tracking-wide cursor-not-allowed">
                                            Indisponível
                                        </button>
                                    @else
                                        <button 
                                            type="button"
                                            class="w-full py-2 rounded-lg bg-emerald-600 text-white text-[10px] sm:text-xs font-bold uppercase tracking-wide hover:bg-emerald-700 transition shadow-sm flex items-center justify-center gap-1.5"
                                            data-presentear="{{ $gift->id }}"
                                            data-titulo="{{ $gift->title }}"
                                            data-valor="{{ $gift->value }}"
                                        >
                                            <i data-lucide="heart" class="w-3.5 h-3.5"></i> Presentear
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-gray-200 text-gray-500">
                            <p>Nenhum presente encontrado com estes filtros.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===========================
                 RSVP (Versão Clássica)
        ============================ --}}
        @if ($list->rsvp_enabled)
            <div class="container mx-auto px-4 sm:px-6 pb-24 sm:pb-16" id="rsvp">
                <div class="max-w-3xl mx-auto bg-white p-5 sm:p-8 rounded-2xl border border-gray-100 shadow-lg">
                    <div class="text-center mb-5 sm:mb-6">
                        <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs sm:text-sm font-semibold mb-2">
                            <i data-lucide="calendar" class="w-4 h-4"></i> RSVP
                        </div>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900">Confirme sua presença</h3>
                    </div>

                    <form action="{{ route('list.public.rsvp', $list) }}" method="POST" class="max-w-xl mx-auto space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Seu nome</label>
                            <input type="text" name="guest_name" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nome completo">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Adultos</label>
                                <input type="number" name="adults" value="1" min="1" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Crianças</label>
                                <input type="number" name="children" value="0" min="0" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contato (opcional)</label>
                            <input type="text" name="contact" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="E-mail ou telefone">
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition">
                            Enviar confirmação
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- ===========================
                 MURAL DE RECADOS
        ============================ --}}
        <div class="container mx-auto px-4 sm:px-6 pb-28 sm:pb-20">
            <div class="max-w-4xl mx-auto text-center mb-8">
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900">Mural de Recados</h3>
            </div>
            <div class="swiper-container relative max-w-4xl mx-auto">
                <div class="swiper-wrapper">
                    @forelse ($transactions as $tx)
                        <div class="swiper-slide px-2 py-4">
                            <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-lg text-center">
                                <p class="text-gray-700 italic text-lg">“{{ $tx->guest_message ?: 'Um presente com carinho' }}”</p>
                                <p class="font-bold text-emerald-700 mt-4">{{ $tx->guest_name ?: 'Anônimo' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide px-2 py-4">
                            <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow text-center text-gray-500">
                                Ainda não há recados.
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>

        {{-- Barra de ações fixa (MOBILE) --}}
        <div class="fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur border-t border-gray-200 p-3 sm:hidden">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-2 gap-3">
                    <a href="#presentes" class="inline-flex items-center justify-center gap-2 px-3 py-3 rounded-lg bg-emerald-50 text-emerald-700 font-semibold">
                        <i data-lucide="gift" class="w-5 h-5"></i> Presentes
                    </a>
                    @if ($list->rsvp_enabled)
                        <a href="#rsvp" class="inline-flex items-center justify-center gap-2 px-3 py-3 rounded-lg bg-emerald-600 text-white font-semibold">
                            <i data-lucide="calendar-check" class="w-5 h-5"></i> RSVP
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Modal PIX --}}
    @include('public-modal-pix', ['pix_key' => $list->pix_key])

    {{-- Scripts --}}
    <script>
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
            modal.querySelector('#pixChave').value = modal.dataset.pixKey;
            modal.showModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
            if (window.Swiper) {
                new Swiper('.swiper-container', {
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: { 640: { slidesPerView: 1 } },
                    pagination: { el: '.swiper-pagination', clickable: true }
                });
            }
        });
    </script>
</x-guest-layout>