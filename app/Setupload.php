<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setupload extends Model
{
	protected $table = 'sgd_setuploads';
	protected $primaryKey = 'id_setup';
	protected $fillable = ['id_setup','modobodega','ftp_server','ftp_user','ftp_pass','ftp_port','estatus','id_estado'];
}