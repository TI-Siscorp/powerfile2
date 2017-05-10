<?php

namespace App\Http\Controllers\jlt\Api;use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Grupo;
use App\Grupo_usuario;

class ApigrupoController extends Controller
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
			
					$registroper = conocepermisosapi('view_grupo',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$grupos = DB::select('select g.id_grupo,g.nombre,d.descripcion from '.$workspace.'.sgd_grupos g, '.$workspace.'.sgd_estados d where g.id_estado = d.id_estado order by g.nombre asc');
								}
							else
								{
									if ($driver == 'pgsql')
										{
											$grupos = DB::select('select g.id_grupo,g.nombre,d.descripcion from '.$workspace.'.public.sgd_grupos g, '.$workspace.'.public.sgd_estados d where g.id_estado = d.id_estado order by g.nombre asc');
										}
								}
								
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$grupos]));
								
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
				
						$registroper = conocepermisosapi('add_grupo',$usuarios,$idusu,$workspace,$driver);
				
						if ($registroper == true)
							{
								$v = \Validator::make($request->all(), [
								
										'nombre' => 'required|max:255',
								]);
									
								if ($v->fails())
									{
										
										return response()->json((['status'=>'error','code'=>203,'message'=>'missing data']));
										
									}
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_grupos')->insert(
													array(
															'nombre'     =>   $request->input('nombre'),
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
										$reggrupo = DB::select("select id_grupo from ".$workspace.".sgd_grupos where id_grupo > 0 order by id_grupo asc");
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_grupos')->insert(
														array(
																'nombre'     =>   $request->input('nombre'),
																'id_estado'   =>   1,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
														);
												$reggrupo = DB::select("select id_grupo from ".$workspace.".public.sgd_grupos where id_grupo > 0 order by id_grupo asc");
											}
									}
								
								
								$totalreg = count($reggrupo);
								
								$idgru[] = $reggrupo[($totalreg-1)]->id_grupo;
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idgru]));
									
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
					
							$registroper = conocepermisosapi('edit_grupo',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									
									if ($driver != 'pgsql')
										{
											DB::table($workspace.'.sgd_grupos')
												->where('id_grupo', $id)
												->update(array(
														'nombre' => $request->input('nombre'),
														'id_estado' => 1,
														'updated_at' =>	date("Y-m-d H:i:s"),
												));
									
											$registro= DB::select("select * from ".$workspace.".sgd_grupos where id_grupo = ".$id);		
										}
									else
										{
											if ($driver == 'pgsql')
												{
													DB::table($workspace.'.public.sgd_grupos')
													->where('id_grupo', $id)
													->update(array(
															'nombre' => $request->input('nombre'),
															'id_estado' => 1,
															'updated_at' =>	date("Y-m-d H:i:s"),
													));
													
													$registro= DB::select("select * from ".$workspace.".public.sgd_grupos where id_grupo = ".$id);
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
								
							$registroper = conocepermisosapi('delete_grupo',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									if ($driver != 'pgsql')
										{
											DB::select('delete from '.$workspace.'.sgd_grupos where id_grupo = '.$id);
										}
									else
										{
											if ($driver == 'pgsql')
												{
													DB::select('delete from '.$workspace.'.public.sgd_grupos where id_grupo = '.$id);
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
				
						$registroper = conocepermisosapi('view_grupo',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
									
								if ($driver != 'pgsql')
									{
										$grupos = DB::select('select g.id_grupo,g.nombre,d.descripcion from '.$workspace.'.sgd_grupos g, '.$workspace.'.sgd_estados d where g.id_estado = d.id_estado and id_grupo = '.$id.' order by g.nombre asc');
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												$grupos = DB::select('select g.id_grupo,g.nombre,d.descripcion from '.$workspace.'.public.sgd_grupos g, '.$workspace.'.public.sgd_estados d where g.id_estado = d.id_estado and id_grupo = '.$id.' order by g.nombre asc');
											}
									}
									
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$grupos]));
									
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
	
			public function update_agrupar(Request $request)  //2,5,1,3	
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
				
						$registroper = conocepermisosapi('agrupa_user',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								
								$usuarios = $request->input('usuarios_grupo');   
								
								$grupoid = $request->input('idgrupo');
								
								$id = $request->input('idgrupo');
																
								//se elimina cualquier permiso agrupamiento de ese grupo
								
								if ($driver != 'pgsql')
									{
									
										$grupos = DB::select('delete from '.$workspace.'.sgd_grupo_usuarios where id_grupo = '.$id);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												
												$grupos = DB::select('delete from '.$workspace.'.public.sgd_grupo_usuarios where id_grupo = '.$id);
											}
									}
								
								//se convierte en arreglo los id de usuarios
								
								if (trim($usuarios) != '')
									{
										$usuarios = explode(",",$usuarios);   
								
										if (count($usuarios) > 0)
											{
												for ($i = 0; $i < count($usuarios); $i++) {
													
													if ($driver != 'pgsql')
														{
																DB::table($workspace.'.sgd_grupo_usuarios')->insert(
																		array(
																				'id_grupo'     =>   $grupoid,
																				'id_usuario' => $usuarios[$i],
																				'created_at'   =>   date("Y-m-d H:i:s"),
																		)
																	);
														}
													else
														{
															if ($driver == 'pgsql')
																{
																	DB::table($workspace.'.public.sgd_grupo_usuarios')->insert(
																			array(
																					'id_grupo'     =>   $grupoid,
																					'id_usuario' => $usuarios[$i],
																					'created_at'   =>   date("Y-m-d H:i:s"),
																			)
																			);
																}
														}
														
												}
												
												return response()->json((['status'=>'ok','code'=>200,'message'=>'Grouped successfully ','data'=>$usuarios,'idgrupo'=>$id]));
												
											}
										else
											{
												return response()->json((['status'=>'error','code'=>203,'message'=>'You have not selected users']));
											}
									
									}
								else
									{
										return response()->json((['status'=>'error','code'=>203,'message'=>'You have not selected users']));
									}
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
			
			
}			