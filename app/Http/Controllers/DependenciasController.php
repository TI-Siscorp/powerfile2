<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Dependencia;
use App\Tabla;
use App\Estado;

class DependenciasController extends Controller
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
		$dependencias = DB::select('select d.id_dependencia,d.descripcion,d.codigo_departamento,e.descripcion as nestado from sgd_dependencias d,sgd_estados e where d.id_estado = e.id_estado order by d.descripcion asc');

		return view('dependencias.index',compact('dependencias'))->with('i', ($request->input('page', 1) - 1) * 5);
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
				//return view('auth.login');
				return redirect('/');
			}
		$estados = Estado::pluck('descripcion', 'id_estado');
		return view('dependencias.create')->with('estados',$estados);
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

				'descripcion' => 'required',
				'codigo_departamento' => 'required|max:255|unique:sgd_dependencias',
				'id_estado' => 'required',
		]);
	
		if ($v->fails())
			{
				Session::put('mensajeerror',trans("principal.msgerrrol"));
				return redirect()->back();
			}
		 
		Dependencia::create($request->all());
	  
		//\Session::flash('flash_message', 'Mensaje de prueba');
	  
		Session::put('mensaje',trans("principal.msgexitodepe"));
	  
		return redirect()->route('dependencias.index');
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
		$dependencias = Dependencia::find($id);
		return view('dependencias.edit',compact('dependencias'))->with('estados',$estados);
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
		$registro = Dependencia::findOrFail($id);
		 
		$registro->descripcion = $request->input('descripcion');
		
		$registro->codigo_departamento = $request->input('codigo_departamento');
		 
		$registro->id_estado = $request->input('id_estado');
		 
		$registro->save();
		 
		Session::put('mensaje',trans("principal.msgeditdepe"));
		 
		return redirect()->route('dependencias.index');
		 
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
			
		$registro=Dependencia::find($id);
		
		$registro->delete();
		
		//se eliminan los registros de la tabla sgd_dependencias_folders donde la dependencia sea la eliminada
		
		$dependencias = DB::select('delete from sgd_dependencias_folders where id_dependencia = '.$id);		
		
		Session::put('mensaje',trans("principal.msgelimdepe"));
		
		return redirect()->route('dependencias.index');
	}
	 
	public function estructura(Request $request, $id){
		if (is_null(Session::get('id_usuario')))
		{
			return redirect('/');
		}
		 
		$dependencias = Dependencia::find($id);
	
		$tablas = Tabla::pluck('nombre_tabla', 'id_tabla');
		
		return view('dependencias.permisos',compact('dependencias'))->with(['dependencias'=>$dependencias,'dependenciaid'=>$id,'tablas'=>$tablas]);
			
	}	
}
