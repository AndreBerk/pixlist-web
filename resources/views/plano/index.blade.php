<x-admin-layout>

    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">

            {{--
               =========================================================
               1. ALERTAS DE SISTEMA (Refinados)
               =========================================================
            --}}
            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-100 p-4 animate-fade-in-up">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="x-circle" class="h-5 w-5 text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Atenção aos detalhes</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status') === 'pagamento-processando')
                 <div class="rounded-xl bg-blue-50 border border-blue-100 p-4 animate-fade-in-up">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="loader-2" class="h-5 w-5 text-blue-400 animate-spin"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Pagamento em Análise</h3>
                            <p class="mt-2 text-sm text-blue-700">
                                Estamos confirmando a transação com o banco. Seu painel atualizará automaticamente em instantes.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{--
               =========================================================
               2. CARD DE OFERTA / CHECKOUT
               =========================================================
            --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-emerald-900/10 border border-slate-100 overflow-hidden">

                {{-- Header Decorativo --}}
                <div class="relative bg-slate-900 px-6 py-10 text-center overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-transparent"></div>
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500 rounded-full blur-3xl opacity-20"></div>

                    <div class="relative z-10 flex justify-center mb-4">
                        <div class="h-16 w-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
                            <i data-lucide="crown" class="w-8 h-8 text-emerald-400"></i>
                        </div>
                    </div>
                    <h2 class="relative z-10 text-2xl font-bold text-white tracking-tight">
                        Ative seu Evento Premium
                    </h2>
                    <p class="relative z-10 mt-2 text-slate-400 text-sm">
                        Desbloqueie todos os recursos da PixList agora.
                    </p>
                </div>

                <div class="px-6 py-8 sm:p-8">

                    {{-- Preço e Benefícios --}}
                    <div class="text-center mb-8">
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 mb-4">
                            TAXA ÚNICA • SEM MENSALIDADE
                        </span>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-2xl font-medium text-slate-400 mt-2">R$</span>
                            <span class="text-6xl font-extrabold text-slate-900 tracking-tight">24,90</span>
                        </div>
                        <p class="text-slate-500 text-sm mt-2">Validade de 1 ano (365 dias)</p>
                    </div>

                    {{-- Lista de Vantagens (Social Proof) --}}
                    <ul class="space-y-4 mb-8 border-t border-b border-slate-100 py-6">
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
                            </div>
                            <span class="text-sm text-slate-600">Receba <strong>100% do valor</strong> dos presentes (Pix direto).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
                            </div>
                            <span class="text-sm text-slate-600">Página <strong>personalizada</strong> com fotos.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
                            </div>
                            <span class="text-sm text-slate-600">Acesso ilimitado ao <strong>RSVP</strong> e Galeria.</span>
                        </li>
                    </ul>

                    {{-- Botão de Ação --}}
                    <form action="{{ route('plano.pagar') }}" method="POST">
                        @csrf
                        <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-base font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                                <i data-lucide="qr-code" class="h-5 w-5 text-emerald-200 group-hover:text-emerald-100 transition-colors"></i>
                            </span>
                            Pagar com PIX Agora
                        </button>
                    </form>

                    <p class="mt-4 text-center text-xs text-slate-400">
                        Ambiente seguro. Liberação imediata após confirmação.
                    </p>
                </div>
            </div>

            {{-- Footer Links --}}
            <div class="flex items-center justify-center gap-6 text-sm">
                <a href="{{ route('profile.edit') }}" class="text-slate-500 hover:text-slate-800 font-medium transition-colors">
                    Alterar dados da conta
                </a>
                <span class="text-slate-300">|</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-red-600 font-medium transition-colors">
                        Sair
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</x-admin-layout>
