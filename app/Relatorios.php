<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relatorios extends Model
{
    protected $connection = 'mysql';

    public static function getRelatorio($data_inicio, $data_fim, $id_usuario)
    {
        return Relatorios::selectRaw("DATE_FORMAT(tratativas.created_at,'%d/%m/%Y %H:%i:%s') as data_ocorrencia,
       users.name,ocorrencia.nome_ocorrencia,IF(tratativas.id_titulo, tratativas.id_titulo, 'N/A'),
       IF(tratativas.titulos, tratativas.titulos, 'N/A'), tratativas.nome_cliente, 
       DATE_FORMAT(tratativas.vencimento_original,'%d/%m/%Y') as vencimento_original,
       DATE_FORMAT(tratativas.vencimento_prorrogado,'%d/%m/%Y') as vencimento_prorrogado,
       tratativas.saldo_devedor,FORMAT(tratativas.Valor,2,'de_DE') as Valor,
       (select max(created_at) from atendimento where atendimento.id_cliente = tratativas.id_cliente) as ultimo_acionamento")
            ->from('tratativas')
            ->join('ocorrencia', 'tratativas.id_ocorrencia', 'ocorrencia.id')
            ->join('users', 'tratativas.id_usuario', 'users.id')
            ->whereRaw("DATE_FORMAT(tratativas.created_at, '%Y-%m-%d') BETWEEN '$data_inicio' AND '$data_fim'")
            ->when($id_usuario, function ($query, $id_usuario) {
                return $query->whereIn('tratativas.id_usuario', $id_usuario);
            })
            ->orderBy('tratativas.created_at', 'DESC')
            ->get();
    }
}
