<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Mostra o extrato de transações.
     */
    public function index(): View
    {
        // Pega a lista do usuário logado
        $list = Auth::user()->list;

        // Pega todas as transações, ordenadas da mais nova para a mais antiga
        $transactions = $list->transactions()
                             ->with('gift') // Carrega o presente para mostrar o nome
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        // Calcula os totais
        $totalArrecadado = $list->transactions()->sum('amount');
        $presentesRecebidos = $list->transactions()->count();

        return view('extrato', [
            'transactions' => $transactions,
            'totalArrecadado' => $totalArrecadado,
            'presentesRecebidos' => $presentesRecebidos,
        ]);
    }

    /**
     * Aprova uma mensagem para aparecer no mural público.
     */
    public function approve(Request $request, Transaction $transaction): RedirectResponse
    {
        // 1. Recupera a lista do usuário logado através do relacionamento
        $userList = $request->user()->list;

        // 2. VERIFICAÇÃO DE SEGURANÇA CORRIGIDA
        // Verifica se o ID da lista da transação é igual ao ID da lista do usuário logado.
        if (!$userList || $userList->id !== $transaction->list_id) {
            abort(403, 'Você não tem permissão para aprovar esta mensagem.');
        }

        // 3. Aprova a mensagem
        $transaction->update(['is_approved' => true]);

        // 4. Retorna para a página anterior com mensagem de sucesso
        return back()->with('status', 'Mensagem aprovada com sucesso!');
    }
}
