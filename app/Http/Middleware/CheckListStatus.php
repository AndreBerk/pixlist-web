<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Carbon\Carbon; // Import

class CheckListStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // --- Verificação 1 ---
        // O utilizador nem sequer tem uma lista?
        if ($user->list()->doesntExist()) {
            return redirect()->route('onboarding.create');
        }

        $list = $user->list;

        // [MUDANÇA] LÓGICA DE ACESSO ATUALIZADA

        // --- Verificação 2 (Acesso de Teste) ---
        // O utilizador NÃO PAGOU. Está no TESTE GRÁTIS?
        if (!$list->plano_pago && $list->trial_expires_at && Carbon::parse($list->trial_expires_at)->isFuture()) {
            return $next($request); // Deixa passar (Acesso de Teste).
        }

        // --- Verificação 3 (Acesso Pago) ---
        // O utilizador JÁ PAGOU E O PLANO ESTÁ VÁLIDO?
        if ($list->plano_pago && $list->plano_expires_at && Carbon::parse($list->plano_expires_at)->isFuture()) {
            return $next($request); // Deixa passar (Acesso Pago).
        }

        // --- Verificação 4 (Acesso Bloqueado) ---
        // O utilizador NÃO PAGOU, o TESTE EXPIROU, ou o PLANO PAGO EXPIROU.
        // Expulsa-o para a página de pagamento.
        return redirect()->route('plano.index');
    }
}
