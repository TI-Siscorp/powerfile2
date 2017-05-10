<?php

namespace App\Http\Controllers\jlt\Auth;use Lang;
use App\Usuario;
use App\Logo;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
	/*
	 |--------------------------------------------------------------------------
	 | Login Controller
	 |--------------------------------------------------------------------------
	 |
	 | This controller handles authenticating users for the application and
	 | redirecting them to your home screen. The controller uses a trait
	 | to conveniently provide its functionality to your applications.
	 |
	 */
	 
	use AuthenticatesUsers;
	
	

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/login';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}


	public function showLoginForm()
	{
		@session_start();
		
		$salidaurl = $_SESSION['espaciotrabajo'];  
		
		return redirect($salidaurl.'\\');
		//return redirect('/');
	}

	public function login(Request $request)
	{
			
		
		@session_start();
		
		$idioma  = Lang::locale();
		
		$_SESSION['lenguaje'] = $idioma;
		
		$login=$request->input('login');
		$clave=$request->input('password');
		if (auth()->attempt(['login' => trim($login), 'password' => trim($clave)]))
			{
				$user = Auth::user();
				Session::put('id_usuario',$user->id);
				Session::put('nombre',$user->name);
				Session::put('avatar',$user->avatar);
				//se busca el reg logo q este activo
				
				$reglogo = DB::select('select * from sgd_logos where act = 1');
				
				Session::put('logo',$reglogo[0]->nombrelogo);
				
				return view('principal.index');
			}
		else
			{
				
				return back()->with('error','tu correo de usuario o clave estan erradas');
			}
	}
	
	public function logout()
	{
	
		@session_start();
		
		$salidaurl = $_SESSION['espaciotrabajo'];  
		
		Session::put('espaciotrabajo',null);
		
		\Auth::logout();
		\Session::flush();
		
		$_SESSION['espaciotrabajo'] =  null;
		
		unset($_SESSION['espaciotrabajo']);
		
		$_SESSION['espaciotrabajo'] = "s";
		
		return redirect($salidaurl.'\\');
	}
	
	/*public function getLogout()
	{
		Session::put('espaciotrabajo','');
				
		$this->auth->logout();		

		return redirect('logout');
	}*/
}
