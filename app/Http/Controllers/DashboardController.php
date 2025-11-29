<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Mostra o painel principal.
     */
    public function index(): View
    {
        $user = Auth::user();
        $list = $user->list; // O middleware 'checklist' garante que isto existe

        // Pega os dados que o dashboard precisa
        $totalArrecadado = $list->transactions()->sum('amount');
        $presentesRecebidos = $list->transactions()->count();
        $latestTransactions = $list->transactions()
            ->with('gift') // 'gift' (minúsculo) é o nome da relação no modelo Transaction
            ->orderBy('created_at', 'desc')
            ->take(3) // Pega só os 3 mais recentes
            ->get();

        // [LÓGICA DO TUTORIAL]
        // Verifica a coluna que criámos
        $showTutorial = !$user->has_seen_dashboard_tutorial;

        return view('dashboard', [
            'list' => $list,
            'totalArrecadado' => $totalArrecadado,
            'presentesRecebidos' => $presentesRecebidos,
            'latestTransactions' => $latestTransactions,
            'showTutorial' => $showTutorial, // Envia a variável para a view
        ]);
    }

    /**
     * Marca o tutorial como visto e redireciona.
     */
    public function dismissTutorial(): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->has_seen_dashboard_tutorial) {
            $user->update(['has_seen_dashboard_tutorial' => true]);
        }

        return redirect()->route('dashboard');
    }
}
