<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	protected $table = 'sgd_rols';
	protected $primaryKey = 'id_rol';
	protected $fillable = ['id_rol','nombre','id_estado'];
}
