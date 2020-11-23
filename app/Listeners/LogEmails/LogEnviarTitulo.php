<?php

namespace App\Listeners\LogEmails;

use App\Events\EnviarTitulo;
use App\LogUsuario;

class LogEnviarTitulo
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
     * @param  EnviarTitulo  $event
     * @return void
     */
    public function handle(EnviarTitulo $event)
    {
        LogUsuario::create([
            'user_id' => auth()->user()->id, 
            'cliente_id' => $event->email()->ClienteId,
            'type' => 'ENVIO DE TITULO E NOTA',
            'description' =>'Envio referente ao boleto de número: '.$event->email()->CdRcd
        ]);
    }
}
