<x-guest-layout>
    <section class="min-h-[70vh] flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur p-8 md:p-10 rounded-2xl shadow-2xl border border-gray-100">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    Esqueceu sua senha?
                </h2>
                <p class="mb-4 text-sm text-gray-600">
                    Sem problema. Informe seu e-mail e enviaremos um link para você criar uma nova senha.
                </p>

                {{-- Status da sessão --}}
                <x-auth-session-status class="mb-4 text-sm" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="E-mail" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end pt-2">
                        <x-primary-button>
                            Enviar link de redefinição
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
