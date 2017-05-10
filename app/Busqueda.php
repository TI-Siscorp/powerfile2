<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
	protected $table = 'sgd_busquedas';
	protected $primaryKey = 'id_busqueda';
	protected $fillable = ['id_busqueda','id_usuario','busqueda','id_estado'];
}