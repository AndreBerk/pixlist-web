<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTermsAccepted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. Verifica se o usuário está logado E se NÃO aceitou os termos
        if ($user && is_null($user->terms_accepted_at)) {

            // 2. Lista de rotas permitidas para quem ainda não aceitou
            $rotasPermitidas = [
                'terms.accept', // A tela de aceitar
                'terms.store',  // A ação de salvar o aceite
                'logout',       // IMPORTANTE: Permitir sair da conta
                'termos',       // Ler os termos
            ];

            // 3. Se a rota atual NÃO for uma das permitidas, redireciona
            if (!in_array($request->route()->getName(), $rotasPermitidas)) {
                return redirect()->route('terms.accept');
            }
        }

        return $next($request);
    }
}
