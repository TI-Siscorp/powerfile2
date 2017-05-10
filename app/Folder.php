<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
	protected $table = 'sgd_folders';
	protected $primaryKey = 'id';
	protected $fillable = ['id','nombre','text','parent_id','id_tabla','id_estado'];
}
