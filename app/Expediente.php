<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
	protected $table = 'sgd_expedientes';
	protected $primaryKey = 'id_expediente';
	protected $fillable = ['id_expediente','id_usuario','id_tabla','spider','id_central','nombre','id_estado'];
}
