<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListModel;

class TieCuttingController extends Controller
{
    // Configuração (Admin)
    public function edit()
    {
        $list = Auth::user()->list;

        // Configuração padrão se estiver vazio
        $slices = $list->roulette_config ?? [
            ['label' => 'R$ 10,00', 'color' => '#34d399'], // Emerald-400
            ['label' => 'R$ 20,00', 'color' => '#fbbf24'], // Amber-400
            ['label' => 'R$ 50,00', 'color' => '#f87171'], // Red-400
            ['label' => 'Mico!',    'color' => '#60a5fa'], // Blue-400
            ['label' => 'Isento',   'color' => '#9ca3af'], // Gray-400
            ['label' => 'R$ 5,00',  'color' => '#a78bfa'], // Purple-400
        ];

        return view('gravata.config', compact('list', 'slices'));
    }

    // Salvar Configuração (Admin)
    public function update(Request $request)
    {
        $request->validate([
            'slices' => 'required|array|min:2',
            'slices.*.label' => 'required|string|max:20',
            'slices.*.color' => 'required|string|size:7', // Hex code
        ]);

        $list = Auth::user()->list;
        $list->update(['roulette_config' => $request->slices]);

        return redirect()->back()->with('status', 'roleta-atualizada');
    }

    // O Jogo (Público/Tela Cheia)
    public function show(ListModel $list)
    {
        $slices = $list->roulette_config ?? [
            ['label' => 'R$ 20', 'color' => '#34d399'],
            ['label' => 'R$ 50', 'color' => '#fbbf24'],
            ['label' => 'R$ 10', 'color' => '#60a5fa'],
            ['label' => 'Isento', 'color' => '#9ca3af'],
        ];

        return view('gravata.game', compact('list', 'slices'));
    }
}
