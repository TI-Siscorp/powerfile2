<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;

use App\Tipoindice;
use App\Estado;

class TiposindicesController extends Controller
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
									
		$tiposindices = DB::select('select t.id_tipo,t.nombre,d.descripcion from sgd_tipoindices t,sgd_estados d where t.id_estado = d.id_estado order by t.nombre asc');

		return view('tiposindices.index',compact('tiposindices'))->with('i', ($request->input('page', 1) - 1) * 5);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$estados = Estado::pluck('descripcion', 'id_estado');
		return view('tiposindices.create')->with('estados',$estados);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$v = \Validator::make($request->all(), [

				'nombre' => 'required|max:255',
				'id_estado' => 'required',
		]);
		// dd($v);
		if ($v->fails())
		{
			Session::put('mensajeerror','No se permiten datos en blanco!');
			return redirect()->back();
		}
		 
		Tipoindice::create($request->all());
	  
		//\Session::flash('flash_message', 'Mensaje de prueba');
	  
		Session::put('mensaje','Se cre&oacute; el Tipo de Indice exitosamente');
	  
		return redirect()->route('tiposindices.index');
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
		$estados = Estado::pluck('descripcion', 'id_estado');
		$tipoindices = Tipoindice::find($id);
		return view('tiposindices.edit',compact('tipoindices'))->with('estados',$estados);
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

		$registro = Tipoindice::findOrFail($id);
		 
		$registro->nombre = $request->input('nombre');
		 
		$registro->id_estado = $request->input('id_estado');
		 
		$registro->save();
		 
		Session::put('mensaje','Se edit&oacute; el Tipo de Item exitosamente');
		 
		return redirect()->route('tiposindices.index');
		 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$registro=Tipoindice::find($id);
		$registro->delete();
		Session::put('mensaje','El rol se elimin&oacute; con  &eacute;xito!');
		return redirect()->route('tiposindices.index');
	}
	 
}
