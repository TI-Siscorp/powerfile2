<?php
   @session_start();
   
   @$configdb = $_REQUEST['configdb'];
   
   @$espaciotrabajo = $_SESSION['espaciotrabajo'];
   
   //////////////////////////  
   
   /////// 	
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
					
		function getLastId() {
			$result = sqlsrv_fetch_assoc(sqlsrv_query("select @@IDENTITY as id"));
			return $result['id'];
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
								
								if ($configdb[0] == 'mysql')
									{
								
										$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."')";
										
										mysql_query($sql,$conn);
										
										$result = array('id' => mysql_insert_id($conn));
									}
								else 
									{
										if ($configdb[0] == 'pgsql')
											{
												
												$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."') RETURNING id";
												
												$resuquery = pg_query($conn,$sql);     
												 
												$resid = pg_fetch_array($resuquery);
												
												$result = array('id' => $resid[0]);
												
											}	
										else 
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$nodeText."', '".$nodeText."', '".$node."',1,".$tablaid.",'".date("Y-m-d H:i:s")."')";
														
														$resource = sqlsrv_query($conn, $sql);		
														
														$sql ="SELECT top 1 id FROM  sgd_folders where id_tabla = ".$tablaid." ORDER BY id desc";
														
														$resource = sqlsrv_query($conn, $sql);
														
														while( $row = sqlsrv_fetch_array( $resource, SQLSRV_FETCH_ASSOC ))
															{
																$resid =  $row['id'];
															}
															
														$result = array('id' => $resid); 
													}
											}
									}	
								
								
							break;
							case 'rename_node':
							
								$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
								
								$nodeText = isset($_GET['text']) && $_GET['text'] !== '' ? $_GET['text'] : '';
								
								
								
								if ($configdb[0] == 'mysql')
									{
								
										$sql ="UPDATE sgd_folders SET nombre ='".$nodeText."',text = '".$nodeText."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";
										mysql_query($sql,$conn);
										
									}
								else 
									{
										if ($configdb[0] == 'pgsql')
											{
												
												$sql ="UPDATE sgd_folders SET nombre ='".$nodeText."',text = '".$nodeText."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";
												$resuquery = pg_query($conn,$sql);
												
											}
										else 
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														$sql ="UPDATE sgd_folders SET nombre ='".$nodeText."',text = '".$nodeText."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = ".$node;
														$resuquery = sqlsrv_query( $conn, $sql);
													}
											}
									}	
								break;
								
							case 'delete_node':
								$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
								
								
								//se recorre el arbol desde este nodo hacia abajo y se eliminan las ramas inferiores hacia arriba
								
								$sql ="select id from sgd_folders where parent_id = '".$node."'";//se buscan los id hijos
								
								if ($configdb[0] == 'mysql')
									{
									
										$queryhijo = mysql_query($sql,$conn);
										
										while($campohijo = mysql_fetch_array($queryhijo))
											{
												$sql ="select id from sgd_folders where parent_id = '".$campohijo['id']."'";  //se buscan los nietos
												
												$querynieto = mysql_query($sql,$conn);
												
												while($camponieto = mysql_fetch_array($querynieto))
													{
														$sql ="select id from sgd_folders where parent_id = '".$camponieto['id']."'";  //se buscan los bisnietos
														
														$querybisnieto = mysql_query($sql,$conn);
														
														while($campobisnieto = mysql_fetch_array($querybisnieto))
															{
																$sql ="select id from sgd_folders where parent_id = '".$campobisnieto['id']."'";  //se buscan los tataranietos
																
																$querytataranieto = mysql_query($sql,$conn);
																
																while($campotataranieto = mysql_fetch_array($querytataranieto))
																	{
																		$sql ="select id from sgd_folders where parent_id = '".$campotataranieto['id']."'";  //se buscan los trastataranieto
																		
																		$querytrastataranieto = mysql_query($sql,$conn);
																		
																		while($campotrastataranieto = mysql_fetch_array($querytrastataranieto))
																			{
																				$sql ="select id from sgd_folders where parent_id = '".$campotrastataranieto['id']."'";  //se buscan los pentanieto
																				
																				$querypentanieto = mysql_query($sql,$conn);
																				
																				while($campopentanieto = mysql_fetch_array($querypentanieto))
																					{
																						$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campopentanieto['id']."'";   //elimino los hexanieto
																						
																						mysql_query($sql,$conn);
																					}
																					
																				$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotrastataranieto['id']."'";   //elimino los pentanieto
																				
																				mysql_query($sql,$conn);
																			}
																		
																		$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotataranieto['id']."'";   //elimino los trastataranieto
																		
																		mysql_query($sql,$conn);
																		
																	}
																
																$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campobisnieto['id']."'";   //elimino los tataranietos
																
																mysql_query($sql,$conn);
																
															}
														
														$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$camponieto['id']."'";   //elimino los bisnietos
														
														mysql_query($sql,$conn);
													}
													
												$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campohijo['id']."'";   //elimino los nietos
												
												mysql_query($sql,$conn);
												
											}	
											
									}
								else
									{
										if ($configdb[0] == 'pgsql')
											{
										
												$queryhijo = pg_query($conn,$sql);
												
												while($campohijo = pg_fetch_array($queryhijo))
													{
														$sql ="select id from sgd_folders where parent_id = '".$campohijo['id']."'";  //se buscan los nietos
													
														$querynieto = pg_query($conn,$sql);
													
														while($camponieto = pg_fetch_array($querynieto))
															{
																$sql ="select id from sgd_folders where parent_id = '".$camponieto['id']."'";  //se buscan los bisnietos
														
																$querybisnieto = pg_query($conn,$sql);
														
																while($campobisnieto = pg_fetch_array($querybisnieto))
																	{
																		$sql ="select id from sgd_folders where parent_id = '".$campobisnieto['id']."'";  //se buscan los tataranietos
															
																		$querytataranieto = pg_query($conn,$sql);
															
																		while($campotataranieto = pg_fetch_array($querytataranieto))
																			{
																				$sql ="select id from sgd_folders where parent_id = '".$campotataranieto['id']."'";  //se buscan los trastataranieto
																
																				$querytrastataranieto = pg_query($conn,$sql);
																
																				while($campotrastataranieto = pg_fetch_array($querytrastataranieto))
																					{
																						$sql ="select id from sgd_folders where parent_id = '".$campotrastataranieto['id']."'";  //se buscan los pentanieto
																	
																						$querypentanieto = pg_query($conn,$sql);
																	
																						while($campopentanieto = pg_fetch_array($querypentanieto))
																							{
																								$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campopentanieto['id']."'";   //elimino los hexanieto
																		
																								pg_query($conn,$sql);
																							}
																							
																						$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotrastataranieto['id']."'";   //elimino los pentanieto
																	
																						pg_query($conn,$sql);
																					}
																
																				$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotataranieto['id']."'";   //elimino los trastataranieto
																
																				pg_query($conn,$sql);
																
																			}
															
																		$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campobisnieto['id']."'";   //elimino los tataranietos
															
																		pg_query($conn,$sql);
															
																	}
														
																$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$camponieto['id']."'";   //elimino los bisnietos
														
																pg_query($conn,$sql);
															}
															
														$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campohijo['id']."'";   //elimino los nietos
													
														pg_query($conn,$sql);
													
													}
																						
											}	
										else
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														 $queryhijo = sqlsrv_query( $conn, $sql);
														
														while( $campohijo = sqlsrv_fetch_array( $queryhijo, SQLSRV_FETCH_ASSOC ))
															{
																$sql ="select id from sgd_folders where parent_id = '".$campohijo['id']."'";  //se buscan los nietos
																
																 $querynieto = sqlsrv_query( $conn, $sql);
																	
																while($camponieto = sqlsrv_fetch_array( $querynieto, SQLSRV_FETCH_ASSOC )) 
																{
																	$sql ="select id from sgd_folders where parent_id = '".$camponieto['id']."'";  //se buscan los bisnietos
															
																	$querybisnieto = sqlsrv_query($conn,$sql);
															
																	while($campobisnieto = sqlsrv_fetch_array( $querybisnieto, SQLSRV_FETCH_ASSOC )) 
																	{
																		$sql ="select id from sgd_folders where parent_id = '".$campobisnieto['id']."'";  //se buscan los tataranietos
																			
																		$querytataranieto = sqlsrv_query($conn,$sql);
																			
																		while($campotataranieto = sqlsrv_fetch_array( $querytataranieto, SQLSRV_FETCH_ASSOC ))  
																		{
																			$sql ="select id from sgd_folders where parent_id = '".$campotataranieto['id']."'";  //se buscan los trastataranieto
															
																			$querytrastataranieto = sqlsrv_query($conn,$sql);
															
																			while($campotrastataranieto = sqlsrv_fetch_array( $querytrastataranieto, SQLSRV_FETCH_ASSOC )) 
																			{
																				$sql ="select id from sgd_folders where parent_id = '".$campotrastataranieto['id']."'";  //se buscan los pentanieto
																					
																				$querypentanieto = sqlsrv_query($conn,$sql);
																					
																				while($campopentanieto = sqlsrv_fetch_array( $querypentanieto, SQLSRV_FETCH_ASSOC )) 
																				{
																					$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campopentanieto['id']."'";   //elimino los hexanieto
															
																					sqlsrv_query($conn,$sql);
																				}
																					
																				$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotrastataranieto['id']."'";   //elimino los pentanieto
																					
																				sqlsrv_query($conn,$sql);
																			}
															
																			$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campotataranieto['id']."'";   //elimino los trastataranieto
															
																			sqlsrv_query($conn,$sql);
															
																		}
																			
																		$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campobisnieto['id']."'";   //elimino los tataranietos
																			
																		sqlsrv_query($conn,$sql);
																			
																	}
															
																	$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$camponieto['id']."'";   //elimino los bisnietos
															
																	sqlsrv_query($conn,$sql);
																}
																	
																$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$campohijo['id']."'";   //elimino los nietos
																	
																sqlsrv_query($conn,$sql);
																	
															}
													}
											}
									
									}
									
								$sql ="DELETE FROM sgd_folders WHERE parent_id = '".$node."'";   //elimino los hijos
								
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
								
									
								$sql ="DELETE FROM sgd_folders WHERE id = '".$node."'";  //se elimina el nodo
								
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
								
									
									
									//se eliminan los registros de la tabla sgd_dependencias_folders donde el folder sea el seleccionado
									
									$sql ="DELETE FROM sgd_dependencias_folders WHERE id_folder = '".$node."'";
										
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
								
							 case 'guardatipodoc':			 		
							 	  
								$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
								
								$tablaid = isset($_GET['tablaid']) && $_GET['tablaid'] !== '#' ? (int)$_GET['tablaid'] : 0;
																
								$id_tipodoc = isset($_GET['id_tipodoc']) && $_GET['id_tipodoc'] !== '' ? $_GET['id_tipodoc'] : '';   // echo $id_tipodoc;
								
								//se eliminan las relacion previas de esa carpeta
								
								$sql ="DELETE FROM sgd_folders_tipodocs WHERE id_folder = ".$node;   
								
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
								
								//se registran las relaciones de esa carpeta con los tipos documentales q se le asignaron
								
								$id_tipodoc = explode(',',$id_tipodoc);
								
								for ($i = 0; $i < count($id_tipodoc); $i++) {
									
									$sql ="INSERT INTO sgd_folders_tipodocs (id_folder, id_tipodoc,created_at) VALUES(".$node.", ".$id_tipodoc[$i].", '".date("Y-m-d H:i:s")."')"; 
									
									if ($configdb[0] == 'mysql')
										{
												
											mysql_query($sql,$conn);
											
											//se captura el ultimo id de la tabla de relacion de folder y tipodoc
											
											$idfoldertpdoc = mysql_insert_id($conn);
												
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
							break;
							case 'guardatipodocindice': 	
								$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
								
								$id_tipodoc = isset($_GET['id_tipodoc']) && $_GET['id_tipodoc'] !== '#' ? (int)$_GET['id_tipodoc'] : 0;
								
								$id_indices = isset($_GET['id_indices']) && $_GET['id_indices'] !== '' ? $_GET['id_indices'] : '';
								
								//se eliminan las relacion previas de esa carpeta con los indioces para es tipo documental
								
								$sql ="DELETE FROM sgd_tipodoc_indices WHERE id_tipodoc = ".$id_tipodoc." and id_folder = ".$node;
								
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
								//se registran las relaciones de esa carpeta con los indices para ese tipo documental
								
								$id_indices = explode(',',$id_indices);
								
								for ($i = 0; $i < count($id_indices); $i++) {
										
									$sql ="INSERT INTO sgd_tipodoc_indices (id_folder, id_tipodoc,id_indice,created_at) VALUES(".$node.", ".$id_tipodoc.",".$id_indices[$i].", '".date("Y-m-d H:i:s")."')";
										
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
							break;
							case 'move_node':
								$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
								
								$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
								
								$sql ="UPDATE sgd_folders SET parent_id ='".$parn."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id = '".$node."'";
								
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
							case 'copy_node':
								$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
								
								$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
								
								//se buscan los datos
								
								$sql = "SELECT * FROM sgd_folders where id = ".$node;
								
								if ($configdb[0] == 'mysql')
									{
										$resf = mysql_query($sql,$conn);
										
										$rowf = mysql_fetch_assoc($resf);
									}
								else 
									{
										if ($configdb[0] == 'pgsql')
											{
												
												$resf = pg_query($conn,$sql);
												
												$rowf = pg_fetch_assoc($resf);
												
											}
										else 
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														$resuquery = sqlsrv_query($conn,$sql);
														
														while( $row = sqlsrv_fetch_array( $resuquery, SQLSRV_FETCH_ASSOC ))
															{
																$rowf = pg_fetch_assoc($row); 
															}
													}
											}
									}	
								$sql ="INSERT INTO sgd_folders (nombre, text,parent_id,id_estado,id_tabla,created_at) VALUES('".$rowf['nombre']."', '".$rowf['nombre']."', '".$parn."',".$rowf['id_estado'].",".$rowf['id_tabla'].",'".date("Y-m-d H:i:s")."')";
								
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
							
							case 'damedocumentales':
								
								$idstp = '';
								
								$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
							
								$sql =" select id_tipodoc from sgd_folders_tipodocs where id_folder = ".$node;  
							
								if ($configdb[0] == 'mysql')
									{
								
										$queryids =  mysql_query($sql,$conn);
										
										while($campo2 = mysql_fetch_array($queryids))
											{
												$idstp .= $campo2['id_tipodoc'].'_;_';
											}
										
									}	
								else 
									{
										if ($configdb[0] == 'pgsql')
											{
												
												$resuquery = pg_query($conn,$sql);
												
												while($campo2 = pg_fetch_array($resuquery))
													{
														$idstp .= $campo2['id_tipodoc'].'_;_';
													}
												
											}
										
									}
							
														
								echo  $idstp;
								
							break;
							
							case 'damedocumentalestxt':
								$idstp = '';
								
								$node = isset($_GET['id_carpeta']) && $_GET['id_carpeta'] !== '#' ? (int)$_GET['id_carpeta'] : 0;
									
								$sql =" select td.id_tipodoc,td.nombre,td.color from sgd_folders_tipodocs tpd,sgd_tipodocumentales td  where tpd.id_folder = ".$node." and tpd.id_tipodoc = td.id_tipodoc";
								
								$script = '<ul>';
								
								if ($configdb[0] == 'mysql')
									{
										$queryids =  mysql_query($sql,$conn);
										
										while($campo2 = mysql_fetch_array($queryids))
											{
																								
												$script .= '<li id="tpdoc_'.$campo2['id_tipodoc'].'" class="sombraicono" style="cursor:pointer;color:'.$campo2['color'].'" ><span style="color:#020202" onclick="verindices('.$campo2['id_tipodoc'].','.$node.')">'.utf8_encode($campo2['nombre']).'</span>&nbsp;&nbsp;<i class="glyphicon glyphicon-th-list sombraicono iconoverde" style="font-size:1.3em;position:relative;float:right" onclick=cargaindices('.$campo2['id_tipodoc'].','.$node.') title="Indices">&nbsp;</i></li>';
											}
										
									}
								else 
									{
										if ($configdb[0] == 'pgsql')
											{
												
												$resuquery = pg_query($conn,$sql);
												
												while($campo2 = pg_fetch_array($resuquery))
													{
														$script .= '<li id="tpdoc_'.$campo2['id_tipodoc'].'" class="sombraicono" style="cursor:pointer;color:'.$campo2['color'].'" ><span style="color:#020202" onclick="verindices('.$campo2['id_tipodoc'].','.$node.')">'.utf8_encode($campo2['nombre']).'</span>&nbsp;&nbsp;<i class="glyphicon glyphicon-th-list sombraicono iconoverde" style="font-size:1.3em;position:relative;float:right" onclick=cargaindices('.$campo2['id_tipodoc'].','.$node.') title="Indices">&nbsp;</i></li>';
													}
												
											}
										else 
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
													
														$resuquery = sqlsrv_query($conn,$sql);
														
														while( $row = sqlsrv_fetch_array( $resuquery, SQLSRV_FETCH_ASSOC ))
															{
																$script .= '<li id="tpdoc_'.$row['id_tipodoc'].'" class="sombraicono" style="cursor:pointer;color:'.$row['color'].'" ><span style="color:#020202" onclick="verindices('.$row['id_tipodoc'].','.$node.')">'.utf8_encode($row['nombre']).'</span>&nbsp;&nbsp;<i class="glyphicon glyphicon-th-list sombraicono iconoverde" style="font-size:1.3em;position:relative;float:right" onclick=cargaindices('.$row['id_tipodoc'].','.$node.') title="Indices">&nbsp;</i></li>';
															}
													}
											}
											
									}
									
								$script .= '</ul>';
								
								echo $script;
								
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
										else 
											{
												if (trim($configdb[0]) == 'sqlsrv')
													{
														$resuquery = sqlsrv_query($conn,$sql);
														
														while( $row = sqlsrv_fetch_array( $resuquery, SQLSRV_FETCH_ASSOC ))
															{
																$script .= '<li id="indice_'.$row['id_indice'].'"  style="cursor:pointer" >'.utf8_encode($row['nombre']).'</li>';
															}
														
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
							   			else 
							   				{
							   					if (trim($configdb[0]) == 'sqlsrv')
							   						{
							   							$resuquery = sqlsrv_query($conn,$sql);
							   							
							   							while( $row = sqlsrv_fetch_array( $resuquery, SQLSRV_FETCH_ASSOC ))
							   							{
							   								$script .= '<option id="indice_'.$row['id_indice'].'" value="'.$row['id_indice'].'">'.utf8_encode($row['nombre']).'</option>';
							   							}
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
									else 
										{
											if (trim($configdb[0]) == 'sqlsrv')
												{
													$resuquery = sqlsrv_query($conn,$sql);
													 
													while( $row = sqlsrv_fetch_array( $resuquery, SQLSRV_FETCH_ASSOC ))
														{
															$idsind .= $row['id_indice'].'_;_';
														}
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
				
	function lastId($queryID) {
		sqlsrv_next_result($queryID);
		sqlsrv_fetch($queryID);
		return sqlsrv_get_field($queryID, 0);
	}
?>