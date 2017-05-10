<?php

use Illuminate\Database\Seeder;

class SetuprecoveryTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		
		//	DB::statement('SET IDENTITY_INSERT users ON;');
		
		DB::table('sgd_setuprecovery')->insert(array(
				'modobodega' => 'powerfile2',
				'ftp_server' => '000.000.0.0',
				'ftp_user' => 'powerfile2',
				'ftp_pass' => 'powerfile2',
				'ftp_port' => '21',
				'estatus' => 1,
				'id_estado' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
				
		));
		
		//  DB::statement('SET IDENTITY_INSERT users OFF;');
		
	}
}