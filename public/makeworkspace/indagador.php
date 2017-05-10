<?php 
	use PhpParser\Node\Stmt\Else_;

	set_time_limit(0);
	
	$id = @$_REQUEST["ip"];
	if ($id != '' or $id!= 'undefined')
	 { 
	  $id();
	 }
	 
	 function darurl()
	 {
	 	return sprintf(
	 			"%s://%s%s",
	 			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
	 			$_SERVER['SERVER_NAME'],
	 			''
	 			);
	 }
	 
	function crearespacios(){  
		
				@session_start();
		
				$espaciotrabajo = $_SESSION['espaciotrabajo'];
				/////////////nuevo
				$fp = fopen("../../config/database.php", "r");
				
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
				
				//se desglosan los 6 valores a usar
				
				//1.- el driver
				
				$driverl = explode('=>',$driverl);
				
				$driverl = trim($driverl[1]);
				
				$driverl = substr($driverl, 0, -1);
				
				$driverl = str_replace("'","", $driverl);
				//
				//2.- el host
				
				$hostl = explode('=>',$hostl);
				
				$hostl = trim($hostl[1]);
				
				$hostl = substr($hostl, 0, -1);
				
				$hostl = str_replace("'","", $hostl);
				//
				//3.- el puerto
				
				$puertol = explode('=>',$puertol);
				
				$puertol = trim($puertol[1]);
				
				$puertol = substr($puertol, 0, -1);
				
				$puertol = str_replace("'","", $puertol);
				////
				//4.- la db
				
				$dbl = $espaciotrabajo;
				//
				//5.- el usuario
				
				$usernl = explode('=>',$usernl);
				
				$usernl = trim($usernl[1]);
				
				$usernl = substr($usernl, 0, -1);
				
				$usernl = str_replace("'","", $usernl);
				//
				//5.- el pass
				
				$passl = explode('=>',$passl);
				
				$passl = trim($passl[1]);
				
				$passl = substr($passl, 0, -1);
				
				$passl = str_replace("'","", $passl);
				
				
				unset($configdb);
				
				$configdb[] = trim($driverl);
				
				$configdb[] = trim($hostl);
				
				$configdb[] = trim($usernl);
				
				$configdb[] = trim($passl);
				
				$configdb[] = trim($dbl);
				
				$configdb[] = trim($puertol);
				
				//print_r($configdb);
				
				if ($configdb[0] == 'mysql')
				{
					$servername = $configdb[1]; //"127.0.0.1";
					$username = $configdb[2]; //"root";
					$password = $configdb[3];//"desarrollo1";
					//se busca el espacio de trabajo
					$dbname = $_SESSION['espaciotrabajo'];
					@$tablaid = @$_REQUEST['tablaid'];
					$conn = mysql_connect($servername, $username, $password, true, 65536) or trigger_error(mysql_error(),E_USER_ERROR);
					mysql_select_db($dbname,$conn);
				}
				else
				{
					if (trim($configdb[0]) == 'pgsql')
					{
						$servername = trim($configdb[1]);//"127.0.0.1";
						$username = trim($configdb[2]); //"root";
						$password = trim($configdb[3]);//"loquesea";
						//se busca el espacio de trabajo
						$dbname = $_SESSION['espaciotrabajo'];
						$port = trim($configdb[5]); //"5432";
						@$tablaid = @$_REQUEST['tablaid'];
						$conn = pg_connect("host=$servername port=$port user=$username password=$password dbname=$dbname") or die ('no se pudo conectar'.pg_last_error());
					}
				}
				
				/////////////
				
				$nespaciotrab = $_REQUEST["workspace"];  
				
				$bdespaciotrab = $_REQUEST["databasename"];
				
				define("ESPACIOTRABAJO", "\$espaciotrabajo");
				
				define("LRUTA", "\$ruta");  
						
				define("LTIRA", "darurl()"); 		
				
				
				
				
				//se verifica que no existe el espacio de trabjo previamente
				
				$lineas = file("../../config/database.php");
				
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
						
						$fp = fopen("../../config/database.php", "r");
					   
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
											$nlinea .= "\t"."\t"."\t"."'host' => '".$configdb[1]."',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'port' => '3306',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'username' => '".$configdb[2]."',"."\n" ; 
											$nlinea .= "\t"."\t"."\t"."'password' => '".$configdb[3]."',"."\n" ; 
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
											if (trim($linea) == '//fin de bd')
												{
													 $nlinea .= "\t"."\t"."'".$nespaciotrab."' => ["."\n" ;  //'pgsql' => [
													 $nlinea .= "\t"."\t"."\t"."'driver' => 'pgsql',"."\n" ; 	//'driver' => 'pgsql',
													 $nlinea .= "\t"."\t"."\t"."'host' => '".$configdb[1]."',"."\n" ; 
													 $nlinea .= "\t"."\t"."\t"."'port' => '".$configdb[5]."',"."\n" ; 	//'port' => env('DB_PORT', '5432'),
													 $nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ;  //'database' => env('DB_DATABASE', 'forge'),
													 $nlinea .= "\t"."\t"."\t"."'username' => '".$configdb[2]."',"."\n" ; 				//'username' => env('DB_USERNAME', 'forge'),
													 $nlinea .= "\t"."\t"."\t"."'password' => '".$configdb[3]."',"."\n" ;         //'password' => env('DB_PASSWORD', ''),
													 $nlinea .= "\t"."\t"."\t"."'charset' => 'utf8',"."\n" ; //'charset' => 'utf8',
													 $nlinea .= "\t"."\t"."\t"."'prefix' => '',"."\n" ; 	//'prefix' => '',
													 $nlinea .= "\t"."\t"."\t"."'schema' => 'public',"."\n" ; 	//'schema' => 'public',
													 $nlinea .= "\t"."\t"."\t"."'sslmode' => 'prefer',"."\n" ;  //	'sslmode' => 'prefer',
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
											if ($configdb[0] == 'sqlsrv')
												{
													if (trim($linea) == '//fin de bd')
														{
															$nlinea .= "\t"."\t"."'".$nespaciotrab."' => ["."\n" ;  //'sqlsrv' => [
															$nlinea .= "\t"."\t"."\t"."'driver' => 'sqlsrv',"."\n" ;  //'driver' => 'sqlsrv',
															$nlinea .= "\t"."\t"."\t"."'host' => '".$configdb[1]."',"."\n" ; //'host' => '192.168.0.20', // Provide IP address here
															$nlinea .= "\t"."\t"."\t"."'database' => '".$bdespaciotrab."',"."\n" ;  //'database' => 'powerfile',
															$nlinea .= "\t"."\t"."\t"."'username' => '".$configdb[2]."',"."\n" ;  //'username' => 'sa',
															$nlinea .= "\t"."\t"."\t"."'password' => '".$configdb[3]."',"."\n" ;  //'password' => 'Loquese@',
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
						$fp = fopen("../../config/database.php", "w");
					   
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						print_r('se creó la estructura en el archivo database.php ........');
						echo '<br>';
					   ///////////////////////////////////////////////////fin de agregar el nuevo espacio de trabajo
					   
					   //step 2: se crea la nueva base de datos

						
						/////////////nuevo
						$fp = fopen("../../config/database.php", "r");
						
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
						
						//se desglosan los 6 valores a usar
						
						//1.- el driver
						
						$driverl = explode('=>',$driverl);
						
						$driverl = trim($driverl[1]);
						
						$driverl = substr($driverl, 0, -1);
						
						$driverl = str_replace("'","", $driverl);
						//
						//2.- el host
						
						$hostl = explode('=>',$hostl);
						
						$hostl = trim($hostl[1]);
						
						$hostl = substr($hostl, 0, -1);
						
						$hostl = str_replace("'","", $hostl);
						//
						//3.- el puerto
						
						$puertol = explode('=>',$puertol);
						
						$puertol = trim($puertol[1]);
						
						$puertol = substr($puertol, 0, -1);
						
						$puertol = str_replace("'","", $puertol);
						////
						//4.- la db
						
						$dbl = $espaciotrabajo;
						//
						//5.- el usuario
						
						$usernl = explode('=>',$usernl);
						
						$usernl = trim($usernl[1]);
						
						$usernl = substr($usernl, 0, -1);
						
						$usernl = str_replace("'","", $usernl);
						//
						//5.- el pass
						
						$passl = explode('=>',$passl);
						
						$passl = trim($passl[1]);
						
						$passl = substr($passl, 0, -1);
						
						$passl = str_replace("'","", $passl);
						
						
						unset($configdb);
						
						$configdb[] = trim($driverl);
						
						$configdb[] = trim($hostl);
						
						$configdb[] = trim($usernl);
						
						$configdb[] = trim($passl);
						
						$configdb[] = trim($dbl);
						
						$configdb[] = trim($puertol);
						
						
					   
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
									echo 'Error al crear la base de datos: '.$bdespaciotrab.' '. pg_last_error() . "\n";
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
										$port = $configdb[5]; //"5432";  		$sql = 'createdb '.$bdespaciotrab;  
										if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
											{
												$conn = pg_connect("host=$servername port=$port user=$username password=$password dbname=$dbname") or die ('no se pudo conectar'.pg_last_error());
												$sql = 'CREATE DATABASE '.$bdespaciotrab;
												if (pg_query($conn,$sql)) 
													{
														echo "La base de datos ".$bdespaciotrab." se creó correctamente\n";
													} 
												else
													{
														echo 'Error al crear la base de datos: '.$bdespaciotrab.' '. pg_last_error() . "\n";
													}
											}
										else
											{
												//echo strtoupper(substr(PHP_OS, 0, 3)).'<br>';
												$ret = exec("su createdb ".$bdespaciotrab, $out, $err);
												echo $out;
												echo $err;
												//$salida = shell_exec('createdb '.$bdespaciotrab);
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
						
						$fp = fopen("../../config/database.php", "r");
					   
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
						$fp = fopen("../../config/database.php", "w");
					   
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						print_r('se modifica el archivo database.php con la linea "default" ........');
						echo '<br>';
												
						$fp = fopen("../../routes/web.php", "r");
						
						$lineaorig  = '';
						
						while(!feof($fp)) {
								
							$lineaorig .= fgets($fp);
							
						}//fin del while
								
						fclose($fp);
						
						//se balquea antes de correr los comandos de composer
						
						//se escribe el archivo
						$fp = fopen("../../routes/web.php", "w");
						
						$nlinea = '<?php    ';
						
						fputs($fp, $nlinea);
						
						fclose($fp);
						
						
						print_r('se creó modificó el archivo web.php en routes ........');
						echo '<br>';
						
						
						
						if ($ctlexito == 1)
							{
								
								$oldcwd = getcwd();
								
								chdir ('../');
								
								chdir ('../');	
								
								$salida = exec('composer dump-autoload'); 
								
								sleep(10);
								
								$salida = exec('php artisan migrate');
								
								sleep(10);
								
								$salida = exec('composer dump-autoload');
								
								sleep(10);
											
								$salida = exec('php artisan db:seed');
								
								sleep(10);
								
								
								
								chdir($oldcwd);
								
								//se vuelve a colocar la linea del archivo web.php para manejar dinámicamente lso espacios de trabajo
								
								
								//se escribe el archivo								
						
								$nlinea = $lineaorig;
								
								$nlinea .= "\n" ;
								
								$nlinea .= "\t"."\t"."Route::get('".$nespaciotrab."/', function () {"."\n" ;
									$nlinea .=	"\t"."\t"."\t"."\t"."return view('auth.login');"."\n" ;
									$nlinea .= "\t"."\t"."});"."\n" ;
								
								
								$fp = fopen("../../routes/web.php", "w");
								
								fputs($fp, $nlinea);
								
								fclose($fp);							
								
								//se vuelve a colocar el archivo database.php para que trabaje dinamicamente
								
								$fp = fopen("../../config/database.php", "r");
					   
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
								$fp = fopen("../../config/database.php", "w");
							   
								fputs($fp, $nlinea);
								
								fclose($fp);
								
								print_r('se modifica el archivo database.php con la linea "default" ........');
								echo '<br>';
													
								
								
								//se modifica el archivo VerifyCsrfToken para la exepcion del api del espacio de trabajo
								
								$fp = fopen("../../app/Http/Middleware/VerifyCsrfToken.php", "r");
								
								$linea = '';
								$nlinea = '';
								while(!feof($fp)) {
										
									$linea = fgets($fp); //echo $linea;
										
									if (trim($linea) == '//fin exepcion')
										{
											$nlinea .= "\t"."\t"."\t"."'".$nespaciotrab."/api/*', "."\n" ; 
											$nlinea .= "\t"."\t"."\t"."//fin exepcion"."\n" ;
											
										}
									else 
										{
											$nlinea .= $linea;
										}
								
								}
								
								fclose($fp);
								
								//se escribe el archivo
								$fp = fopen("../../app/Http/Middleware/VerifyCsrfToken.php", "w");
								
								fputs($fp, $nlinea);
								
								fclose($fp);
								
								print_r('se creó la estructura de exepcion del api rest en el archivo VerifyCsrfToken.php ........');
								echo '<br>';
																
								///////
								
								//se crean el directorio nuevo para el espacio de trabjo
								
								//Recojo el valor de donde copio y donde tengo que copiar


								$destino = "../../app/Http/Controllers/".$nespaciotrab."/";
								$origen = "../../app/Http/Controllers/powerfile2/";

								copia($origen, $destino,$nespaciotrab);
								
								print_r('se creó en espacio de trabajo correctamente');
								
								if (!file_exists('../loads/'.$nespaciotrab))
									{
										mkdir('../loads/'.$nespaciotrab, 0777, true);
										
										print_r('se creó la carpeta de carga e archivos para el espacoo de trabajo');
									}
									
								//se agreaga el fulltext a search
								
									if ($configdb[0] == 'mysql')
										{
											$servername = $configdb[1]; //"127.0.0.1";
											$username = $configdb[2]; //"root";
											$password = $configdb[3];//"desarrollo1";
											$conn = mysql_connect($servername, $username, $password, true, 65536) or trigger_error(mysql_error(),E_USER_ERROR);
											
											$sql = "ALTER TABLE sgd_search ADD FULLTEXT full(nombre, search)";
											
											if (mysql_query($sql, $conn)) 
												{
													echo "se agreg&oacute; el fulltext a search con exito";
												} 
											else 
												{
													echo 'Error al crear el fulltext';
												}
										}
									else
										{
											if ($configdb[0] == 'pgsql')
												{
													$sql = "ALTER TABLE sgd_search ADD FULLTEXT full(nombre, search)";
													
													if (pg_query($conn,$sql))
														{
															echo "se agreg&oacute; el fulltext a search con exito";
														}
													else
														{
															echo 'Error al crear el fulltext';
														}
													
												}
										}
								print_r('listo la cracion del espacio');		
								
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
																				$pos = strpos($dirOrigen.$file, 'Api');	
																				if ($pos == true)
																					{
																						$nlinea .= "namespace App\Http\Controllers\\".$nespaciotrab."\Api;";																						
																					}
																				else
																					{
																						$nlinea .= "namespace App\Http\Controllers\\".$nespaciotrab.";";
																					}	
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