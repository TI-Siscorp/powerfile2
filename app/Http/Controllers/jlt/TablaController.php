<?php

namespace App\Http\Controllers\jlt;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Tabla;
use App\Estado;
use App\Folder;
use App\Busqueda_avanzada;


class TablaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 *
	 * @return void
	 */


	public function index(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$tablas = DB::select('select t.id_tabla,t.nombre_tabla,t.version,e.descripcion as nestado from sgd_tablas t,sgd_estados e where t.id_estado = e.id_estado order by t.nombre_tabla asc');

		return view('tablas.index',compact('tablas'))->with('i', ($request->input('page', 1) - 1) * 5);
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
		
		return view('tablas.create')->with('estados',$estados);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$v = \Validator::make($request->all(), [

				'nombre_tabla' => 'required',	
				'version' => 'required', 
				'descripcion' => 'required',
				'id_estado' => 'required',
		]);

		if ($v->fails())
		{
			Session::put('mensajeerror',trans("principal.msgerrrol"));
			return redirect()->back();
		}
			
		Tabla::create($request->all());
		
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
		
		$registro->id_usuario = Session::get('id_usuario'); 
				
		$registro->id_tpdoc = 0; 
		
		$registro->id_folder_tpdoc = 0; 
		
		
		
		
		$registro->save();
		
		
		Session::put('mensaje',trans("principal.msgexitotabl"));
		
		return redirect()->route('tablas.index');
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
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$estados = Estado::pluck('descripcion', 'id_estado');
		$tablas = Tabla::find($id);
		return view('tablas.edit',compact('tablas'))->with('estados',$estados);
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
		//Update Query
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		$registro = Tabla::findOrFail($id);			
		
		$registro->nombre_tabla = $request->input('nombre_tabla');
		
		$registro->version = $request->input('version'); 
		
		$registro->descripcion = $request->input('descripcion');

		$registro->id_estado = $request->input('id_estado');
			
		$registro->save();
			
		Session::put('mensaje',trans("principal.msgedittabl"));
			
		return redirect()->route('tablas.index');
			
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
		$registro = Tabla::find($id);
		
		$registro->delete();
		
		//se eliminan las carpeta q pertenezcan a la tabla
		
		$folders = DB::select('delete from sgd_folders where id_tabla = '.$id);
		
		$tablas = DB::select('delete from sgd_dependencias_folders where id_tabla = '.$id);
		
		Session::put('mensaje',trans("principal.msgelimtabl"));
		
		return redirect()->route('tablas.index');
	}

}
