<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Usuario extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	protected $table = 'sgd_usuarios';
	protected $primaryKey = 'id';
	protected $fillable = ['id','name','lastname','login','password','id_estado','fecha_proceso','id_rol','email','direccion','celular','fijo','cedula','remember_token','avatar'];

	public function admin(){
		return $this->id_rol === 1;
	}

}