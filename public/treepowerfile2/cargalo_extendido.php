<?php
 
@session_start();
 
@$configdb = $_REQUEST['configdb'];

require('traduccion_arbol.php');

$traduce = new Traduccion_arbol();

$ruta = $configdb;
 
$espaciotrabajo = $_SESSION['espaciotrabajo'];
//////
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
		else
			{
				if (trim($configdb[0]) == 'sqlsrv')
				{
					$servername = $configdb[1]; //"127.0.0.1";
					$username = $configdb[2]; //"root";
					$password = $configdb[3];//"desarrollo1";
					//se busca el espacio de trabajo
					@$dbname = $_SESSION['espaciotrabajo'];
					if ($dbname == ''){$dbname = $espaciotrabajo;}
					@$tablaid = @$_REQUEST['tablaid'];
					$port = trim($configdb[5]); //"5432";
					$connectionInfo = array( "Database"=>$dbname, "UID"=>$username, "PWD"=>$password);
					$conn = sqlsrv_connect( $hostl, $connectionInfo);
						
				}
			}
	}
/////

if (!$conn)
	{
		print_r('no se conecta a la bd');
		exit;
	}

$idusuario = $_SESSION['idusuario'];

date_default_timezone_set('America/Bogota');
if(isset($_GET['operation'])) {
	try {
		$result = null;

		switch($_GET['operation']) {
			case 'analyze':
				var_dump($fs->analyze(true));
				die();
				break;
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$sql = "SELECT * FROM sgd_busqueda_avanzada where id_tabla = ".$tablaid." and text <> 'root'";
				if ($configdb[0] == 'mysql')
				{
					$res = mysql_query($sql,$conn);
					$numreg = mysql_num_rows($res);
					//iterate on results row and create new index array of data
					while( $row = mysql_fetch_assoc($res) ) {
						$data[] = $row;
					}
				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{
						$res = pg_query($conn,$sql);
						$numreg = pg_num_rows($res);
							
						//iterate on results row and create new index array of data
						while( $row = pg_fetch_assoc($res) ) {
							$data[] = $row;
						}
					}
					else
					{
						if (trim($configdb[0]) == 'sqlsrv')
						{
							$res = sqlsrv_query( $conn, $sql);

							while( $row = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC ))
							{
								$data[] = $row;
							}
						}
					}
				}
					
				$itemsByReference = array();
					
				// Build array of item references:
				foreach($data as $key => &$item) {
					$itemsByReference[$item['id']] = &$item;
					// Children array:
					$itemsByReference[$item['id']]['children'] = array();
					// Empty data class (so that json_encode adds "data: {}" )
					$itemsByReference[$item['id']]['data'] = new StdClass();
				}
					
				// Set items as children of the relevant parent item.
				foreach($data as $key => &$item)
					if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
						$itemsByReference [$item['parent_id']]['children'][] = &$item;
							
						// Remove items that were added to parents elsewhere:
						foreach($data as $key => &$item) {
							if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
								unset($data[$key]);
						}
						$result = $data;
							
			break;

			
			default:
				throw new Exception('Unsupported operation: ' . $_GET['operation']);
				break;

			default:
				throw new Exception('No se puede realizar la operación: ' . $_GET['operation']);
				break;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result);
	}
	catch (Exception $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
		header('Status:  500 Server Error');
		echo $e->getMessage();
	}
	die();
}

