<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
	protected $table = 'sgd_search';
	protected $primaryKey = 'id_search';
	protected $fillable = ['id_search','id_documento','id_expediente','id_tipodocumental','nombre','search','id_node','id_tabla','id_indices','id_estado'];
}
