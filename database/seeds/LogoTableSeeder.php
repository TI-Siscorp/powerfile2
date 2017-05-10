<?php

use Illuminate\Database\Seeder;

class LogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	
    	//DB::statement('SET IDENTITY_INSERT sgd_logos ON;');
    	
         DB::table('sgd_logos')->insert(array(
    			'nombrelogo'=>'logopowerfile.png',
    			'ruta'=>'/var/www/html/powerfile2/public/img/logos/',
    			'ext'=>'png',
         		'act'=>'1',
    			'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")
   
    	));
         
       // DB::statement('SET IDENTITY_INSERT sgd_logos OFF;');
    }
}
