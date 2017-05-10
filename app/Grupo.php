<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
	protected $table = 'sgd_grupos';
	protected $primaryKey = 'id_grupo';
	protected $fillable = ['id_grupo','nombre','id_estado'];
}
