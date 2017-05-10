<?php

namespace App\Http\Controllers\powerfile2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setupbodega;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Estado;



class SetupbodegaController extends Controller
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
			return redirect('/');
		}
		
		$setup = Setupbodega::orderBy('id_setup','ASC')->paginate();
		return view('setupbodega.index')->with('setup',$setup);
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
			return redirect('/');
		}
		
		$estados = Estado::pluck('descripcion', 'id_estado');
		
		return view('setupbodega.create')->with( ['estados'=>$estados]); //se deben pasar los parametros en un arreglo si son varios
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
		
		$modobodega= $request->input('modobodega');
		
		$estatus= $request->input('estatus');
		
		$grabalo = 0;
		if ($estatus == 1)
			{
				$rservers = DB::select("select s.id_setup from sgd_setupbodega s where estatus = 1 order by id_setup asc");
				
				if (count($rservers) == 0)
				{
					
					$grabalo = 1;
				}
			}
		else
			{
				$grabalo = 1;
				
			}
		if ($modobodega != 'powerfile2')
			{
				$v = \Validator::make($request->all(), [
						
						'modobodega' => 'required|max:255',
						'ftp_server' => 'required|max:255',
						'ftp_user' => 'required|max:255',
						'ftp_pass' => 'required|max:255',
						'ftp_port' => 'required|max:255',
						'estatus' => 'required',			
						'id_estado' => 'required',
				]);
				
				if ($v->fails())
				{
					Session::put('mensajeerror',trans("principal.msgerrrol"));
					return redirect()->back();
				}
			}
		//se verifica q no haya un server por defecto ya
		
		
		if ($grabalo == 1)
			{
		
				$espaciotrabajo = $_SESSION['espaciotrabajo'];
				
				if ($modobodega != 'powerfile2')
					{
						$ftp_server= $request->input('ftp_server');
						$ftp_user= $request->input('ftp_user');
						$ftp_pass= $request->input('ftp_pass');
						$ftp_port= $request->input('ftp_port');				
						$id_estado= $request->input('id_estado');		
					}
				else 
					{
						if ($modobodega == 'powerfile2')
							{
								$ftp_server= '000.000.00.00';
								$ftp_user= 'powerfile2';
								$ftp_pass= 'powerfile2';
								$ftp_port= 21;
								$id_estado= $request->input('id_estado');	
							}
					}
						
				$regsetup = new Setupbodega();
				
				$id_usuario = Session::get('id_usuario');
				
				$regsetup->modobodega= $modobodega;		
				$regsetup->ftp_server= $ftp_server;
				$regsetup->ftp_user= $ftp_user;
				$regsetup->ftp_pass= $ftp_pass;
				$regsetup->ftp_port= $ftp_port;
				$regsetup->estatus= $estatus;
				$regsetup->id_estado= $id_estado;
				
				
				$regsetup->save();
				
				$regsetup= Setupbodega::all();
				
				$idsetup = $regsetup->last();
				
				Session::put('mensaje',trans("principal.msgexitorol"));
				
				return redirect()->route('setupbodega.index');
		
			}
		else
			{
				Session::put('mensajeerror',trans("principal.msgerserverexits"));
				
				return redirect()->back();
				
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
		$bodegas = Setupbodega::find($id);
		return view('setupbodega.edit',compact('bodegas'))->with('estados',$estados);
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
		$registro = Setupbodega::findOrFail($id);
		
		$registro->modobodega= $request->input('modobodega');
		$registro->ftp_server= $request->input('ftp_server');
		$registro->ftp_user= $request->input('ftp_user');
		$registro->id_estado = $request->input('id_estado');
		$registro->ftp_pass= $request->input('ftp_pass');
		$registro->ftp_port= $request->input('ftp_port');
		$registro->estatus=  $request->input('estatus');
		$registro->save();
		
		Session::put('mensaje',trans("principal.msgexitoeditserver"));
		
		return redirect()->route('setupbodega.index');
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
		$registro = Setupbodega::find($id);
		
		$registro->delete();
		
		Session::put('mensaje',trans("principal.msgelimbodeg"));
		
		return redirect()->route('setupbodega.index');
	}

	
	
	
}