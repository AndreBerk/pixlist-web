<x-admin-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">

            <i data-lucide="check-circle" class="w-16 h-16 text-emerald-500 mx-auto mb-4"></i>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Pagamento Aprovado!</h2>
            <p class="text-gray-600 text-lg mb-8">
                Sua lista foi ativada com sucesso. Você já pode acessar seu painel completo e começar a configurar seus presentes.
            </p>

            <a href="{{ route('dashboard') }}" class="inline-block w-full px-6 py-4 bg-emerald-600 text-white text-lg font-bold rounded-lg shadow-md hover:bg-emerald-700 transition">
                Ir para o meu Dashboard
            </a>
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
