<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            Informações do Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
            Atualize os dados do seu perfil e endereço de e-mail.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nome" class="dark:text-slate-300" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full dark:bg-slate-900 dark:text-white dark:border-slate-600 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-600"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="E-mail" class="dark:text-slate-300" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full dark:bg-slate-900 dark:text-white dark:border-slate-600 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-600"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-slate-300">
                        Seu endereço de e-mail não foi verificado.

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:focus:ring-offset-slate-800">
                            Clique aqui para reenviar o e-mail de verificação.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600 dark:text-emerald-400">
                            Um novo link de verificação foi enviado para o seu e-mail.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-slate-900 dark:bg-emerald-600 hover:bg-slate-800 dark:hover:bg-emerald-700 focus:ring-emerald-500 dark:focus:ring-emerald-600">
                Salvar
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-slate-400"
                >Salvo.</p>
            @endif
        </div>
    </form>
</section>
