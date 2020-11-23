<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Boletos\BoletoItau;
use App\Boletos\BoletoBradesco;
use App\Boletos\BoletoCaixa;
use App\Boletos\BoletoSantander;

class Clientes extends Model
{
    protected $connection = 'sqlsrv';

    public static function getQtdTitulos($id_cliente)
    {
        return TodosBoletos::getQtdTitulos($id_cliente);
    }

    public static function getInformacoesCliente($id)
    {
        return Clientes::selectRaw('NomeFantasia as nome, CNPJCPF as cnpj, Vendedor, Email,
        Telefone, Telefone1, Telefone2, Celular')
            ->from('Pessoas')
            ->where('CodigoCliente', '=', $id)
            ->first();
    }


    public static function getInforTitutlos($id_cliente)
    {
        return TodosBoletos::getInformacoesTitulos($id_cliente);
    }

    public static function getTitutlosId($id)
    {
        return Clientes::selectRAW('CdRcd as id,
        ClienteId,
        Cast(Valor as decimal(8, 2)) Valor,
        convert(varchar, DtRctVen ,103) as data_vencimento,
        Situacao, SituacaoBoleto,
        Cast(ValorPago as decimal(8, 2)) valor_pago')
            ->from('Boletos')
            ->whereRaw("CdRcd in ($id)")
            ->get();
    }

    public static function getCliente($cnpj)
    {
        return Clientes::selectRaw('CodigoCliente as id_cliente,TipoCliente as segmento')
            ->from('Pessoas')
            ->where('CNPJCPF', '=', $cnpj)
            ->first()->toArray();
    }

    public static function getInformacoesClienteRenitencia($id)
    {
        return Clientes::selectRaw('TipoCliente as segmento')
            ->from('Pessoas')
            ->where('CodigoCliente', '=', $id)
            ->first()->toArray();
    }

    public static function getTodosCliente()
    {
        
        return  Clientes::selectRaw('
        CodigoCliente as id_cliente,NomeFantasia as nome,CNPJCPF as cnpj')
            ->from('Pessoas')
            ->whereRaw("CNPJCPF is not null")
            ->get();
    }
}
