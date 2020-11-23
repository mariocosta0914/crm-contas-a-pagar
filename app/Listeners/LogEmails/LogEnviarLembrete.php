<?php

namespace App\Listeners\LogEmails;

use App\Events\EnviarLembrete;
use App\LogUsuario;

class LogEnviarLembrete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EnviarLembrete  $event
     * @return void
     */
    public function handle(EnviarLembrete $event)
    {
        LogUsuario::create([
            'user_id' => auth()->user()->id, 
            'cliente_id' => $event->email()->ClienteId,
            'type' => 'ENVIO DE LEMBRETE DE FATURA',
            'description' =>'Envio referente ao boleto de número: '.$event->email()->CdRcd
        ]);
    }
}
