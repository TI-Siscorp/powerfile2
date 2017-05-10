<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
	protected $table = 'sgd_documentos';
	protected $primaryKey = 'id_documento';
	protected $fillable = ['id_documento','id_expediente','id_tipodocumental','id_usuario','id_tabla','id_folder','orden','id_estado'];
}
