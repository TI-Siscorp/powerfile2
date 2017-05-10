<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		
		
		//DB::statement('SET IDENTITY_INSERT sgd_usuarios ON;');
		
		DB::table('sgd_usuarios')->insert(array(
				'name' => 'ADMIN',
				'lastname' => 'ADMINISTRADOR',
				'cedula' => '123456789',
				'login' => 'admin',
				'email' => 'admin@siscorp.com.co',
				'password' => bcrypt('admin'),
				'direccion' => 'Calle 63A # 28 - 31',
				'celular' => '3097465587',
				'fijo' => '2111104',
				'avatar' => 'desarrollo-web.png',
				'id_estado' => 1,
				'id_rol' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
				 
		));
		
		//DB::statement('SET IDENTITY_INSERT sgd_usuarios OFF;');
		
	}
}
