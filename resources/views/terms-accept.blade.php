<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex p-3 bg-emerald-100 rounded-full mb-4">
                    <i data-lucide="scroll-text" class="w-8 h-8 text-emerald-600"></i>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Atualização de Termos
                </h1>

                <p class="text-sm sm:text-base text-gray-600 mt-2 leading-relaxed">
                    Para continuar com segurança no Pixlist, precisamos que você leia e aceite os termos e a política de privacidade.
                </p>
            </div>

            {{-- Link termos --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 mb-6 flex items-center justify-between gap-3">
                <span class="font-medium">Leia o documento completo:</span>

                {{-- PADRÃO: route('terms') --}}
                <a href="{{ route('terms') }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1 font-bold text-emerald-600 hover:underline">
                    Ver Termos
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
            </div>

            {{-- Form principal --}}
            <form method="POST" action="{{ route('terms.store') }}" class="space-y-5">
                @csrf

                <label class="flex items-start gap-3 cursor-pointer p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    <input
                        type="checkbox"
                        name="accept_terms"
                        value="1"
                        class="mt-1 w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                        required
                    >
                    <span class="text-sm text-gray-700 leading-relaxed">
                        Declaro que li e concordo com os
                        <a href="{{ route('terms') }}" target="_blank" rel="noopener" class="font-bold text-emerald-700 hover:underline">Termos de Uso</a>
                        e a
                        <a href="{{ route('terms') }}#privacidade" target="_blank" rel="noopener" class="font-bold text-emerald-700 hover:underline">Política de Privacidade</a>
                        do Pixlist.
                    </span>
                </label>

                @error('accept_terms')
                    <p class="text-sm text-red-600 font-semibold text-center">
                        {{ $message }}
                    </p>
                @enderror

                <button type="submit"
                        class="w-full px-4 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    Aceitar e acessar o painel
                </button>
            </form>

            {{-- Botão de sair (FORA do form principal) --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit"
                        class="w-full text-xs text-gray-400 hover:text-gray-600 underline">
                    Não concordo, quero sair da conta
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</x-guest-layout>
