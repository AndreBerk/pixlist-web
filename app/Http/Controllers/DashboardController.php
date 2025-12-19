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
        $list = $user->list;

        // Pega os dados que o dashboard precisa
        $totalArrecadado = $list->transactions()->sum('amount');
        $presentesRecebidos = $list->transactions()->count();
        $latestTransactions = $list->transactions()
            ->with('gift')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // [CORREÇÃO] A lógica deve ser: Se já viu, NÃO mostra.
        // Se has_seen_dashboard_tutorial for 0 (false), mostramos.
        // Se for 1 (true), escondemos.
        $showTutorial = !$user->has_seen_dashboard_tutorial;

        return view('dashboard', [
            'list' => $list,
            'totalArrecadado' => $totalArrecadado,
            'presentesRecebidos' => $presentesRecebidos,
            'latestTransactions' => $latestTransactions,
            'showTutorial' => $showTutorial,
        ]);
    }

    /**
     * Marca o tutorial como visto e redireciona.
     */
    public function dismissTutorial(): RedirectResponse
    {
        $user = Auth::user();

        // Marca como visto (true) para não aparecer mais
        $user->forceFill(['has_seen_dashboard_tutorial' => true])->save();

        return redirect()->route('dashboard');
    }
}
