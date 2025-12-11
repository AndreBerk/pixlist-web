<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use App\Models\EventPhoto;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // Mostra a grade de fotos (Estilo Instagram)
    public function show($listId)
    {
        $list = ListModel::findOrFail($listId);

        $photos = $list->photos()
                       ->where('is_approved', true)
                       ->withCount(['likes', 'comments'])
                       ->with('comments')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('public-gallery', [
            'list' => $list,
            'photos' => $photos
        ]);
    }

    // Dar Like (AJAX)
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

    // Comentar (COM FILTRO DE PALAVRÕES)
    public function comment(Request $request, EventPhoto $photo)
    {
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:200',
                // [NOVO] Lógica de Bloqueio de Palavras
                function ($attribute, $value, $fail) {
                    // Lista básica de palavras ofensivas (adicione mais aqui se quiser)
                    $badWords = [
                        'merda', 'bosta', 'caralho', 'porra', 'puta', 'viado', 'corno',
                        'buceta', 'pinto', 'cu', 'foder', 'imbecil', 'idiota', 'trouxa',
                        'vagabundo', 'safado', 'inutil', 'burro'
                    ];

                    // Verifica se alguma palavra proibida está no texto (case insensitive)
                    foreach ($badWords as $word) {
                        // stripos encontra a posição da palavra ignorando maiúsculas/minúsculas
                        if (stripos($value, $word) !== false) {
                            $fail('Por favor, mantenha o respeito e evite palavras ofensivas.');
                            return; // Para a verificação ao encontrar a primeira
                        }
                    }
                },
            ]
        ]);

        $authorName = $request->input('author_name', 'Convidado');

        $photo->comments()->create([
            'author_name' => $authorName,
            'content' => $request->content
        ]);

        return redirect()->back()->with('status', 'comentario-enviado');
    }
}
