<?php

namespace App\Http\Controllers\powerfile2;
//use App\Http\Requests;
//use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Usuario;
/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	/*public function __construct()
	 {
	 $this->middleware('guest', ['except' => 'logout']);
	 }*/
	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

}