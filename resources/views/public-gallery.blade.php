<x-guest-layout>
    {{-- CONFIGURAÇÕES DE VIEWPORT E ESTILOS --}}
    <meta name="theme-color" content="#020617">
    <style>
        /* Reset para App-like experience */
        header, nav, .navbar { display: none !important; }
        body { padding-top: 0 !important; background-color: #020617; overscroll-behavior-y: none; }

        /* Previne zoom em inputs no iPhone */
        input, textarea { font-size: 16px !important; }

        /* Esconde scrollbar mas mantém funcionalidade */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Animações */
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5) translate(-50%, 0); opacity: 0; } 100% { transform: scale(1) translate(-50%, 0); opacity: 1; } }
    </style>

    <div class="min-h-screen bg-slate-950 text-gray-200 font-sans pb-24 selection:bg-emerald-500 selection:text-white">

        {{--
           1. CABEÇALHO FIXO E BOTÕES
        --}}
        <div class="fixed top-0 inset-x-0 z-40 bg-slate-950/80 backdrop-blur-md border-b border-white/5 px-4 h-16 flex items-center justify-between">
            <a href="{{ route('list.public.show', $list) }}" class="p-2 -ml-2 text-white hover:bg-white/10 rounded-full transition">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>

            <div class="text-center">
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 block leading-tight">Galeria VIP</span>
                <h1 class="text-white font-bold text-sm leading-tight truncate max-w-[200px]">{{ $list->display_name }}</h1>
            </div>

            {{-- Espaço vazio para equilibrar o flex --}}
            <div class="w-10"></div>
        </div>

        {{--
           2. FEEDBACK / TOASTS
        --}}
        <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4 pointer-events-none space-y-2">
            @if (session('status') === 'foto-publicada')
                <div class="bg-emerald-600 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce-in pointer-events-auto">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-bold">Foto publicada!</span>
                </div>
            @endif
            @if (session('status') === 'foto-enviada')
                <div class="bg-blue-600 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce-in pointer-events-auto">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                    <div>
                        <p class="text-sm font-bold">Foto enviada!</p>
                        <p class="text-xs opacity-90">Aguardando aprovação dos noivos.</p>
                    </div>
                </div>
            @endif
            @if (session('status') === 'comentario-enviado')
                <div class="bg-slate-800 text-white border border-slate-700 px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce-in pointer-events-auto">
                    <i data-lucide="message-circle" class="w-5 h-5 text-emerald-400"></i>
                    <span class="text-sm font-bold">Comentário enviado!</span>
                </div>
            @endif
        </div>

        {{--
           3. GRID DE FOTOS (MOSAICO)
        --}}
        <main class="pt-16 max-w-5xl mx-auto">
            @if($photos->isEmpty())
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-6">
                    <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mb-4 border border-white/10">
                        <i data-lucide="image" class="w-8 h-8 text-slate-500"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">Galeria vazia</h2>
                    <p class="text-slate-400 text-sm mb-8">Seja o primeiro a compartilhar um momento!</p>
                    <button onclick="document.getElementById('modalFoto').showModal()" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-full shadow-lg hover:scale-105 transition">
                        Postar Primeira Foto
                    </button>
                </div>
            @else
                {{-- Grid Otimizado: 3 colunas, gap mínimo --}}
                <div class="grid grid-cols-3 gap-0.5 sm:gap-4 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($photos as $photo)
                        <div onclick="abrirStory({{ $photo->id }})" class="relative aspect-square cursor-pointer bg-slate-900 overflow-hidden active:opacity-80 transition-opacity">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 alt="Foto">

                            {{-- Overlay Sutil com Curtidas (Visível sempre ou no hover) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 hover:opacity-100 transition-opacity flex items-end justify-start p-2">
                                <div class="flex items-center gap-1 text-white text-xs font-bold">
                                    <i data-lucide="heart" class="w-3 h-3 fill-white"></i> {{ $photo->likes_count }}
                                </div>
                            </div>
                        </div>

                        {{--
                           4. MODAL STORY (VISUALIZADOR)
                           Design otimizado: Imagem grande, chat em sheet inferior
                        --}}
                        <dialog id="story-{{ $photo->id }}" data-photo-id="{{ $photo->id }}" class="w-full h-full max-w-full max-h-full bg-black m-0 p-0 backdrop:bg-black/90">
                            <div class="w-full h-full flex flex-col md:flex-row relative">

                                {{-- Botão Fechar (Mobile: Flutuante Topo Esquerdo) --}}
                                <button onclick="document.getElementById('story-{{ $photo->id }}').close()" class="absolute top-4 left-4 z-50 p-2 bg-black/20 backdrop-blur-md rounded-full text-white md:hidden">
                                    <i data-lucide="x" class="w-6 h-6 shadow-sm"></i>
                                </button>

                                {{-- Área da Imagem (Swipe Zone) --}}
                                <div class="flex-1 relative bg-black flex items-center justify-center overflow-hidden touch-none" id="swipe-zone-{{ $photo->id }}">
                                    {{-- Blur Background --}}
                                    <div class="absolute inset-0 opacity-30 blur-3xl scale-125">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">
                                    </div>

                                    {{-- Imagem Principal --}}
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" class="relative max-w-full max-h-[60vh] md:max-h-full object-contain shadow-2xl z-10">

                                    {{-- Navegação Desktop --}}
                                    <button onclick="prevStory({{ $photo->id }})" class="hidden md:flex absolute left-4 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full items-center justify-center text-white z-50 transition">
                                        <i data-lucide="chevron-left" class="w-8 h-8"></i>
                                    </button>
                                    <button onclick="nextStory({{ $photo->id }})" class="hidden md:flex absolute right-4 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full items-center justify-center text-white z-50 transition">
                                        <i data-lucide="chevron-right" class="w-8 h-8"></i>
                                    </button>
                                </div>

                                {{-- Área de Interação (Bottom Sheet no Mobile) --}}
                                <div class="h-[40vh] md:h-full w-full md:w-[350px] bg-slate-900 border-t md:border-t-0 md:border-l border-white/10 flex flex-col rounded-t-3xl md:rounded-none z-20 shadow-[0_-10px_40px_rgba(0,0,0,0.5)] relative -mt-6 md:mt-0">

                                    {{-- Puxador Visual --}}
                                    <div class="w-12 h-1.5 bg-slate-700 rounded-full mx-auto mt-3 mb-1 md:hidden"></div>

                                    {{-- Header do Post --}}
                                    <div class="p-4 border-b border-white/5 flex items-center gap-3 shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 p-[2px]">
                                            <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center text-sm font-bold text-white uppercase">
                                                {{ substr($photo->guest_name ?: 'A', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-sm text-white">{{ $photo->guest_name ?: 'Convidado' }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $photo->created_at->diffForHumans() }}</p>
                                        </div>

                                        {{-- Like Button --}}
                                        <button onclick="toggleLike({{ $photo->id }})" id="btn-like-{{ $photo->id }}" class="flex items-center gap-1.5 bg-white/5 px-3 py-1.5 rounded-full transition active:scale-95">
                                            <i data-lucide="heart" class="w-5 h-5 transition-colors {{ $photo->liked ? 'fill-red-500 text-red-500' : 'text-white' }}"></i>
                                            <span id="likes-count-{{ $photo->id }}" class="text-xs font-bold text-white">{{ $photo->likes_count }}</span>
                                        </button>
                                    </div>

                                    {{-- Lista de Comentários --}}
                                    <div class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar">
                                        @if($photo->message)
                                            <div class="text-sm text-white/90 pb-4 border-b border-white/5">
                                                {{ $photo->message }}
                                            </div>
                                        @endif

                                        @forelse($photo->comments as $comment)
                                            <div class="flex gap-2 items-start animate-fade-in-up">
                                                <div class="flex-1 bg-slate-800/50 p-3 rounded-2xl rounded-tl-none border border-white/5">
                                                    <p class="text-xs font-bold text-emerald-400 mb-0.5">{{ $comment->author_name }}</p>
                                                    <p class="text-sm text-slate-200">{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            @if(!$photo->message)
                                                <div class="h-full flex flex-col items-center justify-center text-slate-600 opacity-60">
                                                    <i data-lucide="message-square-dashed" class="w-8 h-8 mb-2"></i>
                                                    <p class="text-xs">Seja o primeiro a comentar</p>
                                                </div>
                                            @endif
                                        @endforelse
                                    </div>

                                    {{-- Input de Comentário --}}
                                    <div class="p-3 bg-slate-900 border-t border-white/10">
                                        <form action="{{ route('photos.comment', $photo) }}" method="POST" class="flex gap-2 items-center">
                                            @csrf
                                            <input type="hidden" name="author_name" value="Convidado">
                                            <div class="flex-1 relative">
                                                <input name="content" type="text" placeholder="Escreva um comentário..."
                                                       class="w-full bg-slate-800 text-white rounded-full pl-4 pr-10 py-3 text-sm border border-slate-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 placeholder-slate-500"
                                                       required autocomplete="off">
                                            </div>
                                            <button type="submit" class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white shadow-lg disabled:opacity-50 active:scale-90 transition">
                                                <i data-lucide="send" class="w-4 h-4 ml-0.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </dialog>
                    @endforeach
                </div>
            @endif
        </main>

        {{--
           5. BOTÃO FLUTUANTE (FAB) DE AÇÃO
           Posicionado em baixo à direita, melhor para o polegar
        --}}
        <button onclick="document.getElementById('modalFoto').showModal()"
                class="fixed bottom-6 right-6 z-40 w-14 h-14 bg-emerald-500 hover:bg-emerald-400 text-white rounded-full shadow-xl shadow-emerald-500/30 flex items-center justify-center transition transform active:scale-90 border-4 border-slate-900">
            <i data-lucide="camera" class="w-7 h-7"></i>
        </button>

        {{--
           6. MODAL UPLOAD
        --}}
        <dialog id="modalFoto" class="rounded-3xl p-0 w-[90%] max-w-sm shadow-2xl backdrop:bg-black/80 open:animate-bounce-in">
            <form method="POST" action="{{ route('public.photos.store', $list) }}" enctype="multipart/form-data" class="bg-white p-6">
                @csrf
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-black text-gray-900">Nova Foto</h3>
                    <button type="button" onclick="document.getElementById('modalFoto').close()" class="p-2 bg-gray-100 rounded-full text-gray-500">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    {{-- Upload Area --}}
                    <div class="border-2 border-dashed border-emerald-200 bg-emerald-50 rounded-2xl h-48 relative flex items-center justify-center group overflow-hidden">
                        <input type="file" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer" onchange="previewImage(this)">

                        <div id="upload-placeholder" class="text-center group-hover:scale-105 transition">
                            <div class="w-12 h-12 bg-emerald-200 text-emerald-700 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="image-plus" class="w-6 h-6"></i>
                            </div>
                            <p class="text-sm font-bold text-emerald-800">Toque para selecionar</p>
                        </div>
                        <img id="image-preview" class="hidden w-full h-full object-contain bg-black/5">
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <input type="text" name="guest_name" class="w-full px-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 text-base focus:border-emerald-500 focus:ring-emerald-500" placeholder="Seu Nome">
                        <input type="text" name="message" class="w-full px-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 text-base focus:border-emerald-500 focus:ring-emerald-500" placeholder="Legenda (opcional)">
                    </div>

                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg active:scale-95 transition flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i> Publicar Agora
                    </button>
                </div>
            </form>
        </dialog>

    </div>

    {{-- SCRIPTS LÓGICOS --}}
    <script>
        const photoOrder = @json($photos->pluck('id'));

        function abrirStory(id) {
            const modal = document.getElementById('story-' + id);
            if (!modal) return;
            modal.showModal();
            document.body.style.overflow = 'hidden'; // Trava scroll do fundo

            // Adiciona swipe apenas quando abre
            attachSwipe(document.getElementById('swipe-zone-' + id), id);
        }

        // Fecha modal e destrava scroll
        document.querySelectorAll('dialog[id^="story-"]').forEach(dialog => {
            dialog.addEventListener('close', () => {
                document.body.style.overflow = '';
            });
        });

        function closeStory(id) {
            const modal = document.getElementById('story-' + id);
            if(modal && modal.open) modal.close();
        }

        function nextStory(id) {
            const index = photoOrder.indexOf(id);
            if(index < photoOrder.length - 1) {
                closeStory(id);
                abrirStory(photoOrder[index + 1]);
            }
        }

        function prevStory(id) {
            const index = photoOrder.indexOf(id);
            if(index > 0) {
                closeStory(id);
                abrirStory(photoOrder[index - 1]);
            }
        }

        // Lógica de Swipe (Arrastar para os lados)
        function attachSwipe(element, id) {
            if(!element) return;
            let startX = null;
            element.addEventListener('touchstart', e => startX = e.touches[0].clientX, {passive: true});
            element.addEventListener('touchend', e => {
                if(!startX) return;
                const endX = e.changedTouches[0].clientX;
                const diff = endX - startX;
                if(diff < -50) nextStory(id); // Swipe Left -> Next
                if(diff > 50) prevStory(id);  // Swipe Right -> Prev
                startX = null;
            }, {passive: true});
        }

        // Preview do Upload
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

        // Like assíncrono com feedback visual imediato
        async function toggleLike(photoId) {
            const btn = document.getElementById('btn-like-' + photoId);
            const icon = btn.querySelector('svg');
            const counter = document.getElementById('likes-count-' + photoId);
            const isLiked = icon.classList.contains('text-red-500');

            // Animação de pulso
            btn.classList.add('scale-75');
            setTimeout(() => btn.classList.remove('scale-75'), 150);

            // Atualização Otimista (UI first)
            if (isLiked) {
                icon.setAttribute('class', 'lucide lucide-heart w-5 h-5 text-white transition-colors');
                icon.style.fill = 'none';
                counter.innerText = Math.max(0, parseInt(counter.innerText) - 1);
            } else {
                icon.setAttribute('class', 'lucide lucide-heart w-5 h-5 text-red-500 transition-colors');
                icon.style.fill = 'currentColor';
                counter.innerText = parseInt(counter.innerText) + 1;
            }

            // Request silencioso
            try {
                await fetch(`/fotos/${photoId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
            } catch (e) { console.error('Erro like', e); }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            // Remove toasts automaticamente
            const toasts = document.querySelector('.fixed.top-20');
            if(toasts && toasts.children.length > 0) {
                setTimeout(() => {
                    toasts.classList.add('opacity-0', 'transition', 'duration-500');
                    setTimeout(() => toasts.remove(), 500);
                }, 4000);
            }
        });
    </script>
</x-guest-layout>
