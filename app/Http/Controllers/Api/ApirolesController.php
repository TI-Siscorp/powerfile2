<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



use App\Rol;

class ApirolesController extends Controller
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
				
					$registroper = conocepermisosapi('view_rol',$usuarios,$idusu);
						
					if ($registroper == true)
						{
							$roles = DB::select('select r.id_rol,nombre,descripcion from sgd_rols r,sgd_estados d where r.id_estado = d.id_estado order by nombre asc');
							
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
					
						$usuarios = $user->id;
					
						$idusu = $user->id_rol;
					
						$registroper = conocepermisosapi('add_rol',$usuarios,$idusu);
					
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
								
								$roles = DB::select("select r.id_rol from sgd_rols r where upper(r.nombre) = '".strtoupper($rnombre)."' order by nombre asc");				
								
								if (count($roles) == 0)
									{
									
										$registro = new Rol();
										
										$registro->nombre = $request->input('nombre');
										
										$registro->id_estado = 1;
										
										$registro->save();
										
										$roles= Rol::all();
										
										$idrol = $roles->last();	
										
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
					
						$usuarios = $user->id;
					
						$idusu = $user->id_rol;
						
						$registroper = conocepermisosapi('edit_rol',$usuarios,$idusu);
					
						if ($registroper == true)
							{
								$registro = Rol::findOrFail($id);
								 
								$registro->nombre = $request->input('nombre');
								 
								$registro->save();
								
								$registro = Rol::findOrFail($id);
								
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
					
						$usuarios = $user->id;
					
						$idusu = $user->id_rol;
						
						$registroper = conocepermisosapi('delete_rol',$usuarios,$idusu);
					
						if ($registroper == true)
							{
								
								$registro=Rol::find($id);
									
								$registro->delete();
									
								//se elimina cualquier permiso de ese rol previo
									
								$roles = DB::select('delete from sgd_permiso_rols where id_rol = '.$id);
									
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
				
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
								
							$usuarios = $user->id;
					
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('view_rol',$usuarios,$idusu);
								
							if ($registroper == true)
								{
										
									$roles = DB::select('select r.id_rol,nombre,descripcion from sgd_rols r,sgd_estados d where r.id_estado = d.id_estado  and r.id_rol = '.$id.' order by nombre asc');
										
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
