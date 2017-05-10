<?php

namespace App\Http\Controllers\loreal\Api;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Usuario;
use App\Expediente;
use App\Tabla;
use App\Busqueda_avanzada;
use App\Busqueda;

class ApiexpedientesController extends Controller
{
	
	protected function permisofolder_tabladepuserxfolder($id_folder,$tablaid,$idusuario,$workspace,$driver){
	
		$idfolder = $id_folder;
	
		$idtabla = $tablaid;
	
		// se verifica que la dependencia y la tabla esten permisadas
		
		if ($driver != 'pgsql')
			{
	
				$regisimg = DB::select("select count(id_dependen_folder) as tpermiso FROM ".$workspace.".sgd_dependencias_folders WHERE id_folder = ".$idfolder." and id_tabla = ".$idtabla." and id_usuario = ".$idusuario);
				
			}
		else
			{
				if ($driver == 'pgsql')
					{
						
						$regisimg = DB::select("select count(id_dependen_folder) as tpermiso FROM ".$workspace.".public.sgd_dependencias_folders WHERE id_folder = ".$idfolder." and id_tabla = ".$idtabla." and id_usuario = ".$idusuario);
						
					}
			}
	
		if ($regisimg[0]->tpermiso > 0)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
	
	public function ver(Request $request)
		{
			$login= $request->input('login');
			
			$clave= $request->input('password');
			
			$workspace = $request->input('workspace'); 
			
			$driver = verdriver($workspace);
						
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
				
					$usuarios = $user->id;
				
					$idusu = $user->id_rol;
				
					$registroper = conocepermisosapi('view_exp',$usuarios,$idusu,$workspace,$driver); 
				
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$expedientes = DB::select('select d.id_expediente,d.nombre,e.descripcion as nestado,t.nombre_tabla,t.id_tabla from '.$workspace.'.sgd_expedientes d, '.$workspace.'.sgd_estados e, '.$workspace.'.sgd_tablas t where d.id_estado = e.id_estado and d.id_tabla = t.id_tabla order by d.nombre asc');
								}
							else
								{
									if ($driver == 'pgsql')
										{
											$expedientes = DB::select('select d.id_expediente,d.nombre,e.descripcion as nestado,t.nombre_tabla,t.id_tabla from '.$workspace.'.public.sgd_expedientes d, '.$workspace.'.public.sgd_estados e, '.$workspace.'.public.sgd_tablas t where d.id_estado = e.id_estado and d.id_tabla = t.id_tabla order by d.nombre asc');
										}
								}
														
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$expedientes]));
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
			header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Allow-Origin: *');
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			 
			@session_start();
			
			
			$login= $request->input('login');
		
			$clave= $request->input('password');
		
			$buscar= $request->input('buscar');  
			
			$workspace = $request->input('workspace');   
			
			$driver = verdriver($workspace);
			
			if (trim($buscar) != '')
				{					
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
					
							$usuarios = $user->id;
							
							$idusuario = $usuarios; //
					
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('view_exp',$usuarios,$idusu,$workspace,$driver);  
					
							if ($registroper == true)
								{
						
									if ($buscar == '_;_')
										{
											if ($driver != 'pgsql')
												{
													$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".sgd_valorindice vi, ".$workspace.".sgd_documentos d, ".$workspace.".sgd_expedientes e ,".$workspace.".sgd_folders_tipodocs ft where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental  group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
												}
											else 
												{
													if ($driver == 'pgsql')
														{
															$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".public.sgd_valorindice vi, ".$workspace.".public.sgd_documentos d, ".$workspace.".public.sgd_expedientes e ,".$workspace.".public.sgd_folders_tipodocs ft where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental  group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
														}
												}
												
										}
									else
										{
											if ($buscar != '%')
												{
													if ($driver != 'pgsql')
														{
															$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".sgd_valorindice vi, ".$workspace.".sgd_documentos d, ".$workspace.".sgd_expedientes e ,".$workspace.".sgd_folders_tipodocs ft,".$workspace.".sgd_tipodocumentales tp,".$workspace.".sgd_folders f where  (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and f.id = ft.id_folder and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
														}
													else
														{
															if ($driver == 'pgsql')
																{
																	$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".public.sgd_valorindice vi, ".$workspace.".public.sgd_documentos d, ".$workspace.".public.sgd_expedientes e ,".$workspace.".public.sgd_folders_tipodocs ft,".$workspace.".public.sgd_tipodocumentales tp,".$workspace.".public.sgd_folders f where  (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and f.id = ft.id_folder and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
																}
														}
											
												}
											else
												{
													if ($driver != 'pgsql')
														{
															$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".sgd_valorindice vi, ".$workspace.".sgd_documentos d, ".$workspace.".sgd_expedientes e ,".$workspace.".sgd_folders_tipodocs ft,".$workspace.".sgd_tipodocumentales tp,".$workspace.".sgd_folders f  where  (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
														}
													else
														{
															if ($driver == 'pgsql')
																{
																	$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from ".$workspace.".public.sgd_valorindice vi, ".$workspace.".public.sgd_documentos d, ".$workspace.".public.sgd_expedientes e ,".$workspace.".public.sgd_folders_tipodocs ft,".$workspace.".public.sgd_tipodocumentales tp,".$workspace.".public.sgd_folders f  where  (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
																}
														}
												}
										}
										
										//se registra la palabra de busqueda
										
										return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$expedientes]));
										
										if ($buscar == '_;_')
											{
												
												$sebusca = '';
												
											}
										else
											{
												$sebusca = $buscar;
											}
										
										if ($driver != 'pgsql')
											{
												DB::table($workspace.'.sgd_busquedas')->insert(
															array(
																	'id_usuario'     	=>  $idusuario,
																	'busqueda'   		=>  $sebusca,
																	'id_estado' 	=> 	1,
																	'created_at'	=> date("Y-m-d H:m:s")
															)
														);
											}
										else
											{
												if ($driver == 'pgsql')
													{
														DB::table($workspace.'.public.sgd_busquedas')->insert(
																	array(
																			'id_usuario'     	=>  $idusuario,
																			'busqueda'   		=>  $sebusca,
																			'id_estado' 	=> 	1,
																			'created_at'	=> date("Y-m-d H:m:s")
																	)
																);
													}
											}
										
									
										return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$expedientes]));
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
			else
				{
					return response()->json((['status'=>'error','code'=>201,'message'=>'You must enter some data']));					
				}
		}
		
		
		public function buscar_ind(Request $request)
			{
			
				header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
				header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				header('Access-Control-Allow-Origin: *');
				header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			
				$login= $request->input('login');
				
				$clave= $request->input('password');
				
				$iddoc= $request->input('iddoc');
				
				$workspace = $request->input('workspace'); 
				
				$driver = verdriver($workspace);
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
						
					$idusu = $user->id_rol;
						
					$registroper = conocepermisosapi('view_exp',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$regisindices = DB::select("select vi.id_indice,i.nombre,vi.valor from ".$workspace.".sgd_valorindice vi, ".$workspace.".sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$iddoc);
								}
							else
								{
									if ($driver == 'pgsql')
										{
											$regisindices = DB::select("select vi.id_indice,i.nombre,vi.valor from ".$workspace.".public.sgd_valorindice vi, ".$workspace.".public.sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$iddoc);
										}
								}
							
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$regisindices]));
							
						}
				}		
			}
		
		
		
		public function buscar_avanzada(Request $request)
			{
			
				$login= $request->input('login');
				
				$clave= $request->input('password');
				
				$workspace = $request->input('workspace');
				
				$driver = verdriver($workspace);
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
						
						$idusuario  = $usuarios;
							
						$idusu = $user->id_rol;
							
						$registroper = conocepermisosapi('view_exp',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								$tabla= $request->input('id_tabla');
								
								if ($tabla == 0)
									{
										//se busca la primera tabla existente
										if ($driver != 'pgsql')
											{
												$datostabla  = DB::select('select * from '.$workspace.'.sgd_tablas where id_tabla > 0');
											}
										else
											{
												if ($driver == 'pgsql')
													{
														$datostabla  = DB::select('select * from '.$workspace.'.public.sgd_tablas where id_tabla > 0');
													}
											}
																				
										$id = $datostabla[0]->id_tabla;
										
										$id = $id->id_tabla;
										
										$tablaid = $id;
									}
								else
									{
										$id = $tabla;
											
										$tablaid = $tabla;
									}
									
								//se limpia el arbol avanzado para ese usuario
								if ($driver != 'pgsql')
									{
										$limpiaarbol_avan = DB::select('delete from '.$workspace.'.sgd_busqueda_avanzada where id_usuario = '.$idusuario);
										
										$folderppal  = DB::select('select * from '.$workspace.'.sgd_folders where id_tabla = '.$tablaid);	  	
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$limpiaarbol_avan = DB::select('delete from '.$workspace.'.public.sgd_busqueda_avanzada where id_usuario = '.$idusuario);
												
												$folderppal  = DB::select('select * from '.$workspace.'.public.sgd_folders where id_tabla = '.$tablaid);
											}
									}
											
								//se construye con las ramificaciones actualizadas
								
								foreach ($folderppal as $datofolder) {
								
									//se verifica la permisologia de la dependancia y usuario para poder armar el arbol avanzado
								
									$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id,$tablaid,$idusuario,$workspace,$driver);   
								
									if ($permiso_folder == true)
										{
											
											if ($datofolder->nombre != '')
												{
													
													if ($driver != 'pgsql')
														{
															DB::table($workspace.'.sgd_busqueda_avanzada')->insert(
																		array(
																				'id_usuario'     =>   $idusuario,
																				'nombre'   =>   $datofolder->nombre,
																				'text'   =>   $datofolder->text,
																				'parent_id'   =>  $datofolder->parent_id,
																				'id_estado'   =>   $datofolder->id_estado,
																				'id_tabla'   =>   $datofolder->id_tabla,
																				'id_folder'   =>   $datofolder->id,
																				'created_at'   =>   date("Y-m-d H:i:s"),
																		)
																	);
														}
													else
														{
															if ($driver == 'pgsql')
																{
																	DB::table($workspace.'.public.sgd_busqueda_avanzada')->insert(
																				array(
																						'id_usuario'     =>   $idusuario,
																						'nombre'   =>   $datofolder->nombre,
																						'text'   =>   $datofolder->text,
																						'parent_id'   =>  $datofolder->parent_id,
																						'id_estado'   =>   $datofolder->id_estado,
																						'id_tabla'   =>   $datofolder->id_tabla,
																						'id_folder'   =>   $datofolder->id,
																						'created_at'   =>   date("Y-m-d H:i:s"),
																				)
																			);
																}
														}
												}	
											
										}
								}
								
								//se organiza el arbol avanzado
								if ($driver != 'pgsql')
									{
										$folderavan  = DB::select('select * from '.$workspace.'.sgd_busqueda_avanzada where id_usuario = '.$idusuario);
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$folderavan  = DB::select('select * from '.$workspace.'.public.sgd_busqueda_avanzada where id_usuario = '.$idusuario);
											}
									}
								
								foreach ($folderavan as $datofolder) {
									if ($driver != 'pgsql')
										{
											DB::table($workspace.'.sgd_busqueda_avanzada')
													->where('id_usuario', $idusuario)
													->where('parent_id', $datofolder->id_folder)
													->update(array(
															'parent_id' => $datofolder->id,
															'updated_at' => date("Y-m-d H:i:s"),
															
													));
										}
									else 
										{
											if ($driver == 'pgsql')
												{
													DB::table($workspace.'.public.sgd_busqueda_avanzada')
													->where('id_usuario', $idusuario)
													->where('parent_id', $datofolder->id_folder)
													->update(array(
															'parent_id' => $datofolder->id,
															'updated_at' => date("Y-m-d H:i:s"),
															
													));
												}
										}
								}
								
								//se crean las ramas de los tipos documentales
								if ($driver != 'pgsql')
									{
										$folderavan  = DB::select("select * from ".$workspace.".sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_folder > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$folderavan  = DB::select("select * from ".$workspace.".public.sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_folder > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
											}
									}
								
								foreach ($folderavan as $datofolder) {
								
									$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id_folder,$tablaid,$idusuario,$workspace,$driver);
								
									if ($permiso_folder == true)
									{
										if ($driver != 'pgsql')
											{
												$foldetpdoc  = DB::select("select tpd.id_tipodoc,tpd.nombre,ftp.id_folder from ".$workspace.".sgd_folders_tipodocs ftp, ".$workspace.".sgd_tipodocumentales tpd where ftp.id_folder = ".$datofolder->id_folder." and tpd.id_tipodoc = ftp.id_tipodoc");
											}
										else
											{
												if ($driver == 'pgsql')
													{
														$foldetpdoc  = DB::select("select tpd.id_tipodoc,tpd.nombre,ftp.id_folder from ".$workspace.".public.sgd_folders_tipodocs ftp, ".$workspace.".public.sgd_tipodocumentales tpd where ftp.id_folder = ".$datofolder->id_folder." and tpd.id_tipodoc = ftp.id_tipodoc");
													}
											}
											
										foreach ($foldetpdoc as $datotpdoc) {
								
											$permiso_folder = $this->permisofolder_tabladepuserxfolder($datotpdoc->id_folder,$tablaid,$idusuario,$workspace,$driver);
								
											if ($permiso_folder == true)
											{
								
												
												if ($datotpdoc->nombre!= '')
													{
														if ($driver != 'pgsql')
															{
																DB::table($workspace.'.sgd_busqueda_avanzada')->insert(
																			array(
																					'id_usuario'     =>   $idusuario,
																					'nombre'   =>   $datotpdoc->nombre,
																					'text'   =>   $datotpdoc->nombre,
																					'parent_id'   =>  $datofolder->id,
																					'id_estado'   =>   1,
																					'id_tabla'   =>   $tablaid,
																					'id_folder'   =>   0,
																					'id_folder_tpdoc'   =>   $datofolder->id_folder,
																					'id_tpdoc'   =>   $datotpdoc->id_tipodoc,
																					'created_at'   =>   date("Y-m-d H:i:s"),
																			)
																		);
															}
														else
															{
																
															}
													}	
												
								
											}
										} 
									}
								
								}
								
								//se crean las ramas de los expediente-documentos por cada tipo documental
								
								if ($driver != 'pgsql')
									{
										$folderavan  = DB::select("select * from ".$workspace.".sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$folderavan  = DB::select("select * from ".$workspace.".public.sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
											}
									}
								
								foreach ($folderavan as $datotpdoc) {
								
									if ($driver != 'pgsql')
										{
											$foldetpdocid  = DB::select("SELECT e.id_expediente,e.nombre,d.id_documento FROM ".$workspace.".sgd_expedientes e, ".$workspace.".sgd_documentos d WHERE d.id_tipodocumental = ".$datotpdoc->id_tpdoc." and d.id_folder = ".$datotpdoc->id_folder_tpdoc." and d.id_tabla = ".$tablaid." and d.id_estado = 1 and d.id_expediente = e.id_expediente order by e.id_expediente asc");
										}
									else
										{
											if ($driver == 'pgsql')
												{
													$foldetpdocid  = DB::select("SELECT e.id_expediente,e.nombre,d.id_documento FROM ".$workspace.".public.sgd_expedientes e, ".$workspace.".public.sgd_documentos d WHERE d.id_tipodocumental = ".$datotpdoc->id_tpdoc." and d.id_folder = ".$datotpdoc->id_folder_tpdoc." and d.id_tabla = ".$tablaid." and d.id_estado = 1 and d.id_expediente = e.id_expediente order by e.id_expediente asc");
												}
										}
								
								
								
									foreach ($foldetpdocid as $datodocid) {
								
										if ($driver != 'pgsql')
											{
												$folderxdocxind  = DB::select("SELECT i.nombre as inombre,vi.valor  FROM ".$workspace.".sgd_indices i, ".$workspace.".sgd_valorindice vi WHERE i.id_indice = vi.id_indice and vi.id_documento = ".$datodocid->id_documento." and  vi.id_estado = 1 ");
												
											}
										else
											{
												if ($driver == 'pgsql')
													{
														$folderxdocxind  = DB::select("SELECT i.nombre as inombre,vi.valor  FROM ".$workspace.".public.sgd_indices i, ".$workspace.".public.sgd_valorindice vi WHERE i.id_indice = vi.id_indice and vi.id_documento = ".$datodocid->id_documento." and  vi.id_estado = 1 ");
														
													}
											}
										if (count($folderxdocxind) > 1)
											{
												$nombre = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor.' - '.$folderxdocxind[1]->inombre.': '. $folderxdocxind[1]->valor;
												
												$text = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor.' - '.$folderxdocxind[1]->inombre.': '. $folderxdocxind[1]->valor;
												
											}
										else
											{
												$nombre = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor;
												
												$text = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor;
												
											}
											
											if ($nombre != '')
												{
													if ($driver != 'pgsql')
														{
															DB::table($workspace.'.sgd_busqueda_avanzada')->insert(
																		array(
																				'id_usuario'     =>   $idusuario,
																				'nombre'   =>  $nombre,
																				'text'   =>   $text,
																				'parent_id'   =>  $datotpdoc->id,
																				'id_estado'   =>   1,
																				'id_tabla'   =>   $tablaid,
																				'id_folder'   =>   0,
																				'id_folder_tpdoc'   =>  $datotpdoc->id_folder,
																				'id_tpdoc'   =>   $datotpdoc->id_tpdoc,
																				'created_at'   =>   date("Y-m-d H:i:s"),
																		)
																	);
														}
													else 
														{
															if ($driver == 'pgsql')
																{
																	DB::table($workspace.'.public.sgd_busqueda_avanzada')->insert(
																				array(
																						'id_usuario'     =>   $idusuario,
																						'nombre'   =>  $nombre,
																						'text'   =>   $text,
																						'parent_id'   =>  $datotpdoc->id,
																						'id_estado'   =>   1,
																						'id_tabla'   =>   $tablaid,
																						'id_folder'   =>   0,
																						'id_folder_tpdoc'   =>  $datotpdoc->id_folder,
																						'id_tpdoc'   =>   $datotpdoc->id_tpdoc,
																						'created_at'   =>   date("Y-m-d H:i:s"),
																				)
																			);
																}
														}
												}	
											
											
								
									}
								
								}
								if ($driver != 'pgsql')
									{
										$datosavanzado = DB::select("select * from ".$workspace.".sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$datosavanzado = DB::select("select * from ".$workspace.".public.sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
											}
									}
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$datosavanzado])); 
								
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
		
		public function crear(Request $request)
			{
				@session_start();
				
				$login= $request->input('login');  
				
				$clave= $request->input('password'); 
				
				$workspace = $request->input('workspace');
				
				$driver = verdriver($workspace);
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
						
						$idusuario = $usuarios;
							
						$registroper = conocepermisosapi('add_exp',$usuarios,$idusu,$workspace,$driver);
						
						$idexpediented = array(); 
							
						if ($registroper == true)
							{
			
								$v = \Validator::make($request->all(), [
											
										'nombre' => 'required',
										'id_tabla' => 'required',
								]);
									
								if ($v->fails())
									{
										return 'false';
									}
									
									if ($driver != 'pgsql')
										{
											DB::table($workspace.'.sgd_expedientes')->insert(
														array(
																'id_usuario'     =>   $idusuario,
																'nombre'   =>  $request->input('nombre'),
																'id_tabla'   =>   $request->input('id_tabla'),
																'id_central'   => 1,
																'spider'   =>   1,
																'id_estado'   =>   1,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
													);
										
											$regexpediente= DB::select("select id_expediente from ".$workspace.".sgd_expedientes where id_usuario = ".$idusuario." and id_tabla = ".$request->input('id_tabla')." order by id_expediente asc");
										}
									else
										{
											if ($driver == 'pgsql')
												{
													DB::table($workspace.'.public.sgd_expedientes')->insert(
																array(
																		'id_usuario'     =>   $idusuario,
																		'nombre'   =>  $request->input('nombre'),
																		'id_tabla'   =>   $request->input('id_tabla'),
																		'id_central'   => 1,
																		'spider'   =>   1,
																		'id_estado'   =>   1,
																		'created_at'   =>   date("Y-m-d H:i:s"),
																)
															);
													
													$regexpediente= DB::select("select id_expediente from ".$workspace.".public.sgd_expedientes where id_usuario = ".$idusuario." and id_tabla = ".$request->input('id_tabla')." order by id_expediente asc");
												}
										}
								
								$totalreg = count($regexpediente);
								
								$idexpediented[] = $regexpediente[($totalreg-1)]->id_expediente;
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idexpediented])); 
								
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
		
		public function actualizar(Request $request)
			{
			
				$login= $request->input('login');
				
				$clave= $request->input('password');  
				
				$id = $request->input('id');  
				
				$workspace = $request->input('workspace');
				
				$driver = verdriver($workspace);
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
						
						$idusuario = $usuarios;
							
						$registroper = conocepermisosapi('edit_exp',$usuarios,$idusu,$workspace,$driver);   
							
						if ($registroper == true)
							{
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_expedientes')
												->where('id_expediente', $id)
												->update(array(
															'nombre' => $request->input('nombre'),
															'id_tabla' => $request->input('id_tabla'),
															'updated_at' =>	date("Y-m-d H:i:s"),
														));
													
										$registro= DB::select("select * from ".$workspace.".sgd_expedientes where id_usuario = ".$idusuario." and id_expediente = ".$id);	
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_expedientes')
													->where('id_expediente', $id)
													->update(array(
															'nombre' => $request->input('nombre'),
															'id_tabla' => $request->input('id_tabla'),
															'updated_at' =>	date("Y-m-d H:i:s"),
													));
												
												$registro= DB::select("select * from ".$workspace.".public.sgd_expedientes where id_usuario = ".$idusuario." and id_expediente = ".$id);
											}
									}
								
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$registro]));
								
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
			
			public function borrar(Request $request)
				{
					
					$login= $request->input('login');
					
					$clave= $request->input('password');
					
					$id = $request->input('id');
					
					$workspace = $request->input('workspace');
					
					$driver = verdriver($workspace);
					
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
								
							$usuarios = $user->id;
								
							$idusu = $user->id_rol;
								
							$registroper = conocepermisosapi('delete_exp',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									// se verifica que el expediente no tenga documentos
										
									if ($driver != 'pgsql')
										{
											$documentos = DB::select('select id_documento from '.$workspace.'.sgd_documentos where id_expediente = '.$id);
										}
									else 
										{
											if ($driver == 'pgsql')
												{
													$documentos = DB::select('select id_documento from '.$workspace.'.public.sgd_documentos where id_expediente = '.$id);
												}
										}
										
									if (count($documentos) == 0)
										{
											if ($driver != 'pgsql')
												{
													DB::select('delete from '.$workspace.'.sgd_expedientes where id_expediente = '.$id);
												}
											else
												{
													if ($driver == 'pgsql')
														{
															DB::select('delete from '.$workspace.'.public.sgd_expedientes where id_expediente = '.$id);
														}
													
												}
																								
											return response()->json((['status'=>'ok','code'=>200,'data' =>$id, 'message'=>'Was successfully deleted']));
											
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
					
				}
				
				public function buscarxfecha(Request $request)
				{
					$login= $request->input('login');
				
					$clave= $request->input('password');
					
					$workspace = $request->input('workspace');
					
					$driver = verdriver($workspace);
				
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
				
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
							
						$fecha = $request->input('fecha');
							
						$registroper = conocepermisosapi('view_indice',$usuarios,$idusu,$workspace,$driver);
				
						if ($registroper == true)
						{
								
							if ($driver != 'pgsql')
								{
									$regdoc = DB::select('SELECT id_expediente,created_at FROM '.$workspace.'.sgd_expedientes WHERE id_expediente > 0');
								}
							else 
								{
									if ($driver == 'pgsql')
										{
											$regdoc = DB::select('SELECT id_expediente,created_at FROM '.$workspace.'.public.sgd_expedientes WHERE id_expediente > 0');
										}
								}
							$vdocs = array();
							foreach ($regdoc as $datosdoc)
							{
								$dfecha = $datosdoc->created_at;
								$dfecha = explode(" ",$dfecha);
									
								$f1 = explode("-",$dfecha[0]);
								$f2 = explode("-",$fecha);  
									
								if(GregorianToJd($f1[1],$f1[2],$f1[0]) == GregorianToJd($f2[1],$f2[2],$f2[0]))
									{
										$vdocs[] = $datosdoc->id_expediente;
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
				
				public function reportabuscar(Request $request)
				{
						
					$login= $request->input('login');
						
					$clave= $request->input('password');
					
					$workspace = $request->input('workspace');
					
					$driver = verdriver($workspace);
						
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
					
							$usuarios = $user->id;
					
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('search_report',$usuarios,$idusu,$workspace,$driver);
					
							if ($registroper == true)
								{
					
									if ($driver != 'pgsql')
										{
											$regbusca = DB::select('SELECT count(id_busqueda) as totalbusqueda,busqueda FROM '.$workspace.'.sgd_busquedas WHERE id_busqueda > 0 GROUP BY  busqueda');
										}
									else
										{
											if ($driver == 'pgsql')
												{
													$regbusca = DB::select('SELECT count(id_busqueda) as totalbusqueda,busqueda FROM '.$workspace.'.public.sgd_busquedas WHERE id_busqueda > 0 GROUP BY  busqueda');
												}
										}
									
									return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$regbusca]));
									
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
		
				
				
}
