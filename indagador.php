<?php 
	set_time_limit(0);
	
	$id = @$_REQUEST["ip"];
	if ($id != '' or $id!= 'undefined')
	 { 
	  $id();
	 }
	function crearespacios(){  
	 
				//buscamos el tipo manejador a trabajar de configdb
				
				 $fp = fopen("public/treepowerfile2/configdb", "r");
   
			     $linea = '';
			   
			     while(!feof($fp)) {
			   
				  $linea .= trim(fgets($fp)).'_;_';
			   
			     }
			   
			     fclose($fp);
			   
				 @$configdb = $linea; 
				
				 
			     $configdb = explode("_;_",$configdb); 
				
				
	 
	 
				$nespaciotrab = $_REQUEST["workspace"];  
				
				$bdespaciotrab = $_REQUEST["databasename"];
				
				define("ESPACIOTRABAJO", "\$espaciotrabajo");
				
				//se verifica que no existe el espacio de trabjo previamente
				
				$lineas = file("config/database.php");
				
				$palabra = $nespaciotrab;  
				
				// Podemos mostrar / trabajar con todas las líneas:
				$esta = 0;
				foreach($lineas as $linea)
					{
					
						if (strstr($linea,$palabra))
							{
								$esta = 1;
								break;
							}
						
					}
				if ($esta == 0)
					{
						//step 1: se debe crear la estructura de conexión de la nueva base de datos del nuevo espacio de trabajo
						print_r('inicio de proceso');
						
						echo '<br>';
						
						echo '<br>';
						
						$fp = fopen("config/database.php", "r");
					   
						$linea = '';
						$nlinea = ''; 
						while(!feof($fp)) {
						 
							$linea = fgets($fp);
							
							if ($configdb[0] == 'mysql')
								{
							
									if (trim($linea) == '//fin de bd')
										{
											$nlinea .= "\t"."\t"."'".$nespaciotrab."' => ["."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'driver' => 'mysql',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'host' => '127.0.0.1',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'port' => '3306',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'username' => 'root',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'password' => 'desarrollo1',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'collation' => 'utf8_unicode_ci',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'prefix' => '',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'strict' => true,"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'engine' => null,"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."],"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."//fin de bd"."\n";
										}
									else
										{
											$nlinea .= $linea;
										}	
								}
							else
								{
									if ($configdb[0] == 'pgsql')
										{
											 $nlinea .= "\t"."\t"."'".$nespaciotrab."' => ["."\n" ;  //'pgsql' => [
											 $nlinea .= "\t"."\t"."\t"."'driver' => 'pgsql',"."\n" ; 	//'driver' => 'pgsql',
											 $nlinea .= "\t"."\t"."\t"."'host' => '127.0.0.1',"."\n" ; 
											 $nlinea .= "\t"."\t"."\t"."'port' => '5432',"."\n" ; 	//'port' => env('DB_PORT', '5432'),
											 $nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ;  //'database' => env('DB_DATABASE', 'forge'),
											 $nlinea .= "\t"."\t"."\t"."'username' => 'root',"."\n" ; 				//'username' => env('DB_USERNAME', 'forge'),
											 $nlinea .= "\t"."\t"."\t"."'password' => 'desarrollo1',"."\n" ;         //'password' => env('DB_PASSWORD', ''),
											 $nlinea .= "\t"."\t"."\t"."'charset' => 'utf8',"."\n" ; //'charset' => 'utf8',
											 $nlinea .= "\t"."\t"."\t"."'prefix' => '',"."\n" ; 	//'prefix' => '',
											 $nlinea .= "\t"."\t"."\t"."'schema' => 'public',"."\n" ; 	//'schema' => 'public',
											 $nlinea .= "\t"."\t"."\t"."'sslmode' => 'prefer',"."\n" ;  //	'sslmode' => 'prefer',
											 $nlinea .= "\t"."\t"."\t"."],"."\n" ;
											 $nlinea .= "\t"."\t"."\t"."//fin de bd"."\n";
										}
									else
										{
											if ($configdb[0] == 'sqlsrv')
												{
													if (trim($linea) == '//fin de bd')
														{
															$nlinea .= "\t"."\t"."'".$nespaciotrab."' => ["."\n" ;  //'sqlsrv' => [
															$nlinea .= "\t"."\t"."\t"."'driver' => 'sqlsrv',"."\n" ;  //'driver' => 'sqlsrv',
															$nlinea .= "\t"."\t"."\t"."'host' => '192.168.0.20',"."\n" ; //'host' => '192.168.0.20', // Provide IP address here
															$nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ;  //'database' => 'powerfile',
															$nlinea .= "\t"."\t"."\t"."'username' => 'sa',"."\n" ;  //'username' => 'sa',
															$nlinea .= "\t"."\t"."\t"."'password' => 'Loquese@',"."\n" ;  //'password' => 'Loquese@',
															$nlinea .= "\t"."\t"."\t"."'prefix' => '',"."\n" ;  //'prefix' => '',
															$nlinea .= "\t"."\t"."\t"."],"."\n" ; 
															$nlinea .= "\t"."\t"."\t"."//fin de bd"."\n";
														
														}
													else
														{
															$nlinea .= $linea;
														}
												}
										}	
								}	
							
						}
						 
						fclose($fp);
					   
						//se escribe el archivo
						$fp = fopen("config/database.php", "w");
					   
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						print_r('se creó la estructura en el archivo database.php ........');
						echo '<br>';
					   ///////////////////////////////////////////////////fin de agregar el nuevo espacio de trabajo
					   
					   //step 2: se crea la nueva base de datos

						$configdb =  'http://'.$_SERVER['SERVER_NAME'];
						
						$fp = fopen("public/treepowerfile2/configdb", "r");
					   
						$linea = '';  
					   
						while(!feof($fp)) {
					   
							$linea .= trim(fgets($fp)).'_;_';
					   
						}
					   
					   fclose($fp);
					   
						@$configdb = $linea; 
						
						 
						$configdb = explode("_;_",$configdb);    
					   
					   //se debe leer el archivo database del config
					   
						$ctlexito = 0;
						
						if ($configdb[0] == 'mysql')
							{
								$servername = $configdb[1]; //"127.0.0.1";
								$username = $configdb[2]; //"root";
								$password = $configdb[3];//"desarrollo1";
								$conn = mysql_connect($servername, $username, $password, true, 65536) or trigger_error(mysql_error(),E_USER_ERROR);
								$sql = 'CREATE DATABASE '.$bdespaciotrab;
								if (mysql_query($sql, $conn)) {
									
									echo "La base de datos bogota se creó correctamente\n";
								} else {
									echo 'Error al crear la base de datos: bogota' . mysql_error() . "\n";
								}
								$ctlexito = 1;
							}
						else 
							{
								if ($configdb[0] == 'pgsql')
									{
										$servername = $configdb[1];//"127.0.0.1";    				
										$username = $configdb[2]; //"root";
										$password = $configdb[3];//"loquesea";
										$port = $configdb[5]; //"5432";  				 
										$conn = pg_connect("host=$servername port=$port user=$username password=$password dbname=$dbname") or die ('no se pudo conectar'.pg_last_error());
										$sql = 'CREATE DATABASE bogota';
										if (pg_query($conn,$sql)) {
											
											echo "La base de datos bogota se creó correctamente\n";
										} else {
											echo 'Error al crear la base de datos: bogota' . pg_last_error() . "\n";
										}
										$ctlexito = 1;
									}	
							}
						if (!$conn)
							{
								print_r('no se conecta a la bd');
								exit;
							}
						print_r('se creó la base de datos ........');
						echo '<br>';
						// step 3: se ejecutan los comandos composer para el llenado de la nueva base de datos
						
						//primero se debe colocar por defecto en el archivo database del config el nombre del nuevo espacio de trabajo
						
						$fp = fopen("config/database.php", "r");
					   
						$linea = '';
						$nlinea = ''; 
						while(!feof($fp)) {
						 
							$linea = fgets($fp); 
							
							if (substr(trim($linea), 0, 13) == "/*cambiarlo*/")
								{
									$nlinea .= "/*cambiarlo*/"."\t"."\t"."'default' => '".$nespaciotrab."',"."\n" ;    //aqui se pone el valor de la variable que contiene el nuevo espacio de trabajo
									
								}
							else
								{
									$nlinea .= $linea;
								}
						}
						 
						fclose($fp);
					   
						//se escribe el archivo
						$fp = fopen("config/database.php", "w");
					   
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						print_r('se modifica el archivo database.php con la linea "default" ........');
						echo '<br>';
						
						//segundo se debe colocar la linea del web.php en routes de : $espaciotrabajo = $_SERVER['REQUEST_URI']; a: $espaciotrabajo = '';
						
						$fp = fopen("routes/web.php", "r");
					   
						$linea = '';
						$nlinea = ''; 
						while(!feof($fp)) {
						 
							$linea = fgets($fp); //echo $linea."<br>" ; 
								
							if (substr(trim($linea), 0, 13) == "/*cambiarlo*/")
								{
									$nlinea .= "/*cambiarlo*/"."\t"."\t".ESPACIOTRABAJO."='';"."\n" ; 
								}
							else
								{
									$nlinea .= $linea;
								}
						}
						 
						fclose($fp);
					   
						//se escribe el archivo
						$fp = fopen("routes/web.php", "w");
					   
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						print_r('se creó modificó el archivo web.php en routes ........');
						echo '<br>';
						
						if ($ctlexito == 1)
							{
								$salida = shell_exec('composer dump-autoload');
								
								sleep(10);
								
								$salida = shell_exec('php artisan migrate');
								
								sleep(10);
								
								$salida = shell_exec('composer dump-autoload');
								
								sleep(10);
											
								$salida = shell_exec('php artisan db:seed');
								
								sleep(10);
								
								
								
								
								//se vuelve a colocar la linea del archivo web.php para manejar dinámicamente lso espacios de trabajo
								
								$fp = fopen("routes/web.php", "r");
					   
								$linea = '';
								$nlinea = ''; 
								while(!feof($fp)) {
								 
									$linea = fgets($fp);
									
									if (substr(trim($linea), 0, 13) == "/*cambiarlo*/")
										{
											$nlinea .= "/*cambiarlo*/"."\t"."\t".ESPACIOTRABAJO."=\$_SERVER['REQUEST_URI'];"."\n" ;  echo 'se ajustó de nuevo el espacio de trabajo en el web.php<br>';  
										}
									else
										{
											$nlinea .= $linea;
										}
									
								}
								 
								fclose($fp);
							   
								//se escribe el archivo
								$fp = fopen("routes/web.php", "w");
							   
								fputs($fp, $nlinea);
								
								fclose($fp);
								
								
								//se vuelve a colocar el archivo database.php para que trabaje dinamicamente
								
								$fp = fopen("config/database.php", "r");
					   
								$linea = '';
								$nlinea = ''; 
								while(!feof($fp)) {
								 
									$linea = fgets($fp); 
									
									if (substr(trim($linea), 0, 13) == "/*cambiarlo*/")
										{
											$nlinea .= "/*cambiarlo*/"."\t"."\t"."'default' => ".ESPACIOTRABAJO.","."\n" ;    //aqui se pone el valor de la variable que contiene el nuevo espacio de trabajo
											
										}
									else
										{
											$nlinea .= $linea;
										}
								}
								 
								fclose($fp);
							   
								//se escribe el archivo
								$fp = fopen("config/database.php", "w");
							   
								fputs($fp, $nlinea);
								
								fclose($fp);
								
								print_r('se modifica el archivo database.php con la linea "default" ........');
								echo '<br>';
								
								
								//por ultimo se agregan las rutas del nuevo espacio de trabajo
								
								$nlinea = '';
								
								$nlinea .= "Route::group(['namespace' => '".$nespaciotrab."'], function()"."\n" ;
								$nlinea .= "	{"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/', function () {"."\n" ;
								$nlinea .= "\t"."\t"."return view('auth.login');"."\n" ;
								$nlinea .= "\t"."\t"."});"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/home', 'PrincipalController@index');"."\n" ;
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/logout', 'Auth\LoginController@logout');"."\n" ;
								$nlinea .= "\t"."\t"."Route::post('".$nespaciotrab."/login', 'Auth\LoginController@login');"."\n" ;
										
								$nlinea .= "\t"."\t"."/* rutas para crud para usuarios*/"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/usuarios','UsuarioController');"."\n" ;
								$nlinea .= "\t"."\t"."/* rutas para crud para roles*/"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/roles','RolController');"."\n" ;
								$nlinea .= "\t"."\t"."/* rutas para crud para permisos*/"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/permisos','PermisoController');"."\n" ;
										
										
								$nlinea .= "\t"."\t"."// rutas para crud para indices"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/indices','IndicesController');"."\n" ;
										
								$nlinea .= "\t"."\t"."// rutas para crud para tipos documentales"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/tiposdocumentales','TiposdocumentalesController');"."\n" ;
										
								$nlinea .= "\t"."\t"."// rutas para crud para dependencias"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/dependencias','DependenciasController');"."\n" ;
										
								$nlinea .= "\t"."\t"."// rutas para crud para grupos"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/grupos','GruposController');"."\n" ;
										
								$nlinea .= "\t"."\t"."// rutas para crud para tablas"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/tablas','TablaController');"."\n" ;
										
								$nlinea .= "\t"."\t"."// rutas para crud para folders"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/folders','FoldersController');"."\n" ;
										
								$nlinea .= "\t"."\t"."//rutas para crud logos"."\n" ;
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/logos','LogoController');"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/permisos/{permiso}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'PermisoController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'permisos.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/roles/{rol}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'RolController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'roles.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/roles/{rol}/permiso',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'RolController@permiso',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'roles.permiso'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/roles/{rol}/store_permiso',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'RolController@store_permiso',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'roles.store_permiso'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/usuarios/{usuario}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'UsuarioController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'usuarios.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/usuarios/{usuario}/perfiles',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'UsuarioController@perfiles',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'usuarios.perfiles'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/usuarios/{usuario}/perfil',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'UsuarioController@perfil',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'usuarios.perfil'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::post('".$nespaciotrab."/usuarios/{usuario}/perfil',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'UsuarioController@updateclave',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'usuarios.updateclave'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/indices/{indice}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'IndicesController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'indices.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/tiposdocumentales/{tipodocumental}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'TiposdocumentalesController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'tiposdocumentales.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/dependencias/{dependencia}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'DependenciasController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'dependencias.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/grupos/{grupo}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'GruposController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'grupos.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/tablas/{tabla}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'TablaController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'tablas.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."//de grupos"."\n" ;
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/grupos/{grupo}/agrupar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'GruposController@agrupar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'grupos.agrupar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/grupos/{grupo}/update_agrupar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'GruposController@update_agrupar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'grupos.update_agrupar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."/////"."\n" ;
								$nlinea .= "\t"."\t"."Route::post('".$nespaciotrab."/logos/upload',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'LogoController@upload',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'logos.upload'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/logos/{idlogo}/activar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'LogoController@activar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'logos.activar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/logos/{idlogo}/desactivar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'LogoController@desactivar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'logos.desactivar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."//manejo de folders"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/folders/{tabla}/folder',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'FoldersController@folder',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'folders.folder'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."//manejo de permisos a dependencias"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/dependencias/{dependencia}/estructura',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'DependenciasController@estructura',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'dependencias.estructura'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
										
								$nlinea .= "\t"."\t"."//recuperacion de clave"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::post('".$nespaciotrab."/usuarios/recuperar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'UsuarioController@recuperar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'usuarios.recuperar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."///// principal//////"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/principal','PrincipalController');"."\n" ;
										
										
								$nlinea .= "\t"."\t"."//// expedientes /////"."\n" ;
										
										
								$nlinea .= "\t"."\t"."Route::resource('".$nespaciotrab."/expedientes','ExpedientesController');"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{expediente}/{tabla}/documentos',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@documentos',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.documentos'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{indice}/destroy',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@destroy',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.destroy'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{buscar}/visor',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{buscar}/visor_lista',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor_lista',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor_lista'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{iddocumento}/{buscar}/visor_listado',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor_listado',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor_listado'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{iddocumento}/{buscar}/{id_tabla}/visor_listado_avanzado',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor_listado_avanzado',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor_listado_avanzado'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{buscar}/{tabla}/visor_arbol',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor_arbol',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor_arbol'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{idexp}/visor_exp',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@visor_exp',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.visor_exp'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{idexp}/actualizar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@actualizar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.actualizar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
								$nlinea .= "\t"."\t"."////documentos en storage"."\n" ;
										
										
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/expedientes/{filename}/mostrar',["."\n" ;
								$nlinea .= "\t"."\t"."'uses' => 'ExpedientesController@mostrar',"."\n" ;
								$nlinea .= "\t"."\t"."'as' => 'expedientes.mostrar'"."\n" ;
								$nlinea .= "\t"."\t"."]);"."\n" ;
										
										
									
								$nlinea .= "\t"."});"."\n" ;
								
								$fp = fopen("routes/web.php", "a+");
							   
								fputs($fp, $nlinea);
								
								fclose($fp);
								
								///////
								
								//se crean el directorio nuevo para el espacio de trabjo
								
								//Recojo el valor de donde copio y donde tengo que copiar


								$destino = "app/Http/Controllers/".$nespaciotrab."/";
								$origen = "app/Http/Controllers/powerfile2/";

								copia($origen, $destino,$nespaciotrab);
								
								print_r('se creó en espacio de trabajo correctamente');
								
								exit;
							}
					}
				else
					{
						echo '0';
					}	
				
	}//fin de la funcion de crearespacios
	
	function copia($dirOrigen, $dirDestino,$nespaciotrab)
		{
			//Creo el directorio destino

			if (file_exists($dirDestino)) 
				{
					//echo "El fichero $nombre_fichero existe";
				}
			else 
				{
					mkdir($dirDestino, 0777, true);
				}
			
			//abro el directorio origen

			if ($vcarga = opendir($dirOrigen))
				{
					while($file = readdir($vcarga)) //lo recorro por completo
						{
							if ($file != "." && $file != "..") //quito el raiz y el padre
								{
									echo "<b>$file</b>"; //muestro el nombre del archivo
									
									if (!is_dir($dirOrigen.$file)) //pregunto si no es directorio
										{
											if(copy($dirOrigen.$file, $dirDestino.$file)) //como no es directorio, copio de origen a destino
												{
													//se procede a abrir y cambiarle el espacio de trabajo en la linea de namespace a cada archivo de los controladores namespace
													
													$fp = fopen($dirDestino.$file, "r");
   
													$linea = '';
													$nlinea = ''; 
													while(!feof($fp)) {
													 
														$linea = fgets($fp); 
														if (substr(trim($linea), 0, 9) == "namespace")
															{
																$pos = strpos($dirOrigen.$file, 'Auth');	
																if ($pos == true) 
																	{
																		$nlinea .= "namespace App\Http\Controllers\\".$nespaciotrab."\Auth;";
																	}
																else
																	{
																		if ($pos == false) 
																			{
																				$nlinea .= "namespace App\Http\Controllers\\".$nespaciotrab.";";
																			}
																	}	
																	
															}
														else
															{
																$nlinea .= $linea;
															}
													}
													 
													fclose($fp);
												   
													//se escribe el archivo
													$fp = fopen($dirDestino.$file, "w");
												   
													fputs($fp, $nlinea);
													
													fclose($fp);
													
													echo " COPIADO! en ".getcwd();
												}
											else
												{
													echo " ERROR!";
												}
										}
									else
										{
											echo " — directorio — <br />"; //era directorio llamo a la función de nuevo con la nueva ubicación
											copia($dirOrigen.$file."/", $dirDestino.$file."/",$nespaciotrab);
										}
									echo "<br />";
								}
						}
					closedir($vcarga);
				}
		}
   ?>