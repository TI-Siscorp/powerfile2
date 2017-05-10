<?php

use Illuminate\Database\Seeder;

class CentralTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		 
		//para correr en sqlsrv
		/*DB::insert("SET IDENTITY_INSERT  sgd_rols  ON; insert into  sgd_rols  ([nombre], [id_estado])
		 values ('Administrador', '1');SET IDENTITY_INSERT  sgd_rols OFF;");*/

		////////
		 
		//DB::statement('SET IDENTITY_INSERT sgd_central ON;');
		
		//para correr en mysql y pgsql
		DB::table('sgd_central')->insert(array(
				'nombre'=>'Archivo Central',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")
				 
		));
		
		DB::table('sgd_central')->insert(array(
				'nombre'=>'Archivo de Gestion',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")
					
		));

	//	DB::statement('SET IDENTITY_INSERT sgd_central OFF;');

	}
}
