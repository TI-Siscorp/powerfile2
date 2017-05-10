<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipoindice extends Model
{
	protected $table = 'sgd_tipoindices';
	protected $primaryKey = 'id_tipo';
	protected $fillable = ['id_tipo','nombre','id_estado'];
}