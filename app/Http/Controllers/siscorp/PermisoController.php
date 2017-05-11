<?php

namespace App\Http\Controllers\siscorp;


/*use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Permiso;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;*/


////
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Permiso;


class PermisoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}

		$totalr = DB::table('sgd_permisos')->get();
	  
		$totalr = count($totalr);  //totasl de registros

		$permisos = Permiso::orderBy('id_permiso','ASC')->paginate($totalr);

		return view('permisos.index',compact('permisos'))->with('i', ($request->input('page', 1) - 1) * 5);
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
			return view('auth.login');
		}
		return view('permisos.create');
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
		 
		$messsages = array(
				'permiso.required'=>'el permiso no puede ser vacio',
				'key.required'=>'el key no puede ser vacio',
		);
		 
		$rules = array(
				'permiso' => 'min:4|max:100|required',
				'key' => 'min:4|max:100|required',
		);
		 
		$validator = Validator::make(Input::all(), $rules,$messsages);
		 
		//dd($validator->errors());
		 
		if( $validator->passes() ) {

			$permisos = new Permiso($request->all());

			$permisos->save();

			//flash('Permiso guradado con exito!', 'success');

			Session::put('mensaje',trans("principal.msgpermisograb"));

			return redirect()->route('permisos.create');
		} else {


			Session::put('mensajeerror',trans("principal.msgerropermiso"));

			return redirect()->route('permisos.create');
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
			return view('auth.login');
		}
		$permisos = Permiso::find($id);

		return view('permisos.edit')->with('permiso',$permisos);

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
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$permisos = Permiso::find($id);

		$date =Carbon::now();
		$permisos->updated_at = $date;
		$permisos->permiso = $request->permiso;
		$permisos->key = $request->key;
		$permisos->save();

		// flash('El permiso fue modificado con exito!', 'success');
		Session::put('mensaje',trans("principal.msgexipermiso"));
		return redirect()->route('permisos.index');
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
			return view('auth.login');
		}
		$permisos = Permiso::find($id);
		$permisos->delete();

		//flash('El permiso Se elimino con exito!', 'danger');
		Session::put('mensaje',trans("principal.msgelimpermiso"));
		return redirect()->route('permisos.index');
	}
}
