<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaNfse extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'TodosOsBoletos';


    public static function getXmlNota($cdRcd)
    {
        $xmlnota = NotaNfse::select('XMLNFSe')
        ->where('cdRcd', '=', $cdRcd)->first();
        return $xmlnota;
         
    }
}
