<?php

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
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
    	
    //	DB::statement('SET IDENTITY_INSERT sgd_rols ON;');
    	
    	//para correr en mysql y pgsql
        DB::table('sgd_rols')->insert(array(
    			'nombre'=>'Administrador',
    			'id_estado'=>'1',
    			'created_at'=> date("Y-m-d H:i:s"),
            	'updated_at'=> date("Y-m-d H:i:s")
   
    	));
        
    //    DB::statement('SET IDENTITY_INSERT sgd_rols OFF;');
    }
}
