<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Tipodocumental;


class ApitpdocumentalController extends Controller
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
		
				$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
			
						$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from sgd_tipodocumentales t,sgd_estados d where t.id_estado = d.id_estado order by t.nombre asc');
			
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tiposdocumentales])); 
			
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
		
				$registroper = conocepermisosapi('add_tpdoc',$usuarios,$idusu);
		
				if ($registroper == true)
					{
						$v = \Validator::make($request->all(), [
						
								'nombre' => 'required|max:255',
								//'color' => 'required',
						]);
						if ($v->fails())
							{
								return 'false1';
							}
						
						$registro = new Tipodocumental();
						
						$color = $request->input('color');  
						
						$color = '#'.$color;
						
						$registro->nombre = $request->input('nombre');
						
						$registro->id_estado = 1;
						
						$registro->color = $color;
						
						$registro->descripcion = $request->input('descripcion');
						
						$registro->save();
						
						$tpdid= Tipodocumental::all();
						
						$idtpdoc = $tpdid->last();
						
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idtpdoc])); 	
							
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
		
				$registroper = conocepermisosapi('edit_tpdoc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
						$color = $request->input('color');
						
						$color = '#'.$color;
						
						$registro = Tipodocumental::findOrFail($id);
						
						$registro->nombre = $request->input('nombre');
							
						$registro->id_estado = $request->input('id_estado');
						
						$registro->color = $color;
						
						$registro->id_estado = 1;
						
						$registro->descripcion = $request->input('descripcion');
							
						$registro->save();
							
						$registro = Tipodocumental::findOrFail($id);
						
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
					
				$registroper = conocepermisosapi('delete_tpdoc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
						
						$registro=Tipodocumental::find($id);
						
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
		
				$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu);
					
				if ($registroper == true)
					{
							
						$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from sgd_tipodocumentales t,sgd_estados d where t.id_estado = d.id_estado and t.id_tipodoc = '.$id.' order by t.nombre asc');
							
						return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tiposdocumentales]));
							
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
	
	
	public function buscarind(Request $request)
		{
			$login= $request->input('login');
				
			$clave= $request->input('password');
		
			$id = $request->input('id');
			
			$id_nodo= $request->input('id_nodo');
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
			
					$idusu = $user->id_rol;
			
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
						
					if ($registroper == true)
						{
								
							$indices = DB::select('select itp.id_indice,i.nombre,tpi.nombre as ntipo from sgd_tipodoc_indices itp, sgd_indices i, sgd_tipoindices tpi where itp.id_tipodoc = '.$id." and itp.id_folder = ".$id_nodo." and i.id_indice = itp.id_indice and tpi.id_tipo = i.id_tipo");
								
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
		
		
		public function buscartpdocum(Request $request)
		{
			$login= $request->input('login');
				
			$clave= $request->input('password');
				
			//$tablaid = $request->input('tablaid');
		
			$idnode = $request->input('idnode');
				
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
		
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
					
				$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu);
		
				if ($registroper == true)
				{
					unset($vidtp);
					unset($vntp);
		
					$ddocum = DB::select('select DISTINCT tp.id_tipodoc,n.nombre from sgd_folders_tipodocs tp,sgd_tipodocumentales n where tp.id_folder = '.$idnode.' and n.id_tipodoc = tp.id_tipodoc'); 
		
					return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$ddocum]));
						
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
		
		/*public function buscartpdocum(Request $request)
		 {
		 $login= $request->input('login');
		 	
		 $clave= $request->input('password');
		 	
		 $tablaid = $request->input('tablaid');
		
		 $idnode = $request->input('idnode');
		 	
		 if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
		 {
		 $user = Auth::user();
		
		 $usuarios = $user->id;
		 	
		 $idusu = $user->id_rol;
		 	
		 $registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu);
		
		 if ($registroper == true)
		 {
		 unset($vidtp);
		 unset($vntp);
		
		 $ddocum = DB::select('select DISTINCT tp.id_tipodocumental,n.nombre from sgd_documentos tp,sgd_tipodocumentales n where id_tabla = '.$tablaid." and id_folder = ".$idnode." and n.id_tipodoc = tp.id_tipodocumental");
		
		 return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$ddocum]));
		 	
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
		 }	*/
		
}
