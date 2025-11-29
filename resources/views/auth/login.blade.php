<x-guest-layout>
    {{-- Fundo com padrão suave + centralização --}}
    <section id="page-login" class="min-h-[80vh] flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            {{-- Card --}}
            <div class="bg-white/95 backdrop-blur p-8 md:p-10 rounded-2xl shadow-2xl border border-gray-100">

                {{-- Logo + título --}}
                <div class="text-center mb-8">
                    </a>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900">Entrar</h2>
                    <p class="mt-2 text-sm text-gray-600">Acesse seu painel para gerenciar sua lista.</p>
                </div>

                {{-- Status de sessão (ex.: reset de senha enviado) --}}
                <x-auth-session-status class="mb-4 text-green-600" :status="session('status')" />

                {{-- Formulário --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input
                            type="email"
                            id="login-email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="voce@email.com"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 {{ $errors->has('email') ? 'border-red-300' : 'border-gray-300' }}"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Senha + Mostrar/ocultar --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <label for="login-senha" class="block text-sm font-medium text-gray-700">Senha</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>

                        <div class="mt-1 relative">
                            <input
                                type="password"
                                id="login-senha"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Sua senha"
                               class="mt-1 block w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 {{ $errors->has('email') ? 'border-red-300' : 'border-gray-300' }}"
                            />
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Mostrar/ocultar senha"
                            >
                                <svg id="eye-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 5 12 5c4.64 0 8.577 2.51 9.964 6.678a1.012 1.012 0 010 .644C20.577 16.49 16.64 19 12 19c-4.64 0-8.577-2.51-9.964-6.678z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 15.948 7.21 18.75 12 18.75c1.6 0 3.122-.314 4.5-.884M6.228 6.228A10.45 10.45 0 0112 5.25c4.79 0 8.774 2.802 10.066 6.75-.4 1.23-1.07 2.36-1.96 3.32M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Lembrar-me --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
                        </label>
                    </div>

                    {{-- Botão --}}
                    <button
                        type="submit"
                        class="w-full px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        Entrar
                    </button>

                    {{-- Divisor --}}
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-3 bg-white text-xs font-medium text-gray-400">ou</span>
                        </div>
                    </div>

                    {{-- CTA cadastro --}}
                    <p class="text-center text-sm text-gray-600">
                        Não tem uma conta?
                        <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-500">
                            Cadastre-se gratuitamente
                        </a>
                    </p>
                </form>
            </div>

            {{-- Rodapé pequeno opcional --}}
            <p class="mt-6 text-center text-xs text-gray-400">
                Protegido por autenticação segura. Dúvidas? <a href="mailto:suporte@pixlist.com.br" class="underline underline-offset-2 hover:text-gray-600">suporte@pixlist.com.br</a>
            </p>
        </div>
    </section>

    {{-- Mostrar/ocultar senha (JS simples, sem dependências) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('login-senha');
            const btn = document.getElementById('togglePassword');
            const eyeOn = document.getElementById('eye-on');
            const eyeOff = document.getElementById('eye-off');

            btn?.addEventListener('click', () => {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                eyeOn.classList.toggle('hidden', !isPassword);
                eyeOff.classList.toggle('hidden', isPassword);
            });
        });
    </script>
</x-guest-layout>
