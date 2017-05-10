<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabla extends Model
{
	protected $table = 'sgd_tablas';
	protected $primaryKey = 'id_tabla';
	protected $fillable = ['id_tabla','nombre_tabla','version','descripcion','id_estado'];
}
