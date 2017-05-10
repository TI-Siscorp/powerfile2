<?php
 
@session_start();
 
@$configdb = $_REQUEST['configdb'];

$espaciotrabajo = $_SESSION['espaciotrabajo'];
////////	

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
 
/////////////
	
	
if (!$conn)
	{
		print_r('no se conecta a la bd');
		exit;
	}
	
	
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
				$sql = "SELECT * FROM sgd_folders where id_tabla = ".$tablaid;
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
								$numreg = pg_numrows($res);
									
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

			case 'get_content':
				/*$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
				 $node = explode(':', $node);
				 if(count($node) > 1) {
				 $rslt = array('content' => 'Multiple selected');
				 }
				 else {
				 $temp = $fs->get_node((int)$node[0], array('with_path' => true));
				 $rslt = array('content' => 'Selected: /' . implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])). '/'.$temp['nm']);
				 }*/
				break;
			case 'create_node':

				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

				$nodeText = isset($_GET['text']) && $_GET['text'] !== '' ? $_GET['text'] : '';

				$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."')";

				if ($configdb[0] == 'mysql')
				{

					mysql_query($sql,$conn);

					$result = array('id' => mysql_insert_id($conn));
				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."') RETURNING id";
						//INSERT INTO persons (lastname,firstname) VALUES ('Smith', 'John')

						$resuquery = pg_query($conn,$sql);
							
						$resid = pg_fetch_array($resuquery);

						$result = array('id' => $resid[0]);
							
					}
				}


				break;
			case 'rename_node':
					
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

				$nodeText = isset($_GET['text']) && $_GET['text'] !== '' ? $_GET['text'] : '';

				$sql ="UPDATE sgd_folders SET nombre ='".$nodeText."',text = '".$nodeText."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";

				if ($configdb[0] == 'mysql')
				{

					mysql_query($sql,$conn);

				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$resuquery = pg_query($conn,$sql);

					}
				}
				break;

			case 'delete_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

				$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$node."'";

				if ($configdb[0] == 'mysql')
				{

					mysql_query($sql,$conn);
						
				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$resuquery = pg_query($conn,$sql);

					}
				}

				$sql ="DELETE FROM sgd_folders WHERE id = '".$node."'";

				if ($configdb[0] == 'mysql')
				{
						
					mysql_query($sql,$conn);
						
				}
				else
				{
					if ($configdb[0] == 'pgsql')
					{

						$resuquery = pg_query($conn,$sql);

					}
				}

			break;
			
			case 'guardadepenfolder':
					
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;

				$iddependencia = isset($_GET['iddependencia']) && $_GET['iddependencia'] !== '#' ? (int)$_GET['iddependencia'] : 0;
				
				$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0; 
				
				$idchildrenp = isset($_GET['idchildren']) && $_GET['idchildren'] !== '' ? $_GET['idchildren'] : '';  //se debe crear una variable para cada usuario
				
				$idparentsp = isset($_GET['idparents']) && $_GET['idparents'] !== '' ? $_GET['idparents'] : '';  //se debe crear una variable para cada usuario
				
				$usuarios_grupo = isset($_GET['usuarios_grupo']) && $_GET['usuarios_grupo'] !== '' ? $_GET['usuarios_grupo'] : '';
				
				//se crea el arreglo de id de usuarios
				
				$usuarios_grupo = explode("_;_",$usuarios_grupo);
				
				$totalu = count($usuarios_grupo);
				
				//$totalu = $totalu - 1;
				
				//se toma el dato del o de los usuarios que van a tener esa permisologia
				
				for ($jz = 0; $jz <= $totalu; $jz++) {
				
						//se registran el permiso dependencia x folder - primero el padre
		
						$sql ="INSERT INTO sgd_dependencias_folders (id_folder,id_dependencia,id_tabla,id_usuario,created_at) VALUES(".$node.", ".$iddependencia.", ".$tablaid.",".$usuarios_grupo[$jz].",'".date("Y-m-d H:i:s")."')";
						
						if ($configdb[0] == 'mysql')
							{
							
								mysql_query($sql,$conn);
							
							}
						else
							{
								if ($configdb[0] == 'pgsql')
									{
								
										$resuquery = pg_query($conn,$sql);
								
									}
								else 
									{
										if (trim($configdb[0]) == 'sqlsrv')
											{
												
												$resuquery = sqlsrv_query($conn,$sql);												
												
											}
									}
							}
				}			
				for ($jz = 0; $jz <= $totalu; $jz++) {
						// segundo los hijos si los tiene
						if ($idchildrenp != '')
							{
								$idchildren = explode(",",$idchildrenp);
								
								$tidchildren = count($idchildren);
								
								$tidchildren = $tidchildren - 1;
								
								for ($i = 0; $i < $tidchildren; $i++) {
									
									$sql ="INSERT INTO sgd_dependencias_folders (id_folder,id_dependencia,id_tabla,id_usuario,created_at) VALUES(".$idchildren[$i].", ".$iddependencia.", ".$tablaid.",".$usuarios_grupo[$jz].",'".date("Y-m-d H:i:s")."')";
									
									if ($configdb[0] == 'mysql')
										{
												
											mysql_query($sql,$conn);
												
										}
									else
										{
											if ($configdb[0] == 'pgsql')
												{
														
													$resuquery = pg_query($conn,$sql);
														
												}
											else
												{
													if (trim($configdb[0]) == 'sqlsrv')
														{
															$resuquery = sqlsrv_query($conn,$sql);
														}
												}
										}
									
								};
							}	
				}
				for ($jz = 0; $jz <= $totalu; $jz++) {
						//tercero los padres si los tiene
						if ($idparentsp != '')
							{
								$idparents = explode(",",$idparentsp);
								
								$tidparents = count($idparents);
								
								$tidparents = $tidparents - 1;
								
								for ($i = 0; $i < $tidparents; $i++) {
										
									$sql ="INSERT INTO sgd_dependencias_folders (id_folder,id_dependencia,id_tabla,id_usuario,created_at) VALUES(".$idparents[$i].", ".$iddependencia.", ".$tablaid.",".$usuarios_grupo[$jz].",'".date("Y-m-d H:i:s")."')";
										
									if ($configdb[0] == 'mysql')
										{
												
											mysql_query($sql,$conn);
												
										}
									else
										{
											if ($configdb[0] == 'pgsql')
												{
										
													$resuquery = pg_query($conn,$sql);
										
												}
											else
												{
													if (trim($configdb[0]) == 'sqlsrv')
														{
															
															$resuquery = sqlsrv_query($conn,$sql);
															
														}
												}
										}
										
								};
								
							}
				}					
			break;
			case 'borradepenfolder':
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
				
				$iddependencia = isset($_GET['iddependencia']) && $_GET['iddependencia'] !== '#' ? (int)$_GET['iddependencia'] : 0;
				
				$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0;
				
				$idchildrenp = isset($_GET['idchildren']) && $_GET['idchildren'] !== '' ? $_GET['idchildren'] : '';
				
				$idparentsp = isset($_GET['idparents']) && $_GET['idparents'] !== '' ? $_GET['idparents'] : '';		
				
				$usuarios_grupo = isset($_GET['usuarios_grupo']) && $_GET['usuarios_grupo'] !== '' ? $_GET['usuarios_grupo'] : '';
								
				//se crea el arreglo de id de usuarios
				
				$usuarios_grupo = explode("_;_",$usuarios_grupo);
				
				$totalu = count($usuarios_grupo);
				
				//$totalu = $totalu - 1;
				
				//se eliminan las relacion previas de esa carpeta
				for ($jz = 0; $jz < $totalu; $jz++) {
					//primero el padre
					$sql = "DELETE FROM sgd_dependencias_folders WHERE id_folder = ".$node." and id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid." and id_usuario = ".$usuarios_grupo[$jz];
					
					if ($configdb[0] == 'mysql')
						{
						
							mysql_query($sql,$conn);
						
						}
					else
						{
							if ($configdb[0] == 'pgsql')
								{
										
									$resuquery = pg_query($conn,$sql);
										
								}
							else
								{
									if (trim($configdb[0]) == 'sqlsrv')
										{
											
											$resuquery = sqlsrv_query($conn,$sql);
											
										}
								}
						}
				}
				for ($jz = 0; $jz <= $totalu; $jz++) {
					//segundo los hijos
					if ($idchildren != '')
						{
							$idchildren = explode(",",$idparentsp);
								
							$tidchildren = count($idchildren);
								
							$tidchildren = $tidchildren - 1;
								
							for ($i = 0; $i < $tidchildren; $i++) {
						
								$sql = "DELETE FROM sgd_dependencias_folders WHERE id_folder = ".$idchildren[$i]." and id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid." and id_usuario = ".$usuarios_grupo[$jz];
						
								if ($configdb[0] == 'mysql')
									{
											
										mysql_query($sql,$conn);
											
									}
								else
									{
										if ($configdb[0] == 'pgsql')
											{
													
												$resuquery = pg_query($conn,$sql);
													
											}
										else
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														
														$resuquery = sqlsrv_query($conn,$sql);
														
													}
											}
									}
						
							};
						}
				}		
					//tercero los padres
				for ($jz = 0; $jz <= $totalu; $jz++) {
					//tercero los padres si los tiene
					if ($idparents != '')
						{
							$idparents = explode(",",$idparents);
						
							$tidparents = count($idparents);
						
							$tidparents = $tidparents - 1;
						
							for ($i = 0; $i < $tidparents; $i++) {
						
								$sql = "DELETE FROM sgd_dependencias_folders WHERE id_folder = ".$idparents[$i]." and id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid." and id_usuario = ".$usuarios_grupo[$jz];
						
								if ($configdb[0] == 'mysql')
									{
							
										mysql_query($sql,$conn);
							
									}
								else
									{
										if ($configdb[0] == 'pgsql')
											{
													
												$resuquery = pg_query($conn,$sql);
													
											}
										else
											{
												
												if (trim($configdb[0]) == 'sqlsrv')
													{
														
														$resuquery = sqlsrv_query($conn,$sql);
														
													}
												
											}
									}
						
							};
								
						}
				}
				
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
			
			case 'damefolders':
				$iddependencia = isset($_GET['iddependencia']) && $_GET['iddependencia'] !== '#' ? (int)$_GET['iddependencia'] : 0;
			
				$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0;
			
				$sql = "select id_folder from sgd_dependencias_folders where id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid;
			
				$iddefolders = '';
				
				if ($configdb[0] == 'mysql')
					{
						$res = mysql_query($sql,$conn);
						$numreg = mysql_num_rows($res);
						//iterate on results row and create new index array of data
						while( $row = mysql_fetch_assoc($res) ) {
							$iddefolders .= $row['id_folder'].',';
						}
					}
				else
					{
						if ($configdb[0] == 'pgsql')
							{
								$res = pg_query($conn,$sql);
								$numreg = pg_numrows($res);
					
								//iterate on results row and create new index array of data
								while( $row = pg_fetch_assoc($res) ) {
									$iddefolders .= $row['id_folder'].',';
								}
							}
						else 
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										
										$res = sqlsrv_query($conn,$sql);
										
										$numreg = sqlsrv_query( $conn, "SELECT * FROM sgd_dependencias_folders", array(), array("Scrollable"=>"buffered"));
										
										//iterate on results row and create new index array of data
										while( $row = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC ))
											{
												$iddefolders .= $row['id_folder'].',';
											}
										
									}
							}
					}
				echo $iddefolders;
			break;	
			case 'damusuarios':
				
				$id_tabla = isset($_GET['id_tabla']) && $_GET['id_tabla'] !== '#' ? (int)$_GET['id_tabla'] : 0;
				
				//armamos el array de usuarios registrados para esa tabla en la tabla de permisos 
				
				$sql = "select distinct id_usuario from sgd_dependencias_folders where id_tabla = ".$id_tabla."  order by id_usuario asc";	  
				
				if ($configdb[0] == 'mysql')
					{
						$res = mysql_query($sql,$conn);
						
						$cuantosus = @mysql_num_rows($res);
						
						//se arman el array
						unset($vusuarios);
						
						if ($cuantosus > 0)
							{
								while( $row = mysql_fetch_assoc($res) ) {
									$vusuarios[] =  $row['id_usuario'];
								}
							}
						else 
							{
								$vusuarios[] = 0;
							}
						$sql = "select id,name,lastname from sgd_usuarios where id > 0 order by name asc";
						
						$script = '';
						
						$res = mysql_query($sql,$conn);
						$numreg = mysql_num_rows($res);
						//se arman los options del select de usuarios
						while( $row = mysql_fetch_assoc($res) ) {
							
							if (in_array($row['id'], $vusuarios) )
								{
									$script .= '<option value="'.$row['id'].'" selected="selected">'.utf8_decode($row['name']).' '.utf8_encode($row['lastname']).'</option>';
								}
							else
								{
									$script .= '<option value="'.$row['id'].'">'.utf8_decode($row['name']).' '.utf8_encode($row['lastname']).'</option>';
								}
						}
						
					}
				else
					{
						if ($configdb[0] == 'pgsql')
							{
								$res = pg_query($conn,$sql);
								
								$cuantosus = @pg_num_rows($res);
								
								//se arman el array
								unset($vusuarios);
								
								if ($cuantosus > 0)
									{
										while( $row = pg_fetch_assoc($res) ) {
											$vusuarios[] =  $row['id_usuario'];
										}
									}
								else
									{
										$vusuarios[] = 0;
									}
								$sql = "select id,name,lastname from sgd_usuarios where id > 0 order by name asc";
								
								$script = '';
								
								$res = pg_query($conn,$sql);
								$numreg = pg_num_rows($res);
								//se arman los options del select de usuarios
								while( $row = pg_fetch_assoc($res) ) {
										
									if (in_array($row['id'], $vusuarios) )
										{
											$script .= '<option value="'.$row['id'].'" selected="selected">'.$row['name'].' '.$row['lastname'].'</option>';
										}
									else
										{
											$script .= '<option value="'.$row['id'].'">'.$row['name'].' '.$row['lastname'].'</option>';
										}
								}
							}
						else
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										$res = sqlsrv_query($conn,$sql);
										//$cuantosus = sqlsrv_num_rows($res);  
										
										$cuantosus = sqlsrv_query( $conn, "SELECT * FROM sgd_dependencias_folders", array(), array("Scrollable"=>"buffered"));
										
										//se arman el array
										unset($vusuarios);
										if ($cuantosus > 0)
											{
												
												while( $row = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC ))
													{
														$vusuarios[] =  $row['id_usuario'];
													}
												
											}
										else
											{
												$vusuarios[] = 0;
											}
											
										//print_r($vusuarios);	
											
										$sql = "select id,name,lastname from sgd_usuarios where id > 0 order by name asc";
										
										$script = '';
										
										$res = sqlsrv_query($conn,$sql);
										
										$numreg = sqlsrv_query( $conn, "SELECT * FROM sgd_usuarios", array(), array("Scrollable"=>"buffered"));
										
										
										//se arman los options del select de usuarios
										while( $row = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC )){
											if (in_array($row['id'], $vusuarios) )
												{
													$script .= '<option value="'.$row['id'].'" selected="selected">'.$row['name'].' '.$row['lastname'].'</option>';
												}
											else
												{
													$script .= '<option value="'.$row['id'].'">'.$row['name'].' '.$row['lastname'].'</option>';
												}											
										}
									}
							}
						
					}	
				echo $script;
			break;	
			case 'guardadepenfolderlote':
							
				$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '' ? $_GET['id_carpeta'] : '';  
			
				$iddependencia = isset($_GET['iddependencia']) && $_GET['iddependencia'] !== '#' ? (int)$_GET['iddependencia'] : 0;
			
				$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0;
									
				$usuarios_grupo = isset($_GET['usuarios_grupo']) && $_GET['usuarios_grupo'] !== '' ? $_GET['usuarios_grupo'] : ''; 
				
				//se crea el arreglo de id de folder
					
				$node = explode("_;_",$node);
					
				$totalnode = count($node);
			
				//se crea el arreglo de id de usuarios
			
				$usuarios_grupo = explode("_;_",$usuarios_grupo);
			
				$totalu = count($usuarios_grupo);
			
				//se elimina pimero toda la data de esa dependencia
				
				$sql = "DELETE FROM sgd_dependencias_folders WHERE id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid;
				
				if ($configdb[0] == 'mysql')
					{
					
						mysql_query($sql,$conn);
					
					}
				else
					{
						if ($configdb[0] == 'pgsql')
							{
						
								$resuquery = pg_query($conn,$sql);
						
							}
						else
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										
										$resuquery = sqlsrv_query($conn,$sql);
										
									}
							}
					}
				
				
				//se toma el dato del o de los usuarios que van a tener esa permisologia
			
				for ($jz = 0; $jz < $totalu; $jz++) {
			
					//se registran el permiso dependencia x folder - por cada folder seleccionado
					
					for ($i = 0; $i < $totalnode; $i++) {
			
							$sql ="INSERT INTO sgd_dependencias_folders (id_folder,id_dependencia,id_tabla,id_usuario,created_at) VALUES(".$node[$i].", ".$iddependencia.", ".$tablaid.",".$usuarios_grupo[$jz].",'".date("Y-m-d H:i:s")."')";
					
							
							if ($configdb[0] == 'mysql')
								{
										
									mysql_query($sql,$conn);
										
								}
							else
								{
									if ($configdb[0] == 'pgsql')
										{
												
											$resuquery = pg_query($conn,$sql);
												
										}
									else 
										{
											if (trim($configdb[0]) == 'sqlsrv')
												{
													
													$resuquery = sqlsrv_query($conn,$sql);
													
												}
										}
								}
					}		
				}
				
			break;
			case 'borradepenfolderlote':
				
				$iddependencia = isset($_GET['iddependencia']) && $_GET['iddependencia'] !== '#' ? (int)$_GET['iddependencia'] : 0;
				
				$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0;
				
				$sql = "DELETE FROM sgd_dependencias_folders WHERE id_dependencia = ".$iddependencia." and id_tabla = ".$tablaid;
				
				if ($configdb[0] == 'mysql')
					{
							
						mysql_query($sql,$conn);
							
					}
				else
					{
						if ($configdb[0] == 'pgsql')
							{
						
								$resuquery = pg_query($conn,$sql);
						
							}
						else
							{
								if (trim($configdb[0]) == 'sqlsrv')
									{
										
										$resuquery = sqlsrv_query($conn,$sql);
								
									}	
							}
					}			
			
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
?>