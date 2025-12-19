<x-guest-layout>
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-700">
        {{-- fundo suave --}}
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.25)_0,transparent_35%),radial-gradient(circle_at_80%_30%,rgba(255,255,255,0.18)_0,transparent_35%),radial-gradient(circle_at_60%_90%,rgba(255,255,255,0.12)_0,transparent_35%)]"></div>
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.08)_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="relative max-w-7xl mx-auto px-6 pt-24 pb-16 lg:pt-32 lg:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Copy --}}
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-4 py-2 backdrop-blur">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        <span class="text-xs font-semibold tracking-wide uppercase text-emerald-50">
                            PIX direto na conta • sem taxas
                        </span>
                    </div>

                    <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.05]">
                        Presentes que viram
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 to-teal-200">
                            dinheiro na hora.
                        </span>
                    </h1>

                    <p class="mt-5 text-lg md:text-xl text-emerald-50/80 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Crie sua lista de casamento, chá de bebê ou aniversário.
                        Seus convidados presenteiam e você recebe <strong class="text-white">100% do valor via PIX</strong>.
                        Sem intermediários, sem taxas ocultas.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-7 py-4 font-extrabold text-emerald-900 shadow-lg shadow-black/10 hover:shadow-xl hover:-translate-y-0.5 transition">
                            Começar teste grátis
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>

                        <a href="#como-funciona"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 px-7 py-4 font-semibold text-white border border-white/15 hover:bg-white/15 transition">
                            <i data-lucide="play-circle" class="w-5 h-5"></i>
                            Ver como funciona
                        </a>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-x-4 gap-y-2 justify-center lg:justify-start text-sm text-emerald-50/70">
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4"></i> 7 dias grátis
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4"></i> cancela quando quiser
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4"></i> sem cartão
                        </span>
                    </div>
                </div>

                {{-- Mockup --}}
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="absolute -inset-6 bg-emerald-400/20 blur-3xl rounded-[2rem]"></div>

                        <div class="relative rounded-[2rem] border border-white/15 bg-white/5 backdrop-blur p-3 shadow-2xl">
                            <div class="overflow-hidden rounded-[1.6rem] bg-white">
                                <div class="aspect-[16/10] bg-gray-100">
                                    <img
                                        src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1600&auto=format&fit=crop"
                                        alt="Pixlist"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                </div>

                                <div class="p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                                                <i data-lucide="gift" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 font-semibold uppercase">Novo presente</p>
                                                <p class="text-sm font-bold text-gray-900">Presente da Tia Maria</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-emerald-700 font-black text-lg">+ R$ 250,00</p>
                                            <p class="text-xs text-gray-400">recebido agora</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-teal-400/20 blur-2xl"></div>
                    </div>
                </div>
            </div>

            {{-- selos --}}
            <div class="mt-12 pt-10 border-t border-white/10">
                <div class="flex flex-wrap items-center justify-center gap-6 text-emerald-50/70 text-sm">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5"></i> Segurança
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="lock" class="w-5 h-5"></i> SSL
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="qr-code" class="w-5 h-5"></i> PIX
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- COMO FUNCIONA --}}
    <section id="como-funciona" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto">
                <p class="text-emerald-700 font-bold tracking-wider text-sm uppercase">Passo a passo</p>
                <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900">Simples, como deve ser.</h2>
                <p class="mt-4 text-lg text-gray-500">
                    Em poucos minutos sua lista está no ar pronta para receber presentes.
                </p>
            </div>

            <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $steps = [
                        ['n' => '1', 't' => 'Crie sua lista', 'd' => 'Personalize com fotos, texto e presentes.'],
                        ['n' => '2', 't' => 'Compartilhe', 'd' => 'Envie o link e QR Code no WhatsApp e no convite.'],
                        ['n' => '3', 't' => 'Receba via PIX', 'd' => 'O valor cai na sua conta na hora, taxa zero.'],
                    ];
                @endphp

                @foreach($steps as $s)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg">
                            {{ $s['n'] }}
                        </div>
                        <h3 class="mt-5 text-xl font-bold text-gray-900">{{ $s['t'] }}</h3>
                        <p class="mt-2 text-gray-600 leading-relaxed">{{ $s['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Galeria interativa</h3>
                    </div>
                    <p class="mt-3 text-gray-600">
                        Fotos do evento com likes e comentários — memória viva do seu dia.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i data-lucide="dices" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Roleta da gravata</h3>
                    </div>
                    <p class="mt-3 text-gray-600">
                        Gamifique a festa: sorteio divertido e arrecadação com clima leve.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">RSVP simples</h3>
                    </div>
                    <p class="mt-3 text-gray-600">
                        Controle presença, adultos e crianças. Tudo organizado.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i data-lucide="badge-check" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Taxa zero</h3>
                    </div>
                    <p class="mt-3 text-gray-600">
                        Presenteou? Cai na sua conta. Sem taxas escondidas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900">Preço transparente.</h2>
                <p class="mt-3 text-lg text-gray-500">Sem mensalidades. Sem surpresas.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-8">
                    <h3 class="text-xl font-extrabold text-gray-900">Teste grátis</h3>
                    <p class="mt-1 text-gray-600 text-sm">Para conhecer a plataforma.</p>

                    <div class="mt-6">
                        <span class="text-4xl font-black text-gray-900">R$ 0</span>
                        <span class="text-gray-500 font-medium">/ 7 dias</span>
                    </div>

                    <ul class="mt-6 space-y-3 text-gray-700">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i> Funcionalidades premium
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i> Sem cartão de crédito
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                       class="mt-8 inline-flex w-full items-center justify-center rounded-xl border-2 border-gray-900 bg-transparent py-4 font-extrabold text-gray-900 hover:bg-gray-900 hover:text-white transition">
                        Começar teste
                    </a>
                </div>

                <div class="rounded-2xl border border-emerald-300 bg-gradient-to-br from-emerald-900 to-emerald-700 p-8 text-white shadow-xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-3 py-1 text-xs font-bold uppercase tracking-wide">
                        Mais escolhido
                    </div>

                    <h3 class="mt-4 text-xl font-extrabold">Plano único</h3>
                    <p class="mt-1 text-emerald-100 text-sm">Acesso completo por 1 ano.</p>

                    <div class="mt-6">
                        <span class="text-4xl font-black">R$ 24,90</span>
                        <span class="text-emerald-100 font-medium block mt-1 text-sm">pagamento único</span>
                    </div>

                    <ul class="mt-6 space-y-3 text-emerald-50">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-200"></i> Presentes ilimitados
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-200"></i> Galeria & Roleta
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-200"></i> Taxa ZERO nos presentes
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                       class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-white py-4 font-black text-emerald-900 hover:opacity-95 transition">
                        Quero este plano
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="py-16 bg-gradient-to-br from-emerald-900 to-teal-700">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-black text-white">Pronto para receber seus presentes?</h2>
            <p class="mt-4 text-emerald-50/80 text-lg max-w-2xl mx-auto">
                Crie sua lista e comece com 7 dias grátis. Configuração rápida e sem cartão.
            </p>

            <div class="mt-8">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-10 py-5 font-black text-emerald-900 shadow-lg hover:-translate-y-0.5 transition">
                    Criar minha lista
                    <i data-lucide="arrow-right" class="w-6 h-6"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- icons --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</x-guest-layout>
