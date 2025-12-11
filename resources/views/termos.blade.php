<x-guest-layout>
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-lg border border-gray-100">

                <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Termos de Uso e Política de Privacidade</h1>

                <div class="prose prose-emerald max-w-none text-gray-600">

                    <h3>1. Sobre o Serviço</h3>
                    <p>O <strong>Pixlist</strong> é uma plataforma SaaS (Software as a Service) que permite a criação de páginas personalizadas para listas de presentes virtuais. O serviço limita-se ao fornecimento da tecnologia para exibição da lista, gestão de confirmações de presença (RSVP) e mural de recados.</p>

                    <h3>2. Transações Financeiras (PIX Direto)</h3>
                    <p>O Pixlist adota o modelo "P2P" (Peer-to-Peer) para os presentes. Isso significa que:</p>
                    <ul>
                        <li>O dinheiro dos presentes é transferido diretamente da conta bancária do convidado para a conta bancária do organizador via sistema PIX do Banco Central.</li>
                        <li><strong>O Pixlist não atua como intermediário financeiro.</strong> O valor não passa, em nenhum momento, pelas contas da nossa empresa.</li>
                        <li>Não cobramos taxas sobre o valor dos presentes recebidos.</li>
                    </ul>

                    <h3>3. Responsabilidades do Usuário</h3>
                    <p>Ao utilizar a plataforma, o usuário declara estar ciente de que:</p>
                    <ul>
                        <li>É o único responsável pela veracidade e exatidão da <strong>Chave PIX</strong> cadastrada. O Pixlist não possui meios técnicos para reverter transferências feitas para chaves incorretas.</li>
                        <li>É responsável por moderar o conteúdo (fotos e mensagens) enviado pelos seus convidados no Mural e Galeria.</li>
                    </ul>

                    <h3>4. Conteúdo de Terceiros (Galeria e Mural)</h3>
                    <p>O Pixlist fornece ferramentas para moderação de conteúdo (aprovação de fotos e mensagens). A plataforma não se responsabiliza por imagens ou textos ofensivos enviados por terceiros (convidados) antes da moderação pelo organizador da lista.</p>

                    <h3>5. Pagamento da Plataforma</h3>
                    <p>A taxa única de ativação (R$ 39,90) refere-se exclusivamente à licença de uso do software por um período de 1 ano. Este valor não é reembolsável após o período de teste de 7 dias, uma vez que o serviço foi prestado.</p>

                    <hr class="my-8">

                    <p class="text-sm">Última atualização: {{ now()->format('d/m/Y') }}</p>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <a href="{{ route('welcome') }}" class="text-emerald-600 font-bold hover:underline">Voltar para a página inicial</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
