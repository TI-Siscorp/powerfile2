<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
	protected $table = 'sgd_dependencias';
	protected $primaryKey = 'id_dependencia';
	protected $fillable = ['id_dependencia','descripcion','codigo_departamento','id_estado'];
}
