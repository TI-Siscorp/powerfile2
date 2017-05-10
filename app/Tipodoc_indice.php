<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodoc_indice extends Model
{
	protected $table = 'sgd_tipodoc_indices';
	protected $primaryKey = 'id_tipodoc_indice';
	protected $fillable = ['id_tipodoc_indice','id_tipodoc','id_indice','id_folder'];
}
