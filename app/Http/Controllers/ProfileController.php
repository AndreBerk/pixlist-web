<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller // (Se der erro 'Controller not found', adicione: use Illuminate\Routing\Controller;)
{
    /**
     * Mostra o formulário de perfil do usuário.
     */
    public function edit(Request $request): View
    {
        // === MUDANÇA AQUI ===
        // 1. Pega o usuário
        $user = $request->user();
        // 2. Pega a lista do usuário (se ela existir)
        $list = $user->list;

        // 3. Envia o usuário E a lista para a view
        return view('profile.edit', [
            'user' => $user,
            'list' => $list,
        ]);
        // === FIM DA MUDANÇA ===
    }

    /**
     * Atualiza as informações de perfil do usuário.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Deleta a conta do usuário.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
