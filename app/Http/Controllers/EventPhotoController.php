<?php

namespace App\Http\Controllers;

use App\Models\EventPhoto;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventPhotoController extends Controller
{
    /**
     * ADMIN: Mostra o painel de moderação de fotos.
     */
    public function index()
    {
        $list = Auth::user()->list;

        // Separa as fotos em duas coleções para facilitar a view
        $pendingPhotos = $list->photos()
                              ->where('is_approved', false)
                              ->orderBy('created_at', 'desc')
                              ->get();

        $approvedPhotos = $list->photos()
                               ->where('is_approved', true)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('fotos', [
            'list' => $list,
            'pendingPhotos' => $pendingPhotos,
            'approvedPhotos' => $approvedPhotos
        ]);
    }

    /**
     * PÚBLICO: Recebe o upload do convidado.
     */
    public function store(Request $request, ListModel $list)
    {
        $request->validate([
            'photo'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Máx 5MB
            'guest_name' => 'nullable|string|max:255',
            'message'    => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('photo')) {
            // Salva na pasta 'event_photos' dentro do disco 'public'
            $path = $request->file('photo')->store('event_photos', 'public');

            EventPhoto::create([
                'list_id'     => $list->id,
                'photo_path'  => $path,
                'guest_name'  => $request->guest_name,
                'message'     => $request->message,
                'is_approved' => false, // Sempre pendente por segurança
            ]);
        }

        return redirect()->back()->with('status', 'foto-enviada');
    }

    /**
     * ADMIN: Aprova uma foto.
     */
    public function approve(Request $request, EventPhoto $photo)
    {
        // Segurança: verifica se a foto pertence à lista do usuário logado
        if ($photo->list_id !== Auth::user()->list->id) {
            abort(403);
        }

        $photo->update(['is_approved' => true]);

        return redirect()->back()->with('status', 'foto-aprovada');
    }

    /**
     * ADMIN: Apaga uma foto (do banco e do armazenamento).
     */
    public function destroy(Request $request, EventPhoto $photo)
    {
        if ($photo->list_id !== Auth::user()->list->id) {
            abort(403);
        }

        // 1. Apaga o arquivo físico
        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        // 2. Apaga o registro no banco
        $photo->delete();

        return redirect()->back()->with('status', 'foto-removida');
    }
}
