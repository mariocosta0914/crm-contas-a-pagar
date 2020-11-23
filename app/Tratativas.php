<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tratativas extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tratativas';
    protected $fillable = [
        'id_cliente',
        'id_titulo',
        'id_ocorrencia',
        'descricao_tratativa',
        'id_usuario',
        'Valor',
        'Data_Renitencia',
        'nome_cliente',
        'saldo_devedor',
        'vencimento_original',
        'vencimento_prorrogado',
        'titulos'
    ];

    public static function inserTratativas($dados)
    {
        return Tratativas::insert($dados);
    }

    public static function getTipoOcorrencia()
    {
        return Tratativas::select('id', 'nome_ocorrencia')
            ->from('ocorrencia')
            ->get();
    }


    public static function getIdOcorrencia($nome_ocorrencia)
    {
        $idOcorrencia = Tratativas::select('id', 'nome_ocorrencia')
            ->from('ocorrencia')
            ->where('nome_ocorrencia', '=', $nome_ocorrencia)
            ->get();
        return $idOcorrencia;
    }

    public static function getHistoricoTratativas($id_cliente)
    {
        $dados = Tratativas::selectRaw('tratativas.id,
         tratativas.id_titulo,
         DATE_FORMAT(tratativas.Data_Renitencia,"%d/%m/%Y") as Data_Renitencia,
         DATE_FORMAT(tratativas.created_at,"%d/%m/%Y %H:%i:%s") as data_criacao,
         tratativas.created_at,
         tratativas.Valor,
         users.name,
         ocorrencia.nome_ocorrencia,
         tratativas.descricao_tratativa,
         tratativas.titulos')
            ->from('tratativas')
            ->join('users', 'tratativas.id_usuario', '=', 'users.id')
            ->join('ocorrencia', 'tratativas.id_ocorrencia', '=', 'ocorrencia.id')
            ->where('id_cliente', '=', $id_cliente)
            ->orderBy('tratativas.id', 'desc')
            ->get();
        return $dados;
    }

    public static function verificaSeExisteTratativa($id_cliente)
    {
        return Tratativas::whereRaw('DATE_FORMAT( created_at, "%Y-%m-%d" ) = CURDATE()')
            ->where('id_cliente', '=', $id_cliente)
            ->count();
    }

    public static function verificaSeExisteTratativaById($id_titulo)
    {
        return Tratativas::whereRaw('DATE_FORMAT( created_at, "%Y-%m-%d" ) = CURDATE()')
        ->where('id_titulo','=',$id_titulo)
        ->count();
    }

    public static function verificaRenitenciaDataDeHoje()
    {
        return Tratativas::distinct()
            ->select('id_cliente')
            ->whereRaw('Data_Renitencia=DATE_FORMAT(CURDATE(),"%Y-%m-%d")')
            ->get()->toArray();
    }

    public static function verificaRenitenciaMesmoDia()
    {
        return Tratativas::distinct()
            ->select('id_cliente')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") = CURDATE() and Data_Renitencia = CURDATE()')
            ->get()->toArray();
    }
}
