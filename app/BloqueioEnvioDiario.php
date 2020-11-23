<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class BloqueioEnvioDiario extends Model
{
    protected $connection = 'mysql';
    protected $table = 'clientes_bloq_env_diario';

    public static function getClientesBloqueados()
    {
        return BloqueioEnvioDiario::selectRaw('
         id_cliente, nome, cnpj')
            ->from('clientes_bloq_env_diario')
            ->get();
    }

    public static function getClientesBloqueadosByCnpj($cnpj)
    {
        return BloqueioEnvioDiario::selectRaw('
         id_cliente, nome, cnpj')
            ->from('clientes_bloq_env_diario')
            ->where('cnpj', '=', $cnpj)
            ->count();
    }

    public static function getClientesBloqueadosById($id_cliente)
    {
        return BloqueioEnvioDiario::selectRaw('
         id_cliente, nome, cnpj')
            ->from('clientes_bloq_env_diario')
            ->where('id_cliente', '=', $id_cliente)
            ->count();
    }


    

    public static function bloquearCliente($dados)
    {
        BloqueioEnvioDiario::insert($dados);
    }

    public static function desbloquearCliente($id_cliente)
    {
        return BloqueioEnvioDiario::where('id_cliente', $id_cliente)
            ->delete();
    }
}
