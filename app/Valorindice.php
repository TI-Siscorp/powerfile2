<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valorindice extends Model
{
	protected $table = 'sgd_valorindice';
	protected $primaryKey = 'id_valorindice';
	protected $fillable = ['id_valorindice','id_documento','id_indice','valor','id_estado'];
}
