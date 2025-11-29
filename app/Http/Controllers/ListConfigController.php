<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ListConfigController extends Controller
{
    /**
     * Mostra a página de configurações da lista.
     */
    public function edit(Request $request): View
    {
        $list = $request->user()->list;

        return view('configuracoes', [
            'list' => $list,
        ]);
    }

    /**
     * Atualiza as configurações da lista.
     */
    public function update(Request $request): RedirectResponse
    {
        $list = $request->user()->list;

        if (!$list) {
            abort(404, 'Lista não encontrada para este usuário.');
        }

        $validatedData = $request->validate([
            'meta_goal'      => 'nullable|numeric|min:0',
            'pix_key'        => 'required|string|max:255',
            'story'          => 'nullable|string',
            'event_location' => 'nullable|string|max:255',
            'cover_photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'rsvp_enabled'   => 'sometimes|boolean', // aceita on/1/true etc.
        ]);

        // Garante meta_goal como número (ou 0)
        $validatedData['meta_goal'] = $validatedData['meta_goal'] ?? 0;

        // Toggle RSVP (checkbox)
        $validatedData['rsvp_enabled'] = $request->boolean('rsvp_enabled');

        // Upload de capa
        if ($request->hasFile('cover_photo')) {
            // remove capa antiga se existir
            if ($list->cover_photo_url) {
                Storage::disk('public')->delete($list->cover_photo_url);
            }

            // salva nova
            $path = $request->file('cover_photo')->store('list_covers', 'public');
            $validatedData['cover_photo_url'] = $path;
        }

        $list->update($validatedData);

        return redirect()
            ->route('list.config.edit')
            ->with('status', 'list-updated');
    }
}
