<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagendocumento extends Model
{
	protected $table = 'sgd_imagen_documento';
	protected $primaryKey = 'id_imagendocum';
	protected $fillable = ['id_imagendocum','id_documento','nombre','extension','bodega','orden','id_estado'];
}
