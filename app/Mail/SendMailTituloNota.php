<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailTituloNota extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($anexo, $dados, $nota)
    {
        $this->anexo = $anexo;
        $this->dados = $dados;
        $this->nota = $nota;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if ($this->dados->NrBco == '104-0') {
            return $this->subject('WIRELINK INFORMA: SUA FATURA CHEGOU!')
                ->with(['boleto' => $this->dados])
                ->attach(storage_path('app/boletos/' . $this->anexo))
                ->view('emails.tituloNota');
        } else {
            return $this->subject('WIRELINK INFORMA: SUA FATURA CHEGOU!')
                ->with(['boleto' => $this->dados])
                ->attach(storage_path('app/boletos/' . $this->anexo))
                ->attach(storage_path('app/notas/' . $this->nota))
                ->view('emails.tituloNota');
        }
    }
}
