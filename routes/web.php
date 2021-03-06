<?php


@session_start();


/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 |
 | This file is where you may define all of the routes that are handled
 | by your application. Just tell Laravel the URIs it should respond
 | to using a Closure or controller method. Build something great!
 |
 */
Auth::routes();

function darurl()
{
	return sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'],
			''
			);
}

function varia(){
	
	$ruta=darurl();  
	$espaciotrabajo=$_SERVER['REQUEST_URI'];
	$pos = strpos($espaciotrabajo, '/api');
	if (trim($espaciotrabajo) == '/')
	{
		echo '<script language="javascript">window.location="'.$ruta.'/powerfile2"</script>';
		$_SESSION['espaciotrabajo'] = 'powerfile2';
	}
	else
	{
		if ($pos == true )
		{
			$turl = explode('/',$espaciotrabajo);
			$_SESSION['espaciotrabajo'] = $turl[1];
		}
		else
		{
			if ($_SERVER['REQUEST_URI'] == '/home')
			{
				echo '<script language="javascript">window.location="'.$ruta.'/'.$_SESSION['espaciotrabajo'].'/principal"</script>';
			}
		}
	}
	//echo $turl[1];
}

function dameespacio(){
	
	$mespacio = @$_SESSION['espaciotrabajo'];
	
	if ($mespacio == '')
	{
		$espaciotrabajo = $_SERVER['REQUEST_URI'];
		$espaciotrabajot = substr($espaciotrabajo,1);
		$mespacio = $espaciotrabajot.'/';
	}
	else
	{
		$mespacio = $_SESSION['espaciotrabajo'].'/';
	}
	
	return $mespacio;
}

