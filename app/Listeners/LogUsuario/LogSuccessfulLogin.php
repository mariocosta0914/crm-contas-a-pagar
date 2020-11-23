<?php

namespace App\Listeners\LogUsuario;

use App\LogUsuario;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
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
    public function handle(Login $event)
    {
        LogUsuario::create([
            'user_id' => $event->user->id, 
            'type' => 'LOGIN',
            'description' =>'O Usuário '. $event->user->name .' Entrou no Sistema!'
        ]);
    }
}
