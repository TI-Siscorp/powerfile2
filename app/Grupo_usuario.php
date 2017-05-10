<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_usuario extends Model
{
	protected $table = 'sgd_grupo_usuarios';
	protected $primaryKey = 'id_grupo_usuario';
	protected $fillable = ['id_grupo_usuario','id_grupo','id_usuario'];
}
