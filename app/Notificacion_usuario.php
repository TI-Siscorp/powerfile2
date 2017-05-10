<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion_usuario extends Model
{
	protected $table = 'sgd_notificacion_usuarios';
	protected $primaryKey = 'id_notifica';
	protected $fillable = ['id_notifica','id_documento','id_usuario'];
}
