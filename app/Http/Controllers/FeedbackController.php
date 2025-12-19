<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Mostra a página do formulário de feedback.
     */
    public function create(Request $request): View
    {
        // Verifica se o usuário enviou feedback nos últimos 30 dias
        // (Lógica excelente para evitar spam)
        $hasSentFeedback = Feedback::where('user_id', $request->user()->id)
            ->where('created_at', '>', now()->subDays(30))
            ->exists();

        return view('feedback', [
            'hasSentFeedback' => $hasSentFeedback
        ]);
    }

    /**
     * Salva o feedback no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validação ajustada para bater com o formulário da View
        $validated = $request->validate([
            'type'    => 'required|string|in:sugestao,erro,elogio,outro', // O campo 'type' vem dos botões de opção
            'message' => 'required|string|max:2000',
            'rating'  => 'nullable|integer|min:1|max:5', // Deixamos opcional caso queira adicionar estrelas no futuro
        ], [
            'type.required'    => 'Por favor, selecione o tipo da mensagem.',
            'message.required' => 'O campo de mensagem não pode ficar vazio.',
        ]);

        Feedback::create([
            'user_id' => $request->user()->id,
            'type'    => $validated['type'],
            'message' => $validated['message'],
            'rating'  => $validated['rating'] ?? null, // Salva nulo se não tiver rating
        ]);

        return redirect()->route('feedback.create')
                         ->with('status', 'feedback-sent');
    }
}
