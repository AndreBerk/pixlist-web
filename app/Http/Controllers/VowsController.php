<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;


class VowsController extends Controller
{
    public function index()
    {
        $list = Auth::user()->list;

        // Se não for Casamento, redireciona (opcional, ou apenas avisa na view)
        // Vamos tratar isso visualmente na View para ser menos agressivo

        return view('vows.index', compact('list'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'role' => 'required|in:bride,groom', // Quem está salvando?
            'vows' => 'nullable|string',
            'pin'  => 'nullable|string|max:4', // Senha de 4 dígitos
        ]);

        $list = Auth::user()->list;
        $role = $request->role;

        // Atualiza dinamicamente dependendo de quem é
        if ($role === 'bride') {
            $list->vows_bride = $request->vows;
            if ($request->filled('pin')) $list->vows_bride_pin = $request->pin;
        } else {
            $list->vows_groom = $request->vows;
            if ($request->filled('pin')) $list->vows_groom_pin = $request->pin;
        }

        $list->save();

        return back()->with('status', 'Votos salvos com sucesso!');
    }
    public function print(Request $request, $role)
    {
        $list = Auth::user()->list;

        if (!in_array($role, ['bride', 'groom'])) abort(404);

        // Pega os dados corretos baseados no papel (noiva ou noivo)
        $pinStored = ($role === 'bride') ? $list->vows_bride_pin : $list->vows_groom_pin;
        $content   = ($role === 'bride') ? $list->vows_bride : $list->vows_groom;
        $title     = ($role === 'bride') ? 'Votos da Noiva' : 'Votos do Noivo';

        // SEGURANÇA: Se tem PIN configurado E o PIN enviado não bate (ou está vazio)
        if ($pinStored && $request->input('pin') !== $pinStored) {
            // Retorna a tela de bloqueio (Gatekeeper) em vez do conteúdo
            return view('vows.gate', compact('role', 'title'));
        }

        // Se passou da segurança (ou não tem senha), mostra o PDF
        return view('vows.print', compact('content', 'title', 'list'));
    }
    // 1. Enviar o Código (AJAX ou Form)
    public function sendResetCode(Request $request)
    {
        $role = $request->role;
        $user = Auth::user();

        // Gera código de 6 dígitos
        $code = rand(100000, 999999);

        // Salva no Cache por 10 minutos (chave única por usuário e papel)
        Cache::put("vows_reset_{$user->id}_{$role}", $code, 600);

        // Envia por E-mail (Simples e Rápido)
        // Você pode criar uma Mailable bonita depois, aqui vou usar o raw para ser prático
        Mail::raw("Seu código de segurança para acessar os votos é: {$code}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Código de Segurança - Votos');
        });

        return response()->json(['message' => 'Código enviado para o e-mail cadastrado!']);
    }

    // 2. Página para digitar o código
    public function verifyCodePage($role)
    {
        if (!in_array($role, ['bride', 'groom'])) abort(404);
        return view('vows.reset', compact('role'));
    }

    // 3. Verificar código e Resetar PIN
    public function resetWithCode(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'code' => 'required|numeric',
            'new_pin' => 'required|numeric|digits:4'
        ]);

        $user = Auth::user();
        $cachedCode = Cache::get("vows_reset_{$user->id}_{$request->role}");

        if (!$cachedCode || $cachedCode != $request->code) {
            return back()->withErrors(['code' => 'Código inválido ou expirado.']);
        }

        // Código correto! Reseta o PIN
        $list = $user->list;
        if ($request->role === 'bride') {
            $list->vows_bride_pin = $request->new_pin;
        } else {
            $list->vows_groom_pin = $request->new_pin;
        }
        $list->save();

        // Limpa o cache
        Cache::forget("vows_reset_{$user->id}_{$request->role}");

        return redirect()->route('vows.index')->with('status', 'PIN redefinido com sucesso!');
    }
}
