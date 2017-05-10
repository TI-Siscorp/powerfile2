<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso_rol extends Model
{
    protected $table = 'sgd_permiso_rols';
	protected $primaryKey = 'id_permiso_rol';
	protected $fillable = ['id_permiso_rol','id_rol','id_permiso','value'];
}