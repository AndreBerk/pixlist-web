<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListModel;

class TieCuttingController extends Controller
{
    /**
     * Exibe o formulário de configuração da roleta (Admin).
     */
    public function edit()
    {
        $list = Auth::user()->list;

        // Configuração padrão caso o usuário nunca tenha salvado nada
        // Isso garante que a tela não apareça vazia na primeira vez
        $slices = $list->roulette_config ?? [
            ['label' => 'R$ 10,00', 'color' => '#34d399'], // Emerald
            ['label' => 'R$ 20,00', 'color' => '#fbbf24'], // Amber
            ['label' => 'R$ 50,00', 'color' => '#f87171'], // Red
            ['label' => 'Mico!',    'color' => '#60a5fa'], // Blue
            ['label' => 'Isento',   'color' => '#9ca3af'], // Gray
            ['label' => 'R$ 5,00',  'color' => '#a78bfa'], // Purple
        ];

        return view('gravata.config', compact('list', 'slices'));
    }

    /**
     * Salva as alterações da roleta.
     */
    public function update(Request $request)
    {
        // Validação dos dados vindos do formulário
        $request->validate([
            'slices' => 'required|array|min:2', // Mínimo 2 fatias para girar
            'slices.*.label' => 'required|string|max:20', // Texto curto
            'slices.*.color' => 'required|string|size:7', // Código Hex (#000000)
        ]);

        $list = Auth::user()->list;

        // CORREÇÃO IMPORTANTE:
        // O array_values reindexa o array (0, 1, 2...) caso alguma fatia
        // tenha sido excluída do meio da lista no HTML.
        // Sem isso, o Laravel salva como Objeto JSON {"0":..., "2":...}
        // e o Javascript da roleta quebra.
        $cleanSlices = array_values($request->slices);

        $list->update(['roulette_config' => $cleanSlices]);

        return redirect()->back()->with('status', 'roleta-atualizada');
    }

    /**
     * Exibe o Jogo da Roleta (Público/Tela Cheia).
     */
    public function show(ListModel $list)
    {
        // Se não tiver config salva, usa um padrão básico para não dar erro na tela
        $slices = $list->roulette_config ?? [
            ['label' => 'R$ 10', 'color' => '#34d399'],
            ['label' => 'R$ 20', 'color' => '#fbbf24'],
            ['label' => 'R$ 50', 'color' => '#f87171'],
            ['label' => 'Isento', 'color' => '#9ca3af'],
        ];

        // Garante também na exibição que seja um array sequencial
        // (caso tenha dados antigos salvos errados no banco)
        if (is_array($slices)) {
            $slices = array_values($slices);
        }

        return view('gravata.game', compact('list', 'slices'));
    }
}
