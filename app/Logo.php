<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'sgd_logos';
	protected $primaryKey = 'id_logo';
	protected $fillable = ['id_logo','nombrelogo','ruta','ext','act'];
}
