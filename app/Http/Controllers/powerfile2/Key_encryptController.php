<?php

namespace App\Http\Controllers\powerfile2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Key_encrypt;
use App\Estado;

class Key_encryptController extends Controller
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
			return view('auth.login');
		}
		
		$encrypts = DB::select('select y.id_encrypt,y.created_at,e.descripcion as nestado,y.tiene_img from sgd_encrypt y,sgd_estados e where y.id_estado = e.id_estado order by y.created_at asc');
		
		
		return view('encrypts.index',compact('encrypts'))->with(['i'=> ($request->input('page', 1) - 1) * 5,'numreg'=> count($encrypts)]);
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
		$estados = Estado::pluck('descripcion', 'id_estado');
		return view('encrypts.create')->with('estados',$estados); 
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
			return view('auth.login');
		}
		$v = \Validator::make($request->all(), [

				'valor_key' => 'required',
				'id_estado' => 'required',
		]);

		if ($v->fails())
		{
			Session::put('mensajeerror',trans("principal.msgerrrol"));
			return redirect()->back();
		}
			
		$registro = new Key_encrypt;
		
		$registro->id_usuario = Session::get('id_usuario');
		
		$registro->valor_key = $request->input('valor_key');
		
		//se genera la llave de encriptación;
		
		//$key_enc = bcrypt($request->input('valor_key').$_SESSION['espaciotrabajo']);
		
		$key_enc = md5($request->input('valor_key').$_SESSION['espaciotrabajo']);
		
		$registro->key_encrypt = $key_enc;
		
		$registro->id_estado = $request->input('id_estado');
		
		$registro->save();
		 
		Session::put('mensaje',trans("principal.msgexitoencrypt"));
		 
		return redirect()->route('key_encrypt.index');
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
		$estados = Estado::pluck('descripcion', 'id_estado');
		
		$keyencry = Key_encrypt::find($id);
		
		return view('encrypts.edit',compact('keyencry'))->with('estados',$estados);
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
		@session_start();
		
		//Update Query
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$registro = Key_encrypt::findOrFail($id);
			
		$registro->valor_key = $request->input('valor_key');		
		
		//se genera la llave de encriptación;
		
		//$key_enc = bcrypt($request->input('valor_key').$_SESSION['espaciotrabajo']);
		
		$key_enc = md5($request->input('valor_key').$_SESSION['espaciotrabajo']);
		
		$registro->key_encrypt = $key_enc;
			
		$registro->id_estado = $request->input('id_estado');
			
		$registro->save();
			
		Session::put('mensaje',trans("principal.msgeditencry"));
			
		return redirect()->route('key_encrypt.index');
			
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
			
		$registro=Key_encrypt::find($id);

		$registro->delete();

		Session::put('mensaje',trans("principal.msgelimencry"));

		return redirect()->route('key_encrypt.index');
	}
}
