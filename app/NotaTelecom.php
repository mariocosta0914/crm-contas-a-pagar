<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaTelecom extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'NotasFiscaisTelecomunicacoes';

    public static function getNota($cdRcd)
    {
        $nota = NotaTelecom::where('cdRcd', '=', $cdRcd)->first();
        return $nota;
    }

    public static function verificaSeExisteNotaTelecom($cdRcd)
    {
        $nota = NotaTelecom::where("cdrcd", "=", $cdRcd)->count();
        return $nota > 0 ? true : false;
    }
}