if(isset($_GET['otraoperation'])) {
	try {
		$result = null;

		switch($_GET['otraoperation']) {
			case 'arbol_extendido':
				
			break;
			
			
			case 'darindicesxnode':
				
				$script = '';
				
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
				
				$scriptdoc = '';
				
				//buscamos en sgd_busqueda_avanzada el valor del folder
				
				
				$sql = " SELECT id_folder,id_folder_tpdoc,parent_id from sgd_busqueda_avanzada where id = ".$node;
				
				if ($configdb[0] == 'mysql')
					{
						
						$queryids =  mysql_query($sql,$conn);
						
						$didfolderd = mysql_fetch_assoc($queryids);
						
						$didfolder = $didfolderd['id_folder'];
						
						if ($didfolder== 0)
							{
								$didfolder = $didfolderd['id_folder_tpdoc'];
								
								if ($didfolder== 0)
									{
										$sql = " SELECT id_folder,id_folder_tpdoc,parent_id from sgd_busqueda_avanzada where id = ".$didfolderd['parent_id'];
										
										$queryids =  mysql_query($sql,$conn);
										
										$didfolderd = mysql_fetch_assoc($queryids);
										
										$didfolder = $didfolderd['id_folder_tpdoc'];
										
									}
								
							}
						
					}
				else
					{
						if ($configdb[0] == 'pgsql')
							{
								
								$queryids = pg_query($conn,$sql);
								
								$didfolderd = pg_fetch_assoc($queryids);								
								
								$didfolder = $didfolderd['id_folder'];
								
								if ($didfolder== 0)
									{
										$didfolder = $didfolderd['id_folder_tpdoc'];
										
										if ($didfolder== 0)
											{
												$sql = " SELECT id_folder,id_folder_tpdoc,parent_id from sgd_busqueda_avanzada where id = ".$didfolderd['parent_id'];
												
												$queryids =  pg_query($conn,$sql);
												
												$didfolderd = pg_fetch_assoc($queryids);
												
												$didfolder = $didfolderd['id_folder_tpdoc'];
												
											}
									}
							}
						else 
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										$queryids = sqlsrv_query($conn,$sql);
										
										while( $row = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
											{
												$didfolderd =  $row['id_folder'];
												
												if ($didfolder == 0)
													{
														$didfolder = $row['id_folder_tpdoc'];
														
														if ($didfolder== 0)
															{
																$sql = " SELECT id_folder,id_folder_tpdoc,parent_id from sgd_busqueda_avanzada where id = ".$row['parent_id'];
																
																$queryids2 = sqlsrv_query($conn,$sql);
																
																while( $row2 = sqlsrv_fetch_array( $queryids2, SQLSRV_FETCH_ASSOC ))
																	{
																		
																		$didfolderd =  $row2['id_folder_tpdoc'];
																		
																	}
																
															}	
														
													}
												
											}
									}	
								
							}
						
					}
				//se buscan los datos del id y el nombre de los indices que pertenecen a ese node	
				
				$script .= '<form class="form-horizontal bordered-row" id="demo-form" data-parsley-validate="">';
				
				$script .= '<div class="row">';
				
				//$script .= '<div class="col-md-6">';
				
				$sql = "SELECT distinct i.id_indice,i.nombre FROM sgd_tipodoc_indices ti, sgd_indices i WHERE i.id_indice = ti.id_indice and ti.id_folder =  ".$didfolder;
				
							
				if ($configdb[0] == 'mysql')
					{
						$queryids =  mysql_query($sql,$conn);
						
						//contamos el num de indices para separarlos en dos columnas
						
						$treg = mysql_num_rows($queryids);
						
						$mitad = floor($treg / 2);
						
						$ctlmitad = 0;
						
						while($campind = mysql_fetch_array($queryids))
						  {
						  		$ctlmitad = $ctlmitad  + 1;
							  	if ($ctlmitad == 1)
							  		{
							  			$script .= '<div class="col-md-6">';
							  		}
							  	else
							  		{
							  			if ($ctlmitad == ($mitad +1))
							  				{
							  					$script .= '</div>';
							  					$script .= '<div class="col-md-6">';
							  				}
							  		}
							  		
						  		$script .= '<div class="form-group">';
							  	$script .= '<label class="col-sm-3 control-label">'.$campind['nombre'].'</label>';
							  	$script .= '<div class="col-sm-6">';
							  	$script .= '<input id="indice_'.$campind['id_indice'].'" data-idindice="'.$campind['id_indice'].'" type="text" placeholder="'.$campind['nombre'].'" onkeyup="buscarindices()" class="form-control losindices">';
							  	$script .= '</div>';
							  	$script .= '</div>';
						  }
				
					}
				else 
				{ 	
						if ($configdb[0] == 'pgsql')
							{
								$queryids = pg_query($conn,$sql);
								
								//contamos el num de indices para separarlos en dos columnas
								
								$treg = pg_num_rows($queryids);
								
								$mitad = floor($treg / 2);
								
								$ctlmitad = 0;
								
								while($campind = pg_fetch_array($queryids))
									{
										$ctlmitad = $ctlmitad  + 1;
										if ($ctlmitad == 1)
											{
												$script .= '<div class="col-md-6">';
											}
										else
											{
												if ($ctlmitad == ($mitad +1))
													{
														$script .= '</div>';
														$script .= '<div class="col-md-6">';
													}
											}
										
										$script .= '<div class="form-group">';
										$script .= '<label class="col-sm-3 control-label">'.$campind['nombre'].'</label>';
										$script .= '<div class="col-sm-6">';
										$script .= '<input id="indice_'.$campind['id_indice'].'" data-idindice="'.$campind['id_indice'].'" type="text" placeholder="'.$campind['nombre'].'" class="form-control losindices">';
										$script .= '</div>';
										$script .= '</div>';
									}
								
							}
						else
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										$queryids = sqlsrv_query($conn,$sql);
										
										$queryids1 = sqlsrv_query($conn,$sql);
										
										//contamos el num de indices para separarlos en dos columnas
										
										$treg = 0;
										
										while( $row = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
											{
												$treg = $treg + 1;												
											}
																					
										$mitad = floor($treg / 2);
										
										$ctlmitad = 0;
										
										while($campind = sqlsrv_fetch_array( $queryids1, SQLSRV_FETCH_ASSOC ))
											{
												$ctlmitad = $ctlmitad  + 1;
												if ($ctlmitad == 1)
													{
														$script .= '<div class="col-md-6">';
													}
												else
													{
														if ($ctlmitad == ($mitad +1))
															{
																$script .= '</div>';
																$script .= '<div class="col-md-6">';
															}
													}
												
												$script .= '<div class="form-group">';
												$script .= '<label class="col-sm-3 control-label">'.$campind['nombre'].'</label>';
												$script .= '<div class="col-sm-6">';
												$script .= '<input id="indice_'.$campind['id_indice'].'" data-idindice="'.$campind['id_indice'].'" type="text" placeholder="'.$campind['nombre'].'" class="form-control losindices">';
												$script .= '</div>';
												$script .= '</div>';
											}
										
									}
							}
						
					}
					
				$script .= '</div>';
				$script .= '</div>';
				$script .= '';
				
				echo $script;
			break;	
					
			case 'dameidicesbuscar':

				$script = '';

				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
				
				$buscar= isset($_GET['dabuscar']) && $_GET['dabuscar'] !== '' ? $_GET['dabuscar'] : '';
				
				if ($buscar== '_;_')
					{
						$buscar= '';
					}	
				
				$buscar= str_replace('_..._', '%', $buscar);
				
				//buscamos los documentos que existen bajo esa premisa de usuario, carpeta y
				

				$sql = "select * from sgd_busqueda_avanzada where id = ".$node." and id_usuario = ".$_SESSION['idusuario'];

				$script .= '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-expediente">';
				$script .= '<thead>';
				$script .= '<tr>';
				$script .= '<th width="5%" >&nbsp;</th>';
				$script .= '<th class="centrartexto">&nbsp;</th>';
				$script .= '</tr>';
				$script .= '</thead>';
				$script .= '<tbody>';


				if ($configdb[0] == 'mysql')
				{
					$queryids =  mysql_query($sql,$conn);

					$campo2 = mysql_fetch_assoc($queryids);

					//se hace la busqueda de documentos y expedientes

					//se verifica si es una madre
					if ($campo2['id_folder'] > 0)
					{
						//se verifica si tiene hijas
						$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];

						$queryids =  mysql_query($sqlp,$conn);

						$cuantahija = @mysql_num_rows($queryids);

						if ($cuantahija > 0)
							
							{
								//se arman los id de los folders donde se buscara
								$secuencia = '';
	
								$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
								$queryids =  mysql_query($sqlp,$conn);
	
								while($campohja = mysql_fetch_array($queryids))
								{
									if ($campohja['id_folder'] > 0)
									{
										$secuencia .= $campohja['id_folder'].',';
									}
									else
									{
										$secuencia .= $campohja['id_folder_tpdoc'].',';
									}
	
									//buscamos los nietos
									//se verifica si tiene hijas
									$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
									$querynietas =  mysql_query($sqlp,$conn);
	
									$cuantanieta = @mysql_num_rows($querynietas);
										
									if ($cuantanieta > 0)
										
									{
										$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
										$querynietas1 =  mysql_query($sqlp,$conn);
	
										while($camponta = mysql_fetch_array($querynietas1))
										{
											if ($camponta['id_folder'] > 0)
											{
												$secuencia .= $camponta['id_folder'].',';
											}
											else
											{
												$secuencia .= $camponta['id_folder_tpdoc'].',';
											}
											//buscamos los bisnietos
											//se verifica si tiene hijas
											$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
											$querybisnietas =  mysql_query($sqlp,$conn);
	
											$cuantabisnieta = @mysql_num_rows($querybisnietas);
	
											if ($cuantabisnieta > 0)
												
											{
												$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
												$querybisnieta1 =  mysql_query($sqlp,$conn);
	
												while($campobnta = mysql_fetch_array($querybisnieta1))
												{
													if ($campobnta['id_folder'] > 0)
													{
														$secuencia .= $campobnta['id_folder'].',';
													}
													else
													{
														$secuencia .= $campobnta['id_folder_tpdoc'].',';
													}
														
													//buscamos los tataranietos
													//se verifica si tiene hijas
													$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
													$querytataranietas =  mysql_query($sqlp,$conn);
	
													$cuantatataranieta = @mysql_num_rows($querytataranietas);
	
													if ($cuantatataranieta > 0)
														
													{
	
														$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
														$querytataranietas1 =  mysql_query($sqlp,$conn);
	
														while($campotnta = mysql_fetch_array($querytataranietas1))
														{
															if ($campotnta['id_folder'] > 0)
															{
																$secuencia .= $campotnta['id_folder'].',';
															}
															else
															{
																$secuencia .= $campotnta['id_folder_tpdoc'].',';
															}
															//buscamos los trastataranietos
															//se verifica si tiene hijas
															$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
															$querytrastataranietas =  mysql_query($sqlp,$conn);
	
															$cuantatrastataranieta = @mysql_num_rows($querytrastataranietas);
	
															if ($cuantatrastataranieta > 0)
																
															{
																$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
																$querytataranietas1 =  mysql_query($sqlp,$conn);
	
																while($campotrasnta = mysql_fetch_array($querytataranietas1))
																{
																	if ($campotrasnta['id_folder'] > 0)
																	{
																		$secuencia .= $campotrasnta['id_folder'].',';
																	}
																	else
																	{
																		$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																	}
																		
																	//buscamos los pentanietos
																	//se verifica si tiene hijas
																	$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
																	$querypentanietas =  mysql_query($sqlp,$conn);
	
																	$cuantapentanieta = @mysql_num_rows($querypentanietas);
	
																	if ($cuantapentanieta > 0)
																		
																	{
																		$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
																		$querypentanietas1 =  mysql_query($sqlp,$conn);
	
																		while($campopenta = mysql_fetch_array($querypentanietas1))
																		{
																			if ($campopenta['id_folder'] > 0)
																			{
																				$secuencia .= $campopenta['id_folder'].',';
																			}
																			else
																			{
																				$secuencia .= $campopenta['id_folder_tpdoc'].',';
																			}
																				
																			//buscamos los hexanieto
																			//se verifica si tiene hijas
																			$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
																			$queryhexanietas =  mysql_query($sqlp,$conn);
	
																			$cuantahexanietas = @mysql_num_rows($queryhexanietas);
	
																			if ($cuantahexanietas > 0)
																				
																			{
																				$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
	
																				$queryhexanietas1 =  mysql_query($sqlp,$conn);
	
																				while($campohexanietas = mysql_fetch_array($queryhexanietas1))
																				{
																					if ($campohexanietas['id_folder'] > 0)
																					{
																						$secuencia .= $campohexanietas['id_folder'].',';
																					}
																					else
																					{
																						$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																					}
																				}
																					
																			}
																		}
																	}
																}
	
															}
																
														}
													}
	
												}
	
											}
	
										}
	
									}
	
								}
	
								$secuencia = trim($secuencia,",");
	
								if ($buscar == '')
									{
								
										$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
										$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
										$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
										$sql .= " and d.id_folder in (".$secuencia.")";
										if ($campo2['id_tpdoc'] > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
										}
									}	
								else
									{
										if ($buscar != '%')
											{
												$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
												$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
												$sql .= " and e.id_tabla = ".$campo2['id_tabla']." and (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
												$sql .= " and d.id_folder in (".$secuencia.")";
												if ($campo2['id_tpdoc'] > 0)
													{
														$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
													}
											}	
										else 
											{
												
												$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
												$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
												$sql .= " and e.id_tabla = ".$campo2['id_tabla']." (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
												$sql .= " and d.id_folder in (".$secuencia.")";
												if ($campo2['id_tpdoc'] > 0)
													{
														$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
													}
												
											}
									}	
							}
						else
							{
								if ($buscar == '')
									{
										$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
										$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
										$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
										$sql .= " and d.id_folder = ".$campo2['id_folder'];
										if ($campo2['id_tpdoc'] > 0)
											{
												$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
											}
									}
								else 
									{
										if ($buscar != '%')
											{
												$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
												$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
												$sql .= " and e.id_tabla = ".$campo2['id_tabla']." and (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
												$sql .= " and d.id_folder in (".$secuencia.")";
												if ($campo2['id_tpdoc'] > 0)
													{
														$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
													}
												
											}
										else
											{
												$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
												$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
												$sql .= " and e.id_tabla = ".$campo2['id_tabla']." (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
												$sql .= " and d.id_folder = ".$campo2['id_folder'];
												if ($campo2['id_tpdoc'] > 0)
													{
														$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
													}
												
											}
									}
							}
					}
					else
						{
							if ($buscar == '')
								{ 
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
									if ($campo2['id_tpdoc'] > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
										}
								}
							else
								{
									if ($buscar != '%')
										{
											$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
											$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
											$sql .= " and e.id_tabla = ".$campo2['id_tabla']." and (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
											$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
											if ($campo2['id_tpdoc'] > 0)
												{
													$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
												}
										}	
									else
										{
											$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
											$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
											$sql .= " and e.id_tabla = ".$campo2['id_tabla']." (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%')";
											$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
											if ($campo2['id_tpdoc'] > 0)
												{
													$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
												}
											
										}
								}
						}
					$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	; // echo $sql;

					$queryids =  mysql_query($sql,$conn);

					$cuantosreg = @mysql_num_rows($queryids);
					
					
					if ($cuantosreg > 0)
						{
							/*//se limpia la tabla de consulta
							
							$id_usuario = $_SESSION['idusuario'];
							
							$sql ="DELETE FROM sgd_vista_avanzada WHERE id_usuario = ".$id_usuario;
							
							$queryvista =  mysql_query($sql,$conn);
							
							//se carga la data de busqueda
							
							$sqlv = ' INSERT INTO sgd_vista_avanzada(id_documento, id_expediente, nombre,id_tipodocumental) '.$sql;
													
							$queryvista =  mysql_query($sqlv,$conn);*/
							
						}
					
					
					while($campodoc = mysql_fetch_array($queryids))
					{
							
						$idsindices = '';
						
						$vadindices = '';
						
						$iddoc = $campodoc['id_documento'];
						
						//se actualiza el id del usuario para cada documento en la vista

						$ctldioc = $iddoc;

						//se buscan los indices del documento

						$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
						$queryindic =  mysql_query($sql,$conn);
						$cuantosind = @mysql_num_rows($queryindic);

						$scriptdoc = '';
							
						$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';

						if ($cuantosind > 0)
							{
								while($campoind = mysql_fetch_array($queryindic))
									{
										$idsindices .= $campoind['id_indice'].',';
										
										$vadindices .= $campoind['valor'].',';
										
										$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';
											
										$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
									}
								
								$idsindices = trim($idsindices,',');
								
								$vadindices= trim($vadindices,',');
									
							}
						else
							{
	
							}
							
						$scriptdoc = trim($scriptdoc,',');

						//numero de imagenes
						$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];
							
						$queryimgdoc =  mysql_query($sql,$conn);
							
						$daimgdoc = mysql_fetch_assoc($queryimgdoc);
							
						$numimg = $daimgdoc['numimg'];
							
						//el nombre de la carpeta
							
						if ($campo2['id_folder'] > 0)
						{
							$sql = "select nombre from sgd_folders where id = ".$campo2['id_folder'];
								
							$querynfolder =  mysql_query($sql,$conn);

							$danfolder = mysql_fetch_assoc($querynfolder);
								
						}
						else
						{
							$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$campo2['parent_id']." and id_usuario = ".$_SESSION['idusuario'];
								
							$querynfolder =  mysql_query($sql,$conn);
								
							$danfolder = mysql_fetch_assoc($querynfolder);
								
							$sql = "select nombre from sgd_folders where id = ".$danfolder['id_folder'];

							$querynfolder =  mysql_query($sql,$conn);
								
							$danfolder = mysql_fetch_assoc($querynfolder);
								
						}
						$nfolder = $danfolder['nombre'];
							
						//se busca el nombre el tipo docmumental.
							
						$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];
							
						$querytpdoc =  mysql_query($sql,$conn);

						$dantpdoc = mysql_fetch_assoc($querytpdoc);
							
						$ntpdoc = $dantpdoc['nombre'];
							
							

						$script .= '<tr id="document_'.$campodoc['id_documento'].'" data-vindices="'.$idsindices.'" data-valordeindices="'.$vadindices.'" class="lineadocumental">';   
						$script .= '<td class="centrartexto">';
						$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
						$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
						$script .= ' </a>';
						$script .= '</td> ';
						$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
						$script .= '<!-- LOS INDICES Y SUS VALORES-->';
						$script .= '<span>'. $scriptdoc.'</span><br>';
						$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
						$script .= '</td>';
						$script .= '</tr>';

					}  //'.$scriptventana.'

				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{
							
						$queryids = pg_query($conn,$sql);

						$campo2 = pg_fetch_assoc($queryids);

						//se hace la busqueda de documentos y expedientes

						//se verifica si es una madre
						if ($campo2['id_folder'] > 0)
						{
							//se verifica si tiene hijas
							$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];

							$queryids =  pg_query($conn,$sql);

							$cuantahija = @pg_num_rows($queryids);

							if ($cuantahija > 0)

							{
								//se arman los id de los folders donde se buscara
								$secuencia = '';

								$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];

								$queryids =  pg_query($conn,$sql);

								while($campohja = pg_fetch_array($queryids))
								{
									if ($campohja['id_folder'] > 0)
									{
										$secuencia .= $campohja['id_folder'].',';
									}
									else
									{
										$secuencia .= $campohja['id_folder_tpdoc'].',';
									}

									//buscamos los nietos
									//se verifica si tiene hijas
									$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];

									$querynietas =  pg_query($conn,$sql);

									$cuantanieta = @pg_num_rows($querynietas);

									if ($cuantanieta > 0)

									{
										$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];

										$querynietas1 =  pg_query($conn,$sql);

										while($camponta = pg_fetch_array($querynietas1))
										{
											if ($camponta['id_folder'] > 0)
											{
												$secuencia .= $camponta['id_folder'].',';
											}
											else
											{
												$secuencia .= $camponta['id_folder_tpdoc'].',';
											}
											//buscamos los bisnietos
											//se verifica si tiene hijas
											$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];

											$querybisnietas =  pg_query($conn,$sql);

											$cuantabisnieta = @pg_num_rows($querybisnietas);

											if ($cuantabisnieta > 0)

											{
												$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];

												$querybisnieta1 =  pg_query($conn,$sql);

												while($campobnta = pg_fetch_array($querybisnieta1))
												{
													if ($campobnta['id_folder'] > 0)
													{
														$secuencia .= $campobnta['id_folder'].',';
													}
													else
													{
														$secuencia .= $campobnta['id_folder_tpdoc'].',';
													}

													//buscamos los tataranietos
													//se verifica si tiene hijas
													$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];

													$querytataranietas =  pg_query($conn,$sql);

													$cuantatataranieta = @pg_num_rows($querytataranietas);

													if ($cuantatataranieta > 0)

													{

														$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];

														$querytataranietas1 =  pg_query($conn,$sql);

														while($campotnta = pg_fetch_array($querytataranietas1))
														{
															if ($campotnta['id_folder'] > 0)
															{
																$secuencia .= $campotnta['id_folder'].',';
															}
															else
															{
																$secuencia .= $campotnta['id_folder_tpdoc'].',';
															}
															//buscamos los trastataranietos
															//se verifica si tiene hijas
															$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];

															$querytrastataranietas =  pg_query($conn,$sql);

															$cuantatrastataranieta = @pg_num_rows($querytrastataranietas);

															if ($cuantatrastataranieta > 0)

															{
																$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];

																$querytataranietas1 =  pg_query($conn,$sql);

																while($campotrasnta = pg_fetch_array($querytataranietas1))
																{
																	if ($campotrasnta['id_folder'] > 0)
																	{
																		$secuencia .= $campotrasnta['id_folder'].',';
																	}
																	else
																	{
																		$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																	}

																	//buscamos los pentanietos
																	//se verifica si tiene hijas
																	$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];

																	$querypentanietas =  pg_query($conn,$sql);

																	$cuantapentanieta = @pg_num_rows($querypentanietas);

																	if ($cuantapentanieta > 0)

																	{
																		$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];

																		$querypentanietas1 =  pg_query($conn,$sql);

																		while($campopenta = pg_fetch_array($querypentanietas1))
																		{
																			if ($campopenta['id_folder'] > 0)
																			{
																				$secuencia .= $campopenta['id_folder'].',';
																			}
																			else
																			{
																				$secuencia .= $campopenta['id_folder_tpdoc'].',';
																			}

																			//buscamos los hexanieto
																			//se verifica si tiene hijas
																			$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];

																			$queryhexanietas =  pg_query($conn,$sql);

																			$cuantahexanietas = @pg_num_rows($queryhexanietas);

																			if ($cuantahexanietas > 0)

																			{
																				$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];

																				$queryhexanietas1 =  pg_query($conn,$sql);

																				while($campohexanietas = pg_fetch_array($queryhexanietas1))
																				{
																					if ($campohexanietas['id_folder'] > 0)
																					{
																						$secuencia .= $campohexanietas['id_folder'].',';
																					}
																					else
																					{
																						$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																					}
																				}
																					
																			}
																		}
																	}
																}

															}

														}
													}

												}

											}

										}

									}

								}

								$secuencia = trim($secuencia,",");

								$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
								$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
								$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
								$sql .= " and d.id_folder in (".$secuencia.")";
								if ($campo2['id_tpdoc'] > 0)
								{
									$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
								}

							}
							else
							{

								$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
								$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
								$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
								$sql .= " and d.id_folder = ".$campo2['id_folder'];
								if ($campo2['id_tpdoc'] > 0)
								{
									$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
								}
							}
						}
						else
						{

							$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
							$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
							$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
							$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
							if ($campo2['id_tpdoc'] > 0)
							{
								$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
							}
						}
						$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	;

						$queryids =  pg_query($conn,$sql);
						
						$cuantosreg = @pg_num_rows($queryids);

						while($campodoc = pg_fetch_array($queryids))
						{

							$iddoc = $campodoc['id_documento'];

							$ctldioc = $iddoc;

							//se buscan los indices del documento

							$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
							$queryindic =  pg_query($conn,$sql);
							$cuantosind = @pg_num_rows($queryindic);

							$scriptdoc = '';

							$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';

							if ($cuantosind > 0)
							{
								while($campoind = pg_fetch_array($queryindic))
								{
									$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';

									$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
								}
							}
							else
							{

							}

							$scriptdoc = trim($scriptdoc,',');

							//numero de imagenes
							$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];

							$queryimgdoc = pg_query($conn,$sql);

							$daimgdoc = pg_fetch_assoc($queryimgdoc);

							$numimg = $daimgdoc['numimg'];

							//el nombre de la carpeta

							if ($campo2['id_folder'] > 0)
							{
								$sql = "select nombre from sgd_folders where id = ".$campo2['id_folder'];
									
								$querynfolder =  pg_query($conn,$sql);

								$danfolder = pg_fetch_assoc($querynfolder);
									
							}
							else
							{
								$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$campo2['parent_id']." and id_usuario = ".$_SESSION['idusuario'];
									
								$querynfolder =  pg_query($conn,$sql);
									
								$danfolder = pg_fetch_assoc($querynfolder);
									
								$sql = "select nombre from sgd_folders where id = ".$danfolder['id_folder'];

								$querynfolder =  pg_query($conn,$sql);
									
								$danfolder = pg_fetch_assoc($querynfolder);
									
							}
							$nfolder = $danfolder['nombre'];

							//se busca el nombre el tipo docmumental.

							$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];

							$querytpdoc =  pg_query($conn,$sql);

							$dantpdoc = pg_fetch_assoc($querytpdoc);

							$ntpdoc = $dantpdoc['nombre'];




							$script .= '<td class="centrartexto">';
							$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
							$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
							$script .= ' </a>';
							$script .= '</td> ';
							$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
							$script .= '<!-- LOS INDICES Y SUS VALORES-->';
							$script .= '<span>'. $scriptdoc.'</span><br>';
							$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
							$script .= '</td>';
							$script .= '</tr>';

						}  //'.$scriptventana.'
					}
				else
					{
						
						if (trim($configdb[0]) == 'sqlsrv')
							{
								$queryids = sqlsrv_query($conn,$sql);
								
								while( $row = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
									{
										$idparent =  $row['id'];
										$folderid =  $row['id_folder'];
										$tabladid = $row['id_tabla'];  
										$doctp = $row['id_tpdoc']; 
										$doctpfolderid = $row['id_folder_tpdoc'];  
										$idparent = $row['parent_id'];  
										
									}
								
								
								//se hace la busqueda de documentos y expedientes
								
								//se verifica si es una madre
								if ($folderid > 0)
								{
									//se verifica si tiene hijas
									$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$idparent."' and id_usuario = ".$_SESSION['idusuario'];
								
									$queryids =  sqlsrv_query($conn,$sqlp);
									
									$queryidshija = sqlsrv_query($conn, $sqlp);
									
									$cuantahija = 0;
									
									while( $row = sqlsrv_fetch_array( $queryidshija, SQLSRV_FETCH_ASSOC ))
										{
											$cuantahija = $cuantahija + 1;
										}
																
									if ($cuantahija > 0)
								
									{
										//se arman los id de los folders donde se buscara
										$secuencia = '';
								
										$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$idparent."' and id_usuario = ".$_SESSION['idusuario'];
								
										$queryids =  sqlsrv_query($conn,$sqlp);
								
										while( $campohja = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC )) 
										{
											if ($campohja['id_folder'] > 0)
											{
												$secuencia .= $campohja['id_folder'].',';
											}
											else
											{
												$secuencia .= $campohja['id_folder_tpdoc'].',';
											}
								
											//buscamos los nietos
											//se verifica si tiene hijas
											$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
											$querynietas =  sqlsrv_query($conn,$sqlp);
											
											$queryidsnietas = sqlsrv_query($conn, $sqlp);
												
											$cuantanieta = 0;
												
											while( $row = sqlsrv_fetch_array( $queryidsnietas, SQLSRV_FETCH_ASSOC ))
												{
													$cuantanieta = $cuantanieta + 1;
												}
																
											if ($cuantanieta > 0)
								
											{
												$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
												$querynietas1 =  sqlsrv_query($conn,$sqlp);
								
												while( $camponta = sqlsrv_fetch_array( $querynietas1, SQLSRV_FETCH_ASSOC )) 
												{
													if ($camponta['id_folder'] > 0)
													{
														$secuencia .= $camponta['id_folder'].',';
													}
													else
													{
														$secuencia .= $camponta['id_folder_tpdoc'].',';
													}
													//buscamos los bisnietos
													//se verifica si tiene hijas
													$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
													$querybisnietas =  sqlsrv_query($conn,$sqlp);
													
													$queryidsbisnieta = sqlsrv_query($conn, $sqlp);
													
													$cuantabisnieta = 0;
													
													while( $row = sqlsrv_fetch_array( $queryidsbisnieta, SQLSRV_FETCH_ASSOC ))
														{
															$cuantabisnieta = $cuantabisnieta + 1;
														}
																
													if ($cuantabisnieta > 0)
								
													{
														$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
														$querybisnieta1 =  sqlsrv_query($conn,$sqlp);
								
														while( $campobnta = sqlsrv_fetch_array( $querybisnieta1, SQLSRV_FETCH_ASSOC )) 
														{
															if ($campobnta['id_folder'] > 0)
															{
																$secuencia .= $campobnta['id_folder'].',';
															}
															else
															{
																$secuencia .= $campobnta['id_folder_tpdoc'].',';
															}
								
															//buscamos los tataranietos
															//se verifica si tiene hijas
															$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
															$querytataranietas =  sqlsrv_query($conn,$sqlp);
															
															$queryidsataranieta = sqlsrv_query($conn, $sqlp);
															
															$cuantatataranieta = 0;
																
															while( $row = sqlsrv_fetch_array( $queryidsataranieta, SQLSRV_FETCH_ASSOC ))
																{
																	$cuantatataranieta = $cuantatataranieta + 1;
																}
								
															if ($cuantatataranieta > 0)
								
															{
								
																$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																$querytataranietas1 =  sqlsrv_query($conn,$sql);
																							
																while( $campotnta = sqlsrv_fetch_array( $querytataranietas1, SQLSRV_FETCH_ASSOC ))
																{
																	if ($campotnta['id_folder'] > 0)
																	{
																		$secuencia .= $campotnta['id_folder'].',';
																	}
																	else
																	{
																		$secuencia .= $campotnta['id_folder_tpdoc'].',';
																	}
																	//buscamos los trastataranietos
																	//se verifica si tiene hijas
																	$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																	$querytrastataranietas =  sqlsrv_query($conn,$sql);
																	
																	$queryidstrastataranieta = sqlsrv_query($conn, $sqlp);
																		
																	$cuantatrastataranieta = 0;
																	
																	while( $row = sqlsrv_fetch_array( $queryidstrastataranieta, SQLSRV_FETCH_ASSOC ))
																		{
																			$cuantatrastataranieta = $cuantatrastataranieta + 1;
																		}
								
																	if ($cuantatrastataranieta > 0)
								
																	{
																		$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																		$querytrastataranietas1 =  sqlsrv_query($conn,$sql);
								
																		while( $campotrasnta = sqlsrv_fetch_array( $querytrastataranietas1, SQLSRV_FETCH_ASSOC )) 
																		{
																			if ($campotrasnta['id_folder'] > 0)
																			{
																				$secuencia .= $campotrasnta['id_folder'].',';
																			}
																			else
																			{
																				$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																			}
								
																			//buscamos los pentanietos
																			//se verifica si tiene hijas
																			$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																			$querypentanietas =  sqlsrv_query($conn,$sql);
								
																			$queryidspentanieta = sqlsrv_query($conn, $sqlp);
																			
																			$cuantapentanieta = 0;
																				
																			while( $row = sqlsrv_fetch_array( $queryidspentanieta, SQLSRV_FETCH_ASSOC ))
																				{
																					$cuantapentanieta = $cuantapentanieta + 1;
																				}
								
																			if ($cuantapentanieta > 0)
								
																			{
																				$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																				$querypentanietas1 =  sqlsrv_query($conn,$sql);
								
																				while( $campopenta = sqlsrv_fetch_array( $querypentanietas1, SQLSRV_FETCH_ASSOC ))
																				{
																					if ($campopenta['id_folder'] > 0)
																					{
																						$secuencia .= $campopenta['id_folder'].',';
																					}
																					else
																					{
																						$secuencia .= $campopenta['id_folder_tpdoc'].',';
																					}
								
																					//buscamos los hexanieto
																					//se verifica si tiene hijas
																					$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																					$queryhexanietas =  sqlsrv_query($conn,$sql);
																					
																					$queryidshexanietas = sqlsrv_query($conn, $sqlp);
																						
																					$cuantahexanietas = 0;
																					
																					while( $row = sqlsrv_fetch_array( $queryidshexanietas, SQLSRV_FETCH_ASSOC ))
																						{
																							$cuantahexanietas = $cuantahexanietas + 1;
																						}
								
								
																					if ($cuantahexanietas > 0)
								
																					{
																						$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
																						$queryhexanietas1 =  sqlsrv_query($conn,$sql);
								
																						while( $campohexanietas = sqlsrv_fetch_array( $queryhexanietas1, SQLSRV_FETCH_ASSOC )) 
																						{
																							if ($campohexanietas['id_folder'] > 0)
																							{
																								$secuencia .= $campohexanietas['id_folder'].',';
																							}
																							else
																							{
																								$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																							}
																						}
																							
																					}
																				}
																			}
																		}
								
																	}
								
																}
															}
								
														}
								
													}
								
												}
								
											}
								
										}
								
										$secuencia = trim($secuencia,",");
								
										$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
										$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
										$sql .= " and e.id_tabla = ".$tabladid; 
										$sql .= " and d.id_folder in (".$secuencia.")";
										if ($doctp  > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$doctp;
										}
								
									}
									else
									{
								
										$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
										$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
										$sql .= " and e.id_tabla = ".$tabladid;
										$sql .= " and d.id_folder = ".$folderid;
										if ($doctp > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$doctp;
										}
									}
								}
								else
								{
								
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$tabladid;
									$sql .= " and d.id_folder = ".$doctpfolderid;
									if ($doctp > 0)
									{
										$sql .= " and d.id_tipodocumental = ".$doctp;
									}
								}
								$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	;// echo $sql;
								
								$queryids =  sqlsrv_query($conn,$sql);
								
								$queryidsreg = sqlsrv_query($conn, $sql);
								
								$cuantosreg = 0;
									
								while( $row = sqlsrv_fetch_array( $queryidsreg, SQLSRV_FETCH_ASSOC ))
									{
										$cuantosreg = $cuantosreg + 1;
									}
																
							while( $campodoc = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC )) 
								{
								
									$iddoc = $campodoc['id_documento'];
								
									$ctldioc = $iddoc;
								
									//se buscan los indices del documento
								
									$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
									
									$queryindic =  sqlsrv_query($conn,$sql);
									
									$queryidsind = sqlsrv_query($conn, $sql);
									
									$cuantosind = 0;
										
									while( $row = sqlsrv_fetch_array( $queryidsind, SQLSRV_FETCH_ASSOC ))
										{
											$cuantosind = $cuantosind + 1;
										}
																	
									$scriptdoc = '';
								
									$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
								
									if ($cuantosind > 0)
										{
											while( $campoind = sqlsrv_fetch_array( $queryindic, SQLSRV_FETCH_ASSOC ))
												{
													$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';
										
													$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
												}
										}
									else
										{
									
										}
									
									$scriptdoc = trim($scriptdoc,',');
								
									//numero de imagenes
									$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];
								
									$queryimgdoc = sqlsrv_query($conn,$sql);
								
									while( $row = sqlsrv_fetch_array( $queryimgdoc, SQLSRV_FETCH_ASSOC ))
										{
											$numimg = $row['numimg'];
										}
								
									//el nombre de la carpeta
								
									if ($folderid > 0)
										{
											$sql = "select nombre from sgd_folders where id = ".$folderid;
												
											$querynfolder =  sqlsrv_query($conn,$sql);
											
											while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
												{
													$danfolder = $row['nombre'];
												}
																					
										}
									else
										{
											$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$idparent." and id_usuario = ".$_SESSION['idusuario'];
												
											$querynfolder =  sqlsrv_query($conn,$sql);
											
											while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
												{
													$danfolder = $row['id_folder'];
												}
												
												
											$sql = "select nombre from sgd_folders where id = ".$danfolder;
									
											$querynfolder =  sqlsrv_query($conn,$sql);
											
											while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
												{
													$danfolder = $row['nombre'];
												}
																								
										}
									$nfolder = $danfolder;
								
									//se busca el nombre el tipo docmumental.
								
									$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];
								
									$querytpdoc =  sqlsrv_query($conn,$sql);
									
									while( $row = sqlsrv_fetch_array( $querytpdoc, SQLSRV_FETCH_ASSOC ))
										{
											$dantpdoc = $row['nombre'];
										}
								
								
									$ntpdoc = $dantpdoc;
								
									$script .= '<td class="centrartexto">';
									$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
									$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
									$script .= ' </a>';
									$script .= '</td> ';
									$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
									$script .= '<!-- LOS INDICES Y SUS VALORES-->';
									$script .= '<span>'. $scriptdoc.'</span><br>';
									$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
									$script .= '</td>';
									$script .= '</tr>';
								
								}  //'.$scriptventana.'
							}
					}

				}
				
				if ($cuantosreg == 0)
					{
						$script = '';
					}
			echo $script;
			break;
				
			case 'dameidicesbuscarxind':
				$script = '';
				
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
				
				$vindicesid = isset($_GET['vindicesid']) && $_GET['vindicesid'] !== '' ? $_GET['vindicesid'] : '';
				
				$vindicesvalor = isset($_GET['vindicesvalor']) && $_GET['vindicesvalor'] !== '' ? $_GET['vindicesvalor'] : '';
				
				$vindicesid = explode(',',$vindicesid); 
				
				$vindicesvalor= explode(',',$vindicesvalor);
				
							
				//buscamos los documentos que existen bajo esa premisa de usuario, carpeta y
				
				
				$sql = "select * from sgd_busqueda_avanzada where id = ".$node." and id_usuario = ".$_SESSION['idusuario'];
				
				$script .= '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-expediente">';
				$script .= '<thead>';
				$script .= '<tr>';
				$script .= '<th width="5%" >&nbsp;</th>';
				$script .= '<th class="centrartexto">&nbsp;</th>';
				$script .= '</tr>';
				$script .= '</thead>';
				$script .= '<tbody>';
				
				
				if ($configdb[0] == 'mysql')
				{
					$queryids =  mysql_query($sql,$conn);
					
					$campo2 = mysql_fetch_assoc($queryids);
					
					//se hace la busqueda de documentos y expedientes
					
					//se verifica si es una madre
					if ($campo2['id_folder'] > 0)
					{
						//se verifica si tiene hijas
						$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];
						
						$queryids =  mysql_query($sqlp,$conn);
						
						$cuantahija = @mysql_num_rows($queryids);
						
						if ($cuantahija > 0)
						
						{
							//se arman los id de los folders donde se buscara
							$secuencia = '';
							
							$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];
							
							$queryids =  mysql_query($sqlp,$conn);
							
							while($campohja = mysql_fetch_array($queryids))
							{
								if ($campohja['id_folder'] > 0)
								{
									$secuencia .= $campohja['id_folder'].',';
								}
								else
								{
									$secuencia .= $campohja['id_folder_tpdoc'].',';
								}
								
								//buscamos los nietos
								//se verifica si tiene hijas
								$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
								$querynietas =  mysql_query($sqlp,$conn);
								
								$cuantanieta = @mysql_num_rows($querynietas);
								
								if ($cuantanieta > 0)
								
								{
									$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
									
									$querynietas1 =  mysql_query($sqlp,$conn);
									
									while($camponta = mysql_fetch_array($querynietas1))
									{
										if ($camponta['id_folder'] > 0)
										{
											$secuencia .= $camponta['id_folder'].',';
										}
										else
										{
											$secuencia .= $camponta['id_folder_tpdoc'].',';
										}
										//buscamos los bisnietos
										//se verifica si tiene hijas
										$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
										
										$querybisnietas =  mysql_query($sqlp,$conn);
										
										$cuantabisnieta = @mysql_num_rows($querybisnietas);
										
										if ($cuantabisnieta > 0)
										
										{
											$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
											
											$querybisnieta1 =  mysql_query($sqlp,$conn);
											
											while($campobnta = mysql_fetch_array($querybisnieta1))
											{
												if ($campobnta['id_folder'] > 0)
												{
													$secuencia .= $campobnta['id_folder'].',';
												}
												else
												{
													$secuencia .= $campobnta['id_folder_tpdoc'].',';
												}
												
												//buscamos los tataranietos
												//se verifica si tiene hijas
												$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
												
												$querytataranietas =  mysql_query($sqlp,$conn);
												
												$cuantatataranieta = @mysql_num_rows($querytataranietas);
												
												if ($cuantatataranieta > 0)
												
												{
													
													$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
													
													$querytataranietas1 =  mysql_query($sqlp,$conn);
													
													while($campotnta = mysql_fetch_array($querytataranietas1))
													{
														if ($campotnta['id_folder'] > 0)
														{
															$secuencia .= $campotnta['id_folder'].',';
														}
														else
														{
															$secuencia .= $campotnta['id_folder_tpdoc'].',';
														}
														//buscamos los trastataranietos
														//se verifica si tiene hijas
														$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
														
														$querytrastataranietas =  mysql_query($sqlp,$conn);
														
														$cuantatrastataranieta = @mysql_num_rows($querytrastataranietas);
														
														if ($cuantatrastataranieta > 0)
														
														{
															$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
															
															$querytataranietas1 =  mysql_query($sqlp,$conn);
															
															while($campotrasnta = mysql_fetch_array($querytataranietas1))
															{
																if ($campotrasnta['id_folder'] > 0)
																{
																	$secuencia .= $campotrasnta['id_folder'].',';
																}
																else
																{
																	$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																}
																
																//buscamos los pentanietos
																//se verifica si tiene hijas
																$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																
																$querypentanietas =  mysql_query($sqlp,$conn);
																
																$cuantapentanieta = @mysql_num_rows($querypentanietas);
																
																if ($cuantapentanieta > 0)
																
																{
																	$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																	
																	$querypentanietas1 =  mysql_query($sqlp,$conn);
																	
																	while($campopenta = mysql_fetch_array($querypentanietas1))
																	{
																		if ($campopenta['id_folder'] > 0)
																		{
																			$secuencia .= $campopenta['id_folder'].',';
																		}
																		else
																		{
																			$secuencia .= $campopenta['id_folder_tpdoc'].',';
																		}
																		
																		//buscamos los hexanieto
																		//se verifica si tiene hijas
																		$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																		
																		$queryhexanietas =  mysql_query($sqlp,$conn);
																		
																		$cuantahexanietas = @mysql_num_rows($queryhexanietas);
																		
																		if ($cuantahexanietas > 0)
																		
																		{
																			$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																			
																			$queryhexanietas1 =  mysql_query($sqlp,$conn);
																			
																			while($campohexanietas = mysql_fetch_array($queryhexanietas1))
																			{
																				if ($campohexanietas['id_folder'] > 0)
																				{
																					$secuencia .= $campohexanietas['id_folder'].',';
																				}
																				else
																				{
																					$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																				}
																			}
																			
																		}
																	}
																}
															}
															
														}
														
													}
												}
												
											}
											
										}
										
									}
									
								}
								
							}
							
							$totalind = count($vindicesid);
							
							$totalind = $totalind - 1;
							
							$secuencia = trim($secuencia,",");
							
							$sql = "";
							
							
							//los indices
								
							$ctlin = 0;
								
							for ($i = 0; $i < $totalind; $i++) 
								{
									$ctlin = $ctlin + 1;
									
									$sql .= " SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental FROM sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
									$sql .= " WHERE vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder in (".$secuencia.")";
									if ($campo2['id_tpdoc'] > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
										}
									$sql .= " and ( ";		
									
									$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' and vi.id_indice = ".$vindicesid[$i];
									
									$sql .= " ) ";
									
									$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental "	; 
									
									if ($ctlin < $totalind)
										{
											$sql .= " UNION	";
										}
								}
							
							$sql = trim($sql,'UNION');
							
							
								
						}
						else
						{
							
							$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
							$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
							$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
							$sql .= " and d.id_folder = ".$campo2['id_folder'];
							if ($campo2['id_tpdoc'] > 0)
								{
									$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
								}
							//los indices
							$sql .= " and ( ";
							
							for ($i = 0; $i < $totalind; $i++) {
								$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
							}
							
							$sql = trim($sql,' or ');
							
							$sql .= " )";
						}
					}
					else
					{
						
						$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
						$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
						$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
						$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
						if ($campo2['id_tpdoc'] > 0)
							{
								$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
							}
						//los indices
						$sql .= " and ( ";
						
						for ($i = 0; $i < $totalind; $i++) {
							$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
						}
						
						$sql = trim($sql,' or ');
						
						$sql .= " )";
					}
					//$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	;  
					
					//echo $sql;
					
					@$queryids =  mysql_query($sql,$conn); 
					
					$cuantosreg = @mysql_num_rows($queryids);
					
					while($campodoc = mysql_fetch_array($queryids))
					{
						
						$iddoc = $campodoc['id_documento'];
						
						$ctldioc = $iddoc;
						
						//se buscan los indices del documento
						
						$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
						$queryindic =  mysql_query($sql,$conn);
						$cuantosind = @mysql_num_rows($queryindic);
						
						$scriptdoc = '';
						
						$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
						
						if ($cuantosind > 0)
						{
							while($campoind = mysql_fetch_array($queryindic))
							{
								$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';
								
								$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
							}
						}
						else
						{
							
						}
						
						$scriptdoc = trim($scriptdoc,',');
						
						//numero de imagenes
						$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];
						
						$queryimgdoc =  mysql_query($sql,$conn);
						
						$daimgdoc = mysql_fetch_assoc($queryimgdoc);
						
						$numimg = $daimgdoc['numimg'];
						
						//el nombre de la carpeta
						
						if ($campo2['id_folder'] > 0)
						{
							$sql = "select nombre from sgd_folders where id = ".$campo2['id_folder'];
							
							$querynfolder =  mysql_query($sql,$conn);
							
							$danfolder = mysql_fetch_assoc($querynfolder);
							
						}
						else
						{
							$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$campo2['parent_id']." and id_usuario = ".$_SESSION['idusuario'];
							
							$querynfolder =  mysql_query($sql,$conn);
							
							$danfolder = mysql_fetch_assoc($querynfolder);
							
							$sql = "select nombre from sgd_folders where id = ".$danfolder['id_folder'];
							
							$querynfolder =  mysql_query($sql,$conn);
							
							$danfolder = mysql_fetch_assoc($querynfolder);
							
						}
						$nfolder = $danfolder['nombre'];
						
						//se busca el nombre el tipo docmumental.
						
						$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];
						
						$querytpdoc =  mysql_query($sql,$conn);
						
						$dantpdoc = mysql_fetch_assoc($querytpdoc);
						
						$ntpdoc = $dantpdoc['nombre'];
						
						
						
						
						$script .= '<td class="centrartexto">';
						$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
						$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
						$script .= ' </a>';
						$script .= '</td> ';
						$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
						$script .= '<!-- LOS INDICES Y SUS VALORES-->';
						$script .= '<span>'. $scriptdoc.'</span><br>';
						$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
						$script .= '</td>';
						$script .= '</tr>';
						
					}  //'.$scriptventana.'
					
				}
				else
				{
					if ($configdb[0] == 'pgsql')
						{
							
							$queryids = pg_query($conn,$sql);
							
							$campo2 = pg_fetch_assoc($queryids);
							
							//se hace la busqueda de documentos y expedientes
							
							//se verifica si es una madre
							if ($campo2['id_folder'] > 0)
							{
								//se verifica si tiene hijas
								$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];
								
								$queryids =  pg_query($conn,$sql);
								
								$cuantahija = @pg_num_rows($queryids);
								
								if ($cuantahija > 0)
								
								{
									//se arman los id de los folders donde se buscara
									$secuencia = '';
									
									$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campo2['id']."' and id_usuario = ".$_SESSION['idusuario'];
									
									$queryids =  pg_query($conn,$sql);
									
									while($campohja = pg_fetch_array($queryids))
									{
										if ($campohja['id_folder'] > 0)
										{
											$secuencia .= $campohja['id_folder'].',';
										}
										else
										{
											$secuencia .= $campohja['id_folder_tpdoc'].',';
										}
										
										//buscamos los nietos
										//se verifica si tiene hijas
										$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
										
										$querynietas =  pg_query($conn,$sql);
										
										$cuantanieta = @pg_num_rows($querynietas);
										
										if ($cuantanieta > 0)
										
										{
											$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
											
											$querynietas1 =  pg_query($conn,$sql);
											
											while($camponta = pg_fetch_array($querynietas1))
											{
												if ($camponta['id_folder'] > 0)
												{
													$secuencia .= $camponta['id_folder'].',';
												}
												else
												{
													$secuencia .= $camponta['id_folder_tpdoc'].',';
												}
												//buscamos los bisnietos
												//se verifica si tiene hijas
												$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
												
												$querybisnietas =  pg_query($conn,$sql);
												
												$cuantabisnieta = @pg_num_rows($querybisnietas);
												
												if ($cuantabisnieta > 0)
												
												{
													$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
													
													$querybisnieta1 =  pg_query($conn,$sql);
													
													while($campobnta = pg_fetch_array($querybisnieta1))
													{
														if ($campobnta['id_folder'] > 0)
														{
															$secuencia .= $campobnta['id_folder'].',';
														}
														else
														{
															$secuencia .= $campobnta['id_folder_tpdoc'].',';
														}
														
														//buscamos los tataranietos
														//se verifica si tiene hijas
														$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
														
														$querytataranietas =  pg_query($conn,$sql);
														
														$cuantatataranieta = @pg_num_rows($querytataranietas);
														
														if ($cuantatataranieta > 0)
														
														{
															
															$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
															
															$querytataranietas1 =  pg_query($conn,$sql);
															
															while($campotnta = pg_fetch_array($querytataranietas1))
															{
																if ($campotnta['id_folder'] > 0)
																{
																	$secuencia .= $campotnta['id_folder'].',';
																}
																else
																{
																	$secuencia .= $campotnta['id_folder_tpdoc'].',';
																}
																//buscamos los trastataranietos
																//se verifica si tiene hijas
																$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																
																$querytrastataranietas =  pg_query($conn,$sql);
																
																$cuantatrastataranieta = @pg_num_rows($querytrastataranietas);
																
																if ($cuantatrastataranieta > 0)
																
																{
																	$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																	
																	$querytataranietas1 =  pg_query($conn,$sql);
																	
																	while($campotrasnta = pg_fetch_array($querytataranietas1))
																	{
																		if ($campotrasnta['id_folder'] > 0)
																		{
																			$secuencia .= $campotrasnta['id_folder'].',';
																		}
																		else
																		{
																			$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																		}
																		
																		//buscamos los pentanietos
																		//se verifica si tiene hijas
																		$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																		
																		$querypentanietas =  pg_query($conn,$sql);
																		
																		$cuantapentanieta = @pg_num_rows($querypentanietas);
																		
																		if ($cuantapentanieta > 0)
																		
																		{
																			$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																			
																			$querypentanietas1 =  pg_query($conn,$sql);
																			
																			while($campopenta = pg_fetch_array($querypentanietas1))
																			{
																				if ($campopenta['id_folder'] > 0)
																				{
																					$secuencia .= $campopenta['id_folder'].',';
																				}
																				else
																				{
																					$secuencia .= $campopenta['id_folder_tpdoc'].',';
																				}
																				
																				//buscamos los hexanieto
																				//se verifica si tiene hijas
																				$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																				
																				$queryhexanietas =  pg_query($conn,$sql);
																				
																				$cuantahexanietas = @pg_num_rows($queryhexanietas);
																				
																				if ($cuantahexanietas > 0)
																				
																				{
																					$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																					
																					$queryhexanietas1 =  pg_query($conn,$sql);
																					
																					while($campohexanietas = pg_fetch_array($queryhexanietas1))
																					{
																						if ($campohexanietas['id_folder'] > 0)
																						{
																							$secuencia .= $campohexanietas['id_folder'].',';
																						}
																						else
																						{
																							$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																						}
																					}
																					
																				}
																			}
																		}
																	}
																	
																}
																
															}
														}
														
													}
													
												}
												
											}
											
										}
										
									}
									
									$totalind = count($vindicesid);
									
									$totalind = $totalind - 1;
									
									$secuencia = trim($secuencia,",");
									
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder in (".$secuencia.")";
									if ($campo2['id_tpdoc'] > 0)
										{
											$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
										}
									//los indices
									$sql .= " and ( ";
									
									for ($i = 0; $i < $totalind; $i++) {
										$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
									}
									
									$sql = trim($sql,' or ');
									
									$sql .= " )";
									
								}
								else
								{
									
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder = ".$campo2['id_folder'];
									if ($campo2['id_tpdoc'] > 0)
									{
										$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
									}
									//los indices
									$sql .= " and ( ";
									
									for ($i = 0; $i < $totalind; $i++) {
										$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
									}
									
									$sql = trim($sql,' or ');
									
									$sql .= " )";
								}
							}
							else
							{
								
								$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
								$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
								$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
								$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
								if ($campo2['id_tpdoc'] > 0)
								{
									$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
								}
								//los indices
								$sql .= " and ( ";
								
								for ($i = 0; $i < $totalind; $i++) {
									$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
								}
								
								$sql = trim($sql,' or ');
								
								$sql .= " )";
							}
							$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	;  //echo $sql;
						
							$queryids =  pg_query($conn,$sql);
							
							$cuantosreg = @pg_num_rows($queryids);
							
							while($campodoc = pg_fetch_array($queryids))
								{
									
									$iddoc = $campodoc['id_documento'];
									
									$ctldioc = $iddoc;
									
									//se buscan los indices del documento
									
									$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
									$queryindic =  pg_query($conn,$sql);
									$cuantosind = @pg_num_rows($queryindic);
									
									$scriptdoc = '';
									
									$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
									
									if ($cuantosind > 0)
										{
											while($campoind = pg_fetch_array($queryindic))
												{
													$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';
													
													$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
												}
										}
									else
									{
										
									}
									
									$scriptdoc = trim($scriptdoc,',');
									
									//numero de imagenes
									$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];
									
									$queryimgdoc = pg_query($conn,$sql);
									
									$daimgdoc = pg_fetch_assoc($queryimgdoc);
									
									$numimg = $daimgdoc['numimg'];
									
									//el nombre de la carpeta
									
									if ($campo2['id_folder'] > 0)
									{
										$sql = "select nombre from sgd_folders where id = ".$campo2['id_folder'];
										
										$querynfolder =  pg_query($conn,$sql);
										
										$danfolder = pg_fetch_assoc($querynfolder);
										
									}
									else
									{
										$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$campo2['parent_id']." and id_usuario = ".$_SESSION['idusuario'];
										
										$querynfolder =  pg_query($conn,$sql);
										
										$danfolder = pg_fetch_assoc($querynfolder);
										
										$sql = "select nombre from sgd_folders where id = ".$danfolder['id_folder'];
										
										$querynfolder =  pg_query($conn,$sql);
										
										$danfolder = pg_fetch_assoc($querynfolder);
										
									}
									$nfolder = $danfolder['nombre'];
									
									//se busca el nombre el tipo docmumental.
									
									$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];
									
									$querytpdoc =  pg_query($conn,$sql);
									
									$dantpdoc = pg_fetch_assoc($querytpdoc);
									
									$ntpdoc = $dantpdoc['nombre'];
									
									
									
									
									$script .= '<td class="centrartexto">';
									$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
									$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
									$script .= ' </a>';
									$script .= '</td> ';
									$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
									$script .= '<!-- LOS INDICES Y SUS VALORES-->';
									$script .= '<span>'. $scriptdoc.'</span><br>';
									$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
									$script .= '</td>';
									$script .= '</tr>';
									
								}  //'.$scriptventana.'
						}
					else
					{
						
						if (trim($configdb[0]) == 'sqlsrv')
						{
							$queryids = sqlsrv_query($conn,$sql);
							
							while( $row = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
							{
								$idparent =  $row['id'];
								$folderid =  $row['id_folder'];
								$tabladid = $row['id_tabla'];
								$doctp = $row['id_tpdoc'];
								$doctpfolderid = $row['id_folder_tpdoc'];
								$idparent = $row['parent_id'];
								
							}
							
							
							//se hace la busqueda de documentos y expedientes
							
							//se verifica si es una madre
							if ($folderid > 0)
							{
								//se verifica si tiene hijas
								$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$idparent."' and id_usuario = ".$_SESSION['idusuario'];
								
								$queryids =  sqlsrv_query($conn,$sqlp);
								
								$queryidshija = sqlsrv_query($conn, $sqlp);
								
								$cuantahija = 0;
								
								while( $row = sqlsrv_fetch_array( $queryidshija, SQLSRV_FETCH_ASSOC ))
								{
									$cuantahija = $cuantahija + 1;
								}
								
								if ($cuantahija > 0)
								
								{
									//se arman los id de los folders donde se buscara
									$secuencia = '';
									
									$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$idparent."' and id_usuario = ".$_SESSION['idusuario'];
									
									$queryids =  sqlsrv_query($conn,$sqlp);
									
									while( $campohja = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
									{
										if ($campohja['id_folder'] > 0)
										{
											$secuencia .= $campohja['id_folder'].',';
										}
										else
										{
											$secuencia .= $campohja['id_folder_tpdoc'].',';
										}
										
										//buscamos los nietos
										//se verifica si tiene hijas
										$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
										
										$querynietas =  sqlsrv_query($conn,$sqlp);
										
										$queryidsnietas = sqlsrv_query($conn, $sqlp);
										
										$cuantanieta = 0;
										
										while( $row = sqlsrv_fetch_array( $queryidsnietas, SQLSRV_FETCH_ASSOC ))
										{
											$cuantanieta = $cuantanieta + 1;
										}
										
										if ($cuantanieta > 0)
										
										{
											$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campohja['id']."' and id_usuario = ".$_SESSION['idusuario'];
											
											$querynietas1 =  sqlsrv_query($conn,$sqlp);
											
											while( $camponta = sqlsrv_fetch_array( $querynietas1, SQLSRV_FETCH_ASSOC ))
											{
												if ($camponta['id_folder'] > 0)
												{
													$secuencia .= $camponta['id_folder'].',';
												}
												else
												{
													$secuencia .= $camponta['id_folder_tpdoc'].',';
												}
												//buscamos los bisnietos
												//se verifica si tiene hijas
												$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
												
												$querybisnietas =  sqlsrv_query($conn,$sqlp);
												
												$queryidsbisnieta = sqlsrv_query($conn, $sqlp);
												
												$cuantabisnieta = 0;
												
												while( $row = sqlsrv_fetch_array( $queryidsbisnieta, SQLSRV_FETCH_ASSOC ))
												{
													$cuantabisnieta = $cuantabisnieta + 1;
												}
												
												if ($cuantabisnieta > 0)
												
												{
													$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
													
													$querybisnieta1 =  sqlsrv_query($conn,$sqlp);
													
													while( $campobnta = sqlsrv_fetch_array( $querybisnieta1, SQLSRV_FETCH_ASSOC ))
													{
														if ($campobnta['id_folder'] > 0)
														{
															$secuencia .= $campobnta['id_folder'].',';
														}
														else
														{
															$secuencia .= $campobnta['id_folder_tpdoc'].',';
														}
														
														//buscamos los tataranietos
														//se verifica si tiene hijas
														$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
														
														$querytataranietas =  sqlsrv_query($conn,$sqlp);
														
														$queryidsataranieta = sqlsrv_query($conn, $sqlp);
														
														$cuantatataranieta = 0;
														
														while( $row = sqlsrv_fetch_array( $queryidsataranieta, SQLSRV_FETCH_ASSOC ))
														{
															$cuantatataranieta = $cuantatataranieta + 1;
														}
														
														if ($cuantatataranieta > 0)
														
														{
															
															$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
															
															$querytataranietas1 =  sqlsrv_query($conn,$sql);
															
															while( $campotnta = sqlsrv_fetch_array( $querytataranietas1, SQLSRV_FETCH_ASSOC ))
															{
																if ($campotnta['id_folder'] > 0)
																{
																	$secuencia .= $campotnta['id_folder'].',';
																}
																else
																{
																	$secuencia .= $campotnta['id_folder_tpdoc'].',';
																}
																//buscamos los trastataranietos
																//se verifica si tiene hijas
																$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campobnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																
																$querytrastataranietas =  sqlsrv_query($conn,$sql);
																
																$queryidstrastataranieta = sqlsrv_query($conn, $sqlp);
																
																$cuantatrastataranieta = 0;
																
																while( $row = sqlsrv_fetch_array( $queryidstrastataranieta, SQLSRV_FETCH_ASSOC ))
																{
																	$cuantatrastataranieta = $cuantatrastataranieta + 1;
																}
																
																if ($cuantatrastataranieta > 0)
																
																{
																	$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$camponta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																	
																	$querytrastataranietas1 =  sqlsrv_query($conn,$sql);
																	
																	while( $campotrasnta = sqlsrv_fetch_array( $querytrastataranietas1, SQLSRV_FETCH_ASSOC ))
																	{
																		if ($campotrasnta['id_folder'] > 0)
																		{
																			$secuencia .= $campotrasnta['id_folder'].',';
																		}
																		else
																		{
																			$secuencia .= $campotrasnta['id_folder_tpdoc'].',';
																		}
																		
																		//buscamos los pentanietos
																		//se verifica si tiene hijas
																		$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																		
																		$querypentanietas =  sqlsrv_query($conn,$sql);
																		
																		$queryidspentanieta = sqlsrv_query($conn, $sqlp);
																		
																		$cuantapentanieta = 0;
																		
																		while( $row = sqlsrv_fetch_array( $queryidspentanieta, SQLSRV_FETCH_ASSOC ))
																		{
																			$cuantapentanieta = $cuantapentanieta + 1;
																		}
																		
																		if ($cuantapentanieta > 0)
																		
																		{
																			$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campotrasnta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																			
																			$querypentanietas1 =  sqlsrv_query($conn,$sql);
																			
																			while( $campopenta = sqlsrv_fetch_array( $querypentanietas1, SQLSRV_FETCH_ASSOC ))
																			{
																				if ($campopenta['id_folder'] > 0)
																				{
																					$secuencia .= $campopenta['id_folder'].',';
																				}
																				else
																				{
																					$secuencia .= $campopenta['id_folder_tpdoc'].',';
																				}
																				
																				//buscamos los hexanieto
																				//se verifica si tiene hijas
																				$sqlp = "select id from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																				
																				$queryhexanietas =  sqlsrv_query($conn,$sql);
																				
																				$queryidshexanietas = sqlsrv_query($conn, $sqlp);
																				
																				$cuantahexanietas = 0;
																				
																				while( $row = sqlsrv_fetch_array( $queryidshexanietas, SQLSRV_FETCH_ASSOC ))
																				{
																					$cuantahexanietas = $cuantahexanietas + 1;
																				}
																				
																				
																				if ($cuantahexanietas > 0)
																				
																				{
																					$sqlp = "select id,id_folder,id_folder_tpdoc from sgd_busqueda_avanzada where parent_id = '".$campopenta['id']."' and id_usuario = ".$_SESSION['idusuario'];
																					
																					$queryhexanietas1 =  sqlsrv_query($conn,$sql);
																					
																					while( $campohexanietas = sqlsrv_fetch_array( $queryhexanietas1, SQLSRV_FETCH_ASSOC ))
																					{
																						if ($campohexanietas['id_folder'] > 0)
																						{
																							$secuencia .= $campohexanietas['id_folder'].',';
																						}
																						else
																						{
																							$secuencia .= $campohexanietas['id_folder_tpdoc'].',';
																						}
																					}
																					
																				}
																			}
																		}
																	}
																	
																}
																
															}
														}
														
													}
													
												}
												
											}
											
										}
										
									}
									
									$totalind = count($vindicesid);
									
									$totalind = $totalind - 1;
									
									$secuencia = trim($secuencia,",");
									
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_folders f,sgd_tipodocumentales tp ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder in (".$secuencia.")";
									if ($campo2['id_tpdoc'] > 0)
									{
										$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
									}
									//los indices
									$sql .= " and ( ";
									
									for ($i = 0; $i < $totalind; $i++) {
										$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
									}
									
									$sql = trim($sql,' or ');
									
									$sql .= " )";
									
								}
								else
								{
									
									$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
									$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
									$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
									$sql .= " and d.id_folder = ".$campo2['id_folder'];
									if ($campo2['id_tpdoc'] > 0)
									{
										$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
									}
									//los indices
									$sql .= " and ( ";
									
									for ($i = 0; $i < $totalind; $i++) {
										$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
									}
									
									$sql = trim($sql,' or ');
									
									$sql .= " )";
								}
							}
							else
							{
								
								$sql = "SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft ";
								$sql .= " where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental ";
								$sql .= " and e.id_tabla = ".$campo2['id_tabla'];
								$sql .= " and d.id_folder = ".$campo2['id_folder_tpdoc'];
								if ($campo2['id_tpdoc'] > 0)
								{
									$sql .= " and d.id_tipodocumental = ".$campo2['id_tpdoc'];
								}
								//los indices
								$sql .= " and ( ";
								
								for ($i = 0; $i < $totalind; $i++) {
									$sql .= " vi.valor like '%".$vindicesvalor[$i]."%' or ";
								}
								
								$sql = trim($sql,' or ');
								
								$sql .= " )";
							}
							$sql .= " group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc"	;  //echo $sql;
							
							$queryids =  sqlsrv_query($conn,$sql);
							
							$queryidsreg = sqlsrv_query($conn, $sql);
							
							$cuantosreg = 0;
							
							while( $row = sqlsrv_fetch_array( $queryidsreg, SQLSRV_FETCH_ASSOC ))
							{
								$cuantosreg = $cuantosreg + 1;
							}
							
							while( $campodoc = sqlsrv_fetch_array( $queryids, SQLSRV_FETCH_ASSOC ))
							{
								
								$iddoc = $campodoc['id_documento'];
								
								$ctldioc = $iddoc;
								
								//se buscan los indices del documento
								
								$sql = "select vi.id_indice,vi.valor,i.nombre from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$campodoc['id_documento'];
								
								$queryindic =  sqlsrv_query($conn,$sql);
								
								$queryidsind = sqlsrv_query($conn, $sql);
								
								$cuantosind = 0;
								
								while( $row = sqlsrv_fetch_array( $queryidsind, SQLSRV_FETCH_ASSOC ))
								{
									$cuantosind = $cuantosind + 1;
								}
								
								$scriptdoc = '';
								
								$scriptventana = '<span style="font-size:1em"><strong>Archivo de Gesti&oacute;n</strong></span><br>';
								
								if ($cuantosind > 0)
								{
									while( $campoind = sqlsrv_fetch_array( $queryindic, SQLSRV_FETCH_ASSOC ))
									{
										$scriptdoc .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.$campoind['valor'].', ';
										
										$scriptventana .= '<span class="indicesub"><strong>'.utf8_encode($campoind['nombre']).': </strong></span>'.utf8_encode($campoind['valor']).'<br>';
									}
								}
								else
								{
									
								}
								
								$scriptdoc = trim($scriptdoc,',');
								
								//numero de imagenes
								$sql = "select count(id_imagendocum) as numimg FROM sgd_imagen_documento WHERE id_documento = ".$campodoc['id_documento'];
								
								$queryimgdoc = sqlsrv_query($conn,$sql);
								
								while( $row = sqlsrv_fetch_array( $queryimgdoc, SQLSRV_FETCH_ASSOC ))
								{
									$numimg = $row['numimg'];
								}
								
								//el nombre de la carpeta
								
								if ($folderid > 0)
								{
									$sql = "select nombre from sgd_folders where id = ".$folderid;
									
									$querynfolder =  sqlsrv_query($conn,$sql);
									
									while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
									{
										$danfolder = $row['nombre'];
									}
									
								}
								else
								{
									$sql = "select id_folder from sgd_busqueda_avanzada where id = ".$idparent." and id_usuario = ".$_SESSION['idusuario'];
									
									$querynfolder =  sqlsrv_query($conn,$sql);
									
									while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
									{
										$danfolder = $row['id_folder'];
									}
									
									
									$sql = "select nombre from sgd_folders where id = ".$danfolder;
									
									$querynfolder =  sqlsrv_query($conn,$sql);
									
									while( $row = sqlsrv_fetch_array( $querynfolder, SQLSRV_FETCH_ASSOC ))
									{
										$danfolder = $row['nombre'];
									}
									
								}
								$nfolder = $danfolder;
								
								//se busca el nombre el tipo docmumental.
								
								$sql = "select nombre  from sgd_tipodocumentales  where id_tipodoc = ".$campodoc['id_tipodocumental'];
								
								$querytpdoc =  sqlsrv_query($conn,$sql);
								
								while( $row = sqlsrv_fetch_array( $querytpdoc, SQLSRV_FETCH_ASSOC ))
								{
									$dantpdoc = $row['nombre'];
								}
								
								
								$ntpdoc = $dantpdoc;
								
								$script .= '<td class="centrartexto">';
								$script .= '<a href="#" class="btn btn-default btn-md popover-button-default" data-content="amry" title="Datos de Gesti&oacute;n" data-trigger="hover" data-placement="right">';
								$script .= ' <span class="glyphicon glyphicon-info-sign sombraicono" style="color:#1600BF;font-size:2em;cursor:pointer"></span>';
								$script .= ' </a>';
								$script .= '</td> ';
								$script .= '<td class="izqtexto"><a href="javascript:;"  id="docexpediente_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$campodoc['nombre'].'&nbsp;-&nbsp;'.$nfolder.'&nbsp;-&nbsp;'.$ntpdoc.'&nbsp;&nbsp;('.$numimg.'&nbsp;&nbsp;'.$traduce->traduce('titimage').')</a><br>';
								$script .= '<!-- LOS INDICES Y SUS VALORES-->';
								$script .= '<span>'. $scriptdoc.'</span><br>';
								$script .= '<span><a href="javascript:;"  id="eldocumento_'.$campodoc['id_documento'].'" class="actible" onclick="visordocumentohijo(this.id)">'.$traduce->traduce('titirdoc').'</span>';
								$script .= '</td>';
								$script .= '</tr>';
								
							}  //'.$scriptventana.'
						}
					}
					
				}
				
				if ($cuantosreg == 0)
				{
					$script = '';
				}
				echo $script;
				
			break;	
			case 'armarlistado':
				$dabuscar = isset($_GET['dabuscar']) && $_GET['dabuscar'] !== '' ? $_GET['dabuscar'] : '';

				$dabuscar = explode("_;_",$dabuscar);

				/*

				*/

				echo $dabuscar;
				break;
			case 'dameindicestxt':
				$idstp = '';

				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;

				$idtpdoc = isset($_GET['idtpdoc']) && $_GET['idtpdoc'] !== '#' ? (int)$_GET['idtpdoc'] : 0;
					
				$sql =" select i.id_indice,i.nombre from sgd_tipodoc_indices tpi,sgd_indices i  where tpi.id_folder = ".$node." and tpi.id_tipodoc = ".$idtpdoc." and tpi.id_indice = i.id_indice"; //echo $sql;

				$script = '<ul>';

				if ($configdb[0] == 'mysql')
				{
					$queryids =  mysql_query($sql,$conn);

					while($campo2 = mysql_fetch_array($queryids))
					{

						$script .= '<li id="indice_'.$campo2['id_indice'].'" style="cursor:pointer" >'.utf8_encode($campo2['nombre']).'</li>';
					}

				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$resuquery = pg_query($conn,$sql);

						while($campo2 = pg_fetch_array($resuquery))
						{
							$script .= '<li id="indice_'.$campo2['id_indice'].'"  style="cursor:pointer" >'.utf8_encode($campo2['nombre']).'</li>';
						}

					}
				}
					
				$script .= '</ul>';

				echo $script;
				break;
			case 'dameindicesall':

				$script = '';

				$sql =" select id_indice,nombre from sgd_indices  where id_indice > 0 ";
					
				if ($configdb[0] == 'mysql')
				{
					$queryids =  mysql_query($sql,$conn);

					while($campo2 = mysql_fetch_array($queryids))
					{

						$script .= '<option id="indice_'.$campo2['id_indice'].'" value="'.$campo2['id_indice'].'">'.utf8_encode($campo2['nombre']).'</option>';

					}

				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{
							
						$resuquery = pg_query($conn,$sql);
							
						while($campo2 = pg_fetch_array($resuquery))
						{
							$script .= '<option id="indice_'.$campo2['id_indice'].'" value="'.$campo2['id_indice'].'">'.utf8_encode($campo2['nombre']).'</option>';
						}
							
					}
				}
					


				echo $script;

				break;
			case 'dameindices':

				$idsind = '';

				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
					
				$idtpdoc = isset($_GET['idtpdoc']) && $_GET['idtpdoc'] !== '#' ? (int)$_GET['idtpdoc'] : 0;

				$sql =" select id_indice from sgd_tipodoc_indices where id_folder = ".$node." and id_tipodoc = ".$idtpdoc;

				if ($configdb[0] == 'mysql')
				{

					$queryids =  mysql_query($sql,$conn);

					while($campo2 = mysql_fetch_array($queryids))
					{
						$idsind .= $campo2['id_indice'].'_;_';
					}

				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$resuquery = pg_query($conn,$sql);

						while($campo2 = pg_fetch_array($resuquery))
						{
							$idsind .= $campo2['id_indice'].'_;_';
						}

					}

				}


				echo  $idsind;

				break;
					
		}
	}
	catch (Exception $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
		header('Status:  500 Server Error');
		echo $e->getMessage();
	}
	die();
}
