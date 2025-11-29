<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Gift;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    /**
     * Mostra a página de gerenciamento de presentes. (Read)
     */
    public function index(Request $request): View
    {
        $list  = $request->user()->list;
        $gifts = $list->gifts()->orderBy('created_at', 'desc')->get();

        $style          = $list->style;
        $allTemplates   = config('templates.gifts');
        $templatesSugeridos = $allTemplates[$style] ?? $allTemplates['Tradicional'];

        return view('presentes', [
            'list'              => $list,
            'gifts'             => $gifts,
            'templatesSugeridos'=> $templatesSugeridos,
        ]);
    }

    /**
     * Salva um novo presente no banco de dados. (Create)
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'value'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon_name'   => 'nullable|string|max:50|regex:/^[a-z0-9-]+$/',
        ]);

        $list = $request->user()->list;

        $gift = new Gift();
        $gift->list_id     = $list->id;
        $gift->title       = $validatedData['title'];
        $gift->value       = $validatedData['value'];
        $gift->quantity    = $validatedData['quantity'];
        $gift->description = $validatedData['description'] ?? null;
        $gift->quantity_paid = 0; // garante padrão

        // LÓGICA HÍBRIDA (Ícone ou Imagem)
        $gift->image_url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gift_images', 'public');
            $gift->image_url = $path; // ex: gift_images/xxxx.jpg
        } elseif (!empty($validatedData['icon_name'] ?? null)) {
            // guarda o nome do ícone (lucide) no campo image_url
            $gift->image_url = $validatedData['icon_name'];
        }

        $gift->save();

        return redirect()
            ->route('presentes.index')
            ->with('status', 'presente-criado');
    }

    /**
     * Mostra o formulário para editar um presente. (Update - Parte 1)
     */
    public function edit(Request $request, Gift $presente): View
    {
        if ($request->user()->list->id !== $presente->list_id) {
            abort(403, 'AÇÃO NÃO AUTORIZADA');
        }

        return view('presentes-edit', [
            'presente' => $presente,
        ]);
    }

    /**
     * Atualiza um presente no banco de dados. (Update - Parte 2)
     */
    public function update(Request $request, Gift $presente): RedirectResponse
    {
        if ($request->user()->list->id !== $presente->list_id) {
            abort(403, 'AÇÃO NÃO AUTORIZADA');
        }

        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'value'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon_name'   => 'nullable|string|max:50|regex:/^[a-z0-9-]+$/',
        ]);

        // Atualiza campos básicos
        $presente->title       = $validatedData['title'];
        $presente->value       = $validatedData['value'];
        $presente->quantity    = $validatedData['quantity'];
        $presente->description = $validatedData['description'] ?? null;

        // LÓGICA HÍBRIDA (Ícone ou Imagem) - Melhorada
        $oldImage = $presente->image_url;

        // Se usuário fez upload de nova imagem
        if ($request->hasFile('image')) {
            // apaga a antiga se for arquivo salvo em gift_images/
            if ($oldImage && Str::startsWith($oldImage, 'gift_images/')) {
                Storage::disk('public')->delete($oldImage);
            }

            $path = $request->file('image')->store('gift_images', 'public');
            $presente->image_url = $path;

        // Senão, se o usuário informou um novo ícone
        } elseif (!empty($validatedData['icon_name'] ?? null)) {
            // se antes era imagem de upload, deletamos o arquivo
            if ($oldImage && Str::startsWith($oldImage, 'gift_images/')) {
                Storage::disk('public')->delete($oldImage);
            }

            $presente->image_url = $validatedData['icon_name'];

        // Caso não tenha imagem nem icon_name no request,
        // mantemos o image_url atual (não apagamos nada).
        }

        // Protege contra quantity_paid maior que quantity
        if ($presente->quantity_paid > $presente->quantity) {
            $presente->quantity_paid = $presente->quantity;
        }

        $presente->save();

        return redirect()
            ->route('presentes.index')
            ->with('status', 'presente-atualizado');
    }

    /**
     * Remove um presente específico do banco de dados. (Delete)
     */
    public function destroy(Request $request, Gift $presente): RedirectResponse
    {
        if ($request->user()->list->id !== $presente->list_id) {
            abort(403, 'AÇÃO NÃO AUTORIZADA');
        }

        // Deleta arquivo de imagem se for upload
        if ($presente->image_url && Str::startsWith($presente->image_url, 'gift_images/')) {
            Storage::disk('public')->delete($presente->image_url);
        }

        $presente->delete();

        return redirect()
            ->route('presentes.index')
            ->with('status', 'presente-deletado');
    }
}
