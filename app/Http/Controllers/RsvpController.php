<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // [NOVO] Importante para o PDF funcionar

class RsvpController extends Controller
{
    /**
     * Listagem (Admin) com busca e filtro.
     */
    public function index(Request $request): View
    {
        $list   = $request->user()->list;
        $search = $request->input('search');
        $status = $request->input('status');

        $rsvpsQuery = $list->rsvps();

        // Busca por nome/contato
        $rsvpsQuery->when($search, function ($query, $term) {
            $query->where(function ($q) use ($term) {
                $q->where('guest_name', 'like', "%{$term}%")
                  ->orWhere('contact', 'like', "%{$term}%");
            });
        });

        // Filtro por status
        $rsvpsQuery->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        // Clona para totais
        $totalQuery   = clone $rsvpsQuery;

        $rsvps        = $rsvpsQuery->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $totalAdults  = $totalQuery->sum('adults');
        $totalChildren= $totalQuery->sum('children');

        return view('rsvp', [
            'list'          => $list,
            'rsvps'         => $rsvps,
            'totalAdults'   => $totalAdults,
            'totalChildren' => $totalChildren,
            'search_term'   => $search,
            'status_filter' => $status,
        ]);
    }

    /**
     * Admin cria convidado manualmente (status Pendente).
     */
    public function adminStore(Request $request): RedirectResponse
    {
        $list = $request->user()->list;

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'adults'     => 'required|integer|min:0',
            'children'   => 'required|integer|min:0',
            'contact'    => 'nullable|string|max:255',
        ]);

        $validated['list_id'] = $list->id;
        $validated['status']  = 'Pendente';

        Rsvp::create($validated);

        return redirect()->route('rsvp.index')->with('status', 'rsvp-admin-added');
    }

    /**
     * Confirmação pública de presença (página da lista).
     */
    public function store(Request $request, ListModel $list): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'adults'     => 'required|integer|min:1',
            'children'   => 'required|integer|min:0',
            'contact'    => 'nullable|string|max:255',
        ]);

        $validated['list_id'] = $list->id;
        $validated['status']  = 'Confirmado';

        Rsvp::create($validated);

        return redirect()->back()->with('status', 'rsvp-success');
    }

    /**
     * Form de edição (Admin).
     */
    public function edit(Rsvp $rsvp): View
    {
        if ($rsvp->list_id !== Auth::user()->list->id) {
            abort(403, 'Acesso Não Autorizado');
        }

        // View com hífen (bate com o arquivo abaixo)
        return view('rsvp-edit', ['rsvp' => $rsvp]);
    }

    /**
     * Atualiza convidado (Admin).
     */
    public function update(Request $request, Rsvp $rsvp): RedirectResponse
    {
        if ($rsvp->list_id !== Auth::user()->list->id) {
            abort(403, 'Acesso Não Autorizado');
        }

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'adults'     => 'required|integer|min:0',
            'children'   => 'required|integer|min:0',
            'contact'    => 'nullable|string|max:255',
            'status'     => 'required|string|in:Confirmado,Pendente',
        ]);

        $rsvp->update($validated);

        return redirect()->route('rsvp.index')->with('status', 'rsvp-admin-updated');
    }

    /**
     * Remove convidado (Admin).
     */
    public function destroy(Rsvp $rsvp): RedirectResponse
    {
        if ($rsvp->list_id !== Auth::user()->list->id) {
            abort(403, 'Acesso Não Autorizado');
        }

        $rsvp->delete();

        return redirect()->route('rsvp.index')->with('status', 'rsvp-admin-deleted');
    }

    /**
     * [NOVO] Gera e baixa o PDF da lista de convidados.
     */
    public function exportPdf(Request $request)
    {
        $list = $request->user()->list;

        // 1. Pegar TODOS os convidados (sem paginação), ordenados por nome
        $rsvps = $list->rsvps()->orderBy('guest_name')->get();

        // 2. Calcular totais para o rodapé do PDF
        $totalAdults = $list->rsvps()->sum('adults');
        $totalChildren = $list->rsvps()->sum('children');
        $totalGuests = $totalAdults + $totalChildren;

        // 3. Carregar a View do PDF
        $pdf = Pdf::loadView('rsvp-pdf', [
            'list' => $list,
            'rsvps' => $rsvps,
            'totalAdults' => $totalAdults,
            'totalChildren' => $totalChildren,
            'totalGuests' => $totalGuests
        ]);

        // 4. Configurar papel A4
        $pdf->setPaper('a4', 'portrait');

        // 5. Baixar o arquivo
        return $pdf->download('lista-convidados-' . $list->id . '.pdf');
    }
}
