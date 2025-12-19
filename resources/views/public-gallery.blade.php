<x-guest-layout>
    <div class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-800 via-gray-950 to-black text-gray-200 font-sans selection:bg-emerald-500 selection:text-white pb-20">

        <style>
            header, nav, .navbar { display: none !important; }
            body { padding-top: 0 !important; }
        </style>

        {{-- BOTÕES FLUTUANTES --}}
        <a href="{{ route('list.public.show', $list) }}" class="fixed top-4 left-4 z-50 p-3 bg-black/30 hover:bg-black/60 backdrop-blur-md rounded-full text-white transition group border border-white/5">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>

        <button onclick="document.getElementById('modalFoto').showModal()" class="fixed top-4 right-4 z-50 p-3 bg-emerald-600/80 hover:bg-emerald-600 backdrop-blur-md rounded-full text-white shadow-lg transition border border-emerald-500/50">
            <i data-lucide="camera" class="w-6 h-6"></i>
        </button>

        {{-- STATUS DE FEEDBACK --}}
        {{-- Caso 1: Foto publicada instantaneamente --}}
        @if (session('status') === 'foto-publicada')
            <div id="toast-success" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 bg-emerald-600/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 animate-bounce-in border border-emerald-400/30">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span class="text-sm font-bold">Sucesso! Foto publicada.</span>
            </div>
        @endif

        {{-- Caso 2: Foto foi para moderação --}}
        @if (session('status') === 'foto-enviada')
            <div id="toast-pending" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 bg-blue-600/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 animate-bounce-in border border-blue-400/30">
                <i data-lucide="clock" class="w-4 h-4"></i>
                <span class="text-sm font-bold">Foto enviada para aprovação!</span>
            </div>
        @endif

        @if (session('status') === 'comentario-enviado')
            <div id="toast-comment" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 bg-emerald-600/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 animate-bounce-in border border-emerald-400/30">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span class="text-sm font-bold">Comentário enviado!</span>
            </div>
        @endif

        @if ($errors->any())
            <div id="toast-error" class="fixed top-24 left-1/2 -translate-x-1/2 z-[60] bg-red-600/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 animate-bounce-in border border-red-400/30">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span class="text-sm font-bold">{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- GRID DE FOTOS --}}
        <main class="max-w-7xl mx-auto p-1 sm:p-4 pt-20">

            <div class="text-center mb-8 opacity-60">
                <span class="text-[10px] uppercase tracking-[0.2em] text-emerald-400 font-bold">Galeria VIP</span>
                <h1 class="text-white font-bold text-xl">{{ $list->display_name }}</h1>
            </div>

            @if($photos->isEmpty())
                <div class="flex flex-col items-center justify-center py-32 text-center">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-emerald-500 blur-2xl opacity-20 rounded-full"></div>
                        <div class="relative w-24 h-24 bg-white/5 rounded-full flex items-center justify-center border border-white/10 backdrop-blur-sm">
                            <i data-lucide="image" class="w-10 h-10 text-slate-400"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">A galeria está vazia</h2>
                    <p class="text-slate-400 max-w-md mx-auto mb-8 text-sm">Seja o primeiro a compartilhar um momento especial deste evento!</p>
                    <button onclick="document.getElementById('modalFoto').showModal()" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-full transition shadow-lg shadow-emerald-900/40 transform hover:scale-105 border border-emerald-500/50">
                        Postar Primeira Foto
                    </button>
                </div>
            @else
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-1 sm:gap-4">
                    @foreach($photos as $photo)
                        <div onclick="abrirStory({{ $photo->id }})" class="group relative aspect-square cursor-pointer overflow-hidden bg-slate-900 sm:rounded-lg border border-white/5 hover:border-white/20 transition-all duration-300">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:opacity-90"
                                 loading="lazy"
                                 alt="Foto de {{ $photo->guest_name }}">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                <div class="flex items-center gap-4 text-white font-bold text-sm">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="heart" class="w-4 h-4 fill-white"></i>
                                        <span>{{ $photo->likes_count }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="message-circle" class="w-4 h-4 fill-white"></i>
                                        <span>{{ $photo->comments_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL STORY --}}
                        <dialog id="story-{{ $photo->id }}" data-photo-id="{{ $photo->id }}" class="group/modal w-full h-full max-w-full max-h-full bg-transparent m-0 p-0 backdrop:bg-slate-950/95">
                            <div class="w-full h-full flex flex-col md:flex-row overflow-hidden">
                                {{-- LADO ESQUERDO: FOTO --}}
                                <div class="flex-1 bg-black/50 relative flex items-center justify-center overflow-hidden touch-none select-none">
                                    <button onclick="prevStory({{ $photo->id }})" class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/40 hover:bg-black/80 rounded-full items-center justify-center text-white transition z-50">
                                        <i data-lucide="chevron-left" class="w-8 h-8"></i>
                                    </button>
                                    <button onclick="nextStory({{ $photo->id }})" class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/40 hover:bg-black/80 rounded-full items-center justify-center text-white transition z-50">
                                        <i data-lucide="chevron-right" class="w-8 h-8"></i>
                                    </button>
                                    <div class="absolute inset-0 opacity-40 blur-3xl scale-125 pointer-events-none">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">
                                    </div>
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" class="relative max-w-full max-h-[85vh] md:max-h-full object-contain shadow-2xl z-10 rounded-lg md:rounded-none">
                                    <button onclick="document.getElementById('story-{{ $photo->id }}').close()" class="absolute top-4 left-4 p-2 bg-black/40 backdrop-blur-md rounded-full text-white md:hidden z-50 hover:bg-white/20 transition">
                                        <i data-lucide="x" class="w-6 h-6"></i>
                                    </button>
                                </div>

                                {{-- LADO DIREITO: CHAT --}}
                                <div class="w-full md:w-[400px] bg-slate-900 border-l border-white/5 flex flex-col h-[45vh] md:h-full shadow-2xl z-20 relative">
                                    <div class="p-4 border-b border-white/5 flex items-center gap-3 bg-slate-900 z-10 shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-500 p-[2px]">
                                            <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center text-sm font-bold text-white uppercase">
                                                {{ substr($photo->guest_name ?: 'A', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-sm text-white truncate">{{ $photo->guest_name ?: 'Convidado' }}</p>
                                            <p class="text-[10px] text-slate-400 uppercase tracking-wide">{{ $photo->created_at->diffForHumans() }}</p>
                                        </div>
                                        <button onclick="document.getElementById('story-{{ $photo->id }}').close()" class="hidden md:block p-2 text-slate-400 hover:text-white hover:bg-white/5 rounded-full transition">
                                            <i data-lucide="x" class="w-5 h-5"></i>
                                        </button>
                                    </div>

                                    <div class="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
                                        @if($photo->message)
                                            <div class="flex gap-3 mb-6">
                                                <div class="flex-1">
                                                    <p class="text-sm text-slate-300 leading-relaxed">
                                                        <span class="font-bold text-white mr-1">{{ $photo->guest_name ?: 'Autor' }}</span>
                                                        {{ $photo->message }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        @foreach($photo->comments as $comment)
                                            <div class="flex gap-3 group/comment">
                                                <div class="flex-1">
                                                    <p class="text-sm text-slate-400">
                                                        <span class="font-bold text-emerald-400 mr-1">{{ $comment->author_name }}</span>
                                                        {{ $comment->content }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($photo->comments->isEmpty() && !$photo->message)
                                            <div class="h-full flex flex-col items-center justify-center text-slate-600 space-y-2 opacity-50 mt-10">
                                                <i data-lucide="message-square" class="w-8 h-8"></i>
                                                <p class="text-xs">Sem comentários ainda.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4 border-t border-white/5 bg-slate-900 z-20 shrink-0">
                                        <div class="flex items-center gap-4 mb-4">
                                            <button onclick="toggleLike({{ $photo->id }})" id="btn-like-{{ $photo->id }}" class="group/btn transition transform active:scale-90 focus:outline-none">
                                                <i data-lucide="heart" class="w-7 h-7 transition-colors {{ $photo->liked ? 'fill-red-500 text-red-500' : 'text-slate-300 group-hover/btn:text-white' }}"></i>
                                            </button>
                                            <button onclick="document.getElementById('input-comment-{{ $photo->id }}').focus()" class="group/btn focus:outline-none transition transform active:scale-90">
                                                <i data-lucide="message-circle" class="w-7 h-7 text-slate-300 group-hover/btn:text-white"></i>
                                            </button>
                                        </div>
                                        <p class="text-sm font-bold text-white mb-4"><span id="likes-count-{{ $photo->id }}">{{ $photo->likes_count }}</span> curtidas</p>
                                        <form action="{{ route('photos.comment', $photo) }}" method="POST" class="flex gap-2 items-center bg-slate-800/50 rounded-full px-4 py-2 border border-slate-700 focus-within:border-slate-500 transition">
                                            @csrf
                                            <input type="hidden" name="author_name" value="Convidado">
                                            <input id="input-comment-{{ $photo->id }}" name="content" type="text" placeholder="Adicione um comentário..." class="flex-1 bg-transparent border-none text-white focus:ring-0 text-sm p-0 placeholder-slate-500" required autocomplete="off">
                                            <button type="submit" class="text-emerald-500 font-bold disabled:opacity-50 hover:text-emerald-400 uppercase tracking-wide text-xs">Publicar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </dialog>
                    @endforeach
                </div>
            @endif
        </main>

        <dialog id="modalFoto" class="rounded-3xl p-0 w-full max-w-sm shadow-2xl backdrop:bg-slate-900/80">
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
    </div>

    <script>
        const photoOrder = @json($photos->pluck('id'));

        function abrirStory(id) {
            const modal = document.getElementById('story-' + id);
            if (!modal) return;
            modal.showModal();
            document.body.style.overflow = 'hidden';
            modal.addEventListener('close', () => { document.body.style.overflow = ''; }, { once: true });
        }

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

        function attachSwipe(modal, id) {
            let startX = null;
            modal.addEventListener('touchstart', e => startX = e.touches[0].clientX);
            modal.addEventListener('touchend', e => {
                if(!startX) return;
                const endX = e.changedTouches[0].clientX;
                const diff = endX - startX;
                if(diff < -50) nextStory(id);
                if(diff > 50) prevStory(id);
                startX = null;
            });
        }

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

        async function toggleLike(photoId) {
            const btn = document.getElementById('btn-like-' + photoId);
            const icon = btn.querySelector('svg');
            const counter = document.getElementById('likes-count-' + photoId);
            const isLiked = icon.classList.contains('text-red-500');

            btn.classList.add('scale-75');
            setTimeout(() => btn.classList.remove('scale-75'), 150);

            if (isLiked) {
                icon.setAttribute('class', 'lucide lucide-heart w-7 h-7 text-slate-300 hover:text-white transition-colors');
                icon.style.fill = 'none';
                counter.innerText = Math.max(0, parseInt(counter.innerText) - 1);
            } else {
                icon.setAttribute('class', 'lucide lucide-heart w-7 h-7 text-red-500 transition-colors');
                icon.style.fill = 'currentColor';
                counter.innerText = parseInt(counter.innerText) + 1;
            }

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
            const toasts = document.querySelectorAll('[id^="toast-"]');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.add('opacity-0', '-translate-y-full');
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
            });
            document.querySelectorAll('dialog[id^="story-"]').forEach(modal => {
                const id = parseInt(modal.dataset.photoId);
                attachSwipe(modal, id);
            });
        });
    </script>
    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thumb-slate-700::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 20px; }
        .scrollbar-track-transparent::-webkit-scrollbar-track { background-color: transparent; }
        .text-shadow-sm { text-shadow: 0 1px 2px rgba(0,0,0,0.5); }
    </style>
</x-guest-layout>
