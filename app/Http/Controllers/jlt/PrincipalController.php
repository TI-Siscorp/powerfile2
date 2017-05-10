<?php

namespace App\Http\Controllers\jlt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Mail\Message;

//use Telegram\Bot\Laravel\Facades\Telegram;



use Session;

use App\Logo;

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
		
			
			/*\Mail::send('emails.nuevodocum', ['name'=>'jose'], function (message $message) {
			
				$message->to('jose.torres@siscorp.com.co','jose torres')
				->from('josetorresgarcia66@gmail.com','siscorp')
				->subject('Este es un correo automático, no lo responda');
			
			});*/
			
			//return redirect()->route('telegram.getUpdates'); 
			
			/*Telegram::sendMessage([
					'chat_id' => env('@Akiro_veco'),
					'text' => 'hola mundo'
			]);*/
			
			
		return view('principal.index');
	}

}



