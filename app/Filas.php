<?php

namespace App;

use App\Boletos\BoletoBradesco;
use App\Boletos\BoletoCaixa;
use App\Boletos\BoletoItau;
use App\Boletos\BoletoSantander;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Filas extends Model
{
    protected $connection = 'mysql';
    protected $table = 'fila';
    public $timestamps = true;
    protected $fillable = ['id_cliente', 'segmento', 'id_usuario', 'status', 'prioridade'];

    public static function getDadosFila($segmento)
    {
       return TodosBoletos::getInformacoesFila($segmento);
    }

    public static function configuraFila($dados, $segmento, $intervalo)
    {
        $where = Helper::criarWhere($dados);
        $fila=TodosBoletos::configuracaoFila($where,$segmento,$intervalo);
        Filas::salvarFila(Helper::ordenaFila($fila, $segmento), $segmento, $dados, $intervalo);
    }

    public static function salvarFila($dados, $segmento, $prioridades, $intervalo)
    {
        Filas::where('status', '=', 0)
            ->where('segmento', '=', $segmento)
            ->whereNull('prioridade')
            ->delete();
        Filas::insert($dados);
        return Filas::salvarPrioridade($prioridades, $segmento, $intervalo);
    }

    public static function salvarPrioridade($prioridades, $segmento, $intervalo)
    {
        Filas::from('prioridades')
            ->where('segmento', '=', $segmento)
            ->delete();
        Filas::from('intervalos')
            ->where('segmento', '=', $segmento)
            ->delete();
        if (isset($intervalo)) {
            Filas::from('intervalos')->insert($intervalo);
        }
        return Filas::from('prioridades')->insert($prioridades);
    }

    public static function getPrioridadeSalva($segmento)
    {
        return Filas::select('name', 'code', 'segmento', 'selected')
            ->from('prioridades')
            ->where('segmento', $segmento)
            ->get();
    }

    public static function getIdCliente($id_usuario)
    {
        return Filas::select('id_cliente')
            ->from('fila')
            ->where('id_usuario', $id_usuario)
            ->first();
    }

    public static function adicionaUsuarioFila($id_usuario, $segmento)
    {
        Filas::from('fila')
            ->where('segmento', '=', $segmento)
            ->where('status', '<>', '1')
            ->orderBy('prioridade', 'DESC')
            ->limit(1)
            ->update(['id_usuario' => $id_usuario, 'status' => 1]);

        return  Filas::getIdCliente($id_usuario);
    }

    public static function removeClienteFila($id_usuario)
    {
        return Filas::where('status', '=', 1)
            ->where('id_usuario', '=', $id_usuario)
            ->delete();
    }

    public static function verificaClienteFila($id_cliente)
    {
        return Filas::selectRaw('*')
            ->where('id_cliente', '=', $id_cliente)
            ->count();
    }

    public static function removeClienteFilaAtendente($id_usuario)
    {
        return Filas::from('fila')
            ->where('id_usuario', '=', $id_usuario)
            ->update(['id_usuario' => null, 'status' => 0]);
    }

    public static function adicionaUmClientenaFila($dados)
    {
        return Filas::create($dados);
    }

    public static function verificaClienteFilaAtendente($id_cliente)
    {
        return Filas::from('fila')
            ->where('id_cliente', '=', $id_cliente)
            ->where('status', '=', 1)
            ->count();
    }

    public static function atualizaUmClienteNaFilaReceptivo($id_cliente, $id_usuario)
    {
        return Filas::from('fila')
            ->where('id_cliente', '=', $id_cliente)
            ->update(['id_usuario' => $id_usuario, 'status' => 1]);
    }

    public static function getValoresFila($dados, $segmento, $intervalo)
    {
        $where = Helper::criarWhere($dados);
        return TodosBoletos::configuracaoFila($where,$segmento,$intervalo);
    }

    public static function getIntervalos($segmento)
    {
        return Filas::from('intervalos')
            ->where('segmento', $segmento)
            ->first();
    }
}
