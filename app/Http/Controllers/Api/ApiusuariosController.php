<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
				 
				$users = DB::select( DB::raw("SELECT * FROM sgd_usuarios WHERE id='$usuarios'"));
		
				$registroper = conocepermisosapi('view_user',$usuarios,$idusu);
					
				if ($registroper == true)
					{
						$tksam = $_SESSION['espaciotrabajo'];
						
						$tksam = md5($tksam);
						
						//$_SESSION['tksam'] = $tksam;
						


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
		
		//$tk = $request->input('tk');
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('view_user',$usuarios,$idusu);
					
				if ($registroper == true)
					{
						//if (maketk() == $tk)
							//{
						
								$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from sgd_usuarios u,sgd_rols r,sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id > 0');
								
							//}	
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
				
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
				
					$usuarios = $user->id;
				
					$idusu = $user->id_rol;
				
					$registroper = conocepermisosapi('add_user',$usuarios,$idusu);
				
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
							
								$regavatar = new Usuario();
							
								$regavatar->name = $request->input('name');
							
								$regavatar->lastname = $request->input('lastname');
							
								$regavatar->cedula = $request->input('cedula');
							
								$regavatar->login = $request->input('loginu');
							
								$regavatar->email = $request->input('email');
							
								$regavatar->password = bcrypt($request->input('passwordu'));
							
								$regavatar->celular = $request->input('celular');
							
								$regavatar->fijo = $request->input('fijo');
							
								$regavatar->direccion = $request->input('direccion');
							
								$regavatar->avatar = '';
							
								$regavatar->id_rol = $request->input('id_rol');
							
								$regavatar->id_estado = 1;
							
								$imagen = $request->file('avatar');
							
								//cambiando el nomnbre del avatar para que no haya conflicto
								$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
							
								$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();
							
								$regavatar->avatar = $nombreavatar;
							
								$imagen->move(public_path().'/img/perfiles/', $nombreavatar);
							
								$regavatar->save();
								
								$regavatar= Usuario::all();
								
								$idus = $regavatar->last();
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'User information ','data'=>$idus]));
							
							
							}
						else
							{
							
								$regavatar = new Usuario();
							
								$regavatar->name = $request->input('name'); //   
							
								$regavatar->lastname = $request->input('lastname');
							
								$regavatar->cedula = $request->input('cedula');
							
								$regavatar->login = $request->input('loginu');
							
								$regavatar->email = $request->input('email');
							
								$regavatar->password = bcrypt($request->input('passwordu'));
							
								$regavatar->celular = $request->input('celular');
							
								$regavatar->fijo = $request->input('fijo');
							
								$regavatar->direccion = $request->input('direccion');
							
								$regavatar->avatar = '';
							
								$regavatar->id_rol = $request->input('id_rol');
							
								$regavatar->id_estado = 1;
							
								$regavatar->save();
								
								$regavatar= Usuario::all();
							
								$idus = $regavatar->last();
								
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
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
					
						$usuarios = $user->id;
					
						$idusu = $user->id_rol;
					
						$registroper = conocepermisosapi('edit_user',$usuarios,$idusu);
					
						if ($registroper == true)
							{
								
								$registro = Usuario::findOrFail($id); 
								
								$dusua = $registro;								
									
								$registro->name = $request->input('name');
									
								$registro->lastname = $request->input('lastname');
									
								$registro->cedula = $request->input('cedula');
									
								$registro->login = $request->input('loginu');
									
								$registro->email = $request->input('email');
									
								$password = $request->input('passwordu');
									
								if ($password != '')
									{
										$registro->password = bcrypt($request->input('password'));
									}
								$registro->celular = $request->input('celular');
									
								$registro->fijo = $request->input('fijo');
									
								$registro->direccion = $request->input('direccion');
									
								if($request->hasFile('avatar'))
									{
									
										$imagen = $request->file('avatar');
									
										//cambiando el nomnbre del avatar para que no haya conflicto
										$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
											
										$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();
									
										$registro->avatar = $nombreavatar;
									
										$imagen->move(public_path().'/img/perfiles/', $nombreavatar);
									}
								
									
								$registro->id_rol = $request->input('id_rol');
									
								$registro->id_estado = 1;
									
								$registro->save();
								
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
					
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
								
							$usuarios = $user->id;
								
							$idusu = $user->id_rol;
								
							$registroper = conocepermisosapi('change_pass',$usuarios,$idusu);
								
							if ($registroper == true)
								{
									$registro = Usuario::findOrFail($id);
									
									$password = $request->input('password_nueva');
									
									if ($password != '')
										{
											$registro->password = bcrypt($request->input('password_nueva'));
											
											$registro->save();
											
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
				
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
								
							$usuarios = $user->id;
					
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('view_user',$usuarios,$idusu);
								
							if ($registroper == true)
								{
										
									$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre,u.direccion,u.celular,u.fijo,u.avatar,u.id_rol from sgd_usuarios u,sgd_rols r,sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id = '.$id);
									
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
							
						$registroper = conocepermisosapi('delete_user',$usuarios,$idusu);
							
						if ($registroper == true)
							{
								$registro=Usuario::find($id);
								
								$registro->delete();
								
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
