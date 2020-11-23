<?php

namespace App\Console\Commands;

use App\Clientes;
use App\Filas;
use App\Tratativas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AdicionaRenitenciaMesmoDia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:renitenciadia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a Fila Para Uma Renitência no Mesmo Dia';

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
        $renitencias = Tratativas::verificaRenitenciaDataDeHoje();
        foreach ($renitencias as $valor) {
            $cliente = Clientes::getInformacoesClienteRenitencia($valor['id_cliente']);
            Filas::adicionaUmClientenaFila(
                [
                    'segmento' => strtoupper($cliente['segmento']),
                    'id_cliente' => $valor['id_cliente'],
                    'prioridade' => 1
                ]
            );
        }
        Log::info('Quantidade de Cliente de Renitencia Para o Mesmo Dia:' . count($renitencias));
    }
}
