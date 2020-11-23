<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailLembrete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($anexo,$dados)
    {
        $this->anexo=$anexo;
        $this->dados=$dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('LEMBRETE: A SUA FATURA WIRELINK ESTÁ ATRASADA, PAGUE AGORA MESMO!')
        ->with(['cliente' => $this->dados])
        ->attach(storage_path('app/boletos/'.$this->anexo))
        ->view('emails.lembrete');
    }
}
