<?php

namespace App\Listeners\LogUsuario;

use App\LogUsuario;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
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
     * @param  object  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        LogUsuario::create([
            'user_id' => $event->user->id, 
            'type' => 'LOGOUT',
            'description' =>'O Usuário '. $event->user->name .' Saiu do Sistema!'
        ]);
    }
}
