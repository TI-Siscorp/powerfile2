<?php 
	use PhpParser\Node\Stmt\Else_;

	set_time_limit(0);
	
	define("ESPACIOTRABAJO", "\$espaciotrabajo");
	
	//primero se debe colocar por defecto en el archivo database del config el nombre del nuevo espacio de trabajo
	
	$fp = fopen("config/database.php", "r");
	
	$linea = '';
	$nlinea = '';
	while(!feof($fp)) {
			
		$linea = fgets($fp);
			
		if (substr(trim($linea), 0, 13) == "/*cambiarlo*/")
			{
				$nlinea .= "/*cambiarlo*/"."\t"."\t"."'default' => 'powerfile2',"."\n" ;    //aqui se pone el valor de la variable que contiene el nuevo espacio de trabajo
					
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
	
	$fp = fopen("routes/web.php", "r");
	
	$lineaorig  = '';
	
	while(!feof($fp)) {
	
		$lineaorig .= fgets($fp);
			
	}//fin del while
	
	fclose($fp);
	
	//se balquea antes de correr los comandos de composer
	
	//se escribe el archivo
	$fp = fopen("routes/web.php", "w");
	
	$nlinea = '<?php    ';
	
	fputs($fp, $nlinea);
	
	fclose($fp);
	
	
	print_r('se creó modificó el archivo web.php en routes ........');
	echo '<br>';
	
	

		
			$oldcwd = getcwd();
		
			$salida = exec('composer dump-autoload');
		
			sleep(10);
		
			$salida = exec('php artisan migrate');
		
			sleep(10);
		
			$salida = exec('composer dump-autoload');
		
			sleep(10);
				
			$salida = exec('php artisan db:seed');
		
			sleep(10);
		
			//chdir($oldcwd);
		
			//se vuelve a colocar la linea del archivo web.php para manejar dinámicamente lso espacios de trabajo
		
		
			//se escribe el archivo
		
			$nlinea = $lineaorig;
		
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
			
			
			//se captura la configuracion para saber que manejador se va a atrabajr y crear el fulltext en la tabla search
			
			
			$espaciotrabajo = 'powerfile2';
			
			/////////////nuevo
			
			$fp = fopen("config/database.php", "r");
			
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
			
				
			if ($configdb[0] == 'mysql')
				{
					$servername = $configdb[1]; //"127.0.0.1";
					$username = $configdb[2]; //"root";
					$password = $configdb[3];//"desarrollo1";
					//se busca el espacio de trabajo
					$dbname = $espaciotrabajo;
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
							$conn = pg_connect("host=$servername port=$port user=$username password=$password dbname=$dbname") or die ('no se pudo conectar'.pg_last_error());
						}
				}
			
			if (!$conn)
				{
					print_r('no se conecta a la bd');
					exit;
				}
				
				//se agreaga el fulltext a search
				
				if ($configdb[0] == 'mysql')
					{
						
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
				
			
			echo '<br>';
			
			print_r('se realizo la migracion correctamente');
		
			exit;
		