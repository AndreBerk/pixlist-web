<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Importamos o modelo
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FeedbackController extends Controller
{
    /**
     * Mostra a página do formulário de feedback.
     */
    public function create(): View
    {
        // Verifica se o utilizador já enviou um feedback recentemente
        $existingFeedback = Feedback::where('user_id', Auth::id())
                                  ->where('created_at', '>', now()->subDays(30))
                                  ->exists();

        return view('feedback', [
            'hasSentFeedback' => $existingFeedback
        ]);
    }

    /**
     * Salva o feedback no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:2000',
        ], [
            'rating.required' => 'Por favor, selecione uma nota (de 1 a 5 estrelas).'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'message' => $validated['message'],
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('feedback.create')
                         ->with('status', 'feedback-sent');
    }
}
