<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
	protected $table = 'sgd_bodegas';
	protected $primaryKey = 'id_bodega';
	protected $fillable = ['id_bodega','nombre','limite','actual','id_estado'];
}
