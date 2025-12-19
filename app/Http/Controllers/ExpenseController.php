<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $list = Auth::user()->list;

        // Pega as despesas ordenadas por vencimento
        $expenses = $list->expenses()->orderBy('due_date')->get();

        // Cálculos para o Dashboard
        $totalBudget = $expenses->sum('amount');
        $totalPaid = $expenses->sum('amount_paid');
        $totalPending = $totalBudget - $totalPaid;

        // Porcentagem paga (evita divisão por zero)
        $progress = $totalBudget > 0 ? ($totalPaid / $totalBudget) * 100 : 0;

        return view('expenses.index', compact('expenses', 'totalBudget', 'totalPaid', 'totalPending', 'progress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'payment_method' => 'nullable|string', // <--- Validação
            'due_date' => 'nullable|date',
        ]);

        Auth::user()->list->expenses()->create([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'payment_method' => $request->payment_method, // <--- Salvando
            'due_date' => $request->due_date,
            'amount_paid' => 0,
            'status' => 'pending'
        ]);

        return back()->with('status', 'Despesa adicionada com sucesso!');
    }

    public function update(Request $request, Expense $despesa)
    {
        // Segurança: garante que a despesa é do usuário
        if($despesa->list_id !== Auth::user()->list->id) abort(403);

        // CENÁRIO 1: Apenas registrando pagamento (Modal Pequeno)
        // Se vier 'amount_paid' mas NÃO vier 'description', é apenas pagamento.
        if ($request->has('amount_paid') && !$request->has('description')) {
            $request->validate([
                'amount_paid' => 'required|numeric|min:0',
            ]);

            $status = 'pending';
            if ($request->amount_paid >= $despesa->amount) $status = 'paid';
            elseif ($request->amount_paid > 0) $status = 'partial';

            $despesa->update([
                'amount_paid' => $request->amount_paid,
                'status' => $status
            ]);

            return back()->with('status', 'Pagamento registrado!');
        }

        // CENÁRIO 2: Edição Completa (Modal de Edição)
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'payment_method' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        // Recalcula o status caso o valor total tenha mudado
        $status = $despesa->status;
        // Se o valor pago já for maior ou igual ao novo total, marca como pago
        if ($despesa->amount_paid >= $request->amount) {
            $status = 'paid';
        } elseif ($despesa->amount_paid > 0) {
            $status = 'partial';
        } else {
            $status = 'pending';
        }

        $despesa->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'payment_method' => $request->payment_method,
            'due_date' => $request->due_date,
            'status' => $status
        ]);

        return back()->with('status', 'Despesa editada com sucesso!');
    }

    // Mude de "Expense $expense" para "Expense $despesa"
    public function destroy(Expense $despesa)
    {
        // Verifica se a despesa pertence à lista do usuário logado
        if($despesa->list_id !== Auth::user()->list->id) {
            abort(403);
        }

        $despesa->delete();

        return back()->with('status', 'Despesa removida.');
    }
}
