<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foldertipodoc extends Model
{
	protected $table = 'sgd_folders_tipodocs';
	protected $primaryKey = 'id_folder_tipodoc';
	protected $fillable = ['id_folder_tipodoc','id_folder','id_tipodoc'];
}
