<x-guest-layout>
    {{-- CADASTRO ================================================== --}}
    <section id="page-cadastro" class="min-h-[80vh] flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            {{-- Card --}}
            <div class="bg-white/95 backdrop-blur p-8 md:p-10 rounded-2xl shadow-2xl border border-gray-100">

                {{-- Logo + título --}}
                <div class="text-center mb-8">
                    {{-- <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                        <x-application-logo class="w-10 h-10 text-emerald-600" />
                    </a> --}}
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900">Crie sua conta</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Leva menos de 1 minuto e você já começa com <span class="font-semibold">7 dias grátis</span>.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6" novalidate>
                    @csrf

                    {{-- Nome --}}
                    <div>
                        <label for="cad-nome" class="block text-sm font-medium text-gray-700">Seu nome</label>
                        <input
                            type="text"
                            id="cad-nome"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Seu nome completo"
                            @class([
                                'mt-1 block w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500',
                                'border-red-300' => $errors->has('name'),
                                'border-gray-300' => ! $errors->has('name'),
                            ])
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="cad-email" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input
                            type="email"
                            id="cad-email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="voce@email.com"
                            @class([
                                'mt-1 block w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500',
                                'border-red-300' => $errors->has('email'),
                                'border-gray-300' => ! $errors->has('email'),
                            ])
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Senha --}}
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="cad-senha" class="block text-sm font-medium text-gray-700">Senha</label>
                            <span id="senha-hint" class="text-xs text-gray-500">mín. 8 caracteres</span>
                        </div>

                        <div class="mt-1 relative">
                            <input
                                type="password"
                                id="cad-senha"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Crie uma senha forte"
                                @class([
                                    'block w-full px-4 py-3 pr-12 rounded-lg border shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500',
                                    'border-red-300' => $errors->has('password'),
                                    'border-gray-300' => ! $errors->has('password'),
                                ])
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                aria-describedby="senha-hint senha-meter-label"
                            />
                            <button
                                type="button"
                                id="togglePassword1"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Mostrar ou ocultar senha"
                            >
                                <svg id="eye1-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 5 12 5c4.64 0 8.577 2.51 9.964 6.678a1.012 1.012 0 010 .644C20.577 16.49 16.64 19 12 19c-4.64 0-8.577-2.51-9.964-6.678z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eye1-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 15.948 7.21 18.75 12 18.75c1.6 0 3.122-.314 4.5-.884M6.228 6.228A10.45 10.45 0 0112 5.25c4.79 0 8.774 2.802 10.066 6.75-.4 1.23-1.07 2.36-1.96 3.32M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        {{-- Medidor de força da senha --}}
                        <div class="mt-2">
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden" aria-hidden="true">
                                <div id="senha-meter-bar" class="h-2 w-0 bg-red-400 transition-all"></div>
                            </div>
                            <p id="senha-meter-label" class="mt-1 text-xs font-medium text-gray-500">Força: —</p>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Confirmação de senha --}}
                    <div>
                        <label for="cad-senha-conf" class="block text-sm font-medium text-gray-700">Confirme sua senha</label>
                        <div class="mt-1 relative">
                            <input
                                type="password"
                                id="cad-senha-conf"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Repita a senha"
                                class="block w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                                aria-describedby="senha-conf-hint"
                            />
                            <button
                                type="button"
                                id="togglePassword2"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Mostrar ou ocultar confirmação de senha"
                            >
                                <svg id="eye2-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 5 12 5c4.64 0 8.577 2.51 9.964 6.678a1.012 1.012 0 010 .644C20.577 16.49 16.64 19 12 19c-4.64 0-8.577-2.51-9.964-6.678z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eye2-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 15.948 7.21 18.75 12 18.75c1.6 0 3.122-.314 4.5-.884M6.228 6.228A10.45 10.45 0 0112 5.25c4.79 0 8.774 2.802 10.066 6.75-.4 1.23-1.07 2.36-1.96 3.32M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <p id="senha-conf-hint" class="mt-1 text-xs text-gray-500">Deve ser igual à senha.</p>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Botão --}}
                    <button type="submit"
                            class="w-full px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Registrar e continuar
                    </button>

                    {{-- Divisor + CTA login --}}
                    <div class="pt-2">
                        <div class="relative mb-4">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-3 bg-white text-xs font-medium text-gray-400">já fez cadastro antes?</span>
                            </div>
                        </div>

                        <p class="text-center text-sm text-gray-600">
                            Já tem uma conta?
                            <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-500">
                                Faça login
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            {{-- Rodapé pequeno --}}
            <p class="mt-6 text-center text-xs text-gray-400">
                Ao continuar, você concorda com nossos termos de uso e política de privacidade.
            </p>
        </div>
    </section>

    {{-- JS: mostrar/ocultar senha + medidor simples de força --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // toggle senha 1
            const pwd1 = document.getElementById('cad-senha');
            const btn1 = document.getElementById('togglePassword1');
            const eye1On = document.getElementById('eye1-on');
            const eye1Off = document.getElementById('eye1-off');

            if (btn1 && pwd1) {
                btn1.addEventListener('click', () => {
                    const isPwd = pwd1.getAttribute('type') === 'password';
                    pwd1.setAttribute('type', isPwd ? 'text' : 'password');
                    eye1On.classList.toggle('hidden', !isPwd);
                    eye1Off.classList.toggle('hidden', isPwd);
                });
            }

            // toggle senha 2
            const pwd2 = document.getElementById('cad-senha-conf');
            const btn2 = document.getElementById('togglePassword2');
            const eye2On = document.getElementById('eye2-on');
            const eye2Off = document.getElementById('eye2-off');

            if (btn2 && pwd2) {
                btn2.addEventListener('click', () => {
                    const isPwd = pwd2.getAttribute('type') === 'password';
                    pwd2.setAttribute('type', isPwd ? 'text' : 'password');
                    eye2On.classList.toggle('hidden', !isPwd);
                    eye2Off.classList.toggle('hidden', isPwd);
                });
            }

            // medidor de força de senha (básico)
            const bar = document.getElementById('senha-meter-bar');
            const label = document.getElementById('senha-meter-label');

            function strengthScore(value) {
                let s = 0;
                if (!value) return 0;
                if (value.length >= 8) s++;
                if (/[a-z]/.test(value) && /[A-Z]/.test(value)) s++;
                if (/\d/.test(value)) s++;
                if (/[^A-Za-z0-9]/.test(value)) s++;
                if (value.length >= 12) s++;
                return Math.min(s, 4); // 0-4
            }

            function renderStrength(v) {
                const widths = ['0%', '25%', '50%', '75%', '100%'];
                const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-lime-400', 'bg-emerald-500'];

                colors.forEach(c => bar.classList.remove(c));
                bar.style.width = widths[v];
                bar.classList.add(colors[v]);

                const labels = ['Muito fraca', 'Fraca', 'Média', 'Boa', 'Excelente'];
                label.textContent = 'Força: ' + labels[v];
            }

            pwd1?.addEventListener('input', (e) => {
                renderStrength(strengthScore(e.target.value));
            });
        });
    </script>
</x-guest-layout>
