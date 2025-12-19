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
            'photo'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'guest_name' => 'nullable|string|max:255',
            'message'    => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('event_photos', 'public');

            // ✅ RESPEITA CONFIGURAÇÃO DOS NOIVOS
            // moderação ON -> pendente (false)
            // moderação OFF -> aprovada (true)
            $isApproved = !$list->moderation_enabled;

            EventPhoto::create([
                'list_id'     => $list->id,
                'photo_path'  => $path,
                'guest_name'  => $request->guest_name,
                'message'     => $request->message,
                'is_approved' => $isApproved,
            ]);
        }

        return redirect()->back()->with(
            'status',
            $list->moderation_enabled ? 'foto-enviada' : 'foto-publicada'
        );
    }

    /**
     * ADMIN: Aprova uma foto.
     */
    public function approve(Request $request, EventPhoto $photo)
    {
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

        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $photo->delete();

        return redirect()->back()->with('status', 'foto-removida');
    }
}
