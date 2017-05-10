<?php

namespace App\Http\Controllers\jlt;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Rol;
use App\Estado;
use App\Permiso;
use App\Permiso_rol;

class RolController extends Controller
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
    	$roles = DB::select('select r.id_rol,nombre,descripcion from sgd_rols r,sgd_estados d where r.id_estado = d.id_estado order by nombre asc');    	

       	return view('roles.index',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
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
    	return view('roles.create')->with('estados',$estados);
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
    	]);
    	
    	if ($v->fails())
	    	{
	    		Session::put('mensajeerror',trans("principal.msgerrrol"));
	    		return redirect()->back();
	    	}
    	
    	//se verifica q no exista ya un rol con ese nombre
    	 
    	$rnombre = $request->input('nombre');
    	 
    	$roles = DB::select("select r.id_rol from sgd_rols r where upper(r.nombre) = '".strtoupper($rnombre)."' order by nombre asc");
    	 
    	if (count($roles) == 0)
	    	{
	    		Rol::create($request->all());
	    	
	    		Session::put('mensaje',trans("principal.msgexitorol"));
	    		 
	    		return redirect()->route('roles.index');
	    	}
    	else
	    	{
	    		Session::put('mensajeerror',trans("principal.msgerrrolexits"));
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
    	$roles = Rol::find($id);
    	return view('roles.edit',compact('roles'))->with('estados',$estados);
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
    	$registro = Rol::findOrFail($id);  	
    	
    	$registro->nombre = $request->input('nombre');
    	
    	$registro->id_estado = $request->input('id_estado');
    	
    	$registro->save();
    	
    	Session::put('mensaje',trans("principal.msgeditexitorol"));
    	
    	return redirect()->route('roles.index');
    	
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
    	$registro=Rol::find($id);
    	
    	$registro->delete();
    	
    	//se elimina cualquier permiso de ese rol previo
    	 
    	$roles = DB::select('delete from sgd_permiso_rols where id_rol = '.$id);
    	
    	Session::put('mensaje',trans("principal.msgelimrol"));
    	
    	return redirect()->route('roles.index');
    }

    public function permiso(Request $request, $id){
    	if (is_null(Session::get('id_usuario')))
	    	{
	    		return redirect('/');
	    	}
	    
	    $roles = Rol::find($id);
	    
	    $permiso_rol = DB::select('select id_rol,id_permiso,value from sgd_permiso_rols where id_rol = '.$id); 
	    
	    $totalr = DB::table('sgd_permisos')->get();
	     
	    $totalr = count($totalr);  //total de registros	    
	    	    	
	    $permisos = Permiso::orderBy('id_permiso','ASC')->paginate($totalr);   
	    
	    return view('roles.permiso',compact('permisos'))->with(['permisos'=>$permisos,'roles'=>$roles,'permiso_rol'=>$permiso_rol]);
    }
    
    public function store_permiso(Request $request, $id){
    	
    	if (is_null(Session::get('id_usuario')))
	    	{
	    		return redirect('/');
	    	}
	    	
	    $permisoshab = $request->input('idpermhabiles');
	    
	    $permisoshab = trim($permisoshab,",");
	    
	    $permisosnega = $request->input('idpermnegados');     
	    
	    $permisosnega = trim($permisosnega,",");      

	   //se verifica que se hayan cargado al meno un Permiso::
	    
	    if ($permisoshab == '' and $permisosnega == '')
	    	{
	    		Session::put('mensajeerror',trans("principal.msgpermirol"));
	    		 
	    		return back();
	    		
	    	}
	    
	    //se elimina cualquier permiso de ese rol previo
	    
	    DB::table('sgd_permiso_rols')->where('id_rol', '=', $id)->delete();
	    	
	    
	    //$roles = DB::select('delete from sgd_permiso_rols where id_rol = '.$id); 
	    
	    //se cargan los valores de permisos   
	    
	    $permisoshab = explode(",",$permisoshab);
	    
	    //se recorre el arregle de habilitados y se guardan 
	   
	    for ($i = 0; $i < count($permisoshab); $i++) {
	    	
	    	$datperhab = explode("_;_",$permisoshab[$i]);  
	    	
	    	if ($datperhab[0] > 0)
	    		{
	    	
			    	$registro = new Permiso_rol();
			    	
			    	$registro->id_rol = $id;
			    	
			    	$registro->id_permiso = $datperhab[0];
			    	
			    	$registro->value = $datperhab[1];
			    	
			    	$registro->save();
	    		}	    	
	    }
	    
	    $permisosnega = explode(",",$permisosnega);  
	     
	    //se recorre el arregle de negados y se guardan
	     
	    for ($i = 0; $i < count($permisosnega); $i++) {
	    
	    	$datperneg = explode("_;_",$permisosnega[$i]);
	    	
	    	if ($datperneg[0] > 0)
	    		{
	    
			    	$registro = new Permiso_rol();
			    
			    	$registro->id_rol = $id;
			    
			    	$registro->id_permiso = $datperneg[0];
			    
			    	$registro->value = $datperneg[1];
			    
			    	$registro->save();
	    		} 	
	    
	    }
	    
	    Session::put('mensaje',trans("principal.msgpermirolgrab"));
	     
	    return redirect()->route('roles.index');
	   
    }
   
}
