<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;

use App\Indice;
use App\Tipoindice;
use App\Estado;

class IndicesController extends Controller
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
		$indices = DB::select('select distinct i.id_indice,i.nombre,t.nombre as ntipo,d.descripcion  from sgd_indices i,sgd_estados d,sgd_tipoindices t where i.id_estado = d.id_estado and i.id_tipo = t.id_tipo order by i.nombre asc');

		return view('indices.index',compact('indices'))->with('i', ($request->input('page', 1) - 1) * 5);
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
		$tipos = Tipoindice::pluck('nombre', 'id_tipo');
		return view('indices.create')->with( ['estados'=>$estados,'tipos'=>$tipos]); //se deben pasar los parametros en un arreglo si son varios
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
		$v = \Validator::make($request->all(), [ //nombre id_tipo id_estado descripcion

				'nombre' => 'required|max:255',
				'id_tipo' => 'required',
				'id_estado' => 'required',
				'orden' => 'required',
		]);
		if ($v->fails())
			{
				Session::put('mensajeerror',trans("principal.msgerrrol"));
				return redirect()->back();
			}
		unset($vkey);	
		unset($vvalor);
		
		$ntipo = $request->input('ntipo');
		if ($ntipo == 'LISTA' or $ntipo == 'LISTAS')
			{
				$totalitem = $request->input('totalitem'); 
				for ( $i = 0 ; $i < $totalitem ; $i ++) 
					{
						$vkey[] = $request->input('key')[$i];
						$vvalor[] = $request->input('valor')[$i];
					}
				//el guardado es dif para poder guardar el json de la lista en el campo pertinente	
				$registro = new Indice;
				$registro->nombre = $request->input('nombre');   
				$registro->id_tipo = $request->input('id_tipo');
				$registro->id_estado = $request->input('id_estado');
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
				Indice::create($request->all());				
			}
		//\Session::flash('flash_message', 'Mensaje de prueba');
		
		$id_ctlindice = 	$request->input('id_ctlindice');
			
		Session::put('mensaje',trans("principal.msgexitoindice"));
		 
		if ($id_ctlindice == 'arbol')
			{
				return back();
			}
		else 
			{
				return redirect()->route('indices.index');
			}	
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
		$tipos = Tipoindice::pluck('nombre', 'id_tipo');
		$indices = Indice::find($id);
		return view('indices.edit',compact('indices'))->with( ['estados'=>$estados,'tipos'=>$tipos]); //se deben pasar los parametros en un arreglo si son varios
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
		$registro = Indice::findOrFail($id);
		
		unset($vkey);
		unset($vvalor);
		
		$ntipo = $request->input('ntipo');
		$ntipo = strtoupper($ntipo);  //dd($ntipo);
		if ($ntipo == 'LISTA' or $ntipo == 'LISTAS')
			{
				$totalitem = $request->input('totalitem');
				for ( $i = 0 ; $i < $totalitem ; $i ++)
					{
						$vkey[] = $request->input('key')[$i];
						$vvalor[] = $request->input('valor')[$i];
					}
				//el guardado es dif para poder guardar el json de la lista en el campo pertinente
				$registro->nombre = $request->input('nombre');
				$registro->id_tipo = $request->input('id_tipo');
				$registro->id_estado = $request->input('id_estado');
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
				$registro->id_estado = $request->input('id_estado');
				$registro->orden = $request->input('orden');
				$registro->descripcion = $request->input('descripcion');
				$registro->delistakey = null;
				$registro->delistavalor = null;
			}
		$registro->save();
		
		Session::put('mensaje',trans("principal.msgexitoeditindice"));
			
		return redirect()->route('indices.index');
			
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
		$registro=Indice::find($id);
		$registro->delete();
		Session::put('mensaje',trans("principal.msgexitoeditindice"));
		return redirect()->route('indices.index');
	}

}
