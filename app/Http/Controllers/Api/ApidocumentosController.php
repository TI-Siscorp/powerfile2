<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\Documento;
use App\Bodega;
use App\Imagendocumento;


class ApidocumentosController extends Controller
{
	public function ver(Request $request)
	{
		$login= $request->input('login');
	
		$clave= $request->input('password');
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
					
				if ($registroper == true)
					{
							
						$documentos = DB::select('select d.id_documento,d.id_expediente,d.id_tipodocumental,d.id_usuario,d.id_tabla,d.id_folder,d.orden,d.id_estado,d.created_at as documento_creado,d.updated_at as documento_actualizado,
						e.spider,e.id_central,e.nombre as nombre_expediente,e.id_estado,e.created_at as expediente_creado,e.updated_at as expediente_actualizado,tp.nombre as nombre_tpdocumental,tp.descripcion as descripcion_tpdocumental,tp.id_estado,
						tp.created_at as tpdocumental_creado,tp.updated_at as tpdocumental_actualizado,t.nombre_tabla,t.version,t.descripcion as descripcion_tabla,t.id_estado as id_estado_tabla,t.created_at as tabla_creado,t.updated_at as tabla_actualizado,
						f.text,f.nombre as nombre_folder,f.parent_id,f.id_estado as id_estado_folder,f.created_at as folder_creado,f.updated_at as folder_actualizado,v.id_indice,v.valor
						from sgd_documentos d, sgd_expedientes e, sgd_tipodocumentales tp,sgd_tablas t,sgd_folders f,sgd_valorindice v
						 where d.id_expediente = e.id_expediente and d.id_tipodocumental = tp.id_tipodoc and d.id_tabla = t.id_tabla and d.id_folder = f.id and d.id_documento = v.id_documento
						  and d.id_documento > 0');
						
						$imagenes = DB::select('select id.id_documento,id.id_imagendocum ,id.nombre,id.extension,id.id_bodega,id.orden,id_estado  from sgd_imagen_documento id where id_documento in(select d.id_documento from sgd_documentos d where d.id_documento > 0)');
						
							
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$documentos,'imagenes'=>$imagenes]));
							
					}
				else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					}
			}
		else
			{
				return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
			}
	}	
	
	public function buscar(Request $request)
	{
		$login= $request->input('login');
	
		$clave= $request->input('password');
	
		$id = $request->input('id');
		
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
		{
			$user = Auth::user();
				
			$usuarios = $user->id;
	
			$idusu = $user->id_rol;
	
			$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
				
			if ($registroper == true)
			{
					
				$documentos = DB::select('select d.id_documento,d.id_expediente,d.id_tipodocumental,d.id_usuario,d.id_tabla,d.id_folder,d.orden,d.id_estado,d.created_at as documento_creado,d.updated_at as documento_actualizado,
						e.spider,e.id_central,e.nombre as nombre_expediente,e.id_estado,e.created_at as expediente_creado,e.updated_at as expediente_actualizado,tp.nombre as nombre_tpdocumental,tp.descripcion as descripcion_tpdocumental,tp.id_estado,
						tp.created_at as tpdocumental_creado,tp.updated_at as tpdocumental_actualizado,t.nombre_tabla,t.version,t.descripcion as descripcion_tabla,t.id_estado as id_estado_tabla,t.created_at as tabla_creado,t.updated_at as tabla_actualizado,
						f.text,f.nombre as nombre_folder,f.parent_id,f.id_estado as id_estado_folder,f.created_at as folder_creado,f.updated_at as folder_actualizado,v.id_indice,v.valor
						from sgd_documentos d, sgd_expedientes e, sgd_tipodocumentales tp,sgd_tablas t,sgd_folders f,sgd_valorindice v
						 where d.id_expediente = e.id_expediente and d.id_tipodocumental = tp.id_tipodoc and d.id_tabla = t.id_tabla and d.id_folder = f.id and d.id_documento = v.id_documento and d.id_documento = '.$id);
					
				$imagenes = DB::select('select id.id_documento,id.id_imagendocum ,id.nombre,id.extension,id.id_bodega,id.orden,id_estado  from sgd_imagen_documento id where id_documento in(select d.id_documento from sgd_documentos d where d.id_documento ='.$id.')');
				
				return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$documentos,'imagenes'=>$imagenes]));
					
			}
			else
			{
				return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
			}
		}
		else
		{
			return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
		}
	}
	
	public function imagenes(Request $request)
	{
		$login= $request->input('login');
	
		$clave= $request->input('password');
		
		$configdb = sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				''
				);
		
		$idimagen = $request->input('idimagen');
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
		
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
				
				
		
				$registroper = conocepermisosapi('view_doc',$usuarios,$idusu);
		
				if ($registroper == true)
					{
			
						@session_start();
						
						$workspace = $_SESSION['espaciotrabajo'];   
						
						$ruta_temp = '/visor/'.$workspace.'/';
						
						$keyllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
						
						$imagenes = DB::select('select id.id_documento,id.id_imagendocum ,id.nombre,id.extension,id.id_bodega,id.orden,id_estado  from sgd_imagen_documento id where  id_imagendocum = '.$idimagen);
									
						$nombreimg = $imagenes[0]->nombre;   
						 
						$extimg = $imagenes[0]->extension;
						
						$bodega = $imagenes[0]->id_bodega;
						
						$idimg = $imagenes[0]->id_imagendocum;
						
						//se busca el archivo
												
						$_SESSION['espaciotrabajo'] =  $workspace;  	
						
						//se manda a ejecutar de forma externa el proceso de carga de imagen
						
						$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=parseaimg&idimagen='.$idimagen.'&configdb='.$configdb.'&nombre='.$nombreimg.'&extendion='.$extimg.'&bodega='.$bodega.'&workspace='.$workspace);
						
						echo $page;
						
					}
				else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					}
			}
		else
			{
				return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
			}
	}
	
	public function tira_imagenes(Request $request)
	{
		$login= $request->input('login');
	
		$clave= $request->input('password');
	
		$configdb = sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				''
				);
		
		$id_documento = $request->input('id_documento');
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
		
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
				
				$ruta_temp = '../../storage/app/visor/powerfile2/';
		
				$registroper = conocepermisosapi('view_doc',$usuarios,$idusu);
		
				if ($registroper == true)
					{
							
						@session_start();
			
						$workspace = $_SESSION['espaciotrabajo'];
			
						$keyllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
						//se busca el archivo
			
						$_SESSION['espaciotrabajo'] =  $workspace;
						
						$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=parseaimgs&id_documento='.$id_documento.'&configdb='.$configdb.'&workspace='.$workspace);
						
						echo $page;
						
					}	
					
				else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					}
			}
		else
			{
				return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
			}
	}
	
	
	
	function grabaimg(Request $request)
	{
		$login= $request->input('login');
		
		$clave= $request->input('password');
		
		$configdb = sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				''
				);
				
		$id_tipodoc = $request->input('id_tipodoc');
		
		$id_documento = $request->input('id_documento');
		
		$id_expediente = trartidexp($id_documento);
				
		@session_start();
		
		$espaciotrabajo = $_SESSION['espaciotrabajo'];  
		
		
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
			
				$usuarios = $user->id;
			
				$idusu = $user->id_rol;
			
				$registroper = conocepermisosapi('add_doc',$usuarios,$idusu); 		
				
				if ($registroper == true)
					{
						
						if(isset($_FILES['imgarh'])){
								
							$file = $request->file('imgarh');
							//buscamos la lleva de encriptación
							
							$lllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
							
							$kweyllave = $lllave[0]->key_encrypt;
							
							$total = count($_FILES['imgarh']['name']);       
							
							$id_usuario = $usuarios;
							
							$workspace = $_SESSION['espaciotrabajo'];   
						
							if ($total > 1)
								{									
									//se manda a procesar
									
									
										
									$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
									
									if (count($lbodega) == 0)
										{
											//se verifica si es la primera bodega
											$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
												
											if (count($cbod) == 0)
												{
													//se genera la primera bodega
														
													DB::table('sgd_bodegas')->insert(
															array(
																	'nombre'     	=>  'Bodega_1',
																	'limite'   		=>  1000,
																	'actual' 		=>	1,
																	'id_estado' 	=> 	1,
																	'created_at'	=> date("Y-m-d H:m:s")
															)
														);
														
													$nombreb = 'Bodega_1';
											
													$limiteb = 1000;
											
													$actualb = 0;
														
													$regbodega = Bodega::all();
														
													$idbodega = $regbodega->last();
														
													$idbodega = $idbodega->id_bodega;
											
												}
											else
												{
											
													//se busca la ultima bodega para continuar el control
													$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
											
													$dbod = $cbod[0]->nombre;
											
													$nombreb = explode("_".$dbod);
											
													$nombreb = ($nombreb[1]*1) + 1;
											
													$nombreb = 'Bodega_'.$nombreb;
											
													$limiteb = 1000;
														
													$actualb = 0;
											
													//se registra la nueva bodega
											
													DB::table('sgd_bodegas')->insert(
															array(
																	'nombre'     	=>  $nombreb,
																	'limite'   		=>  1000,
																	'actual' 		=>	1,
																	'id_estado' 	=> 	1,
																	'created_at'	=> date("Y-m-d H:m:s")
															)
														);
											
													$regbodega = Bodega::all();
														
													$idbodega = $regbodega->last();
											
													$idbodega = $idbodega->id_bodega;
											
												}
										}
									else
										{
											//existe una bodega desocupada
												
											$idbodega = $lbodega[0]->id_bodega;
												
											$nombreb = $lbodega[0]->nombre;
												
											$limiteb = $lbodega[0]->limite;
												
											$actualb = $lbodega[0]->actual;
												
										}
									/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
							
									unset($vimagenesup);
										
									for($i=0; $i<$total; $i++) {
										
										$tmpFilePath = '';
											
										$nombrear = '';
										
										//Get the temp file path
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];    
											
										$nombrear = $_FILES['imgarh']['name'][$i];    					
										$actualb = $actualb + 1;
										
										if ($actualb > $limiteb) //se genera una nueva bodega
											{
											
												$nombreb = explode("_".$nombreb);
													
												$nombreb = ($nombreb[1]*1) + 1;
													
												$nombreb = 'Bodega_'.$nombreb;
													
												$limiteb = 1000;
													
												$actualb = 1;
													
												//se registra la nueva bodega
											
												DB::table('sgd_bodegas')->insert(
														array(
																'nombre'     	=>  $nombreb,
																'limite'   		=>  1000,
																'actual' 		=>	1,
																'id_estado' 	=> 	1,
																'created_at'	=> date("Y-m-d H:m:s")
														)
														);
											
												$regbodega = Bodega::all();
													
												$idbodega = $regbodega->last();
											
												$idbodega = $idbodega->id_bodega;
											
											}
										else
											{
												//se acutaliza el valor de documentos actuales en la tabla bodega
											
												DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
												->update(['actual' => $actualb]);
											
											}
											
										//Get the temp file path
											
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];  
											
										$nombrear1 = $_FILES['imgarh']['name'][$i];
											
										$nombrear2 = explode('.',$nombrear1);
											
										$nombrear = $nombrear2[0];
											
										$file_ext = strtolower($nombrear2[1]);
											
										$norden = 0;
											
										if ($file_ext != 'zip' and $file_ext != 'ZIP' )
											{
												//se verifica cual es el  último orden de imagenes para ese documento y se coloca la imagen al final del mismo
												
												$cuantoorden = DB::select('select orden from sgd_imagen_documento where id_documento = '.$id_documento.' order by orden asc');
												
												if (count($cuantoorden) > 0)
													{
														
														foreach ($cuantoorden as $ordenu)
															{
																$norden = $ordenu->orden;
															}
														
														$norden = $norden + 1;
																												
													}
												else
													{
														
														$norden = 0;
														
														$norden = $norden + 1;
														
													}
													//se registra
													
													DB::table('sgd_imagen_documento')->insert(
															array(
																	'id_documento'     	=>  $id_documento,
																	'nombre'   			=>  $nombrear,
																	'extension' 		=>	$file_ext,
																	'id_bodega' 		=> 	$idbodega,
																	'id_estado'			=> 	1,
																	'orden' 			=>	$norden,
																	'created_at'		=> date("Y-m-d H:m:s")
															)
													);
													
													//se captura el ultimo id registrado
													
													$regimagen = Imagendocumento::all();
													
													$idimagen = $regimagen->last();
													
													$idimagen = $idimagen->id_imagendocum;
													
													/////// proceso con encriptación
													
													if ($idimagen > 0)
														{
															
															if($request->hasFile('imgarh'))
																{
																	
																	unset($vimagenes);
																	
																	unset($vextensiones);
																	
																	//$file = $request->file('imgarh');
																	
																	$dir = public_path('img/tempo/'.$espaciotrabajo);
																	
																	if (!file_exists($dir))
																		{
																			mkdir($dir, 0777, true);
																		}
																	
																	
																	$imageName =  $file[$i]->getClientOriginalName();
																	
																	$imagemove= $file[$i]->move(public_path('img/tempo/'.$espaciotrabajo),$idimagen.'_.'.$file_ext);
																	
																	encryptFile($idimagen.'_.'.$file_ext,public_path('img/tempo/'.$espaciotrabajo),$kweyllave);
																	
																	unlink($dir.'/'.$idimagen.'_.'.$file_ext);
																	
																	$vimagenes[] = $idimagen;
																	
																	$vextensiones[] = 'dat';
																	
																	$vimagenesup[] = $idimagen.'._dat';
																	
																	$dimagenes = json_encode($vimagenes);
																	
																	$dextensiones = json_encode($vextensiones);
																	
																	//se mueven los archivos hacia el storage respectivo
																	
																	$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastorage&dir='.$dir.'&configdb='.$configdb.'&workspace='.$workspace.'&dimagenes='.$dimagenes.'&dextensiones='.$dextensiones.'&nombreb='.$nombreb);
																	
																	echo $page;
																	
																}
														}	
												
											}
										else 
											{
												if ($file_ext == 'zip' or $file_ext == 'ZIP' )
													{
														
																$dir = public_path('img/tempo/'.$espaciotrabajo);
																
																if (!file_exists($dir))
																	{
																		mkdir($dir, 0777, true);
																	}																
																
																$imageName =  $_FILES['imgarh']['name'][$i];
																
																$nombrear2 = explode('.',$imageName);
																
																$nombrear = $nombrear2[0];
																
																$file_ext = strtolower($nombrear2[1]);
																
																$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);  
																
																//se mueven los archivos hacia el storage respectivo
																
																$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento);
																
																echo $page;
															
														
													}
												
											}
																				
									}// fin del  for
									
									return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$total,'imagenes' =>$vimagenesup]));
								}
							else
								{
									///un solo archivo
									if ($total == 1)
										{
											
											
											$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];  
											
											$nombrear = $_FILES['imgarh']['name'][0];
											
											$nombrear2 = explode('.',$nombrear);
											
											$file_ext = strtolower($nombrear2[1]);
										
											//se manda a procesar
											
											$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');     
											
																						
											if (count($lbodega) == 0)
												{
													//se verifica si es la primera bodega
													$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
													
													if (count($cbod) == 0)
														{
															//se genera la primera bodega
															
															DB::table('sgd_bodegas')->insert(
																		array(
																				'nombre'     	=>  'Bodega_1',
																				'limite'   		=>  1000,
																				'actual' 		=>	1,
																				'id_estado' 	=> 	1,
																				'created_at'			=> date("Y-m-d H:m:s")
																		)
																	);
																													
															$nombreb = 'Bodega_1';
														
															$limiteb = 1000;
														
															$actualb = 0;
															
															$regbodega = Bodega::all();
															
															$idbodega = $regbodega->last();		
															
															$idbodega = $idbodega->id_bodega;
														
													}
												else
													{
														
														//se busca la ultima bodega para continuar el control
														$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
														
														$dbod = $cbod[0]->nombre;
														
														$nombreb = explode("_".$dbod);
														
														$nombreb = ($nombreb[1]*1) + 1;
														
														$nombreb = 'Bodega_'.$nombreb;
														
														$limiteb = 1000;
															
														$actualb = 0;
														
														//se registra la nueva bodega
														
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  $nombreb,
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'	=> date("Y-m-d H:m:s")
																)
															);
														
														$regbodega = Bodega::all();
															
														$idbodega = $regbodega->last();
														
														$idbodega = $idbodega->id_bodega;
														
													}
										}
									else
										{
											//existe una bodega desocupada
											
											$idbodega = $lbodega[0]->id_bodega;
											
											$nombreb = $lbodega[0]->nombre;
											
											$limiteb = $lbodega[0]->limite;
											
											$actualb = $lbodega[0]->actual;
											
										}
										/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
										
										if ($file_ext != 'zip' and $file_ext != 'ZIP' )
											{
												
												$actualb = $actualb + 1;
												
												if ($actualb > $limiteb) //se genera una nueva bodega
													{
														
														$nombreb = explode("_".$nombreb);
														
														$nombreb = ($nombreb[1]*1) + 1;
														
														$nombreb = 'Bodega_'.$nombreb;
														
														$limiteb = 1000;
														
														$actualb = 1;
														
														//se registra la nueva bodega
														
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  $nombreb,
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'			=> date("Y-m-d H:m:s")
																)
														);
														
														$regbodega = Bodega::all();
														
														$idbodega = $regbodega->last();
														
														$idbodega = $idbodega->id_bodega;
														
													}
												else
													{
														//se acutaliza el valor de documentos actuales en la tabla bodega
														
														DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
														->update(['actual' => $actualb]);
														
													}
													
													//Get the temp file path
													
													$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];
													
													$nombrear1 = $_FILES['imgarh']['name'][0];    dd($nombrear1);
													
													$nombrear2 = explode('.',$nombrear1);
													
													$nombrear = $nombrear2[0];
													
													$file_ext = strtolower($nombrear2[1]);
													
													$norden = 0;
													
													//se verifica cual es el  último orden de imagenes para ese documento y se coloca la imagen al final del mismo
													
													$cuantoorden = DB::select('select orden from sgd_imagen_documento where id_documento = '.$id_documento.' order by orden asc');
													
													if (count($cuantoorden) > 0)
													{
														
														foreach ($cuantoorden as $ordenu)
														{
															$norden = $ordenu->orden;
														}
														
														$norden = $norden + 1;
														
													}
													else
													{
														
														$norden = 0;
														
														$norden = $norden + 1;
														
													}
													
													
													//se registra
													
													DB::table('sgd_imagen_documento')->insert(
															array(
																	'id_documento'     	=>  $id_documento,
																	'nombre'   			=>  $nombrear,
																	'extension' 		=>	$file_ext,
																	'id_bodega' 		=> 	$idbodega,
																	'id_estado'			=> 	1,
																	'orden' 			=>	$norden,
																	'created_at'			=> date("Y-m-d H:m:s")
															)
															);
													
													
													//se captura el ultimo id registrado
													
													$regimagen = Imagendocumento::all();
													
													$idimagen = $regimagen->last();
													
													$idimagen = $idimagen->id_imagendocum;	
													
													/////// proceso con encriptación
													
													unset($vimagenes);
													
													if ($idimagen > 0)
														{
															
															/*if($request->hasFile('imgarh'))
																{*/
																	
																	//$file = $request->file('imgarh');
																	
																	
																	
																	$dir = public_path('img/tempo/'.$espaciotrabajo);
																	
																	
																	if (!file_exists($dir))
																		{
																			mkdir($dir, 0777, true);
																		}
																	
																	
																	$imageName =  $file[0]->getClientOriginalName();
																	
																	$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$idimagen.'_.'.$file_ext);
																	
																	encryptFile($idimagen.'_.'.$file_ext,public_path('img/tempo/'.$espaciotrabajo),$kweyllave);
																	
																	unlink($dir.'/'.$idimagen.'_.'.$file_ext);
																	
																	$vimagenes[] = $idimagen;
																	
																	$dimagenes = json_encode($vimagenes);
																	
																	//se mueven los archivos hacia el storage respectivo
																	
																	$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastorage&dir='.$dir.'&configdb='.$configdb.'&workspace='.$workspace.'&$dimagenes='.$dimagenes.'&$nombreb='.$nombreb);
																	
																	echo $page;
																	
																//}
														}
													return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$total,'imagenes' =>$vimagenes]));  
													
											}
										else
											{
												
												/*if($request->hasFile('imgarh'))
													{*/
														
														//$file = $request->file('imgarh');
														
														$dir = public_path('img/tempo/'.$espaciotrabajo);
														
														
														if (!file_exists($dir))
															{
																mkdir($dir, 0777, true);
															}
														
														
														$imageName =  $file[0]->getClientOriginalName(); //dd($imageName);
														
														$nombrear2 = explode('.',$imageName);
														
														$nombrear = $nombrear2[0];
														
														$file_ext = strtolower($nombrear2[1]);
														
														$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);  //dd($nombrear.'.'.$file_ext);
																											
														//se mueven los archivos hacia el storage respectivo
														
														$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento);
														
														echo $page;
														
													//}
												//se mueven los archivos hacia el storage respectivo
											}
											
								}// fin de si es uno
							
							}//fin de si es uno o varios files
						}	
					else
						{
							return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
						
						}
						
					}
					
			}		
	}
	
	
	public function creadoc(Request $request)  
		{
			$login= $request->input('login');
				
			$clave= $request->input('password');
		
			$id_tipodoc = $request->input('id_tipodoc');
		
			$id_folder = $request->input('id_folder');
		
			$id_tabla = $request->input('id_tabla');
		
			$id_expediente = $request->input('id_expediente');
			
			$totalindices = count($request->input('valor'));  
			
			$vidindices = $request->input('indices'); 
			
			$valor = $request->input('valor');  
			
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
			
			//se procede a guardar en cada tabla correspondientemente
			$ordendoc = 0;
				
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
			
					$idusu = $user->id_rol;
						
					$id_usuario = $idusu;
			
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
						
					if ($registroper == true)
						{
							
							if(isset($_FILES['imgarh'])){
								
								//buscamos la lleva de encriptación
									
								$lllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
									
								$kweyllave = $lllave[0]->key_encrypt;
									
								$total = count($_FILES['imgarh']['name']);
									
								$id_usuario = $usuarios;
								
								@session_start();
								
								$espaciotrabajo = $_SESSION['espaciotrabajo'];
									
								$workspace = $_SESSION['espaciotrabajo'];
								
								$file = $request->file('imgarh');
								
								//se guarda el documento
								
								$haydocumetn = DB::select('select id_documento from sgd_documentos  where id_documento = 0 and id_expediente = '.$id_expediente.' and id_tipodocumental = '.$id_tipodoc.' and id_tabla = '.$id_tabla.' and id_folder = '.$id_folder);
								
								if (count($haydocumetn) == 0)
									{
										//se registran los datos
										// primero el documento
										
										DB::table('sgd_documentos')->insert(
												array(
														'id_expediente'     	=>  $id_expediente,
														'id_tipodocumental'   	=>  $id_tipodoc,
														'id_usuario' 			=>	$id_usuario,
														'id_tabla' 				=> 	$id_tabla,
														'id_folder' 			=>	$id_folder,
														'id_estado'				=> 	1,
														'orden' 				=>	$ordendoc,
														'created_at'			=> date("Y-m-d H:m:s")
												)
											);
										
										//se captura el ultimo id registrado
										
										$regdocumento = Documento::all();
										
										$iddocumento = $regdocumento->last();
											
										$iddocumento = $iddocumento->id_documento;
											
										//se registran los valores indices
											
										for ( $i = 0 ; $i < $totalindices ; $i ++)
											{
												$valord = $valor[$i];
												
												if ($i == 0)
													{
														$elvalorb = $valord;
													}
													
												DB::table('sgd_valorindice')->insert(
														array(
																'id_documento'     	=>  $iddocumento,
																'id_indice'   		=>  $vidindices[$i],
																'valor' 			=>	$valord,
																'id_estado'			=> 	1,
																'created_at'		=> date("Y-m-d H:m:s")
														)
												);
													
													
											}
										
											$id_documento = $iddocumento;
											
											if ($total > 1)
											{
												//se manda a procesar
													
													
													
												$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
													
												if (count($lbodega) == 0)
												{
													//se verifica si es la primera bodega
													$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
														
													if (count($cbod) == 0)
													{
														//se genera la primera bodega
															
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  'Bodega_1',
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'	=> date("Y-m-d H:m:s")
																)
																);
															
														$nombreb = 'Bodega_1';
															
														$limiteb = 1000;
															
														$actualb = 0;
															
														$regbodega = Bodega::all();
															
														$idbodega = $regbodega->last();
															
														$idbodega = $idbodega->id_bodega;
															
													}
													else
													{
															
														//se busca la ultima bodega para continuar el control
														$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
															
														$dbod = $cbod[0]->nombre;
															
														$nombreb = explode("_".$dbod);
															
														$nombreb = ($nombreb[1]*1) + 1;
															
														$nombreb = 'Bodega_'.$nombreb;
															
														$limiteb = 1000;
															
														$actualb = 0;
															
														//se registra la nueva bodega
															
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  $nombreb,
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'	=> date("Y-m-d H:m:s")
																)
																);
															
														$regbodega = Bodega::all();
															
														$idbodega = $regbodega->last();
															
														$idbodega = $idbodega->id_bodega;
															
													}
												}
												else
												{
													//existe una bodega desocupada
														
													$idbodega = $lbodega[0]->id_bodega;
														
													$nombreb = $lbodega[0]->nombre;
														
													$limiteb = $lbodega[0]->limite;
														
													$actualb = $lbodega[0]->actual;
														
												}
												/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
													
												unset($vimagenesup);
													
												for($i=0; $i<$total; $i++) {
														
													$tmpFilePath = '';
											
													$nombrear = '';
														
													//Get the temp file path
													$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];
											
													$nombrear = $_FILES['imgarh']['name'][$i];
													$actualb = $actualb + 1;
														
													if ($actualb > $limiteb) //se genera una nueva bodega
													{
															
														$nombreb = explode("_".$nombreb);
															
														$nombreb = ($nombreb[1]*1) + 1;
															
														$nombreb = 'Bodega_'.$nombreb;
															
														$limiteb = 1000;
															
														$actualb = 1;
															
														//se registra la nueva bodega
															
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  $nombreb,
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'	=> date("Y-m-d H:m:s")
																)
																);
															
														$regbodega = Bodega::all();
															
														$idbodega = $regbodega->last();
															
														$idbodega = $idbodega->id_bodega;
															
													}
													else
													{
														//se acutaliza el valor de documentos actuales en la tabla bodega
															
														DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
														->update(['actual' => $actualb]);
															
													}
											
													//Get the temp file path
											
													$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];
											
													$nombrear1 = $_FILES['imgarh']['name'][$i];
											
													$nombrear2 = explode('.',$nombrear1);
											
													$nombrear = $nombrear2[0];
											
													$file_ext = strtolower($nombrear2[1]);
											
													$norden = 0;
											
													if ($file_ext != 'zip' and $file_ext != 'ZIP' )
														{
													
															//se verifica cual es el  último orden de imagenes para ese documento y se coloca la imagen al final del mismo
													
															$cuantoorden = DB::select('select orden from sgd_imagen_documento where id_documento = '.$id_documento.' order by orden asc');
													
															if (count($cuantoorden) > 0)
																{
																		
																	foreach ($cuantoorden as $ordenu)
																		{
																			$norden = $ordenu->orden;
																		}
																		
																	$norden = $norden + 1;
																		
																}
															else
																{
																		
																	$norden = 0;
																		
																	$norden = $norden + 1;
																		
																}
																	
																
															//se registra
													
															DB::table('sgd_imagen_documento')->insert(
																	array(
																			'id_documento'     	=>  $id_documento,
																			'nombre'   			=>  $nombrear,
																			'extension' 		=>	$file_ext,
																			'id_bodega' 		=> 	$idbodega,
																			'id_estado'			=> 	1,
																			'orden' 			=>	$norden,
																			'created_at'		=> date("Y-m-d H:m:s")
																	)
																	);
																
																
															//se captura el ultimo id registrado
													
															$regimagen = Imagendocumento::all();
																
															$idimagen = $regimagen->last();
													
															$idimagen = $idimagen->id_imagendocum;
													
													
															/////// proceso con encriptación
													
															if ($idimagen > 0)
																{
																		
																	if($request->hasFile('imgarh'))
																		{
																				
																			unset($vimagenes);
																				
																			//$file = $request->file('imgarh');
																				
																			$dir = public_path('img/tempo/'.$espaciotrabajo);
															
																			if (!file_exists($dir))
																				{
																					mkdir($dir, 0777, true);
																				}
															
															
																			$imageName =  $file[$i]->getClientOriginalName();
															
																			$imagemove= $file[$i]->move(public_path('img/tempo/'.$espaciotrabajo),$idimagen.'_.'.$file_ext);
															
																			encryptFile($idimagen.'_.'.$file_ext,public_path('img/tempo/'.$espaciotrabajo),$kweyllave);
																				
																			unlink($dir.'/'.$idimagen.'_.'.$file_ext);
																				
																			$vimagenes[] = $idimagen;
																				
																			$vimagenesup[] = $idimagen.'_dat';
																				
																			$dimagenes = json_encode($vimagenes);
																				
																			//se mueven los archivos hacia el storage respectivo
																			
																			$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastorage&dir='.$dir.'&configdb='.$configdb.'&workspace='.$workspace.'&dimagenes='.$dimagenes.'&$nombreb='.$nombreb);
																				
																			echo $page;
																				
																		}
																}
													  }
													else
														 {
														 	if ($file_ext == 'zip' and $file_ext == 'ZIP' )
														 		{
														 			$dir = public_path('img/tempo/'.$espaciotrabajo);
														 			
														 			if (!file_exists($dir))
															 			{
															 				mkdir($dir, 0777, true);
															 			}
														 			
														 			$imageName =  $_FILES['imgarh']['name'][$i];
														 			
														 			$nombrear2 = explode('.',$imageName);
														 			
														 			$nombrear = $nombrear2[0];
														 			
														 			$file_ext = strtolower($nombrear2[1]);
														 			
														 			$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);
														 			
														 			//se mueven los archivos hacia el storage respectivo
														 			
														 			$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento);
														 			
														 			echo $page;
														 			
														 		}
														 }
												}// fin del  for
													
													
													
												return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$total,'imagenes' =>$vimagenesup]));
											}
											else
											{
												///un solo archivo
												if ($total == 1)
												{
													$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];
											
													$nombrear = $_FILES['imgarh']['name'][0];
														
													//se manda a procesar
											
													$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
											
														
													if (count($lbodega) == 0)
													{
														//se verifica si es la primera bodega
														$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
															
														if (count($cbod) == 0)
														{
															//se genera la primera bodega
											
															DB::table('sgd_bodegas')->insert(
																	array(
																			'nombre'     	=>  'Bodega_1',
																			'limite'   		=>  1000,
																			'actual' 		=>	1,
																			'id_estado' 	=> 	1,
																			'created_at'			=> date("Y-m-d H:m:s")
																	)
																	);
											
															$nombreb = 'Bodega_1';
																
															$limiteb = 1000;
																
															$actualb = 0;
											
															$regbodega = Bodega::all();
											
															$idbodega = $regbodega->last();
											
															$idbodega = $idbodega->id_bodega;
																
														}
														else
														{
																
															//se busca la ultima bodega para continuar el control
															$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
																
															$dbod = $cbod[0]->nombre;
																
															$nombreb = explode("_".$dbod);
																
															$nombreb = ($nombreb[1]*1) + 1;
																
															$nombreb = 'Bodega_'.$nombreb;
																
															$limiteb = 1000;
											
															$actualb = 0;
																
															//se registra la nueva bodega
																
															DB::table('sgd_bodegas')->insert(
																	array(
																			'nombre'     	=>  $nombreb,
																			'limite'   		=>  1000,
																			'actual' 		=>	1,
																			'id_estado' 	=> 	1,
																			'created_at'			=> date("Y-m-d H:m:s")
																	)
																	);
																
															$regbodega = Bodega::all();
											
															$idbodega = $regbodega->last();
																
															$idbodega = $idbodega->id_bodega;
																
														}
													}
													else
													{
														//existe una bodega desocupada
															
														$idbodega = $lbodega[0]->id_bodega;
															
														$nombreb = $lbodega[0]->nombre;
															
														$limiteb = $lbodega[0]->limite;
															
														$actualb = $lbodega[0]->actual;
															
													}
													/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
														
													$actualb = $actualb + 1;
														
													if ($actualb > $limiteb) //se genera una nueva bodega
													{
															
														$nombreb = explode("_".$nombreb);
															
														$nombreb = ($nombreb[1]*1) + 1;
															
														$nombreb = 'Bodega_'.$nombreb;
															
														$limiteb = 1000;
															
														$actualb = 1;
															
														//se registra la nueva bodega
															
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  $nombreb,
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'			=> date("Y-m-d H:m:s")
																)
																);
															
														$regbodega = Bodega::all();
															
														$idbodega = $regbodega->last();
															
														$idbodega = $idbodega->id_bodega;
															
													}
													else
													{
														//se acutaliza el valor de documentos actuales en la tabla bodega
															
														DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
														->update(['actual' => $actualb]);
															
													}
											
													//Get the temp file path
											
													$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];
											
													$nombrear1 = $_FILES['imgarh']['name'][0];
											
													$nombrear2 = explode('.',$nombrear1);
											
													$nombrear = $nombrear2[0];
											
													$file_ext = strtolower($nombrear2[1]);
											
													$norden = 0;
													
													if ($file_ext != 'zip' and $file_ext != 'ZIP' )
														{
															//se verifica cual es el  último orden de imagenes para ese documento y se coloca la imagen al final del mismo
															
															$cuantoorden = DB::select('select orden from sgd_imagen_documento where id_documento = '.$id_documento.' order by orden asc');
															
															if (count($cuantoorden) > 0)
															{
																
																foreach ($cuantoorden as $ordenu)
																{
																	$norden = $ordenu->orden;
																}
																
																$norden = $norden + 1;
																
															}
															else
															{
																
																$norden = 0;
																
																$norden = $norden + 1;
																
															}
															
															
															//se registra
															
															DB::table('sgd_imagen_documento')->insert(
																	array(
																			'id_documento'     	=>  $id_documento,
																			'nombre'   			=>  $nombrear,
																			'extension' 		=>	$file_ext,
																			'id_bodega' 		=> 	$idbodega,
																			'id_estado'			=> 	1,
																			'orden' 			=>	$norden,
																			'created_at'			=> date("Y-m-d H:m:s")
																	)
																	);
															
															
															//se captura el ultimo id registrado
															
															$regimagen = Imagendocumento::all();
															
															$idimagen = $regimagen->last();
															
															$idimagen = $idimagen->id_imagendocum;
															
															
															/////// proceso con encriptación
															
															unset($vimagenes);
															
															if ($idimagen > 0)
															{
																
																if($request->hasFile('imgarh'))
																{
																	
																	//$file = $request->file('imgarh');
																	
																	
																	
																	$dir = public_path('img/tempo/'.$espaciotrabajo);
																	
																	
																	if (!file_exists($dir))
																	{
																		mkdir($dir, 0777, true);
																	}
																	
																	
																	$imageName =  $file[0]->getClientOriginalName();
																	
																	$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$idimagen.'_.'.$file_ext);
																	
																	encryptFile($idimagen.'_.'.$file_ext,public_path('img/tempo/'.$espaciotrabajo),$kweyllave);
																	
																	unlink($dir.'/'.$idimagen.'_.'.$file_ext);
																	
																	$vimagenes[] = $idimagen;
																	
																	$dimagenes = json_encode($vimagenes);
																	
																	//se mueven los archivos hacia el storage respectivo
																	
																	$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastorage&dir='.$dir.'&configdb='.$configdb.'&workspace='.$workspace.'&dimagenes='.$dimagenes.'&$nombreb='.$nombreb);
																	
																	echo $page;
																	
																}
															}
															/*//se procede a enviar el correo a los usuarios notificando la creación de un nuevo documento
															
															$reglusuario = DB::select("select email from sgd_usuarios where id <> ".$id_usuario);
															
															foreach ($reglusuario as $datosmail)
															{
															$para = $datosmail->email;
															
															$titulo = trans("principal.msgcreanuevo");
															
															$mensaje = '
															<html>
															<head>
															<title>'.trans("principal.titrecupera").'</title>
															</head>
															<body>
															<img src="http://www.siscorp.com.co/img/powerfile.png">
															<H4>Powerfile</H4>
															<br>
															<table border="1">
															<tr>
															<th>File</th>
															</tr>';
															
															for ( $z = 0 ; $z < $vimagenes ; $z ++)
															{
															
															$mensaje .= ' <tr><td>'.$vimagenes[$z].'</td></tr>';
															}
															$mensaje .= '</table>
															</body>
															</html>';
															
															$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
															
															$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
															
															$cabeceras .= 'From: info@siscorp.com.co' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
															
															mail($para, $titulo, $mensaje, $cabeceras);
															
															}*/
															return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$total,'imagenes' =>@$vimagenes]));
														}
													else 
														{
															if ($file_ext == 'zip' or $file_ext == 'ZIP' )
																{
																	
																	$dir = public_path('img/tempo/'.$espaciotrabajo);
																	
																	if (!file_exists($dir))
																		{
																			mkdir($dir, 0777, true);
																		}
																	
																	$imageName =  $_FILES['imgarh']['name'][0];
																	
																	$nombrear2 = explode('.',$imageName);
																	
																	$nombrear = $nombrear2[0];
																	
																	$file_ext = strtolower($nombrear2[1]);
																	
																	$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);
																	
																	//se mueven los archivos hacia el storage respectivo
																	
																	$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento);
																	
																	echo $page;
																}
														}
													
												}
													
											}
										
										
									}
																	
							}//fin de si hay imagen q subir
						else
							{
								return response()->json((['status'=>'error','code'=>201,'message'=>'data error image']));
								
							}
								
						}
					else
						{
							return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
							
						}
				}
			else
				{
					
					return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
				}
		
		}
		
		/*para el manejo de archivos zip con csv*/
		
		
		
		public function loadfile_folder(Request $request)
			{
				/*header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');*/
				
				$login= $request->input('login');
				
				$clave= $request->input('password');
				
			//	$id_tipodoc = $request->input('id_tipodoc');
				
				$id_folder = $request->input('id_node');
				
				$id_tabla = $request->input('id_tabla');
				
				$configdb = sprintf(
						"%s://%s%s",
						isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
						$_SERVER['SERVER_NAME'],
						''
						);
				
				//se procede a guardar en cada tabla correspondientemente
				$ordendoc = 0;
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
						
						$usuarios = $user->id;
						
						$idusu = $user->id_rol;
						
						$id_usuario = $idusu;
						
						$registroper = conocepermisosapi('load_csv',$usuarios,$idusu);
						
						if ($registroper == true)
							{
								if ($id_tabla > 0 and $id_folder > 0)
									{
										@session_start();
										
										$espaciotrabajo = $_SESSION['espaciotrabajo'];
										
										$workspace = $_SESSION['espaciotrabajo'];
										
										$dir = '../public/loads';
										
										if (!file_exists($dir))
											{
												mkdir($dir, 0777, true);
											}
										else 
											{
												//recorremos los archivos de loads en public
												
												$li = array();
												
												$li[] =  $dir;
												
												$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
												
												if (count($lbodega) == 0)
												{
													//se verifica si es la primera bodega
													$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
													
													if (count($cbod) == 0)
													{
														//se genera la primera bodega
														
														DB::table('sgd_bodegas')->insert(
																array(
																		'nombre'     	=>  'Bodega_1',
																		'limite'   		=>  1000,
																		'actual' 		=>	1,
																		'id_estado' 	=> 	1,
																		'created_at'	=> date("Y-m-d H:m:s")
																)
																);
														
														$nombreb = 'Bodega_1';
														
														$limiteb = 1000;
														
														$actualb = 0;
														
														$regbodega = Bodega::all();
														
														$idbodega = $regbodega->last();
														
														$idbodega = $idbodega->id_bodega;
														
													}
													else
													{
														
														
														//existe una bodega desocupada
														
														$idbodega = $lbodega[0]->id_bodega;
														
														$nombreb = $lbodega[0]->nombre;
														
														$limiteb = $lbodega[0]->limite;
														
														$actualb = $lbodega[0]->actual;
														
														
													}
												}
												else
												{
													//existe una bodega desocupada
													
													$idbodega = $lbodega[0]->id_bodega;
													
													$nombreb = $lbodega[0]->nombre;
													
													$limiteb = $lbodega[0]->limite;
													
													$actualb = $lbodega[0]->actual;
													
												}
												
												//dd($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=load_csv&configdb='.$configdb.'&workspace='.$workspace.'&nombreb='.$nombreb.'&id_tabla='.$id_tabla.'&idusuario='.$usuarios.'&id_tipodoc='.$id_tipodoc.'&id_folder='.$id_folder);
												
												//dd($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=load_csv&configdb='.$configdb.'&workspace='.$workspace.'&nombreb='.$nombreb.'&id_tabla='.$id_tabla.'&idusuario='.$usuarios.'&id_folder='.$id_folder);
												
												$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=load_csv&configdb='.$configdb.'&workspace='.$workspace.'&nombreb='.$nombreb.'&id_tabla='.$id_tabla.'&idusuario='.$usuarios.'&id_folder='.$id_folder);
												
												echo $page;
												
											}
									
									}// fin de si no estan los datos suministrados
								else
									{
										
										return response()->json((['status'=>'error','code'=>201,'message'=>'missing data'])); 
									}
								
							}
						else
							{
								return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
								
							}
							
					}
			}		
		
		
		public function creadoc_csv(Request $request)
		{
			$login= $request->input('login');
			
			$clave= $request->input('password');
			
			$id_tipodoc = $request->input('id_tipodoc');
			
			$id_folder = $request->input('id_folder');
			
			$id_tabla = $request->input('id_tabla');
			
			$id_expediente = $request->input('id_expediente');
			
			//$totalindices = count($request->input('valor'));
			
			//$vidindices = $request->input('indices');
			
			//$valor = $request->input('valor');
			
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
			
			//se procede a guardar en cada tabla correspondientemente
			$ordendoc = 0;
			
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
				
				$usuarios = $user->id;
				
				$idusu = $user->id_rol;
				
				$id_usuario = $idusu;
				
				$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
				
				if ($registroper == true)
				{
					
					if(isset($_FILES['imgarh'])){
						
						//buscamos la lleva de encriptación
						
						$lllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
						
						$kweyllave = $lllave[0]->key_encrypt;
						
						$total = count($_FILES['imgarh']['name']);
						
						$id_usuario = $usuarios;
						
						@session_start();
						
						$espaciotrabajo = $_SESSION['espaciotrabajo'];
						
						$workspace = $_SESSION['espaciotrabajo'];
						
						$file = $request->file('imgarh');
						
						//se guarda el documento
						
						$haydocumetn = DB::select('select id_documento from sgd_documentos  where id_documento = 0 and id_expediente = '.$id_expediente.' and id_tipodocumental = '.$id_tipodoc.' and id_tabla = '.$id_tabla.' and id_folder = '.$id_folder);
						
						if (count($haydocumetn) == 0)
						{
							//se registran los datos
							// primero el documento
							
							DB::table('sgd_documentos')->insert(
									array(
											'id_expediente'     	=>  $id_expediente,
											'id_tipodocumental'   	=>  $id_tipodoc,
											'id_usuario' 			=>	$id_usuario,
											'id_tabla' 				=> 	$id_tabla,
											'id_folder' 			=>	$id_folder,
											'id_estado'				=> 	1,
											'orden' 				=>	$ordendoc,
											'created_at'			=> date("Y-m-d H:m:s")
									)
									);
							
							//se captura el ultimo id registrado
							
							$regdocumento = Documento::all();
							
							$iddocumento = $regdocumento->last();
							
							$iddocumento = $iddocumento->id_documento;
							
							//se registran los valores indices
							/*
							for ( $i = 0 ; $i < $totalindices ; $i ++)
							{
								$valord = $valor[$i];
								
								if ($i == 0)
								{
									$elvalorb = $valord;
								}
								
								DB::table('sgd_valorindice')->insert(
										array(
												'id_documento'     	=>  $iddocumento,
												'id_indice'   		=>  $vidindices[$i],
												'valor' 			=>	$valord,
												'id_estado'			=> 	1,
												'created_at'		=> date("Y-m-d H:m:s")
										)
										);
								
								
							}*/
							
							$id_documento = $iddocumento;
							
							if ($total > 1)
								{
									//se manda a procesar
									
									
									
									$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
									
									if (count($lbodega) == 0)
										{
											//se verifica si es la primera bodega
											$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
											
											if (count($cbod) == 0)
												{
													//se genera la primera bodega
													
													DB::table('sgd_bodegas')->insert(
															array(
																	'nombre'     	=>  'Bodega_1',
																	'limite'   		=>  1000,
																	'actual' 		=>	1,
																	'id_estado' 	=> 	1,
																	'created_at'	=> date("Y-m-d H:m:s")
															)
															);
													
													$nombreb = 'Bodega_1';
													
													$limiteb = 1000;
													
													$actualb = 0;
													
													$regbodega = Bodega::all();
													
													$idbodega = $regbodega->last();
													
													$idbodega = $idbodega->id_bodega;
													
												}
											else
												{
													
													//se busca la ultima bodega para continuar el control
													$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
													
													$dbod = $cbod[0]->nombre;
													
													$nombreb = explode("_".$dbod);
													
													$nombreb = ($nombreb[1]*1) + 1;
													
													$nombreb = 'Bodega_'.$nombreb;
													
													$limiteb = 1000;
													
													$actualb = 0;
													
													//se registra la nueva bodega
													
													DB::table('sgd_bodegas')->insert(
															array(
																	'nombre'     	=>  $nombreb,
																	'limite'   		=>  1000,
																	'actual' 		=>	1,
																	'id_estado' 	=> 	1,
																	'created_at'	=> date("Y-m-d H:m:s")
															)
															);
													
													$regbodega = Bodega::all();
													
													$idbodega = $regbodega->last();
													
													$idbodega = $idbodega->id_bodega;
													
												}
										}
									else
										{
											//existe una bodega desocupada
											
											$idbodega = $lbodega[0]->id_bodega;
											
											$nombreb = $lbodega[0]->nombre;
											
											$limiteb = $lbodega[0]->limite;
											
											$actualb = $lbodega[0]->actual;
											
										}
									/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
									
									unset($vimagenesup);
									
									for($i=0; $i<$total; $i++) {
										
										$tmpFilePath = '';
										
										$nombrear = '';
										
										//Get the temp file path
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];
										
										$nombrear = $_FILES['imgarh']['name'][$i];
										$actualb = $actualb + 1;
										
										if ($actualb > $limiteb) //se genera una nueva bodega
											{
												
												$nombreb = explode("_".$nombreb);
												
												$nombreb = ($nombreb[1]*1) + 1;
												
												$nombreb = 'Bodega_'.$nombreb;
												
												$limiteb = 1000;
												
												$actualb = 1;
												
												//se registra la nueva bodega
												
												DB::table('sgd_bodegas')->insert(
														array(
																'nombre'     	=>  $nombreb,
																'limite'   		=>  1000,
																'actual' 		=>	1,
																'id_estado' 	=> 	1,
																'created_at'	=> date("Y-m-d H:m:s")
														)
														);
												
												$regbodega = Bodega::all();
												
												$idbodega = $regbodega->last();
												
												$idbodega = $idbodega->id_bodega;
												
											}
										else
											{
												//se acutaliza el valor de documentos actuales en la tabla bodega
												
												DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
												->update(['actual' => $actualb]);
												
											}
										
										//Get the temp file path
										
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][$i];
										
										$nombrear1 = $_FILES['imgarh']['name'][$i];
										
										$nombrear2 = explode('.',$nombrear1);
										
										$nombrear = $nombrear2[0];
										
										$file_ext = strtolower($nombrear2[1]);
										
										$norden = 0;
										
										if ($file_ext == 'zip' and $file_ext == 'ZIP' )
											{
												$dir = public_path('img/tempo/'.$espaciotrabajo);
												
												if (!file_exists($dir))
													{
														mkdir($dir, 0777, true);
													}
												
												$imageName =  $_FILES['imgarh']['name'][$i];
												
												$nombrear2 = explode('.',$imageName);
												
												$nombrear = $nombrear2[0];
												
												$file_ext = strtolower($nombrear2[1]);
												
												$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);
												
												//se mueven los archivos hacia el storage respectivo
												
												$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip_csv&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento.'&id_tipodoc='.$id_tipodoc);
												
												echo $page;
												
											}
										
									}// fin del  for
									
									
									
									return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$total,'imagenes' =>$vimagenesup]));
								}
							else
								{
									///un solo archivo
									if ($total == 1)
									{
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];
										
										$nombrear = $_FILES['imgarh']['name'][0];
										
										//se manda a procesar
										
										$lbodega = DB::select('select id_bodega,nombre,limite,actual from sgd_bodegas  where actual < limite');
										
										
										if (count($lbodega) == 0)
										{
											//se verifica si es la primera bodega
											$cbod = DB::select('select id_bodega from sgd_bodegas  where id_bodega > 0');
											
											if (count($cbod) == 0)
											{
												//se genera la primera bodega
												
												DB::table('sgd_bodegas')->insert(
														array(
																'nombre'     	=>  'Bodega_1',
																'limite'   		=>  1000,
																'actual' 		=>	1,
																'id_estado' 	=> 	1,
																'created_at'			=> date("Y-m-d H:m:s")
														)
														);
												
												$nombreb = 'Bodega_1';
												
												$limiteb = 1000;
												
												$actualb = 0;
												
												$regbodega = Bodega::all();
												
												$idbodega = $regbodega->last();
												
												$idbodega = $idbodega->id_bodega;
												
											}
											else
											{
												
												//se busca la ultima bodega para continuar el control
												$cbod = DB::select('select nombre from sgd_bodegas  where id_bodega > 0 ORDER BY id DESC LIMIT 1');
												
												$dbod = $cbod[0]->nombre;
												
												$nombreb = explode("_".$dbod);
												
												$nombreb = ($nombreb[1]*1) + 1;
												
												$nombreb = 'Bodega_'.$nombreb;
												
												$limiteb = 1000;
												
												$actualb = 0;
												
												//se registra la nueva bodega
												
												DB::table('sgd_bodegas')->insert(
														array(
																'nombre'     	=>  $nombreb,
																'limite'   		=>  1000,
																'actual' 		=>	1,
																'id_estado' 	=> 	1,
																'created_at'			=> date("Y-m-d H:m:s")
														)
														);
												
												$regbodega = Bodega::all();
												
												$idbodega = $regbodega->last();
												
												$idbodega = $idbodega->id_bodega;
												
											}
										}
										else
										{
											//existe una bodega desocupada
											
											$idbodega = $lbodega[0]->id_bodega;
											
											$nombreb = $lbodega[0]->nombre;
											
											$limiteb = $lbodega[0]->limite;
											
											$actualb = $lbodega[0]->actual;
											
										}
										/////////////////////////////////////////////////// fin del calculo de los datos de bodega///////////////////////////////////
										
										$actualb = $actualb + 1;
										
										if ($actualb > $limiteb) //se genera una nueva bodega
										{
											
											$nombreb = explode("_".$nombreb);
											
											$nombreb = ($nombreb[1]*1) + 1;
											
											$nombreb = 'Bodega_'.$nombreb;
											
											$limiteb = 1000;
											
											$actualb = 1;
											
											//se registra la nueva bodega
											
											DB::table('sgd_bodegas')->insert(
													array(
															'nombre'     	=>  $nombreb,
															'limite'   		=>  1000,
															'actual' 		=>	1,
															'id_estado' 	=> 	1,
															'created_at'			=> date("Y-m-d H:m:s")
													)
													);
											
											$regbodega = Bodega::all();
											
											$idbodega = $regbodega->last();
											
											$idbodega = $idbodega->id_bodega;
											
										}
										else
										{
											//se acutaliza el valor de documentos actuales en la tabla bodega
											
											DB::table('sgd_bodegas')->where('id_bodega', '=',$idbodega)
											->update(['actual' => $actualb]);
											
										}
										
										//Get the temp file path
										
										$tmpFilePath = $_FILES['imgarh']['tmp_name'][0];
										
										$nombrear1 = $_FILES['imgarh']['name'][0];
										
										$nombrear2 = explode('.',$nombrear1);
										
										$nombrear = $nombrear2[0];
										
										$file_ext = strtolower($nombrear2[1]);
										
										$norden = 0;
										
										if ($file_ext == 'zip' or $file_ext == 'ZIP' )
											{
												
												$dir = public_path('img/tempo/'.$espaciotrabajo);
												
												if (!file_exists($dir))
													{
														mkdir($dir, 0777, true);
													}
												
												$imageName =  $_FILES['imgarh']['name'][0];
												
												$nombrear2 = explode('.',$imageName);
												
												$nombrear = $nombrear2[0];
												
												$file_ext = strtolower($nombrear2[1]);
												
												$imagemove= $file[0]->move(public_path('img/tempo/'.$espaciotrabajo),$nombrear.'.'.$file_ext);
												
												//se mueven los archivos hacia el storage respectivo
												
												$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=grabastoragezip&configdb='.$configdb.'&workspace='.$workspace.'&nombearc='.$nombrear.'&extarc='.$file_ext.'&nombreb='.$nombreb.'&id_documento='.$id_documento);
												
												echo $page;
											}
										
									}
									
								}
							
							
						}
						
					}//fin de si hay imagen q subir
					else
						{
							return response()->json((['status'=>'error','code'=>201,'message'=>'data error image']));
							
						}
					
				}
				else
				{
					return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					
				}
			}
			else
			{
				
				return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
			}
			
		}
		/* ************************************** */
		
		public function buscarxfecha(Request $request)
		{
			$login= $request->input('login');
		
			$clave= $request->input('password');
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
			
					$idusu = $user->id_rol;
					
					$fecha = $request->input('fecha');
			
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
						
					if ($registroper == true)
						{
							
							$regdoc = DB::select('SELECT id_documento,created_at FROM sgd_documentos WHERE id_documento > 0');  
							$vdocs = array();
							foreach ($regdoc as $datosdoc)
								{
									$dfecha = $datosdoc->created_at;
									$dfecha = explode(" ",$dfecha); 
									
									$f1 = explode("-",$dfecha[0]);
									$f2 = explode("-",$fecha);
									
									if(GregorianToJd($f1[0],$f1[1],$f1[2]) == GregorianToJd($f2[0],$f2[1],$f2[2]))
										{
											$vdocs[] = $datosdoc->id_documento;
										}
								}
								
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$vdocs]));
							
						}
					else
						{
							return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
						}	
				}
			else
				{
					return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
				}	
				
		}	
		
		public function comprimezip(Request $request)
		{
			$login= $request->input('login');
		
			$clave= $request->input('password');
			
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
			
					$usuarios = $user->id;
						
					$idusu = $user->id_rol;
						
					$idimagenes = $request->input('idimagenes');   //dd($idimagenes);
					
					$nomzip = $request->input('nomzip');       // dd($nomzip);
						 
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
			
					if ($registroper == true)
						{
							
							//buscamos la llave de encriptación
								
							$lllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
								
							$kweyllave = $lllave[0]->key_encrypt;
								
							$id_usuario = $usuarios;
							
							@session_start();
							
							$espaciotrabajo = $_SESSION['espaciotrabajo'];
								
							$workspace = $_SESSION['espaciotrabajo'];
							
							$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=comprimezip&configdb='.$configdb.'&workspace='.$workspace.'&idimagenes='.$idimagenes.'&id_usuario='.$id_usuario.'&nomzip='.$nomzip);
								
							echo $page;
						}
						
				}
		}		
		
		public function unepdf(Request $request)
		{
			$login= $request->input('login');
			
			$clave= $request->input('password');
			
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
			
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
					
					$usuarios = $user->id;
					
					$idusu = $user->id_rol;
					
					$idimagenes = $request->input('idimagenes');   
					
					$nompdf = 'pdfunido.pdf';    //$request->input('nompdf');   
					
					
					
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
					
					if ($registroper == true)
						{
							
							//buscamos la llave de encriptación
							
							$lllave = DB::select('select key_encrypt from sgd_encrypt  where id_encrypt > 0 and id_estado = 1');
							
							$kweyllave = $lllave[0]->key_encrypt;
							
							$id_usuario = $usuarios;
							
							@session_start();
							
							$espaciotrabajo = $_SESSION['espaciotrabajo'];
							
							$workspace = $_SESSION['espaciotrabajo'];
							
							$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=unepdf&configdb='.$configdb.'&workspace='.$workspace.'&idimagenes='.$idimagenes.'&id_usuario='.$id_usuario.'&nompdf='.$nompdf);
							
							echo $page;
						}
					
				}
		}
		
		public function listazip(Request $request)
		{
				
			$login = $request->input('login');
				
			$clave = $request->input('password');
		
			$idzip = $request->input('idzip'); 
			
			@session_start();
				
			$espaciotrabajo = $_SESSION['espaciotrabajo'];
			
			$workspace = $_SESSION['espaciotrabajo'];
			
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
		
						
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
				
				$id_usuario = $usuarios;
					
				$registroper = conocepermisosapi('view_doc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
							
						$buscaid = DB::select('SELECT id_imagendocum,id_bodega,extension FROM sgd_imagen_documento WHERE id_imagendocum = '.$idzip); 
						
						$nomzip = $idzip;
						
						$extzip = $buscaid[0]->extension;
						
						$idbodega = $buscaid[0]->id_bodega;
						
						if ($extzip == 'zip')
							{
						
								$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=listazip&configdb='.$configdb.'&workspace='.$workspace.'&id_usuario='.$id_usuario.'&idzip='.$idzip.'&idbodega='.$idbodega);
			
								echo $page;
								
							}
						else
							{
								return response()->json((['status'=>'error','code'=>201,'message'=>'Is not a zip file']));
							}	
							
							
					}
				else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					}
			}
		}
		
		public function extraedelzip(Request $request)
		{
		
			$login = $request->input('login');
		
			$clave = $request->input('password');
		
			$idzip = $request->input('idzip');
			
			$elfile = $request->input('elfile');
				
			@session_start();
		
			$espaciotrabajo = $_SESSION['espaciotrabajo'];
				
			$workspace = $_SESSION['espaciotrabajo'];
				
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
		
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
		
				$id_usuario = $usuarios;
					
				$registroper = conocepermisosapi('view_doc',$usuarios,$idusu);
					
				if ($registroper == true)
				{
						
					$buscaid = DB::select('SELECT id_imagendocum,id_bodega,extension FROM sgd_imagen_documento WHERE id_imagendocum = '.$idzip);
		
					$nomzip = $idzip;
		
					$extzip = $buscaid[0]->extension;
		
					$idbodega = $buscaid[0]->id_bodega;
		
					if ($extzip == 'zip')
					{
		
						$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=extraedelzip&configdb='.$configdb.'&workspace='.$workspace.'&id_usuario='.$id_usuario.'&idzip='.$idzip.'&idbodega='.$idbodega.'&elfile='.$elfile);
							
						echo $page;
		
					}
					else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'Is not a zip file']));
					}
						
						
				}
				else
				{
					return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
				}
			}
		}
		
		public function verdelzip(Request $request)
		{
		
			$login = $request->input('login');
		
			$clave = $request->input('password');
		
			$idzip = $request->input('idzip');
				
			@session_start();
		
			$espaciotrabajo = $_SESSION['espaciotrabajo'];
				
			$workspace = $_SESSION['espaciotrabajo'];
				
			$configdb = sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
					$_SERVER['SERVER_NAME'],
					''
					);
		
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
		
				$id_usuario = $usuarios;
					
				$registroper = conocepermisosapi('view_doc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
							
						$buscaid = DB::select('SELECT id_imagendocum,id_bodega,extension FROM sgd_imagen_documento WHERE id_imagendocum = '.$idzip);
			
						$nomzip = $idzip;
			
						$extzip = $buscaid[0]->extension;
			
						$idbodega = $buscaid[0]->id_bodega;
			
						if ($extzip == 'zip')
							{
				
								$page = file_get_contents($configdb.'/treepowerfile2/cargalo_documentos.php?otraoperation=verdelzip&configdb='.$configdb.'&workspace='.$workspace.'&id_usuario='.$id_usuario.'&idzip='.$idzip.'&idbodega='.$idbodega);
									
								echo $page;
				
							}
						else
							{
								return response()->json((['status'=>'error','code'=>201,'message'=>'Is not a zip file']));
							}
							
							
					}
				else
					{
						return response()->json((['status'=>'error','code'=>201,'message'=>'You do not have permission']));
					}
			}
		}
		
}
