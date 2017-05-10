<?php

namespace App\Http\Controllers\loreal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use File;


use Carbon\Carbon;
use App\Expediente;
use App\Tabla;
use App\Estado;
use App\Central;
use App\Documento;
use App\Valorindice;
use App\Imagendocumento;
use App\Tipoindice;
use App\Busqueda_avanzada;
use App\Busqueda;


class ExpedientesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 *
	 * @return void
	 */
	
	protected function permisofolder_tabladepuserxfolder($id_folder,$tablaid){
		
		$idusuario = Session::get('id_usuario');
		
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
	
	
	
	
	public function index(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$expedientes = DB::select('select d.id_expediente,d.nombre,e.descripcion as nestado,t.nombre_tabla,t.id_tabla from sgd_expedientes d,sgd_estados e,sgd_tablas t where d.id_estado = e.id_estado and d.id_tabla = t.id_tabla order by d.nombre asc');
		
		return view('expedientes.index',compact('expedientes'))->with('i', ($request->input('page', 1) - 1) * 5);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		$estados = Estado::pluck('descripcion', 'id_estado');
		
		$tablas = Tabla::pluck('nombre_tabla', 'id_tabla');
		
		$central = Central::pluck('nombre', 'id_central');
		
		return view('expedientes.create')->with(['estados'=>$estados,'tablas'=>$tablas,'central'=>$central]);//->with('estados',$estados);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		@session_start();
		
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$v = \Validator::make($request->all(), [
				
				'nombre' => 'required',
				'id_tabla' => 'required',
				'id_central' => 'required',
				'spider' => 'required',
				'id_estado' => 'required',
		]);
		
		if ($v->fails())
		{
			Session::put('mensajeerror',trans("principal.msgeditexpeind"));
			return redirect()->back();
		}
		
		$espaciotrabajo = $_SESSION['espaciotrabajo'];
		
		$regexpediente = new Expediente();
		
		$id_usuario = Session::get('id_usuario');
		
		$regexpediente->id_usuario = $id_usuario;
		
		$regexpediente->nombre = $request->input('nombre');
		
		$regexpediente->id_tabla = $request->input('id_tabla');
		
		$regexpediente->id_central = $request->input('id_central');
		
		$regexpediente->spider = $request->input('spider');
		
		$regexpediente->id_estado = $request->input('id_estado');
		
		$regexpediente->save();
		
		$regexpediente= Expediente::all();
		
		$idexpediente = $regexpediente->last();
		
		//\Session::flash('flash_message', 'Mensaje de prueba');
		
		Session::put('mensaje',trans("principal.msgexitoexpe"));
		
		return redirect()->route('expedientes.documentos',[$idexpediente,$request->input('id_tabla')]);
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		
		
	}
	
	public function actualizar(Request $request, $id)
	{
		//Update Query
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		unset($vkey);
		unset($vvalor);
		
		
		
		$iddocumento = $request->input('id_documentoind');
		
		$valor = $request->input('valor');
		
		$id_indices = $request->input('id_indices');
		
		$vidindices = explode("_;_",$id_indices);
		
		$id_usuario = $request->input('id_usuario');
		
		$id_tipodoc = $request->input('id_tipodocind');
		
		$id_folder = $request->input('id_folderind');
		
		$id_tabla = $request->input('id_tablaind');
		
		$id_expediente = $request->input('id_expedienteind');
		
		$totalind = count($vidindices);
		
		$totalind = $totalind - 1;
		
		//se eliminan los indices de ese documento
		
		DB::table('sgd_valorindice')->where('id_documento', '=', $iddocumento)->delete();
		
		//$losindices = DB::select('delete from sgd_valorindice where id_documento = '.$iddocumento);
		
		//se registran los valores de los indices
		for ( $i = 0 ; $i < $totalind ; $i ++)
		{
			$regeindices = new Valorindice();
			
			$regeindices->id_documento = $iddocumento;
			
			$regeindices->id_indice = $vidindices[$i];
			
			$regeindices->valor = $valor[$i];
			
			$regeindices->id_estado = 1;
			
			$regeindices->save();
			
		}
		
		Session::put('mensaje',trans("principal.msgeditexpeind"));
		
		return redirect()->back();
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		// se verifica que el expediente no tenga documentos
		
		$documentos = DB::select('select id_documento from sgd_documentos where id_expediente = '.$id);
		
		if (count($documentos) == 0)
		{
			
			$registro=Expediente::find($id);
			
			$registro->delete();
			
			Session::put('mensaje',trans("principal.msgelimexpe"));
		}
		else
		{
			Session::put('mensajeerror',trans("principal.msgelimexpeerror"));
		}
		
		return redirect()->route('expedientes.index');
	}
	
	
	public function documentos(Request $request, $id,$idtabla){
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		$expedientes = Expediente::find($id);
		
		$tablaid = $idtabla;
		
		$expedid = $id;
		
		$id_usuario = Session::get('id_usuario');
		
		return view('expedientes.estructura',compact('expedientes'))->with(['expedientes'=>$expedientes,'tablaid'=>$tablaid,'expedid'=>$expedid,'id_usuario'=>$id_usuario]);
		
	}
	
	public function visor(Request $request, $buscar)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		$buscar = str_replace('_..._', '%', $buscar);
		
		
		if ($buscar == '_;_')
		{
			
			//$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental  group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
			
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
		
		//////////
		$idusuario = Session::get('id_usuario');
		
		//se registra la palabra de busqueda
		
		$regebusquedas = new Busqueda();
		
		$regebusquedas->id_usuario = $idusuario;
		
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
		
		//dd($buscar);
		
		if ($buscar != '_;_')
		{
			return view('expedientes.visor',compact('expedientes'))->with(['buscar'=>$buscar,'idusuario'=>$idusuario]);
		}
		else
		{
			return back();
			
		}
		
	}
	
	public function visor_lista(Request $request, $buscar)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		
		$buscar = str_replace('_..._', '%', $buscar);
		///
		//buscamos la coincidencia
		
		if ($buscar == '_;_')
		{
			
			//$expedientes = DB::select("SELECT distinct vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental from sgd_valorindice vi, sgd_documentos d, sgd_expedientes e ,sgd_folders_tipodocs ft where vi.valor <> '' and d.id_documento = vi.id_documento and e.id_expediente = d.id_expediente and ft.id_tipodoc = d.id_tipodocumental  group by vi.id_documento,e.id_expediente,e.nombre,d.id_tipodocumental order by e.id_expediente asc");
			
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
		
		
		$idusuario = Session::get('id_usuario');
		
		$registrousuarios = DB::select("SELECT u.name,u.lastname,u.id,u.avatar FROM sgd_usuarios u WHERE u.id > 0 and u.id <> ".$idusuario);
		
		
		//se registra la palabra de busqueda
		
		$regebusquedas = new Busqueda();
		
		$regebusquedas->id_usuario = $idusuario;
		
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
		
		if ($buscar != '_;_')
		{
			return view('expedientes.visor_lista',compact('expedientes'))->with('i',['buscar'=>$buscar,'idusuario'=>$idusuario,'registrousuarios'=>$registrousuarios,($request->input('page', 1) - 1) * 5]);
		}
		else
		{
			
			return back();
		}
		
	}
	
	public function comparteloya(Request $request)
	{
		
		$id_eenviara =  $request->input('compartidos');
		
		$iddocumento = $request->input('iddocumento');
		
		$ruta = $request->input('ruta');
		
		$buscar = $request->input('buscar');
		
		if ($buscar == '')
		{
			
			$buscar = '_;_';
		}
		
		//se guarda en la tabla de notificacion a usuarios x documentos
		if ($id_eenviara != '')
		{
			
			$id_eenviara = explode(",",$id_eenviara);
			
			$totalidenvias = count($id_eenviara);
			
			//$totalidenvias = $totalidenvias - 1;
			
			for ( $i = 0 ; $i < $totalidenvias ; $i ++)
			{
				
				DB::table('sgd_notificacion_usuarios')->insert(
						array(
								'id_documento'     	=>  $iddocumento,
								'id_usuario'   		=>  $id_eenviara[$i],
								'id_estado' 	=> 	1,
								'created_at'	=> date("Y-m-d H:m:s")
						)
						);
			}
			
		}
		
		Session::put('mensaje',trans("principal.msgcompartedoc"));
		
		return redirect()->route('expedientes.visor_lista',['buscar'=>$buscar]);
	}
	public function visor_arbol(Request $request, $buscar,$tabla)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		$idusuario = Session::get('id_usuario');
		
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
		
		$lastablas = Tabla::pluck('nombre_tabla', 'id_tabla');
		
		$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre from sgd_tipodocumentales t where t.id_tipodoc > 0 order by t.nombre asc');
		
		$tira = "";
		for ($i = 0; $i < count($tiposdocumentales); $i++) {
			$tira .= $tiposdocumentales[$i]->id_tipodoc."_,_".$tiposdocumentales[$i]->nombre.'_;_' ;
		}
		
		
		$tiposdocumentales = $tira;
		
		$estados = Estado::pluck('descripcion', 'id_estado');
		
		$tipos = Tipoindice::pluck('nombre', 'id_tipo');
		
		//se limpia el arbol avanzado para ese usuario
		
		
		DB::table('sgd_busqueda_avanzada')->where('id_usuario', '=', $id)->delete();
		
		
		//$limpiaarbol_avan = DB::select('delete from sgd_busqueda_avanzada where id_usuario = '.$idusuario); // print_r($tipos);
		
		//se construye con las ramificaciones actualizadas
		
		$folderppal  = DB::select('select * from sgd_folders where id_tabla = '.$tablaid);
		
		foreach ($folderppal as $datofolder) {
			
			//se verifica la permisologia de la dependancia y usuario para poder armar el arbol avanzado
			
			$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id,$tablaid);
			
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
		
		$folderavan  = DB::select('select * from sgd_busqueda_avanzada where id_usuario = '.$idusuario);  //dd($folderavan);
		
		foreach ($folderavan as $datofolder) {
			
			
			//$folderactu  = DB::select("update sgd_busqueda_avanzada set parent_id = ".$datofolder->id." where id_usuario = ".$idusuario." and parent_id = '".$datofolder->id_folder."'");
			
			DB::table('sgd_busqueda_avanzada')->where('id_usuario', '=',$idusuario)
			->where('parent_id', '=',$datofolder->id_folder)
			->update(['parent_id' => $datofolder->id]);
			
		}
		
		//se crean las ramas de los tipos documentales
		$folderavan  = DB::select("select * from sgd_busqueda_avanzada where id_usuario = ".$idusuario." and id_folder > 0 and id_tabla = ".$tablaid." and text <> 'root' order by id asc");
		
		foreach ($folderavan as $datofolder) {
			
			$permiso_folder = $this->permisofolder_tabladepuserxfolder($datofolder->id_folder,$tablaid);
			
			if ($permiso_folder == true)
			{
				
				$foldetpdoc  = DB::select("select tpd.id_tipodoc,tpd.nombre,ftp.id_folder from sgd_folders_tipodocs ftp,sgd_tipodocumentales tpd where ftp.id_folder = ".$datofolder->id_folder." and tpd.id_tipodoc = ftp.id_tipodoc");
				
				foreach ($foldetpdoc as $datotpdoc) {
					
					$permiso_folder = $this->permisofolder_tabladepuserxfolder($datotpdoc->id_folder,$tablaid);
					
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
			
			/*foreach ($foldetpdoc as $datoexp) {
			
			$regnodo = new Busqueda_avanzada();
			
			$regnodo->id_usuario = $idusuario;
			
			$regnodo->nombre = $datoexp->nombre;
			
			$regnodo->text = $datoexp->nombre;
			
			$regnodo->parent_id = $datotpdoc->id;
			
			$regnodo->id_estado = 1;
			
			$regnodo->id_tabla = $tablaid;
			
			$regnodo->id_folder = 0;
			
			$regnodo->id_folder_tpdoc = $datotpdoc->id_folder;
			
			$regnodo->id_tpdoc = $datotpdoc->id_tpdoc;
			
			$regnodo->save();
			
			
			}*/
			
		}
		
		
		/////////////////////////////////////////////////
		@session_start();
		
		$_SESSION['idusuario'] = $idusuario;
		
		return view('expedientes.visor_arbol',compact('tablas'))->with(['tablas'=>$tablas,'tablaid'=>$tablaid,'tiposdocumentales'=>$tiposdocumentales,'estados'=>$estados,'tipos'=>$tipos,'buscar'=>$buscar,'lastablas'=>$lastablas]);
		
		
	}
	
	
	public function visor_listado(Request $request, $id_documento,$buscar)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$idusuario = Session::get('id_usuario');
		
		
		return view('expedientes.visor_listado')->with(['id_documento'=>$id_documento,'idusuario'=>$idusuario,'buscar'=>$buscar]);
	}
	
	public function visor_listado_avanzado(Request $request, $id_documento,$buscar,$id_tabla)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		$idusuario = Session::get('id_usuario');
		
		return view('expedientes.visor_listado_avanzado')->with(['id_documento'=>$id_documento,'idusuario'=>$idusuario,'buscar'=>$buscar,'id_tabla'=>$id_tabla]);
	}
	
	
	
	
	public function visor_exp(Request $request, $idexp)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		
		///
		//buscamos la coincidencia
		
		$documentos = DB::select("select  id_tipodocumental,id_usuario, id_tabla, id_folder, created_at from sgd_documentos  where id_expediente = ".$idexp." order by created_at asc");
		
		return view('expedientes.visor_exp',compact('documentos'))->with('idexp',$idexp);
	}
	
	public function mostrar(Request $request, $filename)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		@session_start();
		
		$workspace = $_SESSION['espaciotrabajo'];
		
		return $documento = Storage::get('/visor/'.$workspace.'/'.$filename);
		
	}
	
	public function agregarimagenes(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$v = \Validator::make($request->all(), [
				
				'nombre' => 'required',
				'id_tabla' => 'required',
				'id_central' => 'required',
				'spider' => 'required',
				'id_estado' => 'required',
		]);
		
		if ($v->fails())
		{
			Session::put('mensajeerror',trans("principal.msgerrrol"));
			return redirect()->back();
		}
		
		$regexpediente = new Expediente();
		
		$id_usuario = Session::get('id_usuario');
		
		$regexpediente->id_usuario = $id_usuario;
		
		$regexpediente->nombre = $request->input('nombre');
		
		$regexpediente->id_tabla = $request->input('id_tabla');
		
		$regexpediente->id_central = $request->input('id_central');
		
		$regexpediente->spider = $request->input('spider');
		
		$regexpediente->id_estado = $request->input('id_estado');
		
		$regexpediente->save();
		
		//\Session::flash('flash_message', 'Mensaje de prueba');
		
		Session::put('mensaje',trans("principal.msgexitoexpe"));
		
		return redirect()->route('expedientes.index');
	}
	
	function darurl()
	{
		return sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['SERVER_NAME'],
				''
				);
	}
}
