<?php

namespace App\Http\Controllers\jlt\Api;use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Tipodocumental;


class ApitpdocumentalController extends Controller
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
		
				$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						if ($driver != 'pgsql')
							{
								$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from '.$workspace.'.sgd_tipodocumentales t,'.$workspace.'.sgd_estados d where t.id_estado = d.id_estado order by t.nombre asc');
							}
						else
							{
								if ($driver == 'pgsql')
									{
										$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from '.$workspace.'.public.sgd_tipodocumentales t,'.$workspace.'.public.sgd_estados d where t.id_estado = d.id_estado order by t.nombre asc');
									}
							}
			
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
		
		$workspace = $request->input('workspace');
			
		$driver = verdriver($workspace);   
		
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
		
				$usuarios = $user->id;
		
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('add_tpdoc',$usuarios,$idusu,$workspace,$driver);
		
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
						
							$color = $request->input('color');
							
							$color = '#'.$color;
							
							if ($driver != 'pgsql')
								{
									DB::table($workspace.'.sgd_tipodocumentales')->insert(
											array(
													'nombre'     =>   $request->input('nombre'),
													'color'     =>   $color,
													'descripcion'     =>   $request->input('descripcion'),
													'id_estado'   =>   1,
													'created_at'   =>   date("Y-m-d H:i:s"),
											)
										);
								}
							else 
								{
									if ($driver == 'pgsql')
										{
											DB::table($workspace.'.public.sgd_tipodocumentales')->insert(
													array(
															'nombre'     =>   $request->input('nombre'),
															'color'     =>   $color,
															'descripcion'     =>   $request->input('descripcion'),
															'id_estado'   =>   1,
															'created_at'   =>   date("Y-m-d H:i:s"),
													)
												);
										}
								}
						if ($driver != 'pgsql')
							{
								$regtpdoc = DB::select("select  id_tipodoc from ".$workspace.".sgd_tipodocumentales where  id_tipodoc > 0  order by  id_tipodoc asc");
							}
						else 
							{
								if ($driver == 'pgsql')
									{
										$regtpdoc = DB::select("select  id_tipodoc from ".$workspace.".public.sgd_tipodocumentales where  id_tipodoc > 0  order by  id_tipodoc asc");
									}
							}
						
						$totalreg = count($regtpdoc);
						
						$idtpdoc= $regtpdoc[($totalreg-1)];
						
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
		
		$workspace = $request->input('workspace');
		
		$driver = verdriver($workspace);   
			
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
					
				$usuarios = $user->id;
					
				$idusu = $user->id_rol;
		
				$registroper = conocepermisosapi('edit_tpdoc',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						$color = $request->input('color');
						
						$color = '#'.$color;
						
						if ($driver != 'pgsql')
							{
								DB::table($workspace.'.sgd_tipodocumentales')
									->where('id_tipodoc', $id)
									->update(array(
											'nombre' => $request->input('nombre'),
											'color' => $request->input('color'),
											'descripcion' => $request->input('descripcion'),
											'id_estado' => 1,
											'updated_at' =>	date("Y-m-d H:i:s"),
									));
							}
						else 
							{
								if ($driver == 'pgsql')
									{
										DB::table($workspace.'.public.sgd_tipodocumentales')
											->where('id_tipodoc', $id)
											->update(array(
													'nombre' => $request->input('nombre'),
													'color' => $request->input('color'),
													'descripcion' => $request->input('descripcion'),
													'id_estado' => 1,
													'updated_at' =>	date("Y-m-d H:i:s"),
											));
									}
							}
						if ($driver != 'pgsql')
							{
								$registro= DB::select("select * from ".$workspace.".sgd_tipodocumentales where id_tipodoc = ".$id);
							}	
						else
							{
								if ($driver == 'pgsql')
									{
										$registro= DB::select("select * from ".$workspace.".public.sgd_tipodocumentales where id_tipodoc = ".$id);
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
					
				$registroper = conocepermisosapi('delete_tpdoc',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
						if ($driver != 'pgsql')
							{
						 		DB::select('delete from '.$workspace.'.sgd_tipodocumentales where id_tipodoc = '.$id);
							}	
						else
							{
								if ($driver == 'pgsql')
									{
										DB::select('delete from '.$workspace.'.public.sgd_tipodocumentales where id_tipodoc = '.$id);
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
		
				$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu,$workspace,$driver);
					
				if ($registroper == true)
					{
							
						if ($driver != 'pgsql')
							{
								$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from '.$workspace.'.sgd_tipodocumentales t, '.$workspace.'.sgd_estados d where t.id_estado = d.id_estado and t.id_tipodoc = '.$id.' order by t.nombre asc');
							}
						else 
							{
								if ($driver == 'pgsql')
									{
										$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from '.$workspace.'.public.sgd_tipodocumentales t, '.$workspace.'.public.sgd_estados d where t.id_estado = d.id_estado and t.id_tipodoc = '.$id.' order by t.nombre asc');
									}
							}
							
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
									$indices = DB::select('select itp.id_indice,i.nombre,tpi.nombre as ntipo from '.$workspace.'.sgd_tipodoc_indices itp, '.$workspace.'.sgd_indices i, '.$workspace.'.sgd_tipoindices tpi where itp.id_tipodoc = '.$id." and itp.id_folder = ".$id_nodo." and i.id_indice = itp.id_indice and tpi.id_tipo = i.id_tipo");
								}
							else 
								{
									if ($driver == 'pgsql')
										{
											$indices = DB::select('select itp.id_indice,i.nombre,tpi.nombre as ntipo from '.$workspace.'.public.sgd_tipodoc_indices itp, '.$workspace.'.public.sgd_indices i, '.$workspace.'.public.sgd_tipoindices tpi where itp.id_tipodoc = '.$id." and itp.id_folder = ".$id_nodo." and i.id_indice = itp.id_indice and tpi.id_tipo = i.id_tipo");
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
		
		
		public function buscartpdocum(Request $request)
		{
			$login= $request->input('login');
				
			$clave= $request->input('password');
			
			$workspace = $request->input('workspace');
				
			$driver = verdriver($workspace);   
		
			$idnode = $request->input('idnode');
				
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
			
					$usuarios = $user->id;
						
					$idusu = $user->id_rol;
						
					$registroper = conocepermisosapi('view_tpdoc',$usuarios,$idusu,$workspace,$driver);
			
					if ($registroper == true)
						{
							unset($vidtp);
							unset($vntp);
							
							if ($driver != 'pgsql')
								{
									$ddocum = DB::select('select DISTINCT tp.id_tipodoc,n.nombre from '.$workspace.'.sgd_folders_tipodocs tp, '.$workspace.'.sgd_tipodocumentales n where tp.id_folder = '.$idnode.' and n.id_tipodoc = tp.id_tipodoc');
								}
							else 
								{
									if ($driver == 'pgsql')
										{
											$ddocum = DB::select('select DISTINCT tp.id_tipodoc,n.nombre from '.$workspace.'.public.sgd_folders_tipodocs tp, '.$workspace.'.public.sgd_tipodocumentales n where tp.id_folder = '.$idnode.' and n.id_tipodoc = tp.id_tipodoc');
										}
								}
				
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
