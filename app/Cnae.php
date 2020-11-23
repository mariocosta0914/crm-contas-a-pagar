<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    protected $connection = 'mysql';
    protected $table = 'cnae';

    public static function getDescricaoCnae($id)
    {
        $cnae = Cnae::where('codigo_cnae', '=', $id)->first();
        return $cnae->descricao;
    }
}
