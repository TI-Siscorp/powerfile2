<?php

use Illuminate\Database\Seeder;

class TipoindiceTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		
		//DB::statement('SET IDENTITY_INSERT sgd_tipoindices ON;');
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Entero',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
				 
		));
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Texto',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
					
		));
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Fecha',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
					
		));
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Moneda',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
					
		));
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Decimal',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
					
		));
		
		DB::table('sgd_tipoindices')->insert(array(
				'nombre'=>'Lista',
				'id_estado'=>'1',
				'created_at'=> date("Y-m-d H:i:s"),
				'updated_at'=> date("Y-m-d H:i:s")
					
		));
		
	//	DB::statement('SET IDENTITY_INSERT sgd_tipoindices OFF;');
	}
}
