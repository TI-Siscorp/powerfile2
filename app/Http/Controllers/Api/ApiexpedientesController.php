<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Usuario;
use App\Expediente;
use App\Tabla;
use App\Busqueda_avanzada;
use App\Busqueda;

class ApiexpedientesController extends Controller
{
	
	protected function permisofolder_tabladepuserxfolder($id_folder,$tablaid,$idusuario){
	
		$idfolder = $id_folder;
	
		$idtabla = $tablaid;
	
		// se verifica que la dependencia y la tabla esten permisadas
	
		$regisimg = DB::select("select count(id_dependen_folder) as tpermiso FROM sgd_dependencias_folders WHERE id_folder = ".$idfolder." and id_tabla = ".$idtabla." and id_usuario = ".$idusuario);
	
		if ($regisimg[0]->tpermiso > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function ver(Request $request)
		{
			$login= $request->input('login');
			
			$clave= $request->input('password');
						
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
				
					$usuarios = $user->id;
				
					$idusu = $user->id_rol;
				
					$registroper = conocepermisosapi('view_exp',$usuarios,$idusu);
				
					if ($registroper == true)
						{
							$expedientes = DB::select('select d.id_expediente,d.nombre,e.descripcion as nestado,t.nombre_tabla,t.id_tabla from sgd_expedientes d,sgd_estados e,sgd_tablas t where d.id_estado = e.id_estado and d.id_tabla = t.id_tabla order by d.nombre asc');
							
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$expedientes]));
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
		
			$buscar= $request->input('buscar');
		
			if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
			
					$usuarios = $user->id;
					
					$idusuario = $usuarios; //
			
					$idusu = $user->id_rol;
			
					$registroper = conocepermisosapi('view_exp',$usuarios,$idusu);
			
					if ($registroper == true)
						{
				
							if ($buscar == '_;_')
								{
								
									$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental  group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
										
								}
							else
								{
									if ($buscar != '%')
										{
									
											$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_tipodocumentales tp,sgd_folders f where  (upper(vi.valor) like '%".strtoupper($buscar)."%' or upper(f.nombre) like '%".strtoupper($buscar)."%' or upper(tp.nombre) like '%".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and f.id = ft.id_folder and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
									
										}
									else
										{
									
											$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft,sgd_tipodocumentales tp,sgd_folders f  where  (upper(vi.valor) like '%\\".strtoupper($buscar)."%' or upper(f.nombre) like '%\\".strtoupper($buscar)."%' or upper(tp.nombre) like '%\\".strtoupper($buscar)."%' or upper(e.nombre) like '%".strtoupper($buscar)."%') and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
										}
								}
								
								//se registra la palabra de busqueda
								
								
								
								$regebusquedas = new Busqueda();
								
								$regebusquedas->id_usuario = $idusuario;  //dd($idusuario);
								
								if ($buscar == '_;_')
									{
									
										$regebusquedas->busqueda = '';
									
									}
								else
									{
										$regebusquedas->busqueda = $buscar;
									}
								$regebusquedas->id_estado = 1;
								
								$regebusquedas->save();
							
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$expedientes]));
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
		
		
		public function buscar_ind(Request $request)
			{
			
				$login= $request->input('login');
				
				$clave= $request->input('password');
				
				$iddoc= $request->input('iddoc');
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
				{
					$user = Auth::user();
						
					$usuarios = $user->id;
						
					$idusu = $user->id_rol;
						
					$registroper = conocepermisosapi('view_exp',$usuarios,$idusu);
						
					if ($registroper == true)
						{
							
							$regisindices = DB::select("select vi.id_indice,i.nombre,vi.valor from sgd_valorindice vi,sgd_indices i where i.id_indice = vi.id_indice and vi.id_documento = ".$iddoc);
							
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$regisindices]));
							
						}
				}		
			}
		
		
		
		public function buscar_avanzada(Request $request)
			{
			
				$login= $request->input('login');
				
				$clave= $request->input('password');
				
				if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
							
						$usuarios = $user->id;
						
						$idusuario  = $usuarios;
							
						$idusu = $user->id_rol;
							
						$registroper = conocepermisosapi('view_exp',$usuarios,$idusu);
							
						if ($registroper == true)
							{
								$tabla= $request->input('id_tabla');
								
								if ($tabla == 0)
									{
										//se busca la primera tabla existente
											
										$tablaid = Tabla::all();
											
										$id = $tablaid->first();
											
										$id = $id->id_tabla;
											
										$tablas = Tabla::find($id);
											
										$tablaid = $id;
									}
								else
									{
										$id = $tabla;
											
										$tablas = Tabla::find($id);
											
										$tablaid = $tabla;
									}
								//se limpia el arbol avanzado para ese usuario
								
								$limpiaarbol_avan = DB::select('delete from sgd_busqueda_avanzada where id_usuario = '.$idusuario);
								
								//se construye con las ramificaciones actualizadas
								
								$folderppal  = DB::select('select * from sgd_folders where id_tabla = '.$tablaid);								
								
								foreach ($folderppal as $datofolder) {
								
									//se verifica la permisologia de la dependancia y usuario para poder armar el arbol avanzado
								
									$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id,$tablaid,$idusuario);
								
									if ($permiso_folder == true)
										{
									
											$regnodo = new Busqueda_avanzada();
												
											$regnodo->id_usuario = $idusuario;
									
											$regnodo->nombre = $datofolder->nombre;
									
											$regnodo->text = $datofolder->text;
									
											$regnodo->parent_id = $datofolder->parent_id;
									
											$regnodo->id_estado = $datofolder->id_estado;
									
											$regnodo->id_tabla = $datofolder->id_tabla;
									
											$regnodo->id_folder = $datofolder->id;
												
											$regnodo->save();
										}
								}
								
								//se organiza el arbol avanzado
								
								$folderavan  = DB::select('select * from sgd_busqueda_avanzada where id_usuario = '.$idusuario);
								
								foreach ($folderavan as $datofolder) {
								
								
									$folderactu  = DB::select("update sgd_busqueda_avanzada set parent_id = ".$datofolder->id." where id_usuario = ".$idusuario." and parent_id = '".$datofolder->id_folder."'");
								
								
								}
								
								//se crean las ramas de los tipos documentales
								$folderavan  = DB::select("select * from sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_folder > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
								
								foreach ($folderavan as $datofolder) {
								
									$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id_folder,$tablaid,$idusuario);
								
									if ($permiso_folder == true)
									{
											
										$foldetpdoc  = DB::select("select tpd.id_tipodoc,tpd.nombre,ftp.id_folder from sgd_folders_tipodocs ftp,sgd_tipodocumentales tpd where ftp.id_folder = ".$datofolder->id_folder." and tpd.id_tipodoc = ftp.id_tipodoc");
											
										foreach ($foldetpdoc as $datotpdoc) {
								
											$permiso_folder = $this->permisofolder_tabladepuserxfolder($datotpdoc->id_folder,$tablaid,$idusuario);
								
											if ($permiso_folder == true)
											{
								
												$regnodo = new Busqueda_avanzada();
								
												$regnodo->id_usuario = $idusuario;
													
												$regnodo->nombre = $datotpdoc->nombre;
													
												$regnodo->text = $datotpdoc->nombre;
													
												$regnodo->parent_id = $datofolder->id;
													
												$regnodo->id_estado = 1;
													
												$regnodo->id_tabla = $tablaid;
													
												$regnodo->id_folder = 0;
								
												$regnodo->id_folder_tpdoc = $datofolder->id_folder;
													
												$regnodo->id_tpdoc = $datotpdoc->id_tipodoc;
													
												$regnodo->save();
								
											}
										}
									}
								
								}
								
								//se crean las ramas de los expediente-documentos por cada tipo documental
								
								$folderavan  = DB::select("select * from sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
								
								foreach ($folderavan as $datotpdoc) {
								
									$foldetpdocid  = DB::select("SELECT e.id_expediente,e.nombre,d.id_documento FROM sgd_expedientes e,sgd_documentos d WHERE d.id_tipodocumental = ".$datotpdoc->id_tpdoc." and d.id_folder = ".$datotpdoc->id_folder_tpdoc." and d.id_tabla = ".$tablaid." and d.id_estado = 1 and d.id_expediente = e.id_expediente order by e.id_expediente asc");
								
								
								
									foreach ($foldetpdocid as $datodocid) {
								
										$folderxdocxind  = DB::select("SELECT i.nombre as inombre,vi.valor  FROM sgd_indices i,sgd_valorindice vi WHERE i.id_indice = vi.id_indice and vi.id_documento = ".$datodocid->id_documento." and  vi.id_estado = 1 ");
											
										$regnodo = new Busqueda_avanzada();
											
										$regnodo->id_usuario = $idusuario;
											
										if (count($folderxdocxind) > 1)
										{
											$regnodo->nombre = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor.' - '.$folderxdocxind[1]->inombre.': '. $folderxdocxind[1]->valor;
								
											$regnodo->text = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor.' - '.$folderxdocxind[1]->inombre.': '. $folderxdocxind[1]->valor;
										}
										else
										{
											$regnodo->nombre = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor;
								
											$regnodo->text = $folderxdocxind[0]->inombre.': '. $folderxdocxind[0]->valor;
								
										}
											
										$regnodo->parent_id = $datotpdoc->id;
											
										$regnodo->id_estado = 1;
											
										$regnodo->id_tabla = $tablaid;
											
										$regnodo->id_folder = 0;
											
										$regnodo->id_folder_tpdoc = $datotpdoc->id_folder;
											
										$regnodo->id_tpdoc = $datotpdoc->id_tpdoc;
											
										$regnodo->save();
								
									}
								
								}
								
								$datosavanzado = DB::select("select * from sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_tpdoc > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
								
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$datosavanzado])); 
								
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
							
						$registroper = conocepermisosapi('add_exp',$usuarios,$idusu);
						
						$idexpediented = array(); 
							
						if ($registroper == true)
							{
			
								$v = \Validator::make($request->all(), [
											
										'nombre' => 'required',
										'id_tabla' => 'required',
								]);
									
								if ($v->fails())
									{
										return 'false';
									}
									
								$espaciotrabajo = $_SESSION['espaciotrabajo'];
									
								$regexpediente = new Expediente();
								
								$regexpediente->id_usuario = $usuarios;
									
								$regexpediente->nombre = $request->input('nombre');
									
								$regexpediente->id_tabla = $request->input('id_tabla');
									
								$regexpediente->id_central = 1;
									
								$regexpediente->spider = 1;
									
								$regexpediente->id_estado = 1;
									
								$regexpediente->save();
									
								$regexpediente= Expediente::all();
									
								$idexpediente = $regexpediente->last();
								
								$idexpediented[] = $idexpediente->id_expediente;								
																	
								return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$idexpediented])); 
								
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
							
						$registroper = conocepermisosapi('edit_exp',$usuarios,$idusu);   
							
						if ($registroper == true)
							{
																
								$registro = Expediente::findOrFail($id);
									
								$registro->nombre = $request->input('nombre');
								
								$registro->id_tabla = $request->input('id_tabla');
								
								$registro->save();
								
								$registro = Expediente::findOrFail($id);
								
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
								
							$registroper = conocepermisosapi('delete_exp',$usuarios,$idusu);
								
							if ($registroper == true)
								{
									// se verifica que el expediente no tenga documentos
										
									$documentos = DB::select('select id_documento from sgd_documentos where id_expediente = '.$id);
										
									if (count($documentos) == 0)
										{
											$registro=Expediente::find($id);
												
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
					
				}
				
				public function buscarxfecha(Request $request)
				{
					$login= $request->input('login');
				
					$clave= $request->input('password');
				
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
					{
						$user = Auth::user();
				
						$usuarios = $user->id;
							
						$idusu = $user->id_rol;
							
						$fecha = $request->input('fecha');
							
						$registroper = conocepermisosapi('view_indice',$usuarios,$idusu);
				
						if ($registroper == true)
						{
								
							$regdoc = DB::select('SELECT id_expediente,created_at FROM sgd_expedientes WHERE id_expediente > 0');
							$vdocs = array();
							foreach ($regdoc as $datosdoc)
							{
								$dfecha = $datosdoc->created_at;
								$dfecha = explode(" ",$dfecha);
									
								$f1 = explode("-",$dfecha[0]);
								$f2 = explode("-",$fecha);
									
								if(GregorianToJd($f1[0],$f1[1],$f1[2]) == GregorianToJd($f2[0],$f2[1],$f2[2]))
								{
									$vdocs[] = $datosdoc->id_expediente;
								}
							}
				
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information','data'=>$vdocs]));
								
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
				
				public function reportabuscar(Request $request)
				{
						
					$login= $request->input('login');
						
					$clave= $request->input('password');
						
					if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
						{
							$user = Auth::user();
					
							$usuarios = $user->id;
					
							$idusu = $user->id_rol;
					
							$registroper = conocepermisosapi('search_report',$usuarios,$idusu);
					
							if ($registroper == true)
								{
					
									$regbusca = DB::select('SELECT count(id_busqueda) as totalbusqueda,busqueda FROM sgd_busquedas WHERE id_busqueda > 0 GROUP BY  busqueda');
									
									dd($regbusca);
									
								}
						}
				}		
		
				
				
}
