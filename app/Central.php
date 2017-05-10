<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Central extends Model
{
	protected $table = 'sgd_central';
	protected $primaryKey = 'id_central';
	protected $fillable = ['id_central','nombre','id_estado'];
}
