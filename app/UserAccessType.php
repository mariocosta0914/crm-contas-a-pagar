<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccessType extends Model
{
    protected $connection = 'mysql';

    protected $table = 'user_access_type';

    protected $fillable = [
        'id_usuario', 'id_tipo_usuario',
    ];

    public $timestamps = false;

    public static function adicionarUsuarioTipoAcesso($dados)
    {
        return UserAccessType::create($dados);
    }

    public static function excluirUsuarioAcesso($id)
    {
        return UserAccessType::where('id_usuario', $id)
            ->delete();
    }

    public static function getUserTypeByIdUser($id_usuario)
    {
        return UserAccessType::select('user_type.tipo')
            ->where('id_usuario', $id_usuario)
            ->join('user_type','user_type.id','=','user_access_type.id_tipo_usuario')
            ->get()
            ->toArray();
    }
}
