<?php

namespace App\Http\Controllers\powerfile2\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



use App\Rol;

class ApirolesController extends Controller
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
				
					$registroper = conocepermisosapi('view_rol',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$roles = DB::select('select r.id_rol,nombre,descripcion from '.$workspace.'.sgd_rols r, '.$workspace.'.sgd_estados d where r.id_estado = d.id_estado order by nombre asc');
								}
							else
								{
									if ($driver == 'pgsql')
										{
											$roles = DB::select('select r.id_rol,nombre,descripcion from '.$workspace.'.public.sgd_rols r, '.$workspace.'.public.sgd_estados d where r.id_estado = d.id_estado order by nombre asc');
										}
								}
							
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$roles]));
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
				$login= $request->input('login');
					
				$clave= $request->input('password');
				
				$workspace = $request->input('workspace');
				
				$driver = verdriver($workspace);
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
					
						$usuarios = $user->id;
					
						$idusu = $user->id_rol;
					
						$registroper = conocepermisosapi('add_rol',$usuarios,$idusu,$workspace,$driver);
					
						if ($registroper == true)
							{
								$v = \Validator::make($request->all(), [
											
										'nombre' => 'required|max:255',
										
								]);
								
								if ($v->fails())
									{
										return response()->json((['status'=>'error','code'=>203,'message'=>'missing data']));
									}
									
								//se verifica q no exista ya un rol con ese nombre
								$rnombre = $request->input('nombre');
								
								if ($driver != 'pgsql')
									{
								
										$roles = DB::select("select r.id_rol from ".$workspace.".sgd_rols r where upper(r.nombre) = '".strtoupper($rnombre)."' order by nombre asc");
										
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$roles = DB::select("select r.id_rol from ".$workspace.".public.sgd_rols r where upper(r.nombre) = '".strtoupper($rnombre)."' order by nombre asc");
											}
										
									}	
								if (count($roles) == 0)
									{
										
										if ($driver != 'pgsql')
											{
												DB::table($workspace.'.sgd_rols')->insert(
															array(
																	'nombre'     =>   $request->input('nombre'),
																	'id_estado'   =>   1,
																	'created_at'   =>   date("Y-m-d H:i:s"),
															)
														);
												$regrol = DB::select("select id_rol from ".$workspace.".sgd_rols where id_rol > 0  order by id_rol asc");
											}
										else
											{
												if ($driver == 'pgsql')
													{
														DB::table($workspace.'.public.sgd_rols')->insert(
																	array(
																			'nombre'     =>   $request->input('nombre'),
																			'id_estado'   =>   1,
																			'created_at'   =>   date("Y-m-d H:i:s"),
																	)
																);
														$regrol = DB::select("select id_rol from ".$workspace.".public.sgd_rols where id_rol > 0  order by id_rol asc");
													}
											}
										
										$totalreg = count($regrol);
										
										$idrol[] = $regrol[($totalreg-1)]->id_rol;
										
										return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idrol])); 
									}
								else
									{
										return response()->json((['status'=>'error','code'=>201,'message'=>'It already exists']));
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
						
						$registroper = conocepermisosapi('edit_rol',$usuarios,$idusu,$workspace,$driver);
					
						if ($registroper == true)
							{
								
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_rols')
											->where('id_rol', $id)
											->update(array(
													'nombre' => $request->input('nombre'),
													'updated_at' =>	date("Y-m-d H:i:s"),
											));
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_rols')
													->where('id_rol', $id)
													->update(array(
															'nombre' => $request->input('nombre'),
															'updated_at' =>	date("Y-m-d H:i:s"),
													));
											}
									}
								
								$registro= DB::select("select * from ".$workspace.".sgd_rols where id_rol = ".$id);								
									
								
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
						
						$registroper = conocepermisosapi('delete_rol',$usuarios,$idusu,$workspace,$driver);
					
						if ($registroper == true)
							{
								if ($driver != 'pgsql')
									{
										$registro= DB::select('delete from '.$workspace.'.sgd_rols where id_rol = '.$id);								
																	
										//se elimina cualquier permiso de ese rol previo
											
										$roles = DB::select('delete from '.$workspace.'.sgd_permiso_rols where id_rol = '.$id);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$registro= DB::select('delete from '.$workspace.'.public.sgd_rols where id_rol = '.$id);
												
												//se elimina cualquier permiso de ese rol previo
												
												$roles = DB::select('delete from '.$workspace.'.public.sgd_permiso_rols where id_rol = '.$id);
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
					
							$registroper = conocepermisosapi('view_rol',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									if ($driver != 'pgsql')
										{
											$roles = DB::select('select r.id_rol,nombre,descripcion from '.$workspace.'.sgd_rols r, '.$workspace.'.sgd_estados d where r.id_estado = d.id_estado  and r.id_rol = '.$id.' order by nombre asc');
										}
									else
										{
											if ($driver == 'pgsql')
												{
													$roles = DB::select('select r.id_rol,nombre,descripcion from '.$workspace.'.public.sgd_rols r, '.$workspace.'.public.sgd_estados d where r.id_estado = d.id_estado  and r.id_rol = '.$id.' order by nombre asc');
												}
										}
										
									return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$roles])); 
										
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
