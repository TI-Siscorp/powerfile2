<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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
	
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
					
				if ($registroper == true)
					{
			
						$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from sgd_indices i,sgd_estados d,sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo order by i.nombre asc');
			
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
			
		@session_start();
			
		$login= $request->input('login');
			
		$clave= $request->input('password');
			
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
		
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('add_indice',$usuarios,$idusu);
		
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
								$registro = new Indice;
								$registro->nombre = $request->input('nombre');
								$registro->id_tipo = $request->input('id_tipo'); 
								$registro->id_estado = 1;
								$registro->orden = $request->input('orden');
								$registro->descripcion = $request->input('descripcion');
								//se convierte el arreglo de datos a un un json para ser guardado en la tabla
								$registro->delistakey = json_encode($vkey);
								$registro->delistavalor = json_encode($vvalor);
								////////////////
								$registro->save();
							}
						else
							{
								$registro = new Indice;
								$registro->nombre = $request->input('nombre');
								$registro->id_tipo = $request->input('id_tipo');
								$registro->id_estado = 1;
								$registro->orden = $request->input('orden');
								$registro->descripcion = $request->input('descripcion');
								//se convierte el arreglo de datos a un un json para ser guardado en la tabla
								$registro->delistakey = null;
								$registro->delistavalor = null;
								
								////////////////
								$registro->save();
							}
							
						$registro= Indice::all();
							
						$idind = $registro->last();
						
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
			
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{	
				$user = Auth::user();
					
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('edit_indice',$usuarios,$idusu);
					
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
								$registro->nombre = $request->input('nombre');
								$registro->id_tipo = $request->input('id_tipo');
								$registro->id_estado = 1;
								$registro->orden = $request->input('orden');
								$registro->descripcion = $request->input('descripcion');
								//se convierte el arreglo de datos a un un json para ser guardado en la tabla
								$registro->delistakey = json_encode($vkey);
								$registro->delistavalor = json_encode($vvalor);
								////////////////
							
							}
						else
							{
								$registro->nombre = $request->input('nombre');
								$registro->id_tipo = $request->input('id_tipo');
								$registro->id_estado = 1;
								$registro->orden = $request->input('orden');
								$registro->descripcion = $request->input('descripcion');
								$registro->delistakey = null;
								$registro->delistavalor = null;
							}
						$registro->save();
						
						$registro = Indice::findOrFail($id);
						
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
					
				$registroper = conocepermisosapi('delete_indice',$usuarios,$idusu);
					
				if ($registroper == true)
					{
						$registro=Indice::find($id);
						
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
							
						$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from sgd_indices i,sgd_estados d,sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo and id_indice = '.$id.' order by i.nombre asc');
							
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

