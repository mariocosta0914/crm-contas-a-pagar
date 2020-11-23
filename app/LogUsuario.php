<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    protected $connection = 'mysql';
    protected $table = 'log_usuario';

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'cliente_id'
    ];
}
