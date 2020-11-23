<?php

namespace App\Http\Controllers;

use App\Filas;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Exibe a Página Inicial do Supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supervisor.home');
    }

    /**
     * Exibe a Página de Configuração do Supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function configuracao()
    {
        return view('supervisor.configuracao');
    }

    /**
     * Exibe a Página de Configuração do Supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function relatorios()
    {
        return view('supervisor.relatorios');
    }

    /**
     * Pega os Dados da Fila Por Segmento.
     *
     * @return \Illuminate\Http\Response
     */
    public function filas(Request $request)
    {
        return Filas::getDadosFila($request->segmento);
    }

    /**
     * Salva a Fila.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFila(Request $request)
    {
        return Filas::configuraFila($request->fila, $request->segmento, $request->intervalo);
    }

    /**
     * Pega os Dados do Intervalo da Fila Por Segmento.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIntervalos(Request $request)
    {
        return Filas::getIntervalos($request->segmento);
    }

    /**
     * Pegas as Prioridades Salvas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrioridades($segmento)
    {
        return Filas::getPrioridadeSalva($segmento);
    }

    /**
     *Retorna os Valores da Configuração do Intervalo.
     *
     * @return \Illuminate\Http\Response
     */
    public function getValoresFila(Request $request)
    {
        $dados = Filas::getValoresFila($request->fila, $request->segmento, $request->intervalo);
        $soma = Helper::somaValores($dados);
        return json_encode(
            [
                'soma' => $soma,
                'quantidade' =>  count($dados)
            ]
        );
    }
}
