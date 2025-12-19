<x-admin-layout title="Moderação de Fotos">
    {{-- Cabeçalho da Página --}}
    <div class="mb-6 md:mb-8">
        <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
            Moderação de Fotos
        </h2>
        <p class="text-sm md:text-base text-gray-500 dark:text-slate-400 mt-1">
            Gerencie as fotos enviadas. Aprove ou exclua pelo celular ou computador.
        </p>
    </div>

    {{-- Feedback de Sucesso/Erro (Com animação) --}}
    @if (session('status') === 'foto-aprovada')
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 rounded-r-lg shadow-sm flex items-center gap-2 animate-fade-in-up">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <div><span class="font-bold">Sucesso!</span> Foto publicada.</div>
        </div>
    @endif
    @if (session('status') === 'foto-removida')
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 rounded-r-lg shadow-sm flex items-center gap-2 animate-fade-in-up">
            <i data-lucide="trash-2" class="w-5 h-5 flex-shrink-0"></i>
            <div><span class="font-bold">Removido!</span> Foto excluída.</div>
        </div>
    @endif

    <div class="space-y-10">

        {{-- =========================================================
             SEÇÃO 1: PENDENTES (Fila de Moderação)
             ========================================================= --}}
        <section>
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg text-amber-700 dark:text-amber-400">
                    <i data-lucide="clock" class="w-5 h-5 md:w-6 md:h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">Aguardando Aprovação</h3>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Visível apenas para você.</p>
                </div>
                <span class="ml-auto bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800 whitespace-nowrap">
                    {{ $pendingPhotos->count() }} pendentes
                </span>
            </div>

            @if($pendingPhotos->isEmpty())
                {{-- Empty State Pendentes --}}
                <div class="bg-white dark:bg-slate-800 border border-dashed border-gray-300 dark:border-slate-700 rounded-2xl p-8 text-center transition-colors duration-300">
                    <div class="w-14 h-14 bg-gray-50 dark:bg-slate-700 text-gray-300 dark:text-slate-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-7 h-7"></i>
                    </div>
                    <p class="text-gray-500 dark:text-slate-400 font-medium text-sm">Tudo limpo por aqui!</p>
                </div>
            @else
                {{-- Grid de Pendentes --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                    @foreach($pendingPhotos as $photo)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-md transition duration-300 flex flex-col">

                            {{-- Imagem --}}
                            <div class="relative aspect-square bg-gray-100 dark:bg-slate-700">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">
                                {{-- Link para ver original --}}
                                <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank" class="absolute top-2 right-2 bg-black/50 text-white p-1.5 rounded-full backdrop-blur-sm hover:bg-black/70 transition-colors">
                                    <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                </a>
                            </div>

                            {{-- Corpo do Card --}}
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="mb-4 flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="bg-gray-100 dark:bg-slate-700 p-1 rounded-full">
                                            <i data-lucide="user" class="w-3 h-3 text-gray-500 dark:text-slate-400"></i>
                                        </div>
                                        <span class="font-bold text-gray-800 dark:text-white text-sm truncate">
                                            {{ $photo->guest_name ?: 'Anônimo' }}
                                        </span>
                                    </div>
                                    @if($photo->message)
                                        <div class="bg-gray-50 dark:bg-slate-700/50 p-2.5 rounded-lg border border-gray-100 dark:border-slate-600">
                                            <p class="text-xs text-gray-600 dark:text-slate-300 italic leading-relaxed line-clamp-3">
                                                "{{ $photo->message }}"
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Botões de Ação (Grandes para Touch) --}}
                                <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-50 dark:border-slate-700">
                                    {{-- Botão Excluir --}}
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="w-full" onsubmit="return confirm('Rejeitar foto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 py-3 text-sm font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-xl active:scale-95 transition-colors">
                                            <i data-lucide="x" class="w-4 h-4"></i> Rejeitar
                                        </button>
                                    </form>

                                    {{-- Botão Aprovar --}}
                                    <form action="{{ route('photos.approve', $photo) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 py-3 text-sm font-bold text-white bg-emerald-600 dark:bg-emerald-500 hover:bg-emerald-700 dark:hover:bg-emerald-600 rounded-xl shadow-sm active:scale-95 transition-colors">
                                            <i data-lucide="check" class="w-4 h-4"></i> Aprovar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <hr class="border-gray-200 dark:border-slate-700">

        {{-- =========================================================
             SEÇÃO 2: APROVADAS (Mural Público)
             ========================================================= --}}
        <section>
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg text-blue-700 dark:text-blue-400">
                    <i data-lucide="image" class="w-5 h-5 md:w-6 md:h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">Mural Público</h3>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Visível no site.</p>
                </div>
                <span class="ml-auto bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 text-xs font-bold px-3 py-1 rounded-full border border-gray-200 dark:border-slate-600">
                    {{ $approvedPhotos->count() }}
                </span>
            </div>

            @if($approvedPhotos->isEmpty())
                <div class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl p-8 text-center border border-dashed border-gray-200 dark:border-slate-700">
                    <p class="text-gray-400 dark:text-slate-500 text-sm">O mural está vazio.</p>
                </div>
            @else
                {{-- Grid Galeria (Mobile: gap-2 | Desktop: gap-4) --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 md:gap-4">
                    @foreach($approvedPhotos as $photo)
                        <div class="group relative aspect-square bg-gray-100 dark:bg-slate-700 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-slate-600">

                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">

                            {{-- Legenda --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                <p class="text-white text-[10px] md:text-xs font-bold truncate">
                                    {{ $photo->guest_name ?: 'Anônimo' }}
                                </p>
                            </div>

                            {{-- Botão Excluir --}}
                            <div class="absolute top-1 right-1 md:top-2 md:right-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition duration-200">
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Remover do site?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 md:w-7 md:h-7 bg-white dark:bg-slate-800 text-red-500 dark:text-red-400 rounded-full flex items-center justify-center shadow-md hover:bg-red-500 hover:text-white dark:hover:bg-red-500 dark:hover:text-white transition-colors" title="Excluir">
                                        <i data-lucide="trash-2" class="w-4 h-4 md:w-3.5 md:h-3.5"></i>
                                    </button>
                                </form>
                            </div>

                            <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank" class="absolute inset-0 z-0"></a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
