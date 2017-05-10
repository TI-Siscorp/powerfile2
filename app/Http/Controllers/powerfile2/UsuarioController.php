<?php

namespace App\Http\Controllers\powerfile2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use Mail;

use Session;

use App\Usuario;
use App\Rol;
use App\Estado;


class UsuarioController extends Controller
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
	    		return redirect('/');
	    	}
    	  	
    	$regusuarios = DB::select('select u.id,u.name,u.lastname,u.cedula,u.email,u.avatar,e.descripcion,r.nombre from sgd_usuarios u, 
    			sgd_rols r,sgd_estados e where u.id_estado = e.id_estado and u.id_rol = r.id_rol and u.id > 0');
    		
    	
    	$usuarios = Usuario::find(Session::get('id_usuario'));
    	
    	return view('usuarios.index',compact('regusuarios'))->with(['i', ($request->input('page', 1) - 1) * 5,]);
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
    	$roles = Rol::pluck('nombre', 'id_rol');
    	return view('usuarios.create')->with( ['estados'=>$estados,'roles'=>$roles]); //se deben pasar los parametros en un arreglo si son varios
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
    	
    			'name' => 'required|max:255',
    			'lastname' => 'required|max:255',
    			'cedula' => 'required|unique:sgd_usuarios',
    			'login' => 'required|unique:sgd_usuarios',
    			'email' => 'required|unique:sgd_usuarios',
    			'password' => 'required|min:2',    			
    			'id_estado' => 'required',
    			'celular' => 'required',
    			'fijo' => 'required',
    			'id_rol' => 'required',
    			
    	]);
    	if ($v->fails())
	    	{
	    		Session::put('mensajeerror',trans("principal.msgerrcreau"));
	    		return redirect()->back();
	    	}
    	if($request->hasFile('avatar')) {
    		
    		$regavatar = new Usuario();            
    		
    		$regavatar->name = $request->input('name');
    		
    		$regavatar->lastname = $request->input('lastname');
    		
    		$regavatar->cedula = $request->input('cedula');
    		
    		$regavatar->login = $request->input('login');
    		
    		$regavatar->email = $request->input('email');
    		
    		$regavatar->password = bcrypt($request->input('password'));
    		
    		$regavatar->celular = $request->input('celular');
    		
    		$regavatar->fijo = $request->input('fijo');
    		
    		$regavatar->direccion = $request->input('direccion');
    		
    		$regavatar->avatar = '';
    		
    		$regavatar->id_rol = $request->input('id_rol');
    		
    		$regavatar->id_estado = $request->input('id_estado');    
    		
    		$imagen = $request->file('avatar');    
    		
    		//cambiando el nomnbre del avatar para que no haya conflicto
    		$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
    	
    		$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName(); 
    		
    		$regavatar->avatar = $nombreavatar;
    		
    		$imagen->move(public_path().'/img/perfiles/', $nombreavatar);    
    		
    		$regavatar->save();
    		
    		Session::put('mensaje',trans("principal.msgcreau"));
    		
    		return redirect()->route('usuarios.index');
    		
    	}
     else 
     	{
     		//Session::put('mensajeerror',trans("principal.msgerravatar"));
     		
     		$regavatar = new Usuario();
     		
     		$regavatar->name = $request->input('name');
     		
     		$regavatar->lastname = $request->input('lastname');
     		
     		$regavatar->cedula = $request->input('cedula');
     		
     		$regavatar->login = $request->input('login');
     		
     		$regavatar->email = $request->input('email');
     		
     		$regavatar->password = bcrypt($request->input('password'));
     		
     		$regavatar->celular = $request->input('celular');
     		
     		$regavatar->fijo = $request->input('fijo');
     		
     		$regavatar->direccion = $request->input('direccion');
     		
     		$regavatar->avatar = '';
     		
     		$regavatar->id_rol = $request->input('id_rol');
     		
     		$regavatar->id_estado = $request->input('id_estado');
     		
     		$regavatar->save();
     		
     		Session::put('mensaje',trans("principal.msgcreau"));
     	
     		return redirect()->route('usuarios.index');
     		
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
    	$roles = Rol::pluck('nombre', 'id_rol');
    	$usuarios = Usuario::find($id);
    	return view('usuarios.edit',compact('usuarios'))->with( ['estados'=>$estados,'roles'=>$roles]);
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
	    		return redirect('/');
	    	}
    	
    	$registro = Usuario::findOrFail($id);
    	
    	$registro->name = $request->input('name');
    	
    	$registro->lastname = $request->input('lastname');
    	
    	$registro->cedula = $request->input('cedula');
    	
    	$registro->login = $request->input('login');
    	
    	$registro->email = $request->input('email');
    	
    	$password = $request->input('password');
    	
    	if ($password != '')
    		{
    			$registro->password = bcrypt($request->input('password'));
    		}
    	else 
    		{
    			$registro->password = $request->input('password_tempo');
    		}	
    	$registro->celular = $request->input('celular');
    	
    	$registro->fijo = $request->input('fijo');
    	
    	$registro->direccion = $request->input('direccion');
    	
    	if($request->hasFile('avatar')) 
    		{
    	
    			$imagen = $request->file('avatar'); 
    	
    		  	//cambiando el nomnbre del avatar para que no haya conflicto
    			$timestamp = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString());
    	 
    			$nombreavatar = $timestamp. '_' .$imagen->getClientOriginalName();     
    	
    			$registro->avatar = $nombreavatar;   
    	
    			$imagen->move(public_path().'/img/perfiles/', $nombreavatar);
    		}
    	else
    		{
    			$registro->avatar =  $request->input('avatar_tempo');
    		}
    	    	
    	$registro->id_rol = $request->input('id_rol');
    	
    	$registro->id_estado = $request->input('id_estado');
    	
    	$registro->save();
    	
    	$datos_perfil = $request->input('datos_perfil'); 
    	
    	if ($datos_perfil == 'p')
    		{
    			//se cambian los valores del nombre y del avatar en la variable de session
    			Session::put('nombre',$request->input('name'));
    			if($request->hasFile('avatar'))
    				{
    					Session::put('avatar',$nombreavatar);
    				} 	
    			Session::put('mensaje',trans("principal.msgexed"));
    			return back();
    						
    		}	
    	else 
    		{
    			Session::put('mensaje',trans("principal.msgexed"));
    			return redirect()->route('usuarios.index');    			
    		}
    	
    }
    
    public function updateclave(Request $request, $id)
    {
    	if (is_null(Session::get('id_usuario')))
	    	{
	    		return redirect('/');
	    	}
    	$registro = Usuario::findOrFail($id);
    	
    	$password = $request->input('password_nueva');
    	 
    	if ($password != '')
	    	{
	    		$registro->password = bcrypt($request->input('password_nueva'));
	    		$registro->save();
	    		Session::put('mensaje',trans("principal.msgaccla"));
	    		return back();
	    	}
	    else 
	    	{	
		    	Session::put('mensaje',trans("principal.msgacuser"));
		    	return back();
	    	}
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
    	$registro=Usuario::find($id);
    	$registro->delete();
    	Session::put('mensaje',trans("principal.msgboruser"));
    	return redirect()->route('usuarios.index');
    }
    
    public function perfiles($id)
    {
    	if (is_null(Session::get('id_usuario')))
	    	{
	    		return redirect('/');
	    	}
    	$estados = Estado::pluck('descripcion', 'id_estado');
    	$roles = Rol::pluck('nombre', 'id_rol');
    	$usuarios = Usuario::find($id);
    	//se busca el nombre del rol del usuario    	
    	$regperfil = Rol::find($usuarios->id_rol);    	
    	return view('usuarios.vista_perfil',compact('usuarios'))->with( ['estados'=>$estados,'roles'=>$roles,'datorol'=>$regperfil]);
    
    }
    public function perfil($id)
    {
    	//
    }
    
    public function recuperar(Request $request)
    {
    	
    	$countl = Usuario::where('login','=',$request->input('login'))->count();    	
    	
    	
    	if ($countl > 0)
    		{
    			//se busca el email
    			$counte = Usuario::where('email','=',$request->input('email'))->count();
    			
    			if ($counte > 0)
    				{
    					$correo = $request->input('email'); //
    					
    					$logind = $request->input('login');
    					
    					//se debe generar un nuevo passwaord temporal, se registra y se envia el nuevo password al correo del usuario
    					$reglusuario = DB::select("select id from sgd_usuarios where login = '".$request->input('login')."' and email = '".$request->input('email')."'");
    					
    					$password = 'powerfile'.$reglusuario[0]->id;
    					
    					$datopassword = 'powerfile'.$reglusuario[0]->id;
    					
    					$registro = Usuario::findOrFail($reglusuario[0]->id);
    					
    					$registro->password = bcrypt($password);
    					
    					$registro->save();
    					
    					//se envia el correo a la cuenta ingresada (laravel)
    
    				   					
    					/*	$data = array(
    								'name' => "Recuperacion de passwordl",
    						);
    						
    						Mail::send('emails.recuperacion', $data, function ($message) {
    						
    							$message->from('info@siscorp.com.co', 'Recuperacion de password '.$datopassword);
    						
    							$message->to($correo)->subject('´password temporal');
    						
    						});*/
    					
    					//para enviarlo via mail de php
    					
    					$para = $correo;
    					
    					$titulo = trans("principal.msgrecupera");
    					
    					$mensaje = '
    							<html>
									<head>
									  <title>'.trans("principal.titrecupera").'</title>
									</head>
									<body>
    									<img src="http://www.siscorp.com.co/img/powerfile.png">
    									<H4>Powerfile</H4>
										<br>
										<u>'.trans("principal.titrecupera2").'</u><br>
										'.trans("principal.titrecupera3").'
									  <p>'.trans("principal.titrecupera4").'</p>
									  <table border="1">
									    <tr>
									      <th>Login</th>
    									  <th>'.trans("principal.titrecupera5").'</th>
									    </tr>
									    <tr>
									      <td>'.$logind.'</td>
    									  <td>'.$datopassword.'</td>
									    </tr>									    
									  </table>
									</body>
								</html>';
    					
    					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    					
    					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";    					
    					
    					$cabeceras .= 'From: info@siscorp.com.co' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
    					
    					mail($para, $titulo, $mensaje, $cabeceras);
    					
    					
    					
    					
    					
    					
    					
    					/*-------------------*/
    					
    					/*$varnumorigen = 3172963098;          //$_POST['numorigen'];  // e-mail del remitente tomado desdel el form.
    					//$varnomemp = $_POST['nomemp'];        // empresa de telefonía (destino) - idem.
    					$varnumdestino = 3172963098;          //$_POST['numdestino']; // numero de celular (destino) - idem.
    					
    					$empresa = "@comcel.com.co";
    					
    					$titulo = "Recuperacion via sms"; // titulo que aparecerá en el sms del destinatario
    					$headers = "From: " . 'prueba';
    					$headers .= "<" . $varnumorigen . ">\\r\\n"; // e-mail del remitente (esto es 100% obligatorio)
    					$headers .= "Reply-To: " . $varnumorigen; // esta campo no es obligatorio, pero queda bien :)
    					$mensaje = $datopassword; // esta variable contiene el mensaje que enviamos, captado desde el formulario
    					$destino = $varnumdestino.$empresa; // concateno el numero de celular con la empresa
    					
    					mail($destino,$titulo,$mensaje,$headers); // enviamos el mail/sms !*/
    					/*--------------------*/
    					
    					
    					
    					Session::put('mensaje',trans("principal.titrecupera6"));
    					
    					return back();
    					
    				}	
    			else 
    				{
    					Session::put('mensaemail',trans("principal.titrecupera7"));
    					
    					return back();
    				}
    		}
    	else 
    		{
    			Session::put('mensalogin',trans("principal.titrecupera8"));
     	
     			return back();
    		}	
    }
    
   
    
}