<x-guest-layout>
    {{-- HERO ===================================================== --}}
    <section
        id="hero"
        class="relative overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-600 to-emerald-500"
        aria-labelledby="hero-title"
    >
        {{-- textura sutil opcional --}}
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1520975916090-3105956dac38?q=80&w=1200&auto=format')] opacity-10 bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative container mx-auto px-6 py-20 md:py-28 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14 items-center">
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 mb-4">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                        <span class="text-xs font-semibold tracking-wide">
                            Presentes em PIX direto na sua conta
                        </span>
                    </div>

                    <h1 id="hero-title" class="text-4xl md:text-6xl font-extrabold leading-tight">
                        Sua lista de presentes em <span class="text-emerald-200 underline decoration-white/40">PIX</span>.
                        <br class="hidden md:block" />
                        Comece grátis por 7 dias.
                    </h1>

                    <p class="mt-4 md:mt-6 text-base md:text-lg text-emerald-50 max-w-xl">
                        Crie sua lista de casamento, chá de bebê ou aniversário. Seus convidados presenteiam
                        e você recebe <span class="font-semibold">100% do valor</span> diretamente na sua conta. Nenhuma taxa sobre os presentes.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full">
                        <a href="{{ route('register') }}"
                           class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-white text-emerald-700 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition">
                            <i data-lucide="rocket" class="w-5 h-5"></i>
                            Começar meu teste grátis
                        </a>
                        <a href="#como-funciona"
                           class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-emerald-800/30 text-white font-semibold rounded-xl border border-white/20 hover:bg-white/10 transition">
                            Saber mais <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <p class="text-emerald-50/90 text-sm mt-3">
                        Não precisa de cartão de crédito • leva menos de 2 minutos.
                    </p>

                    {{-- mini métricas --}}
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div class="bg-white/10 rounded-xl p-3 text-center">
                            <p class="text-2xl font-extrabold">7 dias</p>
                            <p class="text-xs text-emerald-50/90">Teste completo</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 text-center">
                            <p class="text-2xl font-extrabold">0%</p>
                            <p class="text-xs text-emerald-50/90">Taxa no presente</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 text-center">
                            <p class="text-2xl font-extrabold">PIX</p>
                            <p class="text-xs text-emerald-50/90">Na hora, direto</p>
                        </div>
                    </div>
                </div>

                {{-- mockup / screenshot --}}
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1470&auto=format"
                            alt="Demonstração da página pública de uma lista criada no Pixlist"
                            class="w-full h-72 md:h-[28rem] object-cover">
                    </div>
                    <div class="absolute -bottom-4 -left-4 hidden md:block">
                        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 px-4 py-3 flex items-center gap-3">
                            <i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i>
                            <span class="text-sm font-semibold text-emerald-700">Seguro, simples e verificado</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- barra de prova social --}}
            <div class="mt-12 md:mt-16 opacity-90">
                <p class="text-emerald-50/90 text-sm mb-3">Escolhido por casais e famílias modernas</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4 items-center">
                    {{-- aqui no futuro você pode trocar por logos reais --}}
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                    <div class="h-10 bg-white/10 rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMO FUNCIONA ============================================ --}}
    <section id="como-funciona" class="bg-white py-20" aria-labelledby="como-funciona-title">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 id="como-funciona-title" class="text-3xl md:text-4xl font-extrabold text-center text-gray-900 mb-14">
                É simples como deve ser
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                {{-- passo 1 --}}
                <div class="group bg-white p-7 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition">
                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5">
                        <i data-lucide="gift" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">1. Crie sua lista</h3>
                    <p class="text-gray-600">
                        Adicione presentes com fotos ou ícones. Use templates por temas como “Cozinha”, “Casa nova”, “Lua de mel” e muito mais.
                    </p>
                </div>

                {{-- passo 2 --}}
                <div class="group bg-white p-7 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition">
                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5">
                        <i data-lucide="share-2" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">2. Compartilhe o link</h3>
                    <p class="text-gray-600">
                        Um link único (e QR Code) para enviar no WhatsApp, convite físico ou redes sociais.
                        Seus convidados acessam tudo em poucos cliques.
                    </p>
                </div>

                {{-- passo 3 --}}
                <div class="group bg-white p-7 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition">
                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5">
                        <i data-lucide="smartphone-nfc" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">3. Receba em PIX</h3>
                    <p class="text-gray-600">
                        O convidado paga usando <strong>sua</strong> chave PIX. O valor cai direto na sua conta, na mesma hora.
                        Taxa zero no presente.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFÍCIOS RÁPIDOS ======================================= --}}
    <section class="bg-gray-50 py-16" aria-label="Benefícios do Pixlist">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center mb-3">
                        <i data-lucide="layout-grid" class="w-5 h-5 text-emerald-700"></i>
                    </div>
                    <p class="font-semibold">Templates lindos</p>
                    <p class="text-sm text-gray-600">Visual limpo, moderno e personalizável para cada tipo de evento.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center mb-3">
                        <i data-lucide="users" class="w-5 h-5 text-emerald-700"></i>
                    </div>
                    <p class="font-semibold">RSVP embutido</p>
                    <p class="text-sm text-gray-600">Controle de convidados, adultos e crianças em um painel simples.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center mb-3">
                        <i data-lucide="message-square-heart" class="w-5 h-5 text-emerald-700"></i>
                    </div>
                    <p class="font-semibold">Mural de recados</p>
                    <p class="text-sm text-gray-600">Mensagens carinhosas dos convidados aparecem no seu site.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center mb-3">
                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-700"></i>
                    </div>
                    <p class="font-semibold">PIX direto & seguro</p>
                    <p class="text-sm text-gray-600">Sem intermediação no dinheiro. Você no controle do começo ao fim.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- DESTAQUE + LISTA ========================================= --}}
    <section class="bg-white py-20" aria-labelledby="destaque-lista-title">
        <div class="container mx-auto px-6 max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="order-last md:order-first">
                <img
                    src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=1470"
                    alt="Painel de administração do Pixlist com lista de presentes"
                    class="rounded-2xl shadow-2xl border border-gray-100"
                    loading="lazy"
                >
            </div>
            <div>
                <span class="text-sm font-semibold text-emerald-700 uppercase">Tudo em um só lugar</span>
                <h2 id="destaque-lista-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-3 mb-6">
                    Muito mais que uma lista de presentes.
                </h2>
                <ul class="space-y-5">
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold">Gestão de convidados (RSVP)</p>
                            <p class="text-gray-600 text-sm">Confirmações com total de adultos e crianças, tudo organizado em um painel.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold">Mural de recados</p>
                            <p class="text-gray-600 text-sm">Mensagens aparecem em carrossel na sua página, criando um clima ainda mais especial.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold">PIX direto (taxa zero no presente)</p>
                            <p class="text-gray-600 text-sm">O valor integral vai para sua conta, sem que o Pixlist fique com o dinheiro no meio do caminho.</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-7">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:bg-emerald-700 transition">
                        Criar minha lista agora
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <p class="text-xs text-gray-500 mt-2">
                        Você pode testar e só depois decidir se ativa o plano.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING =================================================== --}}
    <section class="bg-gray-50 py-20" aria-labelledby="pricing-title">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 id="pricing-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">Comece de graça</h2>
            <p class="text-gray-600 mb-10">
                Teste tudo por 7 dias. Se curtir, ative o plano único quando quiser. Sem mensalidade, sem pegadinhas.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- teste grátis --}}
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200 hover:-translate-y-1 hover:shadow-2xl transition">
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Teste grátis</h3>
                    <p class="text-gray-500 mb-4">7 dias • acesso total</p>
                    <p class="my-4">
                        <span class="text-6xl font-extrabold text-gray-900">R$ 0</span>
                    </p>
                    <ul class="space-y-2 text-gray-700 text-left my-6">
                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i>
                            Todas as funcionalidades premium liberadas
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i>
                            RSVP integrado e mural de recados
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i>
                            Sem cartão de crédito para começar
                        </li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="mt-6 inline-block w-full px-8 py-3 bg-gray-800 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-gray-900 transition">
                        Começar teste grátis
                    </a>
                    <p class="text-xs text-gray-500 mt-3">
                        Se não ativar o plano, sua lista é encerrada automaticamente após o teste.
                    </p>
                </div>

                {{-- plano único --}}
                <div class="bg-emerald-600 text-white p-8 rounded-2xl shadow-2xl border-4 border-emerald-700 relative overflow-hidden">
                    <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white text-emerald-700 text-xs font-bold">
                        MAIS ESCOLHIDO
                    </div>
                    <h3 class="text-2xl font-bold mb-1">Plano único</h3>
                    <p class="text-emerald-100 mb-4">Pagamento único • sem mensalidade</p>
                    <p class="my-4">
                        <span class="text-6xl font-extrabold">R$ 49,90</span>
                    </p>
                    <ul class="space-y-2 text-emerald-50 text-left my-6">

                        {{-- [MUDANÇA APLICADA AQUI] --}}
                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-white"></i>
                            Acesso válido por 1 ano (365 dias)
                        </li>

                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-white"></i>
                            Presentes e convidados ilimitados
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check" class="w-5 h-5 text-white"></i>
                            PIX direto na sua conta (taxa zero no presente)
                        </li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="mt-6 inline-block w-full px-8 py-3 bg-white text-emerald-700 text-lg font-bold rounded-lg shadow-lg hover:bg-gray-100 transition">
                        Escolher Plano Único
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- DEPOIMENTOS ============================================== --}}
    <section class="bg-white py-20" aria-labelledby="depoimentos-title">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-12">
                <h3 id="depoimentos-title" class="text-3xl md:text-4xl font-extrabold text-gray-900">
                    Quem usou, recomenda
                </h3>
                <p class="text-gray-600 mt-2">Histórias reais de quem facilitou a vida com o Pixlist.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Depoimento 1 --}}
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100"></div>
                        <div>
                            <p class="font-semibold text-gray-900">Ana &amp; Bruno</p>
                            <p class="text-xs text-gray-500">Casamento</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-700">
                        “Foi muito mais fácil do que imaginávamos — criamos a lista em minutos e o Pix caiu direto na conta.”
                    </p>
                    <div class="mt-3 flex items-center gap-1 text-amber-400" aria-label="Avaliação 5 de 5 estrelas">
                        @for ($s = 0; $s < 5; $s++)
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        @endfor
                    </div>
                </article>

                {{-- Depoimento 2 --}}
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100"></div>
                        <div>
                            <p class="font-semibold text-gray-900">Marina</p>
                            <p class="text-xs text-gray-500">Chá de bebê</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-700">
                        “Os convidados elogiaram a praticidade. Acompanhamos tudo em tempo real e sem taxas sobre os presentes.”
                    </p>
                    <div class="mt-3 flex items-center gap-1 text-amber-400" aria-label="Avaliação 5 de 5 estrelas">
                        @for ($s = 0; $s < 5; $s++)
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        @endfor
                    </div>
                </article>

                {{-- Depoimento 3 --}}
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100"></div>
                        <div>
                            <p class="font-semibold text-gray-900">Carlos</p>
                            <p class="text-xs text-gray-500">Aniversário de 30 anos</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-700">
                        “Visual lindo e simples de usar. Personalizei a lista do meu jeito e o Pix entrou na hora.”
                    </p>
                    <div class="mt-3 flex items-center gap-1 text-amber-400" aria-label="Avaliação 5 de 5 estrelas">
                        @for ($s = 0; $s < 5; $s++)
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        @endfor
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- FAQ ======================================================= --}}
    <section class="bg-gray-50 py-20" aria-labelledby="faq-title">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="text-center mb-10">
                <h3 id="faq-title" class="text-3xl md:text-4xl font-extrabold text-gray-900">Dúvidas frequentes</h3>
                <p class="text-gray-600 mt-2">Transparência do início ao fim.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow">
                    <p class="font-semibold">Vocês cobram taxa sobre os presentes?</p>
                    <p class="text-gray-600 mt-2 text-sm">
                        Não. O convidado paga usando a sua chave PIX e o valor cai direto na sua conta.
                        O Pixlist não retém nenhuma taxa sobre os presentes (apenas o banco pode cobrar as taxas normais de operação).
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow">
                    <p class="font-semibold">Preciso de cartão para o teste?</p>
                    <p class="text-gray-600 mt-2 text-sm">
                        Não. Você testa por 7 dias com acesso completo e só paga se decidir ativar o plano único depois.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow">
                    <p class="font-semibold">Consigo gerenciar RSVP?</p>
                    <p class="text-gray-600 mt-2 text-sm">
                        Sim. O painel mostra confirmações, total de adultos e crianças, tudo organizado por evento.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow">
                    <p class="font-semibold">É fácil personalizar a lista?</p>
                    <p class="text-gray-600 mt-2 text-sm">
                        Muito. Você escolhe templates, adiciona fotos, categorias e ajusta tudo em poucos cliques, sem precisar ser “da tecnologia”.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINAL ================================================= --}}
    <section class="bg-white py-20" aria-labelledby="cta-final-title">
        <div class="container mx-auto px-6 text-center max-w-3xl">
            <h3 id="cta-final-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                Pronto para criar a sua lista?
            </h3>
            <p class="text-lg md:text-xl text-gray-600 mb-8">
                A forma mais simples e moderna de receber presentes em PIX. Você no controle, sem taxas sobre os presentes.
            </p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 px-7 py-3 bg-emerald-600 text-white text-lg font-bold rounded-xl shadow-lg hover:bg-emerald-700 hover:-translate-y-0.5 transition">
                Começar os 7 dias grátis
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
            <p class="text-sm text-gray-500 mt-3">Crie sua conta, configure sua lista e compartilhe com os convidados em poucos minutos.</p>
        </div>
    </section>

    {{-- init icons --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</x-guest-layout>
