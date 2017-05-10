<?php

use Illuminate\Database\Seeder;

class PermisoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	///permisos de usuarios
    	
    	   	
    //	DB::statement('SET IDENTITY_INSERT sgd_permisos ON;');
    	
    	
        DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Usuario',
    			'llave' => 'add_user',
    			'created_at' => date("Y-m-d H:i:s"),
            	'updated_at' => date("Y-m-d H:i:s")
   
    	));

    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Usuario',
    			'llave' => 'edit_user',
    			'created_at' => date("Y-m-d H:i:s"),
            	'updated_at' => date("Y-m-d H:i:s")
   
    	));

    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Usuario',
    			'llave' => 'delete_user',
    			'created_at' => date("Y-m-d H:i:s"),
            	'updated_at' => date("Y-m-d H:i:s")
   
    	));

    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Usuario',
    			'llave' => 'view_user',
    			'created_at' => date("Y-m-d H:i:s"),
            	'updated_at' => date("Y-m-d H:i:s")
   
    	));
    	
    	///permisos de roles
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Rol',
    			'llave' => 'add_rol',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Rol',
    			'llave' => 'edit_rol',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Rol',
    			'llave' => 'delete_rol',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Rol',
    			'llave' => 'view_rol',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	///permisos de permisos
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Permiso',
    			'llave' => 'add_permiso',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Permiso',
    			'llave' => 'edit_permiso',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Permiso',
    			'llave' => 'delete_permiso',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Permisar Rol',
    			'llave' => 'permi_rol',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Permiso',
    			'llave' => 'view_permiso',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	///permisos de indices
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Indice',
    			'llave' => 'add_indice',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Indice',
    			'llave' => 'edit_indice',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Indice',
    			'llave' => 'delete_indice',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Indice',
    			'llave' => 'view_indice',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	///permisos de tipo documental
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Tipo documental',
    			'llave' => 'add_tpdoc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Tipo documental',
    			'llave' => 'edit_tpdoc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Tipo documental',
    			'llave' => 'delete_tpdoc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Tipo documental',
    			'llave' => 'view_tpdoc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	///permisos de tipo dependencias
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Dependencias',
    			'llave' => 'add_depen',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Dependencias',
    			'llave' => 'edit_depen',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Dependencias',
    			'llave' => 'delete_depen',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Dependencias',
    			'llave' => 'view_depen',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	///permisos de tipo logo
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Subir Logo',
    			'llave' => 'add_logo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Activar Logo',
    			'llave' => 'act_logo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Desactivar Logo',
    			'llave' => 'desac_logo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver logo',
    			'llave' => 'view_logo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	///permisos de grupos
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Grupo',
    			'llave' => 'add_grupo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Grupo',
    			'llave' => 'edit_grupo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Grupo',
    			'llave' => 'delete_grupo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	 
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Grupo',
    			'llave' => 'view_grupo',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agrupar Usuarios',
    			'llave' => 'agrupa_user',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	///permisos de tablas
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Tabla',
    			'llave' => 'add_tabla',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar Tabla',
    			'llave' => 'edit_tabla',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Tabla',
    			'llave' => 'delete_tabla',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Tabla',
    			'llave' => 'view_tabla',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Carpetas',
    			'llave' => 'view_folders',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	//expedientes
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Agregar Expediente',
    			'llave' => 'add_exp',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Expedientes',
    			'llave' => 'view_exp',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ver Documentos',
    			'llave' => 'view_doc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Expedientes',
    			'llave' => 'delete_exp',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Crear Documentos',
    			'llave' => 'add_doc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar Documentos',
    			'llave' => 'delete_doc',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Ordenar imagenes',
    			'llave' => 'order_img',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Descargar imagenes',
    			'llave' => 'down-img',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Crear key de Encriptaci&oacute;n de imagenes',
    			'llave' => 'make_key_crypt',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Editar key de Encriptaci&oacute;n',
    			'llave' => 'edit_encrypt',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Borrar key Encriptaci&oacute;n',
    			'llave' => 'delete_encrypt',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Crear espacios de trabajo',
    			'llave' => 'make_work_space',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Edit Document',
    			'llave' => 'edit_exp',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Change Password',
    			'llave' => 'change_pass',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			 
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'View info',
    			'llave' => 'view_info_sys',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    	
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Search Report',
    			'llave' => 'search_report',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Load Csv',
    			'llave' => 'load_csv',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Set Up Storage',
    			'llave' => 'set_up_storage',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Edit Storage',
    			'llave' => 'edit_storage',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Delete Storage',
    			'llave' => 'delete_storage',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Load Search',
    			'llave' => 'load_search',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Set Up Load',
    			'llave' => 'set_up_load',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Edit Load',
    			'llave' => 'edit_load',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Delete Load',
    			'llave' => 'delete_load',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Set Up Error',
    			'llave' => 'set_up_error',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Edit Error',
    			'llave' => 'edit_error',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Delete Error',
    			'llave' => 'delete_error',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Set up Recovery',
    			'llave' => 'set_up_recovery',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Edit Recovery',
    			'llave' => 'edit_recovery',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	
    	DB::table('sgd_permisos')->insert(array(
    			'permiso' => 'Delete Recovery',
    			'llave' => 'delete_recovery',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s")
    			
    	));
    	
    	
    	
    	//DB::statement('SET IDENTITY_INSERT sgd_permisos OFF;');
    	
    }
}

