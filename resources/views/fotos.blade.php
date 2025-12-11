<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">
            Galeria de Fotos
        </h2>
    </div>

    @if (session('status') === 'foto-aprovada')
        <div class="mb-4 p-4 text-sm font-medium text-green-800 bg-green-100 rounded-lg">Foto aprovada com sucesso!</div>
    @endif
    @if (session('status') === 'foto-removida')
        <div class="mb-4 p-4 text-sm font-medium text-red-800 bg-red-100 rounded-lg">Foto removida.</div>
    @endif

    <div class="grid grid-cols-1 gap-8">

        {{-- SECÇÃO: PENDENTES --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center gap-2">
                <i data-lucide="clock" class="w-5 h-5"></i> Aguardando Aprovação ({{ $pendingPhotos->count() }})
            </h3>

            @if($pendingPhotos->isEmpty())
                <p class="text-amber-700/60 text-sm italic">Nenhuma foto pendente no momento.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($pendingPhotos as $photo)
                        <div class="bg-white rounded-lg shadow p-3">
                            <div class="aspect-square rounded-md overflow-hidden bg-gray-100 mb-3 relative group">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank" class="text-white text-xs underline">Ver original</a>
                                </div>
                            </div>
                            <p class="font-bold text-sm truncate">{{ $photo->guest_name ?: 'Anônimo' }}</p>
                            @if($photo->message)
                                <p class="text-xs text-gray-500 line-clamp-2 mt-1">"{{ $photo->message }}"</p>
                            @endif

                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('photos.approve', $photo) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-xs font-bold transition">
                                        Aprovar
                                    </button>
                                </form>
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded text-xs transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- SECÇÃO: APROVADAS --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i data-lucide="image" class="w-5 h-5"></i> Mural Público ({{ $approvedPhotos->count() }})
            </h3>

            @if($approvedPhotos->isEmpty())
                <p class="text-gray-400 text-sm italic">Nenhuma foto publicada ainda.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($approvedPhotos as $photo)
                        <div class="relative group">
                            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">
                            </div>
                            {{-- Botão de apagar (aparece no hover) --}}
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Excluir esta foto do mural?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-1.5 bg-red-600 text-white rounded-full shadow-lg hover:bg-red-700">
                                        <i data-lucide="trash" class="w-3 h-3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
