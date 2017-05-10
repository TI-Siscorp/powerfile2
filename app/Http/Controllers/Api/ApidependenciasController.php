<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
			
					$idusu = $user->id_rol;
			
					$registroper = conocepermisosapi('view_depen',$usuarios,$idusu);
						
					if ($registroper == true)
						{
								
							$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from sgd_dependencias d,sgd_estados e where d.id_estado = e.id_estado order by d.descripcion asc');
								
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
				
						$usuarios = $user->id;
				
						$idusu = $user->id_rol;
				
						$registroper = conocepermisosapi('add_depen',$usuarios,$idusu);
				
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
									
								$registro = new Dependencia;
								
								$registro->descripcion = $request->input('descripcion');
								
								$registro->codigo_departamento = $request->input('codigo_departamento');
								
								$registro->id_estado = 1;
								
								$registro->save();
								
								$registro= Dependencia::all();
									
								$iddep = $registro->last();
								
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
						
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
								
							$usuarios = $user->id;
								
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('edit_depen',$usuarios,$idusu);
								
							if ($registroper == true)
								{
									$dependencias = DB::select("select d.id_dependencia from sgd_dependencias d where d.codigo_departamento = '".$request->input('codigo_departamento')."'");
									
									if (count($dependencias) == 0)
										{	
									
											$registro = Dependencia::findOrFail($id);
												
											$registro->descripcion = $request->input('descripcion');
											
											$registro->codigo_departamento = $request->input('codigo_departamento');
												
											$registro->id_estado = 1;
												
											$registro->save();
											
											$registro = Dependencia::findOrFail($id);
											
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
					
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
							
						$registroper = conocepermisosapi('delete_indice',$usuarios,$idusu);
							
						if ($registroper == true)
							{
								$registro=Dependencia::find($id);
								
								$registro->delete();
								
								//se eliminan los registros de la tabla sgd_dependencias_folders donde la dependencia sea la eliminada
								
								$dependencias = DB::select('delete from sgd_dependencias_folders where id_dependencia = '.$id);
								
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
				
						$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
							
						if ($registroper == true)
							{
								
								$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from sgd_dependencias d,sgd_estados e where d.id_estado = e.id_estado and id_dependencia = '.$id.' order by d.descripcion asc');
								
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
