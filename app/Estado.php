<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
	protected $table = 'sgd_estados';
	protected $primaryKey = 'id_estado';
	protected $fillable = ['id_estado','descripcion'];
}
