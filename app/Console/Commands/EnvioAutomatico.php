<?php

namespace App\Console\Commands;

use App\Http\Controllers\EnvioDiario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EnvioAutomatico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:envioAutomatico';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::debug("Inicio envio diario.");

        $this->info('Enviando os Boletoscom data de vencimeto Hoje.');
        EnvioDiario::EnvioBoletosVencHj();

        $this->info('Enviando os Boletos com data de vencimeto para tres dias.');
        EnvioDiario::EnvioBoletosVencEmTresD();

        $this->info('Enviando os Boletos com atraso ha 3 dias');
        EnvioDiario::EnvioBoletosAtrasoTresD();

        $this->info('Enviando os Boletos antigos');
        EnvioDiario::EnvioBoletosAtrasoSeteD();
       // EnvioDiario::envio();

        Log::debug("Fim do envio diario.");
    }
}
