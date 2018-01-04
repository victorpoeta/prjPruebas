<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Curl;
use App\Sessions;

class pruebasSesionesController extends Controller
{
    
    public function showTableSessions(Request $request) {

    	if (\Session::has('login')) {

			$Res = Sessions::selectRaw(' id, user_id, ip_address, user_agent, payload, last_activity, login ')->get();

			if (count($Res) > 0) {

				for ($i=0; $i < count($Res); $i++) { 
					$payloadDecode = unserialize(base64_decode($Res[$i]->payload));

					$login = (isset($payloadDecode['login'])) ? $payloadDecode['login'] : '' ;
					$token = (isset($payloadDecode['_token'])) ? $payloadDecode['_token'] : '';
					$userID = (isset($payloadDecode['user_id'])) ? $payloadDecode['user_id'] : $Res[$i]->user_id;
					
					$Resultado[$i] = ['id' => $Res[$i]['id'],
									  'user_id' => $userID,
									  'ip_address' => $Res[$i]['ip_address'],
									  'user_agent' => $Res[$i]['user_agent'],
									  'payload' => $Res[$i]['payload'],
									  'payload_decode' => stripcslashes(json_encode($payloadDecode)),
									  'token_payload' => $token, 
								  	  'login_payload' => $login, 
								  	  'last_activity' => date('d-m-Y h:i:s', ($Res[$i]['last_activity'])),
								  	  'login' => $Res[$i]['login'] ];
				}

				/*if (\Session::has('message')) {
					echo "<script> alert('" . \Session::get('message') . "');</script>";
				}*/

				//dump($_SERVER); // dump($Resultado);
				// echo "Servidor: " . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ;

			}

			return view('showTableSessions', compact('Resultado'));

    	} else {
    		return "Debe estar autenticado para ver está página.";
    	}

	}

	public function deleteSession(Request $request) {
		$Res = Sessions::where('id', '=', $request->input('txtSessionId'))->firstOrFail();
		$Res->delete();

		return redirect()->route('mostrarTablaSesiones')->with(['message' => 'La Sesión ha sido borrada exitosamente.']);
	}

	public function createSession(Request $request) {
		$login = trim(strtoupper($request->input('txtLogin')));

		if ($login == 'ADMIN' and $request->input('txtClave')=='desarrollo') {
			\Session::put('user_admin', 'S');
			\Session::put('id', 100);
		} 

		\Session::put('user_id', '999');
		\Session::put('login', $request->input('txtLogin'));

		return redirect()->route('pruebasSesiones')->with(['message' => 'Sesión iniciada exitosamente.']);
		//return view('Session');
	}

	public function forgetSession(Request $request) {
		//\Auth::logout();
		\Session::forget('user_id');
		\Session::forget('login');
		\Session::forget('user_admin');
		
		return redirect()->route('pruebasSesiones')->with(['message' => 'Su sesión ha sido cerrada con éxito.']);
	}

	public function regenerateSessions($destroy=true) {
		\Session::regenerate($destroy);
	}

}
