<?php

namespace App\Mail;

use App\Models\ListModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlanActivated extends Mailable
{
    use Queueable, SerializesModels;

    public $list;

    /**
     * Cria uma nova instância da mensagem.
     */
    public function __construct(ListModel $list)
    {
        $this->list = $list;
    }

    /**
     * Constrói a mensagem.
     */
    public function build()
    {
        return $this->subject('Pagamento Confirmado! Sua lista Pixlist está ativa 🚀')
                    ->view('emails.plan_activated');
    }
}