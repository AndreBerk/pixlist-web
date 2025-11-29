<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Gift;
use App\Models\ListModel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PublicListController extends Controller
{
    /**
     * Mostra a página pública da lista de presentes.
     */
    public function show(Request $request, ListModel $list): View
    {
        $filtro = $request->input('filtro');
        $ordenar = $request->input('ordenar');
        $giftsQuery = $list->gifts();

        // Filtro de disponibilidade
        if ($filtro === 'disponiveis') {
            $giftsQuery->whereRaw('quantity_paid < quantity');
        } elseif ($filtro === 'esgotados') {
            $giftsQuery->whereRaw('quantity_paid >= quantity');
        }

        // Filtro de ordenação
        if ($ordenar === 'preco_asc') {
            $giftsQuery->orderBy('value', 'asc');
        } elseif ($ordenar === 'preco_desc') {
            $giftsQuery->orderBy('value', 'desc');
        } else {
            $giftsQuery->orderBy('value', 'asc'); // Padrão
        }

        $gifts = $giftsQuery->get();
        $totalArrecadado = $list->transactions()->sum('amount');

        // [MUDANÇA] Pega as mensagens para o Mural (APENAS APROVADAS)
        $transactions = $list->transactions()
                            ->where(function($query) {
                                $query->whereNotNull('guest_name')
                                      ->orWhereNotNull('guest_message');
                            })
                            ->where('is_approved', true) // <-- SÓ MOSTRA APROVADOS
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('public-list', [
            'list' => $list,
            'gifts' => $gifts,
            'totalArrecadado' => $totalArrecadado,
            'transactions' => $transactions,
            'filtro_ativo' => $filtro ?? 'todos',
            'ordenar_ativo' => $ordenar ?? 'preco_asc',
        ]);
    }

    /**
     * O convidado confirma o pagamento (PIX direto)
     */
    public function pay(Request $request, Gift $gift): RedirectResponse
    {
        $validatedData = $request->validate([
            'guest_name' => 'nullable|string|max:255',
            'guest_message' => 'nullable|string|max:1000',
        ]);

        $gift->update([
            'quantity_paid' => DB::raw('quantity_paid + 1')
        ]);

        // [MUDANÇA] Salva a transação como "Não Aprovada"
        Transaction::create([
            'list_id'       => $gift->list_id,
            'gift_id'       => $gift->id,
            'amount'        => $gift->value,
            'guest_name'    => $validatedData['guest_name'],
            'guest_message' => $validatedData['guest_message'],
            'is_approved'   => false // <-- MENSAGEM VAI PARA MODERAÇÃO
        ]);

        return redirect()->back()->with('status', 'pagamento-sucesso');
    }
}
