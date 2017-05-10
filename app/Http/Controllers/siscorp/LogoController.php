<?php

namespace App\Http\Controllers\siscorp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;




class LogoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$logos = Logo::orderBy('id_logo','ASC')->paginate();
		return view('logos.index')->with('logos',$logos);;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		$file = $request->file('file');

		if(Input::hasFile('file')){

			echo "paso por aqui";

		}



		$allowed = array('png', 'jpg','jpeg');

		if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){

			$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

			if(!in_array(strtolower($extension), $allowed)){
				echo '{"status":"error"}';
				exit;
			}

			$estructura='public/img/logos';

			$uid_path=$_POST['option'];
			$nametmp=$_FILES['file']['name'];
			$nametmp=str_replace(' ','_',$nametmp);
			$ruta='public/img/logos';
			$ext=$extension;
			$act=0;

			if (file_exists($estructura)) {
				if(move_uploaded_file($_FILES['file']['tmp_name'],ROOT . 'public/img/logos' . DS .$nametmp)){
					$this->_logo->insertLogo($nametmp,$ruta,$ext,$act);
					echo '{"status":"success"}';
					exit;
				}

				//guardar archivos en base de datos

			} else {
				if(!mkdir($estructura, 0777, true)) {
					die('Fallo al crear las carpetas...');
				}

				$this->_logo->insertLogo($nametmp,$ruta,$ext,$act);
				if(move_uploaded_file($_FILES['file']['tmp_name'],ROOT . 'public/img/logos'. DS .$nametmp)){
					echo '{"status":"success"}';
					exit;
				}
			}
		}

		//echo '{"status":"error"}';
		exit;
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
		if($request->hasFile('nombrelogo'))
		{
			$allowed = array('png', 'jpg','jpeg');
			 
			$extension = pathinfo($_FILES['nombrelogo']['name'], PATHINFO_EXTENSION);
			 
			if(!in_array(strtolower($extension), $allowed)){
				Session::put('mensajeerror','Formato de imagen no permitida');
				return back();
			}
			 
			$relogo = new Logo();

			$imagen = $request->file('nombrelogo');

			//cambiando el nomnbre del avatar para que no haya conflicto
			//$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
			 
			$nombredelogo = $imagen->getClientOriginalName();
			 
			$ruta='public/img/logos';

			$ext=$extension;

			$act=0;

			$relogo->nombrelogo = $nombredelogo;

			$relogo->ruta = $ruta;

			$relogo->ext = $ext;

			$imagen->move(public_path().'/img/logos/', $nombredelogo);

			$relogo->save();

			Session::put('mensaje','Se Subi&oacute; el logo exitosamente');

			return redirect()->route('logos.index');

		}
		else
		{
			Session::put('mensajeerror','No seleccion&oacute; ninguina imagen');
			return back();
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
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function upload(){

		echo "funcione";

	}

	public function activar($id)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		//se ponen todos los logos registrados en 0
		DB::table('sgd_logos')
		->where('id_logo', '>', 0)
		->update(['act' => 0]);
		//se activa el id del logo seleccionado
		DB::table('sgd_logos')
		->where('id_logo', $id)
		->update(['act' => 1]);
		 
		$reglogo = Logo::where('act', '=', 1)->get()->first();

		Session::put('logo',$reglogo->nombrelogo);
		 
		Session::put('mensaje','Se activ&oacute; con  &eacute;xito!');
		return back();
		 
		 
		 
	}

	public function desactivar($id)
	{
		if (is_null(Session::get('id_usuario')))
		{
			return view('auth.login');
		}
		//se ponen todos los logos registrados en 0
		DB::table('sgd_logos')
		->where('id_logo', '>', 0)
		->update(['act' => 0]);
		//se activa el id del logo seleccionado
		//se vuelve a dejar el que estaba por defecto en el reg 1
		DB::table('sgd_logos')
		->where('id_logo', 1)
		->update(['act' => 1]);
		 
		$reglogo = Logo::where('act', '=', 1)->get()->first();
		 
		Session::put('logo',$reglogo->nombrelogo);

		Session::put('mensaje','Se desactiv&oacute; con  &eacute;xito!');
		return back();
		 
	}
}
