<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria_zip extends Model
{
	protected $table = 'sgd_auditoria_zip';
	protected $primaryKey = 'id_auditoria';
	protected $fillable = ['id_auditoria','id_usuario','zip','archivos','id_estado'];
}