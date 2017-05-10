<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'sgd_permisos';
	protected $primaryKey = 'id_permiso';
	protected $fillable = ['id_permiso','permiso','key'];
}
