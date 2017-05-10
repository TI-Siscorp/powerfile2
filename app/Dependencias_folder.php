<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencias_folder extends Model
{
	protected $table = 'sgd_dependencias_folders';
	protected $primaryKey = 'id_dependen_folder';
	protected $fillable = ['id_dependen_folder','id_dependencia','id_folder','id_tabla','id_usuario'];
}
