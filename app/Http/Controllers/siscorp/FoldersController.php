<?php

namespace App\Http\Controllers\siscorp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Folder;
use App\Estado;
use App\Tabla;
use App\Tipodocumental;
use App\Tipoindice;


class FoldersController extends Controller
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
    	$folders = DB::select('select f.id_folder,f.nombre,f.texto,d.descripcion,t.nombre_tabla  from sgd_folders r,sgd_estados d,sgd_tablas t 
    			where f.id_estado = d.id_estado and f.id_tabla = t.id_tabla order by f.nombre asc');    	

       	return view('folders.index',compact('folders'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	
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
    	
    	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	
    }

    public function folder(Request $request, $id){
    	if (is_null(Session::get('id_usuario')))
	    	{
	    		return view('auth.login');
	    	}
	    
	    $tablas = Tabla::find($id);  
	     
	    $tiposdocumentales = DB::select('select t.id_tipodoc,t.nombre from sgd_tipodocumentales t where t.id_tipodoc > 0 order by t.nombre asc');   
	
	    $tira = "";
	    for ($i = 0; $i < count($tiposdocumentales); $i++) {
	    	$tira .= $tiposdocumentales[$i]->id_tipodoc."_,_".$tiposdocumentales[$i]->nombre.'_;_' ;     	
	    }
	    	    
	    $tablaid = $id;
	    
	    $tiposdocumentales = $tira;
	    
	    $estados = Estado::pluck('descripcion', 'id_estado');
	    
	    $tipos = Tipoindice::pluck('nombre', 'id_tipo');
	    
	    return view('folders.carpetas',compact('tablas'))->with(['tablas'=>$tablas,'tablaid'=>$id,'tiposdocumentales'=>$tiposdocumentales,'estados'=>$estados,'tipos'=>$tipos]);
	   	    
    }
   
    
    
}

