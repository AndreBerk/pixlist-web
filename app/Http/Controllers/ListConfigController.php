<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\EventPhoto;

class ListConfigController extends Controller
{
    public function edit(Request $request): View
    {
        return view('configuracoes', [
            'list' => $request->user()->list,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $list = $request->user()->list;

        $request->validate([
            'display_name' => 'required|string|max:255',
            'event_date'   => 'required|date',
            // ... outras validações ...
        ]);

        // guarda valor antigo pra saber se mudou
        $oldModeration = (bool) $list->moderation_enabled;

        // Checkboxes
        $list->rsvp_enabled       = $request->has('rsvp_enabled');
        $list->gallery_enabled    = $request->has('gallery_enabled');
        $list->moderation_enabled = $request->has('moderation_enabled');

        // Campos simples
        $list->display_name   = $request->display_name;
        $list->event_date     = $request->event_date;
        $list->event_location = $request->event_location;
        $list->story          = $request->story;
        $list->pix_key        = $request->pix_key;
        $list->meta_goal      = $request->meta_goal;

        // Upload da Capa
        if ($request->hasFile('cover_photo')) {
            if ($list->cover_photo_url) {
                Storage::disk('public')->delete($list->cover_photo_url);
            }
            $list->cover_photo_url = $request->file('cover_photo')->store('list_covers', 'public');
        }

        $list->save();

        // ✅ Se DESATIVOU moderação, aprova todas pendentes
        if ($oldModeration === true && $list->moderation_enabled === false) {
            EventPhoto::where('list_id', $list->id)
                ->where('is_approved', false)
                ->update(['is_approved' => true]);
        }

        return redirect()->back()
            ->with('status', 'list-updated')
            ->with('success', 'Configurações salvas!');
    }
}
