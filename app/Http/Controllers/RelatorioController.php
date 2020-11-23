<?php

namespace App\Http\Controllers;

use App\Exports\Relatorios as ExportsRelatorios;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    /**
     * Cria o Relatórios
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dados = array();
        if (isset($request->operadores)) {
            foreach ($request->operadores as $operadores) {
                array_push($dados, $operadores['id']);
            }
        }
        $headings = [
            'Data Ocorrência',
            'Operador',
            'Ocorrência',
            'Título',
            'Títulos',
            'Cliente',
            'Vencimento Original',
            'Vencimento Prorrogado',
            'Saldo Devedor',
            'Saldo Negociado',
            'Data Último Acionamento',
        ];
        return Excel::download(new ExportsRelatorios($request->data_inicial, $request->data_final, $dados, $headings), 'Relatorio-CRM-Cobranca.xls');
    }
}