function conocepermisosapi($v,$usuarios,$idusu,$workspace,$driver)
{
	if ($driver != 'pgsql')
		{
			$registroper = DB::select("select pr.id_permiso_rol,pr.value from ".$workspace.".sgd_permiso_rols pr, ".$workspace.".sgd_permisos p  where p.id_permiso = pr.id_permiso and pr.id_rol = ".$idusu." and pr.value = 1 and p.llave = '".$v."'");
		}
	else 
		{
			if ($driver == 'pgsql')
				{
					$registroper = DB::select("select pr.id_permiso_rol,pr.value from ".$workspace.".public.sgd_permiso_rols pr, ".$workspace.".public.sgd_permisos p  where p.id_permiso = pr.id_permiso and pr.id_rol = ".$idusu." and pr.value = 1 and p.llave = '".$v."'");
				}	
			
		}
	
	if (count($registroper) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}


function verdriver($espaciotrabajo){ 
	$fp = fopen("../config/database.php", "r");
	
	$linea = '';
	$nlinea = '';
	$numlinea = 0;
	$letra = '';
	while(!feof($fp)) {
		
		$linea = fgets($fp);
		
		if (trim($linea) == "'".$espaciotrabajo."' => [" )
		{
			$numlinea = $numlinea + 1;
		}
		if ($numlinea > 0 )
		{
			
			if ($numlinea == 2)
			{
				$driverl = $linea; 
			}
			else
			{
				if ($numlinea == 3)
				{
					$hostl = $linea;
				}
				else
				{
					if ($numlinea == 4)
					{
						$puertol = $linea;
					}
					else
					{
						if ($numlinea == 5)
						{
							$dbl = $espaciotrabajo;
						}
						else
						{
							if ($numlinea == 6)
							{
								$usernl = $linea;
							}
							else
							{
								if ($numlinea == 7)
								{
									$passl = $linea;
								}
								
							}
						}
					}
				}
			}
			$numlinea = $numlinea + 1;
		}
		
	}
	
	fclose($fp);
	
	$driverl = explode('=>',$driverl);
	
	$driverl = trim($driverl[1]);
	
	$driverl = substr($driverl, 0, -1);
	
	$driverl = str_replace("'","", $driverl);	
	
	return $driverl;
}


function maketk()
{
	
	$tksam = $_SESSION['espaciotrabajo'];
	
	$tksam = md5($tksam);
	
	return $tksam;
}

function trartidexp($iddocumento)
{
	
	$regisdocum = DB::select("select id_expediente from sgd_documentos where id_documento = ".$iddocumento);
	
	return $regisdocum[0]->id_expediente;
	
}

function encryptFile($file,$pathbodega,$kweyllave) {//se pasa el nombre del archivo a encriptar
	
	
	
	$path = $pathbodega;   //"content";
	$filename = substr($file, 0, strrpos($file,"."));
	$newfile = $path.'/'.$filename.'.dat';
	$msg = file_get_contents($path.'/'.$file);
	
	//se abre el cifrado de datos
	$td = mcrypt_module_open('tripledes', '', 'ecb', '');
	
	//se crea el valor IV y se determina la longitud de la key, se usa MCRYPT_RAND
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	
	//se coloca la clave a trabajar para el espacio de trabajo (se toma de la bd del espacio de trabajo correspondiente)
	
	
	
	//$key = substr('1a2b3c4d5f6g7h8jqwertyuioplkjhgfdsa', 0, 16);
	
	$key = substr($kweyllave, 0, 16);
	
	//se inicializa el manejador de la encriptación
	mcrypt_generic_init($td, $key, $iv);
	
	//se encripta la data del archivo original
	$encrypted = mcrypt_generic($td, $msg);
	
	//se culmina el proceso de encriptación
	mcrypt_generic_deinit($td);
	
	//se cierra el manejador de  la encriptación
	mcrypt_module_close($td);
	
	//se genera el nuevo archivo ya encriptado
	$nfile = fopen($newfile, 'w');
	fwrite($nfile, $encrypted);
	fclose($nfile);
	
}

function inFTP($file,$pathbodega,$pathvisor,$kweyllave) {  // dd($pathbodega);
	
	
	
	$path = $pathbodega;
	$filename = substr($file, 0, strrpos($file,"."));
	$extensf = substr(strrchr($file, "."),1);
	$newfile = $pathvisor.'/'.$filename.'.'.$extensf;
	$msg = Storage::get($path.'/'.$filename.'.dat');  //dd($msg);
	
	//se abre el cifrado de datos
	$td = mcrypt_module_open('tripledes', '', 'ecb', '');
	
	//se crea el valor IV y se determina la longitud de la key, se usa MCRYPT_RAND
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	
	
	//$key = substr('1a2b3c4d5f6g7h8jqwertyuioplkjhgfdsa', 0, 16);
	
	$key = substr($kweyllave, 0, 16);
	
	//se inicializa el manejador de la encriptación
	mcrypt_generic_init($td, $key, $iv);
	
	//se desencripta la data del archivo encriptado
	$decrypted = mdecrypt_generic($td, $msg);
	
	//se culmina el proceso de desencriptación
	mcrypt_generic_deinit($td);
	
	//se cierra el manejador de  la encriptación
	mcrypt_module_close($td);
	
	//se genera el nuevo archivo ya desenencriptado
	
	Storage::put( $newfile, $decrypted );
	
	//$nfile = fopen($newfile, 'w');
	//fwrite($nfile, $decrypted);
	//fclose($nfile);
}

$haz = varia();   


/*echo $_SESSION['espaciotrabajo'];
 if (is_null(Session::get('id_usuario')))
 {
 $ruta=darurl();
 
 //echo '<script language="javascript">window.location="'.$ruta.'/powerfile2/"</script>';
 }*/

Route::group(['middleware' => ['web']], function () {
	//@session_start();
	
	Route::get('/', function () {
		return view('auth.login');
	});
		
		Route::get('lang/{lang}', function ($lang) {
			session(['lang' => $lang]);
			$_SESSION['lenguaje'] = $lang;
			return \Redirect::back();
		})->where([
				'lang' => 'en|es'
		]);
		
});
	
	$mespacio = dameespacio(); // dd($mespacio);
	
	$elespacio = substr($mespacio,0,-1);  // dd($elespacio);
	
	
	//Route::get('home', $elespacio.'\PrincipalController@index');
	Route::get($mespacio.'logout', $elespacio.'\Auth\LoginController@logout');
	Route::get($mespacio.'login', $elespacio.'\Auth\LoginController@login');
	Route::post($mespacio.'login', $elespacio.'\Auth\LoginController@login');
	
	// rutas para crud para usuarios
	Route::resource($mespacio.'usuarios',$elespacio.'\UsuarioController');
	// rutas para crud para roles
	Route::resource($mespacio.'roles',$elespacio.'\RolController');
	// rutas para crud para permisos
	Route::resource($mespacio.'permisos',$elespacio.'\PermisoController');
	
	
	// rutas para crud para indices
	Route::resource($mespacio.'indices',$elespacio.'\IndicesController');
	
	// rutas para crud para tipos documentales
	Route::resource($mespacio.'tiposdocumentales',$elespacio.'\TiposdocumentalesController');
	
	// rutas para crud para dependencias
	Route::resource($mespacio.'dependencias',$elespacio.'\DependenciasController');
	
	// rutas para crud para grupos
	Route::resource($mespacio.'grupos',$elespacio.'\GruposController');
	
	// rutas para crud para tablas
	Route::resource($mespacio.'tablas',$elespacio.'\TablaController');
	
	// rutas para crud para folders
	Route::resource($mespacio.'folders',$elespacio.'\FoldersController');
	
	//rutas para crud logos
	Route::resource($mespacio.'logos',$elespacio.'\LogoController');
	
	Route::get($mespacio.'permisos/{permiso}/destroy',[
			'uses' => $elespacio.'\PermisoController@destroy',
			'as' => 'permisos.destroy'
	]);
	
	Route::get($mespacio.'roles/{rol}/destroy',[
			'uses' => $elespacio.'\RolController@destroy',
			'as' => 'roles.destroy'
	]);
	
	
	Route::get($mespacio.'roles/{rol}/permiso',[
			'uses' => $elespacio.'\RolController@permiso',
			'as' => 'roles.permiso'
	]);
	
	Route::get($mespacio.'roles/{rol}/store_permiso',[
			'uses' => $elespacio.'\RolController@store_permiso',
			'as' => 'roles.store_permiso'
	]);
	
	
	Route::get($mespacio.'usuarios/{usuario}/destroy',[
			'uses' => $elespacio.'\UsuarioController@destroy',
			'as' => 'usuarios.destroy'
	]);
	
	Route::get($mespacio.'usuarios/{usuario}/perfiles',[
			'uses' => $elespacio.'\UsuarioController@perfiles',
			'as' => 'usuarios.perfiles'
	]);
	
	Route::get($mespacio.'usuarios/{usuario}/perfil',[
			'uses' => $elespacio.'\UsuarioController@perfil',
			'as' => 'usuarios.perfil'
	]);
	
	Route::post($mespacio.'usuarios/{usuario}/perfil',[
			'uses' => $elespacio.'\UsuarioController@updateclave',
			'as' => 'usuarios.updateclave'
	]);
	
	
	
	Route::get($mespacio.'indices/{indice}/destroy',[
			'uses' => $elespacio.'\IndicesController@destroy',
			'as' => 'indices.destroy'
	]);
	
	Route::get($mespacio.'tiposdocumentales/{tipodocumental}/destroy',[
			'uses' => $elespacio.'\TiposdocumentalesController@destroy',
			'as' => 'tiposdocumentales.destroy'
	]);
	
	Route::get($mespacio.'dependencias/{dependencia}/destroy',[
			'uses' => $elespacio.'\DependenciasController@destroy',
			'as' => 'dependencias.destroy'
	]);
	
	Route::get($mespacio.'grupos/{grupo}/destroy',[
			'uses' => $elespacio.'\GruposController@destroy',
			'as' => 'grupos.destroy'
	]);
	
	Route::get($mespacio.'tablas/{tabla}/destroy',[
			'uses' => $elespacio.'\TablaController@destroy',
			'as' => 'tablas.destroy'
	]);
	
	//de grupos
	Route::get($mespacio.'grupos/{grupo}/agrupar',[
			'uses' => $elespacio.'\GruposController@agrupar',
			'as' => 'grupos.agrupar'
	]);
	
	Route::get($mespacio.'grupos/{grupo}/actualizar_agrupar',[
			'uses' => $elespacio.'\GruposController@actualizar_agrupar',
			'as' => 'grupos.actualizar_agrupar'
	]);
	
	/////
	Route::post($mespacio.'logos/upload',[
			'uses' => $elespacio.'\LogoController@upload',
			'as' => 'logos.upload'
	]);
	
	Route::get($mespacio.'logos/{idlogo}/activar',[
			'uses' => $elespacio.'\LogoController@activar',
			'as' => 'logos.activar'
	]);
	
	Route::get($mespacio.'logos/{idlogo}/desactivar',[
			'uses' => $elespacio.'\LogoController@desactivar',
			'as' => 'logos.desactivar'
	]);
	
	
	//manejo de folders
	
	Route::get($mespacio.'folders/{tabla}/folder',[
			'uses' => $elespacio.'\FoldersController@folder',
			'as' => 'folders.folder'
	]);
	
	
	//manejo de permisos a dependencias
	
	Route::get($mespacio.'dependencias/{dependencia}/estructura',[
			'uses' => $elespacio.'\DependenciasController@estructura',
			'as' => 'dependencias.estructura'
	]);
	
	
	
	//recuperacion de clave
	
	Route::post($mespacio.'usuarios/recuperar',[
			'uses' => $elespacio.'\UsuarioController@recuperar',
			'as' => 'usuarios.recuperar'
	]);
	
	
	///// principal//////
	
	
	
	Route::resource($mespacio.'principal',$elespacio.'\PrincipalController');
	
	
	//// expedientes /////
	
	Route::resource($mespacio.'expedientes',$elespacio.'\ExpedientesController');
	
	Route::get($mespacio.'expedientes/documentos/{expediente}/{tabla}',[
			'uses' => $elespacio.'\ExpedientesController@documentos',
			'as' => 'expedientes.documentos'
	]);
	
	Route::get($mespacio.'expedientes/destroy/{indice}',[
			'uses' => $elespacio.'\ExpedientesController@destroy',
			'as' => 'expedientes.destroy'
	]);
	
	Route::get($mespacio.'expedientes/{buscar}/visor',[
			'uses' => $elespacio.'\ExpedientesController@visor',
			'as' => 'expedientes.visor'
	]);
	
	Route::get($mespacio.'expedientes/{buscar}/visor_lista',[
			'uses' => $elespacio.'\ExpedientesController@visor_lista',
			'as' => 'expedientes.visor_lista'
	]);
	
	Route::get($mespacio.'expedientes/{iddocumento}/{buscar}/visor_listado',[
			'uses' => $elespacio.'\ExpedientesController@visor_listado',
			'as' => 'expedientes.visor_listado'
	]);
	
	Route::get($mespacio.'expedientes/{iddocumento}/{buscar}/{id_tabla}/visor_listado_avanzado',[
			'uses' => $elespacio.'\ExpedientesController@visor_listado_avanzado',
			'as' => 'expedientes.visor_listado_avanzado'
	]);
	
	
	Route::get($mespacio.'expedientes/{buscar}/{tabla}/visor_arbol',[
			'uses' => $elespacio.'\ExpedientesController@visor_arbol',
			'as' => 'expedientes.visor_arbol'
	]);
	
	Route::get($mespacio.'expedientes/{idexp}/visor_exp',[
			'uses' => $elespacio.'\ExpedientesController@visor_exp',
			'as' => 'expedientes.visor_exp'
	]);
	
	Route::get($mespacio.'expedientes/{idexp}/actualizar',[
			'uses' => $elespacio.'\ExpedientesController@actualizar',
			'as' => 'expedientes.actualizar'
	]);
	
	Route::post($mespacio.'expedientes/comparteloya',[
			'uses' => $elespacio.'\ExpedientesController@comparteloya',
			'as' => 'expedientes.comparteloya'
	]);
	
	
	
	////documentos en storage
	
	
	Route::get($mespacio.'expedientes/{filename}/mostrar',[
			'uses' => $elespacio.'\ExpedientesController@mostrar',
			'as' => 'expedientes.mostrar'
	]);
	
	// rutas para crud de clave de encriptacion
	Route::resource($mespacio.'key_encrypt',$elespacio.'\KeyencryptController');
	
	Route::get($mespacio.'key_encrypt/{indice}/destroy',[
			'uses' => $elespacio.'\KeyencryptController@destroy',
			'as' => 'key_encrypt.destroy'
	]);
	
	Route::resource($mespacio.'makespace',$elespacio.'\MakespaceController');
	
	
	Route::get($mespacio.'makespace',[
			'uses' => $elespacio.'\MakespaceController@make',
			'as' => 'makespace.make'
	]);
	
	Route::get($mespacio.'infoys',[
			'uses' => $elespacio.'\LogoController@infosys',
			'as' => 'infoys.infosys'
	]);
	
	
	///////////////  el api rest  ///////////////////////////////////////////////////////////////////////
	////
	////
	////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////////      usuarios  ////////////////
	//
	/////////////////////////////////////////////
	
	/*Route::post($mespacio.'api/usuarios/ver',[
			'uses' =>  $elespacio.'\Api\ApiusuariosController@ver',
			'as' => 'usuarios.ver'
	]);*/
	
	
	
	Route::post($mespacio.'api/usuarios/crear',[
			'uses' => $elespacio.'\Api\ApiusuariosController@crear',
			'as' => 'usuarios.crear'
	]);
	
	Route::post($mespacio.'api/usuarios/actualizar',[
			'uses' => $elespacio.'\Api\ApiusuariosController@actualizar',
			'as' => 'usuarios.actualizar'
	]);
	
	Route::post($mespacio.'api/usuarios/actuclave',[
			'uses' => $elespacio.'\Api\ApiusuariosController@actuclave',
			'as' => 'usuarios.actuclave'
	]);
	
	Route::post($mespacio.'api/usuarios/buscar',[
			'uses' => $elespacio.'\Api\ApiusuariosController@buscar',
			'as' => 'usuarios.buscar'
	]);
	
	Route::post($mespacio.'api/usuarios/borrar',[
			'uses' => $elespacio.'\Api\ApiusuariosController@borrar',
			'as' => 'usuarios.borrar'
	]);
	
	Route::post($mespacio.'api/usuarios/login',[
			'uses' => $elespacio.'\Api\ApiusuariosController@login',
			'as' => 'usuarios.login'
	]);
	
	
	////////////      roles  ////////////////////
	//
	/////////////////////////////////////////////
	
	Route::post($mespacio.'api/roles/ver',[
			'uses' => $elespacio.'\Api\ApirolesController@ver',
			'as' => 'roles.ver'
	]);
	
	Route::post($mespacio.'api/roles/crear',[
			'uses' => $elespacio.'\Api\ApirolesController@crear',
			'as' => 'roles.crear'
	]);
	
	Route::post($mespacio.'api/roles/actualizar',[
			'uses' => $elespacio.'\Api\ApirolesController@actualizar',
			'as' => 'roles.actualizar'
	]);
	
	Route::post($mespacio.'api/roles/borrar',[
			'uses' => $elespacio.'\Api\ApirolesController@borrar',
			'as' => 'roles.borrar'
	]);
	
	Route::post($mespacio.'api/roles/buscar',[
			'uses' => $elespacio.'\Api\ApirolesController@buscar',
			'as' => 'roles.buscar'
	]);
	
	
	////////////      expediente  ////////////////
	//
	/////////////////////////////////////////////
	
	Route::post($mespacio.'api/expediente/ver',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@ver',
			'as' => 'expediente.ver'
	]);
	
	Route::post($mespacio.'api/expediente/buscar',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@buscar',
			'as' => 'expediente.buscar'
	]);
	
	Route::post($mespacio.'api/expediente/crear',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@crear',
			'as' => 'expediente.crear'
	]);
	
	Route::post($mespacio.'api/expediente/actualizar',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@actualizar',
			'as' => 'expediente.actualizar'
	]);
	
	Route::post($mespacio.'api/expediente/borrar',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@borrar',
			'as' => 'expediente.borrar'
	]);
	
	Route::post($mespacio.'api/expediente/buscar_avanzada',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@buscar_avanzada',
			'as' => 'expediente.buscar_avanzada'
	]);
	
	Route::post($mespacio.'api/expediente/buscar_ind',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@buscar_ind',
			'as' => 'expediente.buscar_ind'
	]);
	
	Route::post($mespacio.'api/expediente/buscarxfecha',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@buscarxfecha',
			'as' => 'expediente.buscarxfecha'
	]);
	
	
	Route::post($mespacio.'api/expediente/reportabuscar',[
			'uses' => $elespacio.'\Api\ApiexpedientesController@reportabuscar',
			'as' => 'expediente.reportabuscar'
	]);
	
	//////////    Tablas ////////////////////////
	//
	////////////////////////////////////////////
	
	/*Route::resource($mespacio.'api/tablas', 'TablasapiController');*/
	
	Route::post($mespacio.'api/tablas/ver',[
			'uses' => $elespacio.'\Api\ApitablasController@ver',
			'as' => 'tablas.ver'
	]);
	
	Route::post($mespacio.'api/tablas/crear',[
			'uses' => $elespacio.'\Api\ApitablasController@crear',
			'as' => 'tablas.crear'
	]);
	
	Route::post($mespacio.'api/tablas/actualizar',[
			'uses' => $elespacio.'\Api\ApitablasController@actualizar',
			'as' => 'tablas.actualizar'
	]);
	
	Route::post($mespacio.'api/tablas/borrar',[
			'uses' => $elespacio.'\Api\ApitablasController@borrar',
			'as' => 'tablas.borrar'
	]);
	
	Route::post($mespacio.'api/tablas/buscar',[
			'uses' => $elespacio.'\Api\ApitablasController@buscar',
			'as' => 'tablas.buscar'
	]);
	
	
	//////////    Tipos documentales ////////////////////////
	//
	////////////////////////////////////////////
	
	Route::post($mespacio.'api/tipodocumental/ver',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@ver',
			'as' => 'tipodocumental.ver'
	]);
	
	Route::post($mespacio.'api/tipodocumental/crear',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@crear',
			'as' => 'tipodocumental.crear'
	]);
	
	Route::post($mespacio.'api/tipodocumental/actualizar',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@actualizar',
			'as' => 'tipodocumental.actualizar'
	]);
	
	Route::post($mespacio.'api/tipodocumental/borrar',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@borrar',
			'as' => 'tipodocumental.borrar'
	]);
	
	Route::post($mespacio.'api/tipodocumental/buscar',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@buscar',
			'as' => 'tipodocumental.buscar'
	]);
	
	
	Route::post($mespacio.'api/tipodocumental/buscarind',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@buscarind',
			'as' => 'indices.buscarind'
	]);
	
	Route::post($mespacio.'api/tipodocumental/buscartpdocum',[
			'uses' => $elespacio.'\Api\ApitpdocumentalController@buscartpdocum',
			'as' => 'indices.buscartpdocum'
	]);
	
	//////////    Indices ////////////////////////
	//
	////////////////////////////////////////////
	
	Route::post($mespacio.'api/indices/ver',[
			'uses' => $elespacio.'\Api\ApiindicesController@ver',
			'as' => 'indices.ver'
	]);
	
	Route::post($mespacio.'api/indices/crear',[
			'uses' => $elespacio.'\Api\ApiindicesController@crear',
			'as' => 'indices.crear'
	]);
	
	Route::post($mespacio.'api/indices/actualizar',[
			'uses' => $elespacio.'\Api\ApiindicesController@actualizar',
			'as' => 'indices.actualizar'
	]);
	
	Route::post($mespacio.'api/indices/borrar',[
			'uses' => $elespacio.'\Api\ApiindicesController@borrar',
			'as' => 'indices.borrar'
	]);
	
	Route::post($mespacio.'api/indices/buscar',[
			'uses' => $elespacio.'\Api\ApiindicesController@buscar',
			'as' => 'indices.buscar'
	]);
	
	
	
	
	
	
	//////////    Dependencias///////////////////
	//
	////////////////////////////////////////////
	
	Route::post($mespacio.'api/dependencias/ver',[
			'uses' => $elespacio.'\Api\ApidependenciasController@ver',
			'as' => 'dependencias.ver'
	]);
	
	Route::post($mespacio.'api/dependencias/crear',[
			'uses' => $elespacio.'\Api\ApidependenciasController@crear',
			'as' => 'dependencias.crear'
	]);
	
	Route::post($mespacio.'api/dependencias/actualizar',[
			'uses' => $elespacio.'\Api\ApidependenciasController@actualizar',
			'as' => 'dependencias.actualizar'
	]);
	
	Route::post($mespacio.'api/dependencias/borrar',[
			'uses' => $elespacio.'\Api\ApidependenciasController@borrar',
			'as' => 'dependencias.borrar'
	]);
	
	Route::post($mespacio.'api/dependencias/buscar',[
			'uses' => $elespacio.'\Api\ApidependenciasController@buscar',
			'as' => 'dependencias.buscar'
	]);
	
	
	//////////    Documentos ///////////////////
	//
	////////////////////////////////////////////
	
	Route::post($mespacio.'api/documentos/ver',[
			'uses' => $elespacio.'\Api\ApidocumentosController@ver',
			'as' => 'documentos.ver'
	]);
	
	Route::post($mespacio.'api/documentos/buscar',[
			'uses' => $elespacio.'\Api\ApidocumentosController@buscar',
			'as' => 'documentos.buscar'
	]);
	
	Route::post($mespacio.'api/documentos/imagenes',[
			'uses' => $elespacio.'\Api\ApidocumentosController@imagenes',
			'as' => 'documentos.imagenes'
	]);
	
	Route::post($mespacio.'api/documentos/tira_imagenes',[
			'uses' => $elespacio.'\Api\ApidocumentosController@tira_imagenes',
			'as' => 'documentos.tira_imagenes'
	]);
	
	Route::post($mespacio.'api/documentos/buscarxfecha',[
			'uses' => $elespacio.'\Api\ApidocumentosController@buscarxfecha',
			'as' => 'documentos.buscarxfecha'
	]);
	
	Route::post($mespacio.'api/documentos/grabaimg',[
			'uses' => $elespacio.'\Api\ApidocumentosController@grabaimg',
			'as' => 'documentos.grabaimg'
	]);
	
	Route::post($mespacio.'api/documentos/creadoc',[
			'uses' => $elespacio.'\Api\ApidocumentosController@creadoc',
			'as' => 'documentos.creadoc'
	]);
	
	Route::post($mespacio.'api/documentos/creadoc_csv',[
			'uses' => $elespacio.'\Api\ApidocumentosController@creadoc',
			'as' => 'documentos.creadoc'
	]);
	
	Route::post($mespacio.'api/documentos/comprimezip',[
			'uses' => $elespacio.'\Api\ApidocumentosController@comprimezip',
			'as' => 'documentos.comprimezip'
	]);
	
	Route::post($mespacio.'api/documentos/listazip',[
			'uses' => $elespacio.'\Api\ApidocumentosController@listazip',
			'as' => 'documentos.listazip'
	]);
	
	Route::post($mespacio.'api/documentos/extraedelzip',[
			'uses' => $elespacio.'\Api\ApidocumentosController@extraedelzip',
			'as' => 'documentos.extraedelzip'
	]);
	
	Route::post($mespacio.'api/documentos/verdelzip',[
			'uses' => $elespacio.'\Api\ApidocumentosController@verdelzip',
			'as' => 'documentos.verdelzip'
	]);
	
	Route::post($mespacio.'api/documentos/loadfile_folder',[
			'uses' => $elespacio.'\Api\ApidocumentosController@loadfile_folder',
			'as' => 'documentos.loadfile_folder'
	]);
	
	Route::post($mespacio.'api/documentos/unepdf',[
			'uses' => $elespacio.'\Api\ApidocumentosController@unepdf',
			'as' => 'documentos.unepdf'
	]);
	
	Route::post($mespacio.'api/documentos/loadfile_jlt',[
			'uses' => $elespacio.'\Api\ApidocumentosController@loadfile_jlt',
			'as' => 'documentos.loadfile_jlt'
	]); 
	
	Route::post($mespacio.'api/documentos/unepdf_docs',[
			'uses' => $elespacio.'\Api\ApidocumentosController@unepdf_docs',
			'as' => 'documentos.unepdf_docs'
	]);  
	
	
	//////////    Folders  //////////////////////
	//
	////////////////////////////////////////////
	
	Route::post($mespacio.'api/folder/ver',[
			'uses' => $elespacio.'\Api\ApifolderController@ver',
			'as' => 'folder.ver'
	]);
	
	
	
	//////////    grupos  //////////////////////
	//
	////////////////////////////////////////////
	
	
	Route::post($mespacio.'api/grupos/ver',[
			'uses' => $elespacio.'\Api\ApigrupoController@ver',
			'as' => 'grupos.ver'
	]);
	
	Route::post($mespacio.'api/grupos/crear',[
			'uses' => $elespacio.'\Api\ApigrupoController@crear',
			'as' => 'grupos.crear'
	]);
	
	Route::post($mespacio.'api/grupos/actualizar',[
			'uses' => $elespacio.'\Api\ApigrupoController@actualizar',
			'as' => 'grupos.actualizar'
	]);
	
	Route::post($mespacio.'api/grupos/borrar',[
			'uses' => $elespacio.'\Api\ApigrupoController@borrar',
			'as' => 'grupos.borrar'
	]);
	
	Route::post($mespacio.'api/grupos/buscar',[
			'uses' => $elespacio.'\Api\ApigrupoController@buscar',
			'as' => 'grupos.buscar'
	]);
	
	Route::post($mespacio.'api/grupos/update_agrupar',[
			'uses' => $elespacio.'\Api\ApigrupoController@update_agrupar',
			'as' => 'grupos.update_agrupar'
	]);
	
	
	
	///////  fin de apis///////
	
	Route::get('powerfile2/', function () {
		
		return view('auth.login');
	});
	
