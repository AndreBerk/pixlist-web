<x-guest-layout>
    <section class="min-h-[70vh] flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur p-8 md:p-10 rounded-2xl shadow-2xl border border-gray-100">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    Confirme sua senha
                </h2>
                <p class="mb-4 text-sm text-gray-600">
                    Esta é uma área segura do Pixlist. Confirme sua senha para continuar.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6" novalidate>
                    @csrf

                    {{-- Senha --}}
                    <div>
                        <x-input-label for="password" value="Senha" />
                        <x-text-input
                            id="password"
                            class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button>
                            Confirmar
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
