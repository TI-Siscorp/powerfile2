<?php

namespace App\Http\Controllers\jlt\Api;use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Dependencia;

class ApidependenciasController extends Controller
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
			
					$registroper = conocepermisosapi('view_depen',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
									$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from '.$workspace.'.sgd_dependencias d, '.$workspace.'.sgd_estados e where d.id_estado = e.id_estado order by d.descripcion asc');
								}
							else
								{
									if ($driver == 'pgsql')
										{
											$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from '.$workspace.'.public.sgd_dependencias d, '.$workspace.'.public.sgd_estados e where d.id_estado = e.id_estado order by d.descripcion asc');
										}
								}
								
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$dependencias]));
								
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
				
						$registroper = conocepermisosapi('add_depen',$usuarios,$idusu,$workspace,$driver);
				
						if ($registroper == true)
							{
								$v = \Validator::make($request->all(), [
								
										'descripcion' => 'required',
										'codigo_departamento' => 'required|max:255|unique:sgd_dependencias',
								]);
								
								if ($v->fails())
									{
										return response()->json((['status'=>'error','code'=>203,'message'=>'missing data']));
									}
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_dependencias')->insert(
													array(
															'descripcion'     =>   $request->input('descripcion'),
															'codigo_departamento'   =>   $request->input('codigo_departamento'),
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
											
										$registro = DB::select("select * from ".$workspace.".sgd_dependencias where id_dependencia > 0 order by id_dependencia asc");
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_dependencias')->insert(
															array(
																	'descripcion'     =>   $request->input('descripcion'),
																	'codigo_departamento'   =>   $request->input('codigo_departamento'),
																	'id_estado'   =>   1,
																	'created_at'   =>   date("Y-m-d H:i:s"),
															)
														);
												
												$registro = DB::select("select * from ".$workspace.".public.sgd_dependencias where id_dependencia > 0 order by id_dependencia asc");
											}
									}
								
								$totalreg = count($registro);
								
								$iddep[] = $registro[($totalreg-1)];
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$iddep]));								
								
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
					
							$registroper = conocepermisosapi('edit_depen',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									if ($driver != 'pgsql')
										{
											$dependencias = DB::select("select d.id_dependencia from ".$workspace.".sgd_dependencias d where d.codigo_departamento = '".$request->input('codigo_departamento')."'");
										}
									else
										{
											if ($driver == 'pgsql')
												{
													$dependencias = DB::select("select d.id_dependencia from ".$workspace.".public.sgd_dependencias d where d.codigo_departamento = '".$request->input('codigo_departamento')."'");
												}
										}
									
									if (count($dependencias) == 0)
										{	
									
											if ($driver != 'pgsql')
												{
													DB::table($workspace.'.sgd_dependencias')
														->where('id_dependencia', $id)
														->update(array(
																'descripcion' => $request->input('descripcion'),
																'codigo_departamento' => $request->input('codigo_departamento'),
																'updated_at' =>	date("Y-m-d H:i:s"),
														));
													
													$registro = DB::select("select * from ".$workspace.".sgd_dependencias where id_dependencia = ".$id);	
												}
											else
												{
													if ($driver == 'pgsql')
														{
															DB::table($workspace.'.public.sgd_dependencias')
																->where('id_dependencia', $id)
																->update(array(
																		'descripcion' => $request->input('descripcion'),
																		'codigo_departamento' => $request->input('codigo_departamento'),
																		'updated_at' =>	date("Y-m-d H:i:s"),
																));
															
															$registro = DB::select("select * from ".$workspace.".public.sgd_dependencias where id_dependencia = ".$id);
														}
												}
											
											return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$registro]));
											
										}
									else
										{
											
											return response()->json((['status'=>'error','code'=>203,'message'=>'Code already exists']));
											
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
							
						$registroper = conocepermisosapi('delete_indice',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								
								if ($driver != 'pgsql')
									{
										$dependencias = DB::select('delete from '.$workspace.'.sgd_dependencias where id_dependencia = '.$id);
										
										//se eliminan los registros de la tabla sgd_dependencias_folders donde la dependencia sea la eliminada
										
										$dependencias = DB::select('delete from '.$workspace.'.sgd_dependencias_folders where id_dependencia = '.$id);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$dependencias = DB::select('delete from '.$workspace.'.public.sgd_dependencias where id_dependencia = '.$id);
												
												//se eliminan los registros de la tabla sgd_dependencias_folders donde la dependencia sea la eliminada
												
												$dependencias = DB::select('delete from '.$workspace.'.public.sgd_dependencias_folders where id_dependencia = '.$id);
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
				
						$registroper = conocepermisosapi('view_indice',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								
								if ($driver != 'pgsql')
									{
										$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from '.$workspace.'.sgd_dependencias d, '.$workspace.'.sgd_estados e where d.id_estado = e.id_estado and id_dependencia = '.$id.' order by d.descripcion asc');
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from '.$workspace.'.public.sgd_dependencias d, '.$workspace.'.public.sgd_estados e where d.id_estado = e.id_estado and id_dependencia = '.$id.' order by d.descripcion asc');
											}
									}
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$dependencias]));
									
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
