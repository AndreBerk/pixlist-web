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
    public function show(Request $request, ListModel $list): View
    {
        // ... (lógica de filtros continua igual) ...
        $filtro = $request->input('filtro');
        $ordenar = $request->input('ordenar');
        $giftsQuery = $list->gifts();

        if ($filtro === 'disponiveis') {
            $giftsQuery->whereRaw('quantity_paid < quantity');
        } elseif ($filtro === 'esgotados') {
            $giftsQuery->whereRaw('quantity_paid >= quantity');
        }

        if ($ordenar === 'preco_asc') {
            $giftsQuery->orderBy('value', 'asc');
        } elseif ($ordenar === 'preco_desc') {
            $giftsQuery->orderBy('value', 'desc');
        } else {
            $giftsQuery->orderBy('value', 'asc');
        }

        $gifts = $giftsQuery->get();
        $totalArrecadado = $list->transactions()->sum('amount');

        // Mural de Recados (apenas aprovados)
        $transactions = $list->transactions()
                            ->where(function($query) {
                                $query->whereNotNull('guest_name')
                                      ->orWhereNotNull('guest_message');
                            })
                            ->where('is_approved', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // [NOVO] Galeria de Fotos (apenas aprovadas)
        $photos = $list->photos()
                       ->where('is_approved', true)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('public-list', [
            'list' => $list,
            'gifts' => $gifts,
            'totalArrecadado' => $totalArrecadado,
            'transactions' => $transactions,
            'photos' => $photos, // <-- Enviamos as fotos para a view
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
