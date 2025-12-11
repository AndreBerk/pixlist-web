<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                // Lógica de validação personalizada (Anti-Typo)
                function ($attribute, $value, $fail) {
                    $dominiosErrados = [
                        'gmil.com', 'gmal.com', 'gmai.com', 'gimail.com',
                        'hotmal.com', 'hotmail.com.br.com', 'hotmai.com',
                        'outlok.com', 'outlook.com.br.com',
                        'yaho.com', 'yahoo.com.br.com'
                    ];

                    // Pega só o domínio
                    $parts = explode('@', $value);
                    if (count($parts) < 2) return; // Email inválido já falha na regra 'email'
                    $dominio = $parts[1];

                    if (in_array($dominio, $dominiosErrados)) {
                        $fail('Parece que há um erro de digitação no seu e-mail. Você quis dizer gmail.com ou hotmail.com?');
                    }

                    if (!str_contains($dominio, '.')) {
                        $fail('O e-mail parece incompleto. Faltou o .com ou .com.br?');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Se a validação falhar, o Laravel lança uma exceção e o código para aqui.
        // Se chegar aqui, é porque passou.

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // O retorno OBRIGATÓRIO
        return redirect(route('dashboard', absolute: false));
    }
}
