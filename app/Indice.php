<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indice extends Model
{
	protected $table = 'sgd_indices';
	protected $primaryKey = 'id_indice';
	protected $fillable = ['id_indice','nombre','id_tipo','id_estado','orden','descripcion','delistakey','delistavalor'];
}