<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Sessions;

class deleteSessionIdController extends Controller 
{
    //
	public function deleteSessionsID(Request $request) {

		$sessionLogin = (\Session::get('login')!=null) ? \Session::get('login') : '';

		if ($sessionLogin!='') {

			//$Res = Sessions::where('', '', '');
			return \Session::all();

		} else {
			return 'No existe la sesión login.';
		}

		return $sessionLogin;

	}
}
