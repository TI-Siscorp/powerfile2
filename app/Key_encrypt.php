<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key_encrypt extends Model
{
	protected $table = 'sgd_encrypt';
	protected $primaryKey = 'id_encrypt';
	protected $fillable = ['id_encrypt','key_encrypt','id_estado','valor_key','tiene_img','id_usuario'];
}
