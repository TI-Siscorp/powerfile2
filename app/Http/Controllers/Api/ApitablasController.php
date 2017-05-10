<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Tabla;
use App\Usuario;
use App\Expediente;
use App\Folder;
use App\Busqueda_avanzada;

class ApitablasController extends Controller
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
						
					$registroper = conocepermisosapi('view_tabla',$usuarios,$idusu);
					
					if ($registroper == true)
						{
				
							$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from sgd_tablas t,sgd_estados e where t.id_estado = e.id_estado order by t.nombre_tabla asc');
				
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tablas])); 
				
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
						
					$registroper = conocepermisosapi('add_tabla',$usuarios,$idusu);
						
					if ($registroper == true)
						{
								
							$v = \Validator::make($request->all(), [
							
									'nombre_tabla' => 'required',
									'version' => 'required',
									'descripcion' => 'required',
							]);
							
							if ($v->fails())
								{
									return 'false';
								}
								
								$registro = new Tabla();
								
								$registro->nombre_tabla = $request->input('nombre_tabla'); 
								
								$registro->version = $request->input('version');
								
								$registro->descripcion = $request->input('descripcion');
								
								$registro->id_estado = 1;
								
								$registro->save();
								
								//se captura el id de la nueva tabla para crear su root en la tabla folder
								
								$tablas= Tabla::all();
								
								$idta = $tablas->last();
								
								//se crea el nodo en la tabla del arbol
								$registro = new Folder();
								
								$registro->nombre = 'root';
								
								$registro->text = 'root';
								
								$registro->parent_id = '0';
								
								$registro->id_tabla = $idta->id_tabla;
								
								$registro->id_estado = 1;
								
								$registro->save();
								
								//se crea el nodo en la tabla del arbol para la busqueda avanzada
								$registro = new Busqueda_avanzada();
								
								$registro->nombre = 'root';
								
								$registro->text = 'root';
								
								$registro->parent_id = '0';
								
								$registro->id_tabla = $idta->id_tabla;
								
								$registro->id_estado = 1;
								
								$registro->id_folder = $idta->id_tabla;
								
								$registro->id_usuario = $usuarios;
								
								$registro->id_tpdoc = 0;
								
								$registro->id_folder_tpdoc = 0;
								
								$registro->save();		
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idta])); 
							
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
						
						$registroper = conocepermisosapi('edit_tabla',$usuarios,$idusu);
					
						if ($registroper == true)
							{
								$registro = Tabla::findOrFail($id);
									
								$registro->nombre_tabla = $request->input('nombre_tabla');
									
								$registro->version = $request->input('version');
									
								$registro->descripcion = $request->input('descripcion');
									
								$registro->save();
																		
								$registro = Tabla::findOrFail($id);
								
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
					
						$registroper = conocepermisosapi('delete_tabla',$usuarios,$idusu);
							
						if ($registroper == true)
							{
								$registro = Tabla::find($id);
									
								$registro->delete();
									
								//se eliminan las carpeta q pertenezcan a la tabla
									
								$folders = DB::select('delete from sgd_folders where id_tabla = '.$id);
									
								$tablas = DB::select('delete from sgd_dependencias_folders where id_tabla = '.$id);
									
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
				
						$registroper = conocepermisosapi('view_tabla',$usuarios,$idusu);
							
						if ($registroper == true)
							{
					
								$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from sgd_tablas t,sgd_estados e where t.id_estado = e.id_estado and t.id_tabla = '.$id.' order by t.nombre_tabla asc');
					
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$tablas]));
					
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
