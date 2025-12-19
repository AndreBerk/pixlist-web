<x-admin-layout>

    <div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full relative">

            {{-- Efeitos de Fundo (Glow) --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-emerald-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>

            <div class="bg-white rounded-3xl shadow-2xl shadow-emerald-900/10 border border-emerald-100 p-8 text-center relative overflow-hidden animate-fade-in-up">

                {{-- Decoração de "Confetes" sutis no fundo --}}
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                    <i data-lucide="sparkles" class="absolute top-10 left-10 text-yellow-400 w-6 h-6 animate-bounce" style="animation-delay: 0.1s"></i>
                    <i data-lucide="star" class="absolute top-20 right-10 text-emerald-300 w-4 h-4 animate-spin" style="animation-duration: 3s"></i>
                    <i data-lucide="party-popper" class="absolute bottom-10 left-10 text-indigo-300 w-5 h-5 -rotate-12"></i>
                </div>

                {{-- Ícone de Sucesso --}}
                <div class="relative z-10 mb-6 inline-flex">
                    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center relative">
                        {{-- Anel animado --}}
                        <div class="absolute inset-0 rounded-full border-4 border-emerald-100 animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite]"></div>

                        <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/40">
                             <i data-lucide="check" class="w-8 h-8 text-white stroke-[3]"></i>
                        </div>
                    </div>
                </div>

                {{-- Textos --}}
                <div class="relative z-10 space-y-4 mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Pagamento Confirmado!
                    </h2>

                    <p class="text-slate-500 text-lg leading-relaxed">
                        Sua lista está oficialmente <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Ativa</span>.
                        <br class="hidden sm:block">
                        Parabéns pelo evento! Agora é só aproveitar.
                    </p>
                </div>

                {{-- Detalhes do Pedido (Resumo Rápido) --}}
                <div class="relative z-10 bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-8 mx-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Status</span>
                        <span class="font-bold text-emerald-600 flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Premium Ativo
                        </span>
                    </div>
                    <div class="h-px bg-slate-200 my-3"></div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Validade</span>
                        <span class="font-bold text-slate-700">365 dias</span>
                    </div>
                </div>

                {{-- Botão de Ação Principal --}}
                <div class="relative z-10">
                    <a href="{{ route('dashboard') }}"
                       class="group inline-flex items-center justify-center w-full px-6 py-4 bg-emerald-600 text-white text-lg font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:bg-emerald-500 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-200">
                        <span>Acessar meu Dashboard</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <p class="mt-4 text-xs text-slate-400">
                        Você receberá o comprovante por e-mail.
                    </p>
                </div>

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
