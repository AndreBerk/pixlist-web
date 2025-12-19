<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            Atualizar Senha
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
            Garanta que sua conta esteja usando uma senha longa e aleatória para se manter segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Senha Atual" class="dark:text-slate-300" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full dark:bg-slate-900 dark:text-white dark:border-slate-600 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-600"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nova Senha" class="dark:text-slate-300" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full dark:bg-slate-900 dark:text-white dark:border-slate-600 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-600"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar Senha" class="dark:text-slate-300" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full dark:bg-slate-900 dark:text-white dark:border-slate-600 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-600"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-slate-900 dark:bg-emerald-600 hover:bg-slate-800 dark:hover:bg-emerald-700 focus:ring-emerald-500 dark:focus:ring-emerald-600">
                Salvar
            </x-primary-button>

            @if (session('status') === 'password-updated')
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
