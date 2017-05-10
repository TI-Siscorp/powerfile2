<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('EstadoTableSeeder');
		$this->call('RolTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('UsuariosTableSeeder');
        $this->call('PermisoTableSeeder');
        $this->call('LogoTableSeeder');
        $this->call('TipoindiceTableSeeder');
        $this->call('PermisorolsTableSeeder');
        $this->call('CentralTableSeeder'); 
        $this->call('SetupbodegaTableSeeder'); 
        $this->call('SetuperrorTableSeeder'); 
        $this->call('SetuploadTableSeeder'); 
        $this->call('SetuprecoveryTableSeeder'); 
        
        
    }
}
