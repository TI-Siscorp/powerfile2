<?php

namespace App\Http\Controllers\powerfile2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;

use App\Tipodocumental;
use App\Estado;


class TiposdocumentalesController extends Controller
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
		$tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre,d.descripcion from sgd_tipodocumentales t,sgd_estados d where t.id_estado = d.id_estado order by t.nombre asc');

		return view('tiposdocumentales.index',compact('tiposdocumentales'))->with('i', ($request->input('page', 1) - 1) * 5);
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
		return view('tiposdocumentales.create')->with('estados',$estados);
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

		'nombre' => 'required|max:255',
		'id_estado' => 'required',
		'color' => 'required',
		]);
		if ($v->fails())
			{
				Session::put('mensajeerror',trans("principal.msgerrrol"));
				return redirect()->back();
			}
		
		$id_ctltpdoc = 	$request->input('id_ctltpdoc');
			
		Tipodocumental::create($request->all());
			
		Session::put('mensaje',trans("principal.msgexitotpdoc"));
			
		if ($id_ctltpdoc == 'arbol')
			{
				return back();
			}
		else 
			{
				return redirect()->route('tiposdocumentales.index');
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
		 $tiposdocumentales = Tipodocumental::find($id);
		 
		 return view('tiposdocumentales.edit',compact('tiposdocumentales'))->with('estados',$estados);
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
		$registro = Tipodocumental::findOrFail($id);
		 	
		$registro->nombre = $request->input('nombre');
			
		$registro->id_estado = $request->input('id_estado');
				
		$registro->color = $request->input('color');
		
		$registro->descripcion = $request->input('descripcion');
			
		$registro->save();
			
		Session::put('mensaje',trans("principal.msgedittpdoc"));
			
		return redirect()->route('tiposdocumentales.index');
			
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
		  
		  //se verifica si el tipo documental tiene carga
		$tipos = DB::select('select id_tipodoc_indice from sgd_tipodoc_indices where id_tipodoc = '.$id);
		
		if (count($tipos) == 0)
			{
				 $tiposd = DB::select('select id_documento from sgd_documentos where id_tipodocumental = '.$id);
				 
				 if (count($tiposd) == 0)
				 	{
						 $registro=Tipodocumental::find($id);
						 $registro->delete();
						 Session::put('mensaje',trans("principal.msgelimtpdoc"));
						 return redirect()->route('tiposdocumentales.index');
				 	}	 
				 else
				 	{
				 		if (count($tiposd) > 0)
					 		{
					 			
					 			Session::put('mensajeerror',trans("principal.msgerrrorborrartipo"));
					 			return redirect()->back();
					 			
					 		}
				 	}
			}
		else
			{
				if (count($tipos) > 0)
						{
							
							Session::put('mensajeerror',trans("principal.msgerrrorborrartipod"));
							return redirect()->back();
							
						}
				
			}
	}

}
