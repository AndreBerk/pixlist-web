<x-guest-layout>
    <section class="min-h-[70vh] flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-lg">
            <div class="bg-white/95 backdrop-blur p-8 md:p-10 rounded-2xl shadow-2xl border border-gray-100">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    Confirme seu e-mail
                </h2>
                <p class="mb-4 text-sm text-gray-600">
                    Obrigado por se cadastrar! Antes de começar a usar o Pixlist, confirme seu endereço de e-mail
                    clicando no link que acabamos de enviar para você.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        Enviamos um novo link de verificação para o e-mail informado no cadastro.
                    </div>
                @endif

                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <button type="submit"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Reenviar e-mail de verificação
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="text-sm text-gray-500 hover:text-gray-800 underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 rounded-md">
                            Sair da conta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
