<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocumental extends Model
{
	protected $table = 'sgd_tipodocumentales';
	protected $primaryKey = 'id_tipodoc';
	protected $fillable = ['id_tipodoc','nombre','id_estado','descripcion','color'];
}