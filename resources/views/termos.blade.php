<x-guest-layout>
    <div class="bg-gray-50 min-h-screen py-10 sm:py-14">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 sm:mb-10">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <span class="inline-flex w-2 h-2 rounded-full bg-emerald-500"></span>
                    Documento oficial • Pixlist
                </div>

                <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">
                    Termos de Uso e Política de Privacidade
                </h1>

                <p class="mt-2 text-gray-600 text-base sm:text-lg leading-relaxed max-w-3xl">
                    Transparência total: aqui você entende como a plataforma funciona, quais são as responsabilidades e como tratamos dados.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                {{-- Sumário (sticky no desktop) --}}
                <aside class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:sticky lg:top-24">
                        <h2 class="text-sm font-extrabold text-gray-900 tracking-wide uppercase">
                            Sumário
                        </h2>

                        <nav class="mt-4 space-y-2 text-sm">
                            <a href="#sobre" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>1. Sobre o serviço</span>
                                <span class="text-gray-400">›</span>
                            </a>
                            <a href="#pix" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>2. Transações (PIX direto)</span>
                                <span class="text-gray-400">›</span>
                            </a>
                            <a href="#responsabilidades" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>3. Responsabilidades do usuário</span>
                                <span class="text-gray-400">›</span>
                            </a>
                            <a href="#conteudo" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>4. Conteúdo de terceiros</span>
                                <span class="text-gray-400">›</span>
                            </a>
                            <a href="#pagamento" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>5. Pagamento da plataforma</span>
                                <span class="text-gray-400">›</span>
                            </a>
                            <a href="#privacidade" class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 transition">
                                <span>Política de privacidade</span>
                                <span class="text-gray-400">›</span>
                            </a>
                        </nav>

                        <div class="mt-6 rounded-xl bg-gray-50 border border-gray-100 p-4">
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Última atualização:
                                <span class="font-semibold text-gray-700">{{ now()->format('d/m/Y') }}</span>
                            </p>
                        </div>
                    </div>
                </aside>

                {{-- Conteúdo --}}
                <section class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 sm:p-8">

                            {{-- Seções em cards internos --}}
                            <div class="space-y-6">

                                <article id="sobre" class="rounded-2xl border border-gray-100 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        1. Sobre o Serviço
                                    </h3>
                                    <p class="mt-2 text-gray-600 leading-relaxed">
                                        O <strong class="text-gray-900">Pixlist</strong> é uma plataforma SaaS (Software as a Service) que permite a criação de páginas personalizadas
                                        para listas de presentes virtuais, confirmação de presença (RSVP) e galeria de fotos.
                                    </p>
                                </article>

                                <article id="pix" class="rounded-2xl border border-gray-100 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        2. Transações Financeiras (PIX Direto)
                                    </h3>

                                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                            <p class="text-sm font-semibold text-emerald-800">
                                                PIX direto para o organizador
                                            </p>
                                            <p class="mt-1 text-sm text-emerald-700/80 leading-relaxed">
                                                Os valores são transferidos diretamente entre convidado e organizador via PIX.
                                            </p>
                                        </div>

                                        <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                                            <p class="text-sm font-semibold text-gray-900">
                                                Sem intermediação financeira
                                            </p>
                                            <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                                                <strong class="text-gray-900">O Pixlist não atua como intermediário financeiro.</strong>
                                                Não cobramos taxas sobre os valores recebidos.
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article id="responsabilidades" class="rounded-2xl border border-gray-100 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        3. Responsabilidades do Usuário
                                    </h3>

                                    <ul class="mt-4 space-y-3 text-gray-600">
                                        <li class="flex items-start gap-3">
                                            <span class="mt-1 inline-flex w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 items-center justify-center text-xs font-bold">✓</span>
                                            <span>Garantir que a chave PIX cadastrada esteja correta.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <span class="mt-1 inline-flex w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 items-center justify-center text-xs font-bold">✓</span>
                                            <span>Realizar a moderação de fotos e mensagens enviadas por convidados (quando aplicável).</span>
                                        </li>
                                    </ul>
                                </article>

                                <article id="conteudo" class="rounded-2xl border border-gray-100 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        4. Conteúdo de Terceiros
                                    </h3>
                                    <p class="mt-2 text-gray-600 leading-relaxed">
                                        O Pixlist fornece ferramentas de moderação, mas não se responsabiliza por conteúdos enviados por convidados
                                        antes da aprovação do organizador, quando esse fluxo estiver habilitado na conta.
                                    </p>
                                </article>

                                <article id="pagamento" class="rounded-2xl border border-gray-100 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        5. Pagamento da Plataforma
                                    </h3>
                                    <p class="mt-2 text-gray-600 leading-relaxed">
                                        A taxa de ativação refere-se à licença de uso da plataforma por 1 ano.
                                        Após o período de teste, o valor não é reembolsável, salvo exceções previstas em lei.
                                    </p>
                                </article>

                                {{-- Política de Privacidade (âncora exigida) --}}
                                <article id="privacidade" class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-5 sm:p-6">
                                    <h3 class="text-xl font-extrabold text-gray-900">
                                        Política de Privacidade
                                    </h3>

                                    <p class="mt-2 text-gray-700 leading-relaxed">
                                        Para operar a plataforma, podemos coletar e tratar dados mínimos necessários, como dados de conta e informações relacionadas à lista.
                                        Esses dados são utilizados para autenticação, funcionamento do painel e entrega das funcionalidades contratadas.
                                    </p>

                                    <div class="mt-4 rounded-xl bg-white border border-emerald-100 p-4">
                                        <p class="text-sm text-gray-700">
                                            <strong class="text-gray-900">Nosso compromisso:</strong> usar dados apenas para o funcionamento do serviço e segurança,
                                            com boas práticas de proteção e acesso.
                                        </p>
                                    </div>
                                </article>

                            </div>

                            {{-- Rodapé interno --}}
                            <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p class="text-xs text-gray-500">
                                    Última atualização: <span class="font-semibold text-gray-700">{{ now()->format('d/m/Y') }}</span>
                                </p>

                                <a href="{{ route('welcome') }}"
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                                    Voltar para a página inicial
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- Espaço para respiro em mobile --}}
                    <div class="h-8"></div>
                </section>
            </div>
        </div>
    </div>
</x-guest-layout>
