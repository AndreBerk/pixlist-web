<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel; // Importa o Model da Lista
use Illuminate\Support\Facades\Auth; // Importa o helper de Autenticação
use \Carbon\Carbon; // Import para manipular datas

class OnboardingController extends Controller
{
    /**
     * Mostra a página de formulário do onboarding.
     */
    public function create()
    {
        if (Auth::user()->list()->exists()) {
            return redirect()->route('dashboard');
        }

        return view('onboarding');
    }

    /**
     * Salva os dados do formulário de onboarding.
     */
    public function store(Request $request)
    {
        // 1. VALIDAÇÃO:
        $validatedData = $request->validate([
            'event_type'   => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            // [MUDANÇA] Adicionamos a validação de data futura (máx. 2 anos)
            'event_date'   => [
                'required',
                'date',
                'after_or_equal:today', // Não pode ser no passado
                'before_or_equal:' . now()->addYears(2)->format('Y-m-d') // Não pode ser mais de 2 anos no futuro
            ],
            'style'        => 'required|string|max:255',
        ], [
            'event_date.before_or_equal' => 'A data do evento não pode ser mais de 2 anos no futuro.'
        ]);

        // 2. CRIAÇÃO:
        $userId = Auth::id();

        ListModel::create([
            'user_id'        => $userId,
            'event_type'     => $validatedData['event_type'],
            'display_name'   => $validatedData['display_name'],
            'event_date'     => $validatedData['event_date'],
            'style'          => $validatedData['style'],
            'trial_expires_at' => Carbon::now()->addDays(7)
        ]);

        // 3. REDIRECIONAMENTO:
        return redirect()->route('dashboard');
    }
}
