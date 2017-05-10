<?php

namespace App\Http\Controllers\powerfile2\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Folder;

class ApifolderController extends Controller
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
					
					$tablaid= $request->input('tablaid');
			
					$registroper = conocepermisosapi('view_indice',$usuarios,$idusu,$workspace,$driver);
						
					if ($registroper == true)
						{
							if ($driver != 'pgsql')
								{
													
									$folders = DB::select('SELECT * FROM '.$workspace.'.sgd_folders where id_tabla = '.$tablaid);
								}
							else
								{
									if ($driver == 'pgsql')
										{
											
											$folders = DB::select('SELECT * FROM '.$workspace.'.public.sgd_folders where id_tabla = '.$tablaid);
										}
									
								}
							
							foreach($folders as $folder) 
								{
									
									$data[] = $folder;
								}
							
								$itemsByReference = array();   
									
								// Build array of item references:
								foreach($data as $key => &$item) { 
								//	dd($item->id);
								
									$itemsByReference[$item->id] = $item;
									// Children array:
									$itemsByReference[$item->id]->children = array();
									// Empty data class (so that json_encode adds "data: {}" )
									$itemsByReference[$item->id]->data = new \stdClass(); //new StdClass();
								}
								// Set items as children of the relevant parent item.
								foreach($data as $key => &$item)
									if($item->parent_id && isset($itemsByReference[$item->parent_id]))
										$itemsByReference [$item->parent_id]->children[] = $item;
											
										// Remove items that were added to parents elsewhere:
										foreach($data as $key => &$item) {
											if($item->parent_id && isset($itemsByReference[$item->parent_id]))
												unset($data[$key]);
										}
											
											
							$result = $data;
													
							return response()->json((['status'=>'ok','code'=>200,'message'=>'Index information ','data'=>$result]));
							
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
