<?php

namespace App\Providers;

use App\Events\DownloadBoleto;
use App\Events\EnviarLembrete;
use App\Events\EnviarTitulo;
use App\Listeners\LogBoletos\LogDownloadBoleto;
use App\Listeners\LogEmails\LogEnviarLembrete;
use App\Listeners\LogEmails\LogEnviarTitulo;
use App\Listeners\LogUsuario\LogSuccessfulLogin;
use App\Listeners\LogUsuario\LogSuccessfulLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Logout::class => [
            LogSuccessfulLogout::class,
        ],
        DownloadBoleto::class => [
            LogDownloadBoleto::class,
        ],
        EnviarLembrete::class => [
            LogEnviarLembrete::class,
        ],
        EnviarTitulo::class => [
            LogEnviarTitulo::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
