<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use Illuminate\Support\Facades\Storage;

class PublicPhotoController extends Controller
{
    public function store(Request $request, ListModel $list)
    {
        $request->validate([
            'photo'      => 'required|image|max:10240', // 10MB
            'guest_name' => 'nullable|string|max:50',
            'message'    => 'nullable|string|max:200',
        ]);

        // 1. Verifica a configuração da lista
        // Se moderation_enabled for TRUE, a foto NÃO é aprovada automaticamente.
        // Se for FALSE, a foto É aprovada automaticamente.
        $needsApproval = $list->moderation_enabled;

        // A lógica inversa:
        $isApproved = ! $needsApproval;

        // 2. Salva o arquivo
        $path = $request->file('photo')->store('photos', 'public');

        // 3. Cria no banco com o status correto
        $list->photos()->create([
            'photo_path'  => $path,
            'guest_name'  => $request->guest_name,
            'message'     => $request->message,
            'is_approved' => $isApproved,
        ]);

        // 4. Feedback para o usuário
        if ($isApproved) {
            return redirect()->back()->with('status', 'foto-publicada');
        } else {
            return redirect()->back()->with('status', 'foto-enviada');
        }
    }
}
