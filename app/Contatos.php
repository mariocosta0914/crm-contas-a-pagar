<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $connection = 'mysql';
    protected $table = 'contatos';
    protected $fillable = ['id_cliente', 'contato', 'tipo_contato', 'whatsapp'];

    public static function insertContatos($dados)
    {
        return Contatos::create($dados);
    }

    public static function getContatos($id_cliente)
    {
        return Contatos::select('tipo_contato', 'contato', 'whatsapp')
            ->from('contatos')
            ->where('id_cliente', '=', $id_cliente)
            ->orderBy('tipo_contato', 'ASC')
            ->get();
    }

    public static function getContatosEnvioEmail($id_cliente)
    {
        $contatos = Contatos::selectRaw('contato as email')
            ->from('contatos')
            ->where('id_cliente', '=', $id_cliente)
            ->where('tipo_contato', '=', "email")
            ->get()->toArray();
        $contato2 = Clientes::selectRaw('Email as email')
            ->from('Pessoas')
            ->where('CodigoCliente', '=', $id_cliente)
            ->first()->toArray();
            array_push($contatos, $contato2);
            return $contatos;
    }
}