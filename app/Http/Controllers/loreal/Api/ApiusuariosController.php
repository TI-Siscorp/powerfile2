<?php

namespace App\Http\Controllers\loreal\Api;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Usuario;
use App\Rol;
use App\Estado;

class ApiusuariosController extends Controller
{
	public function login(Request $request)
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
				
				if ($driver != 'pgsql')
					{
				 
						$users = DB::select( DB::raw("SELECT * FROM '.$workspace.'.sgd_usuarios WHERE id='$usuarios'"));
						
					}
				else 
					{
						if ($driver == 'pgsql')
							{
								
								$users = DB::select( DB::raw("SELECT * FROM '.$workspace.'.public.sgd_usuarios WHERE id='$usuarios'"));
								
							}
					}	
				$registroper = conocepermisosapi('view_user',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						$tksam = $_SESSION['espaciotrabajo'];
						
						$tksam = md5($tksam);
						
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Correct credentials','token'=>$tksam,'data'=>$users]));
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
		
				$registroper = conocepermisosapi('view_user',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						if ($driver != 'pgsql')
							{
								$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from '.$workspace.'.sgd_usuarios u, '.$workspace.'.sgd_rols r, '.$workspace.'.sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id > 0');
							}
						else 
							{
								if ($driver == 'pgsql')
									{
										$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from '.$workspace.'.public.sgd_usuarios u, '.$workspace.'.public.sgd_rols r, '.$workspace.'.public.sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id > 0');
									}
								
							}	
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Users information ','data'=>$regusuarios]));
			
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
				
					$registroper = conocepermisosapi('add_user',$usuarios,$idusu,$workspace,$driver);
				
					if ($registroper == true)
						{
							
							$v = \Validator::make($request->all(), [
										
									'name' => 'required|max:255',
									'lastname' => 'required|max:255',
									'cedula' => 'required|unique:sgd_usuarios',
									//'login' => 'required|unique:sgd_usuarios',
									'email' => 'required|unique:sgd_usuarios',
									'password' => 'required|min:2',
									'celular' => 'required',
									'fijo' => 'required',
									'id_rol' => 'required',
								
										
							]);
							if ($v->fails())
								{
									return 'false';
								}			
							if($request->hasFile('avatar')) {
								
								$imagen = $request->file('avatar');
								
								//cambiando el nomnbre del avatar para que no haya conflicto
								$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
								
								$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();
								
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_usuarios')->insert(
													array(
															'name'     =>   $request->input('name'),
															'lastname'     =>   $request->input('lastname'),
															'cedula'     =>   $request->input('cedula'),
															'login'     =>   $request->input('loginu'),
															'email'     =>   $request->input('email'),
															'password'     =>   $request->input('passwordu'),
															'fijo'     =>   $request->input('fijo'),
															'direccion'     =>   $request->input('direccion'),
															'avatar'     =>   $nombreavatar,
															'id_rol'     =>   $request->input('id_rol'),
															'celular'     =>   $request->input('celular'),
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_usuarios')->insert(
														array(
																'name'     =>   $request->input('name'),
																'lastname'     =>   $request->input('lastname'),
																'cedula'     =>   $request->input('cedula'),
																'login'     =>   $request->input('loginu'),
																'email'     =>   $request->input('email'),
																'password'     =>   $request->input('passwordu'),
																'fijo'     =>   $request->input('fijo'),
																'direccion'     =>   $request->input('direccion'),
																'avatar'     =>   $nombreavatar,
																'id_rol'     =>   $request->input('id_rol'),
																'celular'     =>   $request->input('celular'),
																'id_estado'   =>   1,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
													);
											}	
									}
										
								$imagen->move(public_path().'/img/perfiles/', $nombreavatar);
								
								$regus = DB::select("select  id from ".$workspace.".sgd_usuarios where  id > 0  order by  id asc");
								
								$totalreg = count($regus);
								
								$idus= $regus[($totalreg-1)];
																
								return response()->json((['status'=>'ok','code'=>200,'message'=>'User information ','data'=>$idus]));
							
							
							}
						else
							{
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_usuarios')->insert(
													array(
															'name'     =>   $request->input('name'),
															'lastname'     =>   $request->input('lastname'),
															'cedula'     =>   $request->input('cedula'),
															'login'     =>   $request->input('loginu'),
															'email'     =>   $request->input('email'),
															'password'     =>   $request->input('passwordu'),
															'fijo'     =>   $request->input('fijo'),
															'direccion'     =>   $request->input('direccion'),
															'avatar'     =>   '',
															'id_rol'     =>   $request->input('id_rol'),
															'celular'     =>   $request->input('celular'),
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_usuarios')->insert(
														array(
																'name'     =>   $request->input('name'),
																'lastname'     =>   $request->input('lastname'),
																'cedula'     =>   $request->input('cedula'),
																'login'     =>   $request->input('loginu'),
																'email'     =>   $request->input('email'),
																'password'     =>   $request->input('passwordu'),
																'fijo'     =>   $request->input('fijo'),
																'direccion'     =>   $request->input('direccion'),
																'avatar'     =>   '',
																'id_rol'     =>   $request->input('id_rol'),
																'celular'     =>   $request->input('celular'),
																'id_estado'   =>   1,
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
														);
											}
										
									}
								if ($driver != 'pgsql')
									{
										$regus = DB::select("select  id from ".$workspace.".sgd_usuarios where  id > 0  order by  id asc");
									}
								else
									{
										if ($driver == 'pgsql')
											{
												
												$regus = DB::select("select  id from ".$workspace.".public.sgd_usuarios where  id > 0  order by  id asc");
												
											}
									}	
									
								$totalreg = count($regus);
								
								$idus= $regus[($totalreg-1)];
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'User information ','data'=>$idus]));
							
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
				
				@session_start();
				
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
					
						$registroper = conocepermisosapi('edit_user',$usuarios,$idusu,$workspace,$driver);
					
						if ($registroper == true)
							{
								
								$password = $request->input('passwordu');
								if ($password != '')
									{
										$mpassword = bcrypt($request->input('password'));
									}
									
								if($request->hasFile('avatar'))
									{
										
										$imagen = $request->file('avatar');
										
										//cambiando el nomnbre del avatar para que no haya conflicto
										$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
										
										$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();
										
										$imagen->move(public_path().'/img/perfiles/', $nombreavatar);
									}
									
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_usuarios')
												->where('id', $id)
												->update(array(
														'name' => $request->input('name'),
														'lastname' => $request->input('lastname'),
														'cedula' => $request->input('cedula'),
														'login' => $request->input('loginu'),
														'email' => $request->input('email'),
														'password' => $mpassword,
														'celular' => $request->input('celular'),
														'fijo' => $request->input('fijo'),
														'direccion' => $request->input('direccion'),
														'avatar' => $nombreavatar,
														'id_rol' => $request->input('id_rol'),
														'id_estado' => 1,
														'updated_at' =>	date("Y-m-d H:i:s"),
												));
									}
								else 
									{
										
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_usuarios')
													->where('id', $id)
													->update(array(
															'name' => $request->input('name'),
															'lastname' => $request->input('lastname'),
															'cedula' => $request->input('cedula'),
															'login' => $request->input('loginu'),
															'email' => $request->input('email'),
															'password' => $mpassword,
															'celular' => $request->input('celular'),
															'fijo' => $request->input('fijo'),
															'direccion' => $request->input('direccion'),
															'avatar' => $nombreavatar,
															'id_rol' => $request->input('id_rol'),
															'id_estado' => 1,
															'updated_at' =>	date("Y-m-d H:i:s"),
												));
												
											}
									}
								if ($driver != 'pgsql')
									{
										$registro= DB::select("select * from ".$workspace.".sgd_usuarios where id = ".$id);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												$registro= DB::select("select * from ".$workspace.".public.sgd_usuarios where id = ".$id);
											}
									}	
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Updated successfully ']));
																	
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
			
			public function actuclave(Request $request)
				{
					
					
					@session_start();
					
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
								
							$registroper = conocepermisosapi('change_pass',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
									
									$password = $request->input('password_nueva');
									
									if ($password != '')
										{
											
											$nclave = $password;
											
											if ($driver != 'pgsql')
												{
											
													DB::table($workspace.'.sgd_usuarios')
															->where('id', $id)
															->update(array(
																	'password' => $nclave,
																	'updated_at' =>	date("Y-m-d H:i:s"),
															));
												}
											else
												{
													if ($driver == 'pgsql')
														{
															DB::table($workspace.'.public.sgd_usuarios')
																	->where('id', $id)
																	->update(array(
																			'password' => $nclave,
																			'updated_at' =>	date("Y-m-d H:i:s"),
																	));
														}
													
												}
										   return response()->json((['status'=>'ok','code'=>200,'message'=>'Updated successfully ']));
										}
									else 
										{
											return response()->json((['status'=>'error','code'=>203,'message'=>'No data']));
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
					
							$registroper = conocepermisosapi('view_user',$usuarios,$idusu,$workspace,$driver);
								
							if ($registroper == true)
								{
										
									if ($driver != 'pgsql')
										{
											$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from '.$workspace.'.sgd_usuarios u, '.$workspace.'.sgd_rols r, '.$workspace.'.sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id = '.$id);
										}
									else
										{
											if ($driver == 'pgsql')
												{
													$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from '.$workspace.'.public.sgd_usuarios u, '.$workspace.'.public.sgd_rols r, '.$workspace.'.public.sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id = '.$id);
												}
										}
									
									return response()->json((['status'=>'ok','code'=>200,'message'=>'User information ','data'=>$regusuarios])); 
										
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
							
						$registroper = conocepermisosapi('delete_user',$usuarios,$idusu,$workspace,$driver);
							
						if ($registroper == true)
							{
								if ($driver != 'pgsql')
									{
										DB::select('delete from '.$workspace.'.sgd_usuarios where id = '.$id);
									}
								else 
									{
										if ($driver == 'pgsql')
											{
												DB::select('delete from '.$workspace.'.public.sgd_usuarios where id = '.$id);
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
						return response()->json((['status'=>'error','code'=>202,'message'=>'Invalid data']));
					}	
			}
				
			
}
