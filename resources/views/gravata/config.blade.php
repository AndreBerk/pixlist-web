<x-admin-layout>
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Configurar Roleta da Gravata</h2>

        <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
            <p class="text-gray-600 mb-6">
                Defina os valores que aparecerão na roleta. Adicione mais fatias para aumentar as chances de certos valores ou para criar uma roleta maior.
            </p>

            <form action="{{ route('gravata.update') }}" method="POST">
                @csrf
                <div id="slices-container" class="space-y-3">
                    @foreach($slices as $index => $slice)
                        <div class="slice-row flex items-center gap-3">
                            <div class="flex-1">
                                <label class="text-xs font-bold text-gray-500 uppercase">Texto / Valor</label>
                                <input type="text" name="slices[{{$index}}][label]" value="{{ $slice['label'] }}" required
                                       class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Cor</label>
                                <input type="color" name="slices[{{$index}}][color]" value="{{ $slice['color'] }}"
                                       class="h-10 w-16 p-1 rounded border border-gray-300 cursor-pointer block">
                            </div>
                            <div class="mt-5">
                                <button type="button" onclick="removeSlice(this)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="addSlice()" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Adicionar Fatia
                    </button>
                    <button type="submit" class="ml-auto px-6 py-2 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition shadow-lg">
                        Salvar Roleta
                    </button>
                </div>
            </form>
        </div>

        {{-- Preview Button --}}
        <div class="mt-8 text-center">
            <a href="{{ route('list.gravata', $list) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 font-bold hover:underline">
                <i data-lucide="play" class="w-4 h-4"></i> Testar o Jogo Agora
            </a>
        </div>
    </div>

    <script>
        function removeSlice(btn) {
            const rows = document.querySelectorAll('.slice-row');
            if (rows.length > 2) {
                btn.closest('.slice-row').remove();
            } else {
                alert('A roleta precisa de pelo menos 2 fatias!');
            }
        }

        function addSlice() {
            const container = document.getElementById('slices-container');
            const index = container.children.length;
            const colors = ['#34d399', '#fbbf24', '#f87171', '#60a5fa', '#a78bfa', '#f472b6'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];

            const html = `
                <div class="slice-row flex items-center gap-3 animate-bounce-in">
                    <div class="flex-1">
                        <input type="text" name="slices[${index}][label]" value="R$ 10" required
                               class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <input type="color" name="slices[${index}][color]" value="${randomColor}"
                               class="h-10 w-16 p-1 rounded border border-gray-300 cursor-pointer block">
                    </div>
                    <div class="">
                        <button type="button" onclick="removeSlice(this)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            if(window.lucide) window.lucide.createIcons();
        }

        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
