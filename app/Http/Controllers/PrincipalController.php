<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class PrincipalController extends Controller
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
				
				
				
				
				
				
			return view('principal.index');
		}
	
}
