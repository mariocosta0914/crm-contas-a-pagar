<?php

namespace App\Mail;

use App\Helpers\ServiceEnvioDiario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendeEnvioDiario extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $boleto,
        $dados,
        $nota,
        $assuntos,
        $tipos_envio
    ) {
        $this->assuntos = $assuntos;
        $this->tipos_envio = $tipos_envio;
        $this->boleto = $boleto;
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
        // Caso seja presciso enviar menssagens em massa 
        // return $this->subject('COMUNICADO AO CLIENTES TTVI')
        //             ->view('emails.script');

        switch ($this->tipos_envio) {

            case 'LEMBRETE DIA';
                if (
                    $this->dados->TipoDeDocumento == 'Nota Fiscal de Serviço Eletrônica'
                    || $this->dados->TipoDeDocumento == 'Nota de Telecomunicação - Fortel'
                ) {
                    return $this->subject($this->assuntos)
                        ->with(['boleto' => $this->dados])
                        ->attach(storage_path('app/boletos/' . $this->boleto))
                        ->attach(storage_path('app/notas/' . $this->nota))
                        ->view('emails.viewDoDia');
                } else {
                    return $this->subject($this->assuntos)
                        ->with(['boleto' => $this->dados])
                        ->attach(storage_path('app/boletos/' . $this->boleto))
                        ->view('emails.viewDoDia');
                }
                break;
            case 'LEMBRETE 3 DIAS':
                return $this->subject($this->assuntos)
                    ->with(['boleto' => $this->dados])
                    ->view('emails.viewLembrete');

                break;

            case 'COBRANCA':
                return $this->subject($this->assuntos)
                    ->with(['boleto' => $this->dados])
                    ->view('emails.viewCobranca');

                break;
        }
    }
}
