<?php

namespace App\Http\Controllers\loreal\Api;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Indice;

class ApiindicesController extends Controller
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
		
				$registroper = conocepermisosapi('view_indice',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						if ($driver != 'pgsql')
							{
								$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from '.$workspace.'.sgd_indices i, '.$workspace.'.sgd_estados d, '.$workspace.'.sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo order by i.nombre asc');
							}
						else
							{
								if ($driver == 'pgsql')
									{
										$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from '.$workspace.'.public.sgd_indices i, '.$workspace.'.public.sgd_estados d, '.$workspace.'.public.sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo order by i.nombre asc');
									}
							}
			
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$indices]));
			
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
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
		
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
		
				$registroper = conocepermisosapi('add_indice',$usuarios,$idusu,$workspace,$driver);
		
				if ($registroper == true)
					{
						$v = \Validator::make($request->all(), [
						
								'nombre' => 'required|max:255',
								'id_tipo' => 'required',
								'orden' => 'required',
						]);
						if ($v->fails())
							{
								return response()->json((['status'=>'error','code'=>203,'message'=>'missing data']));
							}
							
						$vkey = array();
						
						$vvalor = array();
						
						unset($vkey);
						
						unset($vvalor);
						
						$ntipo = $request->input('ntipo');  
						
						$ntipo = strtoupper($ntipo);
						
						if ($ntipo == 'LISTA' or $ntipo == 'LISTAS')
							{
			
								$itemk = $request->input('key');
								
								$itemv = $request->input('valor');
								
								$itemk = explode(",",$itemk);
								
								$itemv = explode(",",$itemv);
								
								$totalitem = count($itemk);
								
								for ( $i = 0 ; $i < $totalitem ; $i ++)
									{
										$vkey[] = $itemk[$i];
										$vvalor[] = $itemv[$i];
									}
								//el guardado es dif para poder guardar el json de la lista en el campo pertinente
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_indices')->insert(
													array(
															'nombre'     =>   $request->input('nombre'),
															'id_tipo'   =>  $request->input('id_tipo'),
															'orden'   =>   $request->input('orden'),
															'descripcion'   => $request->input('descripcion'),
															'id_estado'   =>   1,
															'delistakey' => json_encode($vkey),
															'delistavalor' => json_encode($vvalor),
															'created_at'   =>   date("Y-m-d H:i:s"),
													)										
												);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_indices')->insert(
														array(
																'nombre'     =>   $request->input('nombre'),
																'id_tipo'   =>  $request->input('id_tipo'),
																'orden'   =>   $request->input('orden'),
																'descripcion'   => $request->input('descripcion'),
																'id_estado'   =>   1,
																'delistakey' => json_encode($vkey),
																'delistavalor' => json_encode($vvalor),
																'created_at'   =>   date("Y-m-d H:i:s"),
														)
														);
											}
									}
									
							}
						else
							{
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_indices')->insert(
													array(
															'nombre'     =>   $request->input('nombre'),
															'id_tipo'   =>  $request->input('id_tipo'),
															'orden'   =>   $request->input('orden'),
															'descripcion'   => $request->input('descripcion'),
															'id_estado'   =>   1,
															'delistakey' => null,
															'delistavalor' => null,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_indices')->insert(
															array(
																	'nombre'     =>   $request->input('nombre'),
																	'id_tipo'   =>  $request->input('id_tipo'),
																	'orden'   =>   $request->input('orden'),
																	'descripcion'   => $request->input('descripcion'),
																	'id_estado'   =>   1,
																	'delistakey' => null,
																	'delistavalor' => null,
																	'created_at'   =>   date("Y-m-d H:i:s"),
															)
														);
											}
									}
							}
						if ($driver != 'pgsql')
							{
								$regindice = DB::select("select id_indice from ".$workspace.".sgd_indices where id_indice > 0  order by id_indice asc");
							}
						else
							{
								if ($driver == 'pgsql')
									{
										$regindice = DB::select("select id_indice from ".$workspace.".public.sgd_indices where id_indice > 0  order by id_indice asc");
									}
							}
						
						$totalreg = count($regindice);
						
						$idind[] = $regindice[($totalreg-1)]->id_indice;
						
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idind]));
						
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
		
				$registroper = conocepermisosapi('edit_indice',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						$registro = Indice::findOrFail($id);
						
						unset($vkey);
						unset($vvalor);
						
						$ntipo = $request->input('ntipo');
						$ntipo = strtoupper($ntipo);
						if ($ntipo == 'LISTA' or $ntipo == 'LISTAS')
							{
								$itemk = $request->input('key');
								
								$itemv = $request->input('valor');
								
								$itemk = explode(",",$itemk);
								
								$itemv = explode(",",$itemv);
								
								$totalitem = count($itemk);
								
								for ( $i = 0 ; $i < $totalitem ; $i ++)
									{
										$vkey[] = $itemk[$i];
										$vvalor[] = $itemv[$i];
									}
								//el guardado es dif para poder guardar el json de la lista en el campo pertinente
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_indices')
											->where('id_indice', $id)
											->update(array(
													'nombre' => $request->input('nombre'),
													'id_tipo' => $request->input('id_tipo'),
													'id_estado' => 1,
													'orden' => $request->input('orden'),
													'descripcion' => $request->input('descripcion'),
													'delistakey' => json_encode($vkey),
													'delistavalor' => json_encode($vvalor),											
													'updated_at' =>	date("Y-m-d H:i:s"),
											));
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_indices')
													->where('id_indice', $id)
													->update(array(
															'nombre' => $request->input('nombre'),
															'id_tipo' => $request->input('id_tipo'),
															'id_estado' => 1,
															'orden' => $request->input('orden'),
															'descripcion' => $request->input('descripcion'),
															'delistakey' => json_encode($vkey),
															'delistavalor' => json_encode($vvalor),
															'updated_at' =>	date("Y-m-d H:i:s"),
													));
											}
									}
									
									
								////////////////
							
							}
						else
							{
								if ($driver != 'pgsql')
									{
										DB::table($workspace.'.sgd_indices')
										->where('id_indice', $id)
										->update(array(
												'nombre' => $request->input('nombre'),
												'id_tipo' => $request->input('id_tipo'),
												'id_estado' => 1,
												'orden' => $request->input('orden'),
												'descripcion' => $request->input('descripcion'),
												'delistakey' => null,
												'delistavalor' => null,
												'updated_at' =>	date("Y-m-d H:i:s"),
										));
									}
								else
									{
										if ($driver == 'pgsql')
											{
												DB::table($workspace.'.public.sgd_indices')
													->where('id_indice', $id)
													->update(array(
															'nombre' => $request->input('nombre'),
															'id_tipo' => $request->input('id_tipo'),
															'id_estado' => 1,
															'orden' => $request->input('orden'),
															'descripcion' => $request->input('descripcion'),
															'delistakey' => null,
															'delistavalor' => null,
															'updated_at' =>	date("Y-m-d H:i:s"),
													));
											}
									}
								
								
							}
						if ($driver != 'pgsql')
							{
								$registro= DB::select("select * from ".$workspace.".sgd_indices where id_indice = ".$id);
							}
						else
							{
								if ($driver == 'pgsql')
									{
										$registro= DB::select("select * from ".$workspace.".public.sgd_indices where id_indice = ".$id);
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
					
				$registroper = conocepermisosapi('delete_indice',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						if ($driver != 'pgsql')
							{
								$registro= DB::select('delete from '.$workspace.'.sgd_indices where id_indice = '.$id);
							}
						else
							{
								if ($driver == 'pgsql')
									{
										$registro= DB::select('delete from '.$workspace.'.public.sgd_indices where id_indice = '.$id);
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
								$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from '.$workspace.'.sgd_indices i, '.$workspace.'.sgd_estados d, '.$workspace.'.sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo and id_indice = '.$id.' order by i.nombre asc');
							}
						else 
							{
								if ($driver == 'pgsql')
									{
										$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from '.$workspace.'.public.sgd_indices i, '.$workspace.'.public.sgd_estados d, '.$workspace.'.public.sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo and id_indice = '.$id.' order by i.nombre asc');
									}
							}
							
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$indices]));
							
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

