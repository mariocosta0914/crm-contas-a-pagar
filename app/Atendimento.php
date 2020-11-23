<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $connection = 'mysql';
    protected $table = 'atendimento';
    protected $fillable = ['id_cliente', 'id_usuario','observacao'];

    public static function insertAtendimento($dados)
    {
        return Atendimento::create($dados);
    }
}
