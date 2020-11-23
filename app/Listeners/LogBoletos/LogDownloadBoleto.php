<?php

namespace App\Listeners\LogBoletos;

use App\Events\DownloadBoleto;
use App\LogUsuario;

class LogDownloadBoleto
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
     * @param  DownloadBoleto  $event
     * @return void
     */
    public function handle(DownloadBoleto $event)
    {
        LogUsuario::create([
            'user_id' => auth()->user()->id, 
            'cliente_id' => $event->boleto()->ClienteId,
            'type' => 'DOWNLOAD DE BOLETO',
            'description' =>'Download do boleto de número: '.$event->boleto()->CdRcd
        ]);
    }
}
