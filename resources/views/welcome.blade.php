<x-guest-layout>
    {{--
       HERO SECTION
       - Ajuste mobile: Mockup agora visível.
       - Botões: w-full no mobile para facilitar o toque.
       - Texto: Tamanhos ajustados para não quebrar em telas pequenas.
    --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-700">
        {{-- Background Effects --}}
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.25)_0,transparent_35%),radial-gradient(circle_at_80%_30%,rgba(255,255,255,0.18)_0,transparent_35%)]"></div>
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.08)_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="relative max-w-7xl mx-auto px-5 pt-16 pb-12 lg:pt-32 lg:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-center">

                {{-- Copy --}}
                <div class="text-center lg:text-left order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-3 py-1.5 backdrop-blur mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span class="text-[10px] sm:text-xs font-bold tracking-wide uppercase text-emerald-50">
                            PIX direto na conta • sem taxas
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black tracking-tight text-white leading-[1.1]">
                        Presentes que viram
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 to-teal-200">
                            dinheiro na hora.
                        </span>
                    </h1>

                    <p class="mt-4 sm:mt-6 text-base sm:text-xl text-emerald-50/80 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Crie sua lista de casamento ou aniversário. Seus convidados presenteiam e você recebe <strong class="text-white">100% do valor via PIX</strong>.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-white px-8 py-4 font-extrabold text-emerald-900 shadow-lg shadow-black/10 active:scale-95 hover:shadow-xl hover:-translate-y-0.5 transition">
                            Começar teste grátis
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>

                        <a href="#como-funciona"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 px-8 py-4 font-semibold text-white border border-white/15 active:scale-95 hover:bg-white/15 transition">
                            <i data-lucide="play-circle" class="w-5 h-5"></i>
                            Como funciona
                        </a>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-x-4 gap-y-2 justify-center lg:justify-start text-xs sm:text-sm text-emerald-50/60 font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> 7 dias grátis
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Cancela fácil
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Sem cartão
                        </span>
                    </div>
                </div>

                {{-- Mockup (Agora visível e otimizado para Mobile) --}}
                <div class="order-1 lg:order-2 px-4 sm:px-10 lg:px-0">
                    <div class="relative mx-auto max-w-[320px] lg:max-w-none">
                        {{-- Efeito de Blur atrás --}}
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-emerald-400/20 blur-3xl rounded-full"></div>

                        <div class="relative rounded-[2rem] border border-white/15 bg-white/5 backdrop-blur p-2 shadow-2xl rotate-[-2deg] hover:rotate-0 transition duration-500">
                            <div class="overflow-hidden rounded-[1.6rem] bg-white shadow-inner">
                                {{-- Imagem do produto --}}
                                <div class="aspect-[4/3] bg-gray-100 relative group">
                                    <img
                                        src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop"
                                        alt="Pixlist"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                                        loading="lazy"
                                    >
                                    {{-- Overlay Gradiente --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>
                                </div>

                                {{-- Notificação Simulada --}}
                                <div class="p-4 bg-white relative">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                                <i data-lucide="gift" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Novo Pix Recebido</p>
                                                <p class="text-sm font-bold text-gray-900 leading-tight">Presente da Tia Maria</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-emerald-600 font-black text-base">+ R$ 250</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Selos Mobile --}}
            <div class="mt-12 lg:mt-16 pt-8 border-t border-white/10">
                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-emerald-100/60 text-xs font-semibold uppercase tracking-widest">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Site Seguro
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="lock" class="w-4 h-4"></i> Dados Criptografados
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="qr-code" class="w-4 h-4"></i> Pagamento Instantâneo
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{--
       COMO FUNCIONA
       - Ajuste: Espaçamento reduzido (py-12).
       - Cards: Design mais limpo.
    --}}
    <section id="como-funciona" class="py-12 lg:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-emerald-600 font-bold tracking-wider text-xs uppercase bg-emerald-50 px-3 py-1 rounded-full">Passo a passo</span>
                <h2 class="mt-4 text-2xl md:text-4xl font-black text-gray-900">Simples. Rápido. Seguro.</h2>
                <p class="mt-3 text-base text-gray-500">
                    Em menos de 2 minutos seu site está no ar.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $steps = [
                        ['icon' => 'pen-tool', 't' => '1. Crie sua lista', 'd' => 'Personalize com foto e selecione presentes.'],
                        ['icon' => 'share-2', 't' => '2. Compartilhe', 'd' => 'Envie o link ou QR Code no WhatsApp.'],
                        ['icon' => 'wallet', 't' => '3. Receba PIX', 'd' => 'O dinheiro cai na hora na sua conta.'],
                    ];
                @endphp

                @foreach($steps as $s)
                    <div class="group bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-white shadow-sm text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform group-hover:bg-emerald-600 group-hover:text-white">
                            <i data-lucide="{{ $s['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $s['t'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $s['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{--
       FEATURES
       - Ajuste: Grid responsivo melhorado.
    --}}
    <section class="py-12 lg:py-20 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">

                {{-- Feature Card --}}
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 flex gap-4 items-start">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <i data-lucide="camera" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Galeria Interativa</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Seus convidados postam fotos do evento num mural exclusivo.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 flex gap-4 items-start">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                        <i data-lucide="dices" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Roleta da Gravata</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Substitua a gravata tradicional por um jogo divertido de arrecadação.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 flex gap-4 items-start">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Gestão de RSVP</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Saiba exatamente quem vai. Confirmação simples e rápida.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 flex gap-4 items-start">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <i data-lucide="badge-percent" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Sem Taxas Ocultas</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            O convidado faz o PIX direto para sua chave. 100% seu.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--
       PRICING
       - Ajuste: Destaque visual forte para o plano recomendado.
       - Botões: Largura total.
    --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-5">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-gray-900">Quanto custa?</h2>
                <p class="mt-2 text-gray-500">Transparência total. Sem mensalidade.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

                {{-- Plano Grátis --}}
                <div class="rounded-3xl border border-gray-200 bg-white p-6 md:p-8 order-2 md:order-1">
                    <h3 class="text-lg font-bold text-gray-900">Teste Grátis</h3>
                    <p class="text-sm text-gray-500">Para experimentar.</p>
                    <div class="my-6">
                        <span class="text-4xl font-black text-gray-900">R$ 0</span>
                        <span class="text-gray-400 text-sm">/ 7 dias</span>
                    </div>
                    <ul class="space-y-3 text-sm text-gray-600 mb-8">
                        <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Todas as funções</li>
                        <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600"></i> Sem cartão de crédito</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 rounded-xl border-2 border-gray-900 text-center font-bold text-gray-900 hover:bg-gray-50 transition active:scale-95">
                        Começar Teste
                    </a>
                </div>

                {{-- Plano Pago (Destaque) --}}
                <div class="relative rounded-3xl bg-gradient-to-b from-emerald-800 to-emerald-900 p-6 md:p-8 text-white shadow-2xl shadow-emerald-200 order-1 md:order-2 transform md:scale-105">
                    <div class="absolute top-0 right-0 -mt-3 mr-4 bg-amber-400 text-amber-900 text-[10px] font-black uppercase px-3 py-1 rounded-full shadow-sm">
                        Mais Vendido
                    </div>

                    <h3 class="text-lg font-bold text-white">Acesso Vitalício</h3>
                    <p class="text-sm text-emerald-200">Para seu evento completo.</p>

                    <div class="my-6">
                        <span class="text-5xl font-black">R$ 24,90</span>
                        <span class="block text-emerald-200 text-xs mt-1">pagamento único</span>
                    </div>

                    <ul class="space-y-3 text-sm text-emerald-50 mb-8 font-medium">
                        <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i> <strong>Taxa ZERO</strong> nos presentes</li>
                        <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i> Galeria de Fotos ilimitada</li>
                        <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i> Roleta da Gravata</li>
                    </ul>

                    <a href="{{ route('register') }}" class="block w-full py-4 rounded-xl bg-white text-center font-black text-emerald-900 hover:bg-emerald-50 transition active:scale-95 shadow-lg">
                        Quero este plano
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="py-16 bg-gradient-to-br from-gray-900 to-emerald-900">
        <div class="max-w-md mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-black text-white">Comece agora mesmo</h2>
            <p class="mt-3 text-emerald-100/80 text-sm">
                Leva menos de 2 minutos para configurar.
            </p>

            <div class="mt-8">
                <a href="{{ route('register') }}"
                   class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-500 px-8 py-4 font-black text-white shadow-lg shadow-emerald-500/20 active:scale-95 hover:bg-emerald-400 transition">
                    Criar minha lista
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
            <p class="mt-4 text-xs text-gray-500">Sem compromisso. Cancele a qualquer momento.</p>
        </div>
    </section>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</x-guest-layout>
