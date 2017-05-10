<?php

namespace App\Http\Controllers\siscorp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

class DocumentosController extends Controller
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
		/*if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$expedientes = DB::select('select d.id_expediente,d.nombre,e.descripcion as nestado,t.nombre_tabla,t.id_tabla from sgd_expedientes d,sgd_estados e,sgd_tablas t where d.id_estado = e.id_estado and d.id_tabla = t.id_tabla order by d.nombre asc');

		return view('expedientes.index',compact('expedientes'))->with('i', ($request->input('page', 1) - 1) * 5);*/
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		/*if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}

		$estados = Estado::pluck('descripcion', 'id_estado');

		$tablas = Tabla::pluck('nombre_tabla', 'id_tabla');

		$central = Central::pluck('nombre', 'id_central');

		return view('expedientes.create')->with(['estados'=>$estados,'tablas'=>$tablas,'central'=>$central]);//->with('estados',$estados);*/
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
				return view('auth.login');
			}
		dd('sami');	
			
		/*if($request->hasFile('documentos'))
			{
				dd('si') ;
			}
		else
			{
				dd('no');
			}*/
		
		/*$v = \Validator::make($request->all(), [

				'nombre' => 'required',
				'id_tabla' => 'required',
				'id_central' => 'required',
				'spider' => 'required',
				'id_estado' => 'required',
		]);

		if ($v->fails())
		{
			Session::put('mensajeerror','No se permiten datos en blanco!, por favor verifique');
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
			
		Session::put('mensaje','Se cre&oacute; el Expediente exitosamente');
			
		return redirect()->route('expedientes.index');*/
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
		/*if (is_null(Session::get('id_usuario')))
		 {
			return view('auth.login');
			}
			$estados = Estado::pluck('descripcion', 'id_estado');
			$dependencias = Dependencia::find($id);
			return view('dependencias.edit',compact('dependencias'))->with('estados',$estados);*/
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
		/*if (is_null(Session::get('id_usuario')))
		 {
			return view('auth.login');
			}
			$registro = Dependencia::findOrFail($id);
				
			$registro->descripcion = $request->input('descripcion');

			$registro->codigo_departamento = $request->input('codigo_departamento');
				
			$registro->id_estado = $request->input('id_estado');
				
			$registro->save();
				
			Session::put('mensaje','Se edit&oacute; la Dependencia exitosamente');
				
			return redirect()->route('dependencias.index');*/
			
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		/*if (is_null(Session::get('id_usuario')))
		 {
			return view('auth.login');
			}
				
			$registro=Dependencia::find($id);

			$registro->delete();

			//se eliminan los registros de la tabla sgd_dependencias_folders donde la dependencia sea la eliminada

			$dependencias = DB::select('delete from sgd_dependencias_folders where id_dependencia = '.$id);

			Session::put('mensaje','La Dependencia se elimin&oacute; con  &eacute;xito!');

			return redirect()->route('dependencias.index');*/
	}


	public function documentos(Request $request, $id,$idtabla){
		/*if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
			
		$expedientes = Expediente::find($id);
			
		$tablaid = $idtabla;
			
		$expedid = $id;
			
		return view('expedientes.estructura',compact('expedientes'))->with(['expedientes'=>$expedientes,'tablaid'=>$tablaid,'expedid'=>$expedid]);*/
			
	}

	public function grabadocumento(Request $request)   //,$id
	{
		/*if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$v = \Validator::make($request->all(), [ //nombre id_tipo id_estado descripcion

				'documentos' => 'required',
				'id_indices' => 'required',
		]);
		if ($v->fails())
		{
			Session::put('mensajeerror','No se permiten datos en blanco!');
			return redirect()->back();
		}
			
		unset($vvalor);

		if($request->hasFile('documentos'))
		{
			dd('si') ;
		}
		else
		{
			dd('no');
		}*/
		
		/*$documentos = $request->file('documentos'); //Input::file('documentos'); //$request->input('documentos');

		$id_indices = $request->input('id_indices');

		$vidindices = explode("_;_",$id_indices);

		$id_tipodoc = $request->input('id_tipodoc');

		$id_folder = $request->input('id_folder');

		$id_tabla = $request->input('id_tabla');

		$id_expediente = $request->input('id_expediente');

		$totalindices = $request->input('totalindices');

		//se verifica si es una actualizacion o registro nuevo

		/* $documentoreg = DB::select('select id_documento from sgd_documentos  where id_expediente = '.$id_expediente.' and id_tipodocumental = '.$id_tipodoc.' and id_tabla = '.$id_tabla.' and id_folder = '.$id_folder);
		//Model::where(

		$ordendoc = 0;

		if (count($documentoreg) == 0)
		{
		//se registra primero el documento
		$regdocumento = new Documento();

		$regdocumento->id_expediente = $id_expediente;

		$regdocumento->id_tipodocumental = $id_tipodoc;

		$regdocumento->id_usuario = Session::get('id_usuario');

		$regdocumento->id_tabla = $id_tabla;

		$regdocumento->id_folder = $id_folder;

		$regdocumento->orden = $ordendoc;

		$regdocumento->id_estado = 1;

		$regdocumento->save();

		$ultimoid= Documento::all();

		$iddocum = $ultimoid->last();

		$eliddoc = $iddocum->id_documento;

		//se registran los valores indices

		for ( $i = 0 ; $i < $totalindices ; $i ++)
		{
		$regvalorindi = new Valorindice();

		$regvalorindi->id_documento = $eliddoc;

		$regvalorindi->id_indice = $vidindices[$i];

		$regvalorindi->valor = $request->input('valor')[$i];

		$regvalorindi->id_estado = 1;

		$regvalorindi->save();
		}
		//se registran las imagenes
			
		//for ( $i = 0 ; $i < count($documentos) ; $i ++)
			//{
				
			foreach($documentos as $documento) {
				
			//$imagen = $request->file('documentos'); //$documentos[$i];    //echo $imagen;

			//cambiando el nomnbre del avatar para que no haya conflicto
			//$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());

			//se registra en la tabla de imagenes

			$regimagen = new Imagendocumento();

			$regimagen->id_documento = $eliddoc;

			$regimagen->nombre = File::name($documento);   //echo File::name($imagen);

			$regimagen->extension = File::extension($documento);

			$regimagen->id_bodega = 1;

			$regimagen->id_estado = 1;

			$regimagen->save();

			$ultimoidimg= Imagendocumento::all();

			$idimg = $ultimoidimg->last();

			$elidimg = $idimg->id_imagendocum;

			$nombreimg = $elidimg.'.'.file::extension($documento); //$timestamp. '_' .$imagen->getClientOriginalName();

			$documento->move(public_path().'/bodegas/bodega1/', $nombreimg);

			}

			//}


		}
		else
		{
		//se actualiza eldocumento
		}

			
		Session::put('mensaje','Se cre&oacute; el Documento exitosamente');
			
		return redirect()->back();

		//return redirect()->route('expedientes.documentos',[$id_expediente,$id_tabla]);



		//route('expedientes.documentos',[$expediente->id_expediente,$expediente->id_tabla])

		//dd(count($documentos));


		/*$imagen = $request->file('avatar');
		 
		//cambiando el nomnbre del avatar para que no haya conflicto
		$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());

		$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();
		 
		$registro->avatar = $nombreavatar;
		 
		$imagen->move(public_path().'/img/perfiles/', $nombreavatar);	*/



		//dd($documentoreg);
	}

}
