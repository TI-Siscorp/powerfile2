<?php

use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//para correr en sqlsrv
      	/*DB::insert("SET IDENTITY_INSERT  sgd_estados  ON; insert into  sgd_estados  ([id_estado], [descripcion]) 
    			values ('1', 'Activo');SET IDENTITY_INSERT  sgd_estados OFF;");
    	
    	DB::insert("SET IDENTITY_INSERT  sgd_estados  ON; insert into  sgd_estados  ([id_estado], [descripcion])
    			values ('2', 'Inactivo');SET IDENTITY_INSERT  sgd_estados OFF;");*/
    	////////
    	   	
    	
    	
    	//para correr en mysql y pgsql
        DB::table('sgd_estados')->insert(array(
    			'id_estado'=>'1',
    			'descripcion'=>'Activo',
    			'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")   			
    	
    	));
       
    	DB::table('sgd_estados')->insert(array(
    			'id_estado'=>'2',
    			'descripcion'=>'Inactivo',
    			'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")
   
    	));
    	 
    }
}

