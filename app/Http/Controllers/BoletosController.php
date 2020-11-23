<?php

namespace App\Http\Controllers;
use App\Helpers\Helper;
use App\TodosBoletos;

class BoletosController extends Controller
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
     * Retorna o Boleto em PDF do Cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_boleto)
    {
        $dados=TodosBoletos::getInformacaoBoleto($id_boleto);
        Helper::gerarBoleto($dados);
    }
}
