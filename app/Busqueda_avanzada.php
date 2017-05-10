<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busqueda_avanzada extends Model
{
	protected $table = 'sgd_busqueda_avanzada';
	protected $primaryKey = 'id';
	protected $fillable = ['id','nombre','text','parent_id','id_tabla','id_estado','id_folder','id_tpdoc','id_folder_tpdoc','id_usuario'];
}
