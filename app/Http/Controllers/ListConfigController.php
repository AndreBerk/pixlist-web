<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ListConfigController extends Controller
{
    /**
     * Mostra o formulário de configurações.
     */
    public function edit(Request $request): View
    {
        return view('configuracoes', [
            'list' => $request->user()->list,
        ]);
    }

    /**
     * Atualiza as configurações da lista.
     */
    public function update(Request $request): RedirectResponse
    {
        $list = $request->user()->list;

        // 1. Guardamos a data antiga para comparar depois
        // (Formatamos para Y-m-d para garantir que a comparação seja justa)
        $oldDate = $list->event_date ? Carbon::parse($list->event_date)->format('Y-m-d') : null;

        // 2. Validação
        $validated = $request->validate([
            'display_name'    => 'required|string|max:255',
            'event_date'      => 'required|date',
            'event_location'  => 'nullable|string|max:255',
            'story'           => 'nullable|string|max:2000',
            'pix_key'         => 'nullable|string|max:255',
            'meta_goal'       => 'nullable|numeric|min:0',
            'cover_photo'     => 'nullable|image|max:2048', // Máx 2MB
            // Os checkboxes não precisam de validação estrita, apenas verificamos presença
            'rsvp_enabled'    => 'nullable',
            'gallery_enabled' => 'nullable',
        ]);

        // 3. Tratamento dos "Switches" (Checkboxes)
        // Se o checkbox não estiver marcado, o $request não envia nada, então usamos has()
        $list->rsvp_enabled    = $request->has('rsvp_enabled');
        $list->gallery_enabled = $request->has('gallery_enabled');

        // 4. Tratamento da Foto de Capa
        if ($request->hasFile('cover_photo')) {
            // Apaga a antiga se existir para não acumular lixo
            if ($list->cover_photo_url) {
                Storage::disk('public')->delete($list->cover_photo_url);
            }
            // Salva a nova
            $path = $request->file('cover_photo')->store('list_covers', 'public');
            $list->cover_photo_url = $path;
        }

        // 5. Atualiza os dados de texto
        $list->display_name   = $validated['display_name'];
        $list->event_date     = $validated['event_date'];
        $list->event_location = $validated['event_location'] ?? null;
        $list->story          = $validated['story'] ?? null;
        $list->pix_key        = $validated['pix_key'] ?? null;
        $list->meta_goal      = $validated['meta_goal'] ?? null;

        // 6. Salva no Banco de Dados
        $list->save();

        // 7. Lógica de Notificação de Mudança de Data
        $newDate = Carbon::parse($list->event_date)->format('Y-m-d');
        $message = 'Configurações salvas com sucesso!';

        // Se a data antiga existia E é diferente da nova
        if ($oldDate && $oldDate !== $newDate) {
            // Dispara o envio de e-mails em segundo plano (ou direto, dependendo da config)
            $count = $this->notifyGuestsAboutDateChange($list, $newDate);

            if ($count > 0) {
                $message = "Configurações salvas! $count convidados confirmados foram notificados da nova data.";
            }
        }

        return redirect()->back()->with('status', 'list-updated')->with('success', $message);
    }

    /**
     * Envia e-mail para convidados CONFIRMADOS avisando da mudança.
     * Retorna o número de e-mails enviados.
     */
    private function notifyGuestsAboutDateChange($list, $newDateIso)
    {
        // Pega apenas convidados CONFIRMADOS e que têm email (contato preenchido)
        $guests = $list->rsvps()
                       ->where('status', 'Confirmado')
                       ->whereNotNull('contact')
                       ->get();

        $novaDataFmt = Carbon::parse($newDateIso)->format('d/m/Y');
        $linkLista   = route('list.public.show', ['list' => $list->id]);
        $countSent   = 0;

        foreach ($guests as $guest) {
            // Verifica se o contato parece um e-mail válido
            if (filter_var($guest->contact, FILTER_VALIDATE_EMAIL)) {
                try {
                    // Texto do E-mail
                    $subject = "⚠️ Atenção: Nova data para " . $list->display_name;
                    $content = "Olá {$guest->guest_name},\n\n" .
                               "Os noivos alteraram a data do evento '{$list->display_name}'.\n\n" .
                               "📅 A NOVA DATA É: {$novaDataFmt}\n\n" .
                               "Por favor, atualize a sua agenda!\n\n" .
                               "Acesse o site para ver mais detalhes:\n" .
                               $linkLista;

                    // Envio (Raw é mais simples para este caso, mas pode usar Mailable)
                    Mail::raw($content, function ($message) use ($guest, $subject) {
                        $message->to($guest->contact)
                                ->subject($subject);
                    });

                    Log::info("Aviso de mudança de data enviado para: " . $guest->contact);
                    $countSent++;

                } catch (\Exception $e) {
                    Log::error("Falha ao enviar aviso para {$guest->contact}: " . $e->getMessage());
                }
            }
        }

        return $countSent;
    }
}
