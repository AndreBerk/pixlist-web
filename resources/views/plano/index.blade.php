<x-admin-layout>
    {{-- Usamos o layout do admin para que o usuário ainda se sinta "dentro" do sistema --}}

    <div class="max-w-2xl mx-auto">

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-6 rounded-lg shadow-lg" role="alert">
                <h3 class="font-bold text-lg mb-2">Ocorreu um Erro!</h3>
                <p>Não foi possível gerar seu PIX. O Mercado Pago retornou o seguinte erro:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                 <p class="mt-3 text-sm"><strong>Solução:</strong> Verifique se o seu `MP_ACCESS_TOKEN` no arquivo `.env` está correto e tente novamente.</p>
            </div>
        @endif

        @if (session('status') === 'pagamento-processando')
             <div class="mb-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 p-6 rounded-lg shadow-lg" role="alert">
                <h3 class="font-bold text-lg">Pagamento em Processamento</h3>
                <p>Obrigado! Recebemos seu pagamento e estamos aguardando a confirmação final do banco. Seu painel será liberado automaticamente em alguns segundos.</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">

            <i data-lucide="party-popper" class="w-16 h-16 text-emerald-500 mx-auto mb-4"></i>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Sua lista está quase pronta!</h2>
            <p class="text-gray-600 text-lg mb-8">
                Para ativar sua lista <strong class="text-gray-800">"{{ $list->display_name }}"</strong> e começar a receber presentes, basta finalizar o pagamento da taxa única de ativação.
            </p>

            {{-- Caixa de Preço --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-8">
                <p class="text-lg text-emerald-800">Taxa de Ativação Única</p>
                <p class="text-5xl font-extrabold text-emerald-600 my-2">R$ 49,90</p>

                {{-- [MUDANÇA] Atualizamos o texto para a lógica de 1 ano --}}
                <p class="text-emerald-700">
                    Acesso válido por 1 ano (365 dias)
                    <br>a partir da data de ativação.
                </p>
            </div>

            <a href="{{ route('plano.pagar') }}" class="inline-block text-center w-full px-6 py-4 bg-emerald-600 text-white text-lg font-bold rounded-lg shadow-md hover:bg-emerald-700 transition">
                Pagar R$ 49,90 com PIX
            </a>

             {{-- Link para Perfil/Sair --}}
             <div class="mt-8 text-center space-x-4">
                 <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-gray-700">Alterar dados da conta</a>

                 <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-500">
                        Sair
                    </button>
                 </form>
             </div>
        </div>
    </div>

    {{-- Script para garantir que o ícone 'party-popper' seja renderizado --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</x-admin-layout>
