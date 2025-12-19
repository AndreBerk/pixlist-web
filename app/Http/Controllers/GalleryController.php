<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use App\Models\EventPhoto;

class GalleryController extends Controller
{
    // Exibe a galeria pública
    public function show($listId)
    {
        $list = ListModel::findOrFail($listId);

        $query = $list->photos()
            ->withCount(['likes', 'comments'])
            ->with('comments')
            ->orderBy('created_at', 'desc');

        // ✅ Só filtra aprovadas se moderação estiver ligada
        if ($list->moderation_enabled) {
            $query->where('is_approved', true);
        }

        $photos = $query->get();

        return view('public-gallery', [
            'list' => $list,
            'photos' => $photos
        ]);
    }

    // Função de Like
    public function like(Request $request, EventPhoto $photo)
    {
        $sessionId = $request->session()->getId();
        $existing = $photo->likes()->where('session_id', $sessionId)->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $photo->likes()->create(['session_id' => $sessionId]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $photo->likes()->count()
        ]);
    }

    // Função de Comentário
    public function comment(Request $request, EventPhoto $photo)
    {
        $request->validate(['content' => 'required|string|max:200']);

        $photo->comments()->create([
            'author_name' => $request->input('author_name', 'Convidado'),
            'content' => $request->content
        ]);

        return redirect()->back()->with('status', 'comentario-enviado');
    }
}
