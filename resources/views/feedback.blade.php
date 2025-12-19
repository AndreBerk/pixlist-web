<x-admin-layout title="Enviar Feedback">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
            Enviar Feedback
        </h2>

        @if (session('status') === 'feedback-sent')
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-xl flex items-center gap-3 text-emerald-800 dark:text-emerald-300 animate-bounce-in">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
                <div>
                    <p class="font-bold">Obrigado!</p>
                    <p class="text-sm">Recebemos sua mensagem. Sua opinião é muito importante para nós.</p>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 md:p-8 transition-colors duration-300">
            <p class="text-gray-600 dark:text-slate-400 mb-6">
                Encontrou algum erro? Tem alguma sugestão de melhoria? Ou apenas quer elogiar?
                Escreva abaixo, lemos tudo!
            </p>

            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Tipo de mensagem</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                        {{-- Sugestão --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="sugestao" class="peer sr-only" checked>
                            <div class="px-4 py-2 rounded-lg border border-gray-200 dark:border-slate-600 text-center text-sm text-gray-600 dark:text-slate-400
                                        hover:bg-gray-50 dark:hover:bg-slate-700 transition
                                        peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30
                                        peer-checked:border-emerald-500 dark:peer-checked:border-emerald-500
                                        peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">
                                💡 Sugestão
                            </div>
                        </label>

                        {{-- Erro --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="erro" class="peer sr-only">
                            <div class="px-4 py-2 rounded-lg border border-gray-200 dark:border-slate-600 text-center text-sm text-gray-600 dark:text-slate-400
                                        hover:bg-gray-50 dark:hover:bg-slate-700 transition
                                        peer-checked:bg-red-50 dark:peer-checked:bg-red-900/30
                                        peer-checked:border-red-500 dark:peer-checked:border-red-500
                                        peer-checked:text-red-700 dark:peer-checked:text-red-400">
                                🐛 Erro
                            </div>
                        </label>

                        {{-- Elogio --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="elogio" class="peer sr-only">
                            <div class="px-4 py-2 rounded-lg border border-gray-200 dark:border-slate-600 text-center text-sm text-gray-600 dark:text-slate-400
                                        hover:bg-gray-50 dark:hover:bg-slate-700 transition
                                        peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/30
                                        peer-checked:border-yellow-500 dark:peer-checked:border-yellow-500
                                        peer-checked:text-yellow-700 dark:peer-checked:text-yellow-400">
                                ⭐ Elogio
                            </div>
                        </label>

                        {{-- Outro --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="outro" class="peer sr-only">
                            <div class="px-4 py-2 rounded-lg border border-gray-200 dark:border-slate-600 text-center text-sm text-gray-600 dark:text-slate-400
                                        hover:bg-gray-50 dark:hover:bg-slate-700 transition
                                        peer-checked:bg-gray-100 dark:peer-checked:bg-slate-700
                                        peer-checked:border-gray-500 dark:peer-checked:border-slate-500
                                        peer-checked:text-gray-900 dark:peer-checked:text-white">
                                💬 Outro
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Sua mensagem</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-gray-400 dark:placeholder-slate-500"
                        placeholder="Descreva aqui..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-gray-900 dark:bg-emerald-600 text-white font-bold rounded-xl hover:bg-black dark:hover:bg-emerald-700 transition shadow-lg flex items-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i> Enviar Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });
    </script>
</x-admin-layout>
