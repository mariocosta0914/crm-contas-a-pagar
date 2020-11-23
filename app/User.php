<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUsuarios()
    {
        return User::selectRaw('id,name,email, IF(status=1,"Ativo","Inativo") as status')
            ->from('users')
            ->where('status', '=', '1')
            ->orderBy('id', 'ASC')
            ->get();
    }

    public static function getUserById($id)
    {
        return User::selectRaw('id,name,email,DATE_FORMAT(created_at,"%d/%m/%Y")
        as data_criacao')
            ->from('users')
            ->where('id', '=', $id)
            ->first();
    }

    public static function getAcessos()
    {
        return User::selectRaw('user_access_type.id_usuario,user_type.tipo')
            ->from('user_access_type')
            ->join('user_type', 'user_access_type.id_tipo_usuario', 'user_type.id')
            ->get();
    }

    public static function getUserType()
    {
        return User::selectRaw('id,tipo')
            ->from('user_type')
            ->get();
    }

    public static function getUserTypeById($id)
    {
        return User::selectRaw('user_type.id,user_type.tipo')
            ->from('user_type')
            ->join('user_access_type','user_type.id','user_access_type.id_tipo_usuario')
            ->where('user_access_type.id_usuario','=',$id)
            ->get();
    }

    public static function excluirUsuario($dados, $id)
    {
        return User::where('id', $id)
            ->update($dados);
    }

    public static function updateUsuario($dados, $id)
    {
        if ($dados['password'] == null) {
            unset($dados['password']);
        } else {
            $dados['password'] = Hash::make($dados['password']);
        }
        return User::where('id', $id)
            ->update($dados);
    }

    public static function getUserOperador()
    {
        return User::selectRaw('id,name')
            ->where('supervisor',0)
            ->get();
    }
}
