<?php

namespace App\Http\Controllers\jlt\Api;use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Tabla;
use App\Usuario;
use App\Expediente;
use App\Folder;
use App\Busqueda_avanzada;

class ApitablasController extends Controller
{
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
						
					$registroper = conocepermisosapi('view_tabla',$usuarios,$idusu,$workspace,$driver);
					
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from '.$workspace.'.sgd_tablas t,'.$workspace.'.sgd_estados e where t.id_estado = e.id_estado order by t.nombre_tabla asc');
								}
							else 
								{
									if ($driver == 'pgsql')
										{
											$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from '.$workspace.'.public.sgd_tablas t,'.$workspace.'.public.sgd_estados e where t.id_estado = e.id_estado order by t.nombre_tabla asc');
										}
								}
				
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tablas])); 
				
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
						
					$registroper = conocepermisosapi('add_tabla',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
								
							$v = \Validator::make($request->all(), [
							
									'nombre_tabla' => 'required',
									'version' => 'required',
									'descripcion' => 'required',
							]);
							
							if ($v->fails())
								{
									return 'false';
								}
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_tablas')->insert(
													array(
															'nombre_tabla'     =>   $request->input('nombre_tabla'),
															'version'     =>   $request->input('version'),
															'descripcion'     =>   $request->input('descripcion'),												
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_tablas')->insert(
														array(
																'nombre_tabla'     =>   $request->input('nombre_tabla'),
																'version'     =>   $request->input('version'),
																'descripcion'     =>   $request->input('descripcion'),
																'id_estado'   =>   1,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
													);
											}
									}
											
								//se captura el id de la nueva tabla para crear su root en la tabla folder
							
								if ($driver != 'pgsql')
									{
									
										$regtabla = DB::select("select id_tabla from ".$workspace.".sgd_tablas where id_tabla > 0  order by id_tabla asc");
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$regtabla = DB::select("select id_tabla from ".$workspace.".public.sgd_tablas where id_tabla > 0  order by id_tabla asc");
											}
									}
								
								$totalreg = count($regtabla);
								
								$idta= $regtabla[($totalreg-1)];
								
								
								//se crea el nodo en la tabla del arbol
								
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_folders')->insert(
														array(
															'nombre'     =>   'root',
															'text'     =>   'root',
															'parent_id'     =>  '0',
															'id_estado'   =>   1,
															'id_tabla'     =>  $idta->id_tabla,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
										
																	
										//se crea el nodo en la tabla del arbol para la busqueda avanzada
										
										DB::table($workspace.'.sgd_busqueda_avanzada')->insert(
													array(
															'nombre'     =>   'root',
															'text'     =>   'root',
															'parent_id'     =>  '0',
															'id_estado'   =>   1,
															'id_tabla'     =>  $idta,
															'id_folder'     =>  $idta->id_tabla,
															'id_usuario'	=> $usuarios,
															'id_tpdoc'	=> 0,
															'id_folder_tpdoc'	=> 0,												
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_folders')->insert(
														array(
																'nombre'     =>   'root',
																'text'     =>   'root',
																'parent_id'     =>  '0',
																'id_estado'   =>   1,
																'id_tabla'     =>  $idta->id_tabla,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
														);
												
												
												//se crea el nodo en la tabla del arbol para la busqueda avanzada
												
												DB::table($workspace.'.public.sgd_busqueda_avanzada')->insert(
														array(
																'nombre'     =>   'root',
																'text'     =>   'root',
																'parent_id'     =>  '0',
																'id_estado'   =>   1,
																'id_tabla'     =>  $idta,
																'id_folder'     =>  $idta->id_tabla,
																'id_usuario'	=> $usuarios,
																'id_tpdoc'	=> 0,
																'id_folder_tpdoc'	=> 0,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
														);
											}
									}
								
																
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idta])); 
							
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
						
						$registroper = conocepermisosapi('edit_tabla',$usuarios,$idusu,$workspace,$driver);
					
						if ($registroper == true)
							{
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_tablas')
											->where('id_tabla', $id)
											->update(array(
													'nombre_tabla' => $request->input('nombre_tabla'),
													'version' => $request->input('version'),
													'descripcion' => $request->input('descripcion'),
													'updated_at' =>	date("Y-m-d H:i:s"),
										));
										
										$registro= DB::select("select * from ".$workspace.".sgd_tablas where id_tabla = ".$id);		
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_tablas')
													->where('id_tabla', $id)
													->update(array(
															'nombre_tabla' => $request->input('nombre_tabla'),
															'version' => $request->input('version'),
															'descripcion' => $request->input('descripcion'),
															'updated_at' =>	date("Y-m-d H:i:s"),
												));
											}
											
										$registro= DB::select("select * from ".$workspace.".public.sgd_tablas where id_tabla = ".$id);		
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
					
						$registroper = conocepermisosapi('delete_tabla',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								if ($driver != 'pgsql')
									{
										$folders = DB::select('delete from '.$workspace.'.sgd_tablas where id_tabla = '.$id);
										
										$registro = Tabla::find($id);
											
										$registro->delete();
											
										//se eliminan las carpeta q pertenezcan a la tabla
											
										$folders = DB::select('delete from '.$workspace.'.sgd_folders where id_tabla = '.$id);
											
										$tablas = DB::select('delete from '.$workspace.'.sgd_dependencias_folders where id_tabla = '.$id);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$folders = DB::select('delete from '.$workspace.'.public.sgd_tablas where id_tabla = '.$id);
												
												$registro = Tabla::find($id);
												
												$registro->delete();
												
												//se eliminan las carpeta q pertenezcan a la tabla
												
												$folders = DB::select('delete from '.$workspace.'.public.sgd_folders where id_tabla = '.$id);
												
												$tablas = DB::select('delete from '.$workspace.'.public.sgd_dependencias_folders where id_tabla = '.$id);
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
			
			public function buscar(Request $request)
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
				
						$registroper = conocepermisosapi('view_tabla',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
					
								if ($driver != 'pgsql')
									{
										$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from '.$workspace.'.sgd_tablas t, '.$workspace.'.sgd_estados e where t.id_estado = e.id_estado and t.id_tabla = '.$id.' order by t.nombre_tabla asc');
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from '.$workspace.'.public.sgd_tablas t, '.$workspace.'.public.sgd_estados e where t.id_estado = e.id_estado and t.id_tabla = '.$id.' order by t.nombre_tabla asc');
											}
									}
					
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tablas]));
					
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
