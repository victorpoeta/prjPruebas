<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

include 'Wscanguroazul/routes.php';

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/pruebas', function () {
	$cadena='abcdef';
	return "Prueba encriptación " . $cadena . " a MD5: " . md5($cadena);
});

Route::get('/', ['as' => 'home', 'uses' => 'PruebasController@index']);

Route::get('/envioPost', ['as'=>'envio.post', 'uses'=>'PruebasController@envioPost']);
Route::match(['get','post'], '/recibirPost', 'PruebasController@recibirPost');

Route::get('/pruebas/{id}', 'PruebasController@encriptarMD5');

Route::get('/listaUsuarios', 'PruebasController@listaUsuarios');

Route::get('/guardarUsuario','PruebasController@guardarUsuario');

Route::get('/consultaDesarrollo3','PruebasController@mostrarAgencias');


Route::get('/guardarEstatusPago','EstatusPagoController@guardarEP');

Route::get('/mostrarEstatusP','EstatusPagoController@mostrarEP');

Route::get('/modificarEstatusP','EstatusPagoController@modificarEP');

Route::get('/eliminarEstatusP/{id}','EstatusPagoController@eliminarEP');

/***********************************************************/

Route::get('/ConsultarEstatusP','EstatusPagoController@getListaEstatusPago');

Route::get('/estatuspago', function() {
	return view('EstatusPago');
});

Route::get('/consumirWS','PruebasController@consumirWSEstatusPago');

Route::get('/enviarCorreo','PruebasController@enviarCorreo');

Route::get('/encriptarClave','PruebasController@encriptarClave');

Route::match(['get','post'], '/ejemploWsCurl','consumirWSController@ejemploWsCurl');

Route::match(['get','post'], '/consumirAjax','consumirWSController@consumirAjax');

Route::match(['get','post'], '/enviarArchivosPost','consumirWSController@enviarArchivosPost');

Route::get('/WSlogin', function() {
	return view('WSlogin');
});

Route::match(['get','post'], '/pruebaHash', function() {
	return view('pruebaHash');
})->name('pruebaHash');

Route::get('/SoapController','SoapController@demo');

Route::get('arrays',['uses' => 'PruebasController@arrays', 'as' => 'arrays']);

Route::match(['get','post'], '/infoPagosPendientesWS','consumirWSController@loginAppMovil');

Route::match(['get','post'], 'loginAppMovil','consumirWSController@loginAppMovil');

Route::get('/menusUsuarioWs','consumirWSController@menusUsuarioWs');

Route::get('/operacionesFechas','PruebasController@operacionesFechas');


Route::match(['GET','POST'], 'arrayMenus','PruebasController@arrayMenus')->name('arrayMenus');

//Route::match(['GET','POST'], 'callWebServicesOld','consumirWSController@callWebServicesOld', ['middleware' => 'handle_errors'])->name('callWebServicesOld');
Route::match(['GET','POST'], 'callWebServicesOld','consumirWSController@callWebServicesOld')->name('callWebServicesOld');

Route::match(['GET','POST'], 'directorios','PruebasController@directorios')->name('directorios');



/*Route::get('/ejemplo1', ['middleware' => 'sessionPT', function() {

}]);*/

Route::get('/show_sessions', function() {
	dump(\Session::all());
});

Route::get('/numeros_letras/{numero}', function ($numero) {

	return NumeroALetras::convertir($numero);
	//return NumeroALetras::convertir($numero, ($numero == 1) ? 'BOLIVAR' : 'bolivares', 'centimos');
	
/*	$letras = new NumberToLetterConverter();
	return $letras->to_word(192500.00, 'BS');*/

})->name('numeros_letras');

/*Route::get('/cierre_sesion', function() {
	//\Session::flush();
	\Auth::logout();
	\Session::forget('login');
});
*/

Route::get('/cerrar_sesiones', function() {
	\Session::flush();
	// \Session::regenerate();
});

Route::get('/ver_sesion_actual', function() {
	dump(\Session::get('login'));
});

Route::get('delete_sessionsid', ['uses' => 'deleteSessionIdController@deleteSessionsID']);


// Rutas para verificar si el token enviado está activo, para refrescar token, para invalidar token y para crear un token (JWTToken)
Route::match(['get','post'], 'getInfoToken', ['uses' => 'JWTController@getInfoToken', 'as' => 'getInfoToken']);
Route::post('refreshToken', ['uses' => 'JWTController@refreshToken', 'as' => 'refreshToken']);
Route::post('invalidateToken', ['uses' => 'JWTController@invalidateToken', 'as' => 'invalidateToken']);
Route::post('createGenericToken', ['uses' => 'JWTController@createGenericToken', 'as' => 'createGenericToken']);


// Pruebas de autenticación con Auth0
Route::get('auth0', function() {
	return view('Auth0');
})->name('auth0');

Route::match(['get','post'], 'auth0_logged', function() {
	try {
		$requests = \Request::all();
	
		$payload = explode('.', $requests['id_token']);
	    $payloadDecode = json_decode(base64_decode($payload[1]));

	    dump($requests);

	    //if ($payloadDecode->email_verified==true) {
	    if (isset($payloadDecode)) {
	    	dump($payloadDecode);

	    	\Session::put('user_id', $payloadDecode->aud);
			\Session::put('login', $payloadDecode->sub);

	    	//return "<script> alert('Autenticación realizada correctamente'); </script>";
	    	return "Autenticación realizada correctamente.";
	    } else {
	    	return "No se pudo realizar la autenticación del usuario.";
	    }
	} catch (\Exception $e) {
		return "Error al realizar la autenticación: " . $e->getMessage();
	}
	
})->name('auth0_logged');
// -------------------------------------

Route::get('infoPagosT', function() {
	//\Session::flush();

	$url = "http://10.0.10.13/baaszoom/public/canguroazul/loginGenUEWs";  
	$postData = ["login" => "100000788", "claveenc" => "123456"];

	//$Result = link_CURL($url, $postData);
	//echo "<pre style='display:block;'>";
	//
	//echo "<pre>";

	/*$url = "http://10.0.10.13/faaszoom/public/pagoTransferencia/login";  */
	$Result = link_CURL($url, $postData);

	$ResJson = json_decode($Result);
	//dump($Result, $A->codrespuesta);

	if (count($ResJson) > 0 and $ResJson->codrespuesta=='COD_000') {
		//\Session::put('loginUE', $ResJson->entidadRespuesta);
		\Session::set('loginUE', $ResJson->entidadRespuesta->codusuario);

		dump(Session::get('loginUE'));
		//return redirect("http://10.0.10.13/faaszoom/public/pagoTransferencia/create");
	}

});

Route::get('/cierre_sesion_PagosT', function() {
	\Session::forget('loginUE');
});



Route::get('mostrarTablaSesiones', ['uses' => 'pruebasSesionesController@showTableSessions', 'as' => 'mostrarTablaSesiones']);

Route::get('home', function() {
	return view('Session');
})->name('pruebasSesiones');

/*Route::get('showTableSessions', function() {
	return view('showTableSessions');
})->name('showTableSessions');*/

Route::match(['get','post'], 'crear_sesion', ['uses' => 'pruebasSesionesController@createSession', 'as' => 'crear_sesion']);
Route::match(['get','post'], 'cierre_sesion', ['uses' => 'pruebasSesionesController@forgetSession', 'as' => 'cierre_sesion']);

Route::match(['get','post'], 'borrar_sesion', ['uses' => 'pruebasSesionesController@deleteSession', 'as' => 'borrar_sesion']);

Route::match(['get','post'], 'regenerateSessions', ['uses' => 'pruebasSesionesController@regenerateSessions', 'as' => 'regenerateSessions']);

Route::get('enviarArchivos', function() {
	return view('enviarArchivos');
})->name('enviarArchivos');

Route::match(['get','post'], 'upload_files', ['uses' => 'PruebasController@upload_files', 'as' => 'upload_files']);


Route::match(['get','post'], 'conectarSFTP', ['uses' => 'PruebasController@conectarSFTP', 'as' => 'conectarSFTP']);

Route::post('uploadFilesSFTP', ['uses' => 'PruebasController@uploadFilesSFTP', 'as' => 'uploadFilesSFTP']);

Route::match(['get','post'], 'crearPagosWs', ['uses' => 'PagosController@crearPagosWs', 'as' => 'crearPagosWs']);

Route::match(['get','post'], 'getInfoPagosWs', ['uses' => 'PagosController@getInfoPagosWs', 'as' => 'getInfoPagosWs']);

Route::match(['get','post'], 'encriptarCampos', ['uses' => 'PruebasController@encriptarCampos', 'as' => 'encriptarCampos']);

Route::match(['get','post'], 'cartaGuiaInt', ['uses' => 'dompdfController@cartaGuiaInt', 'as' => 'cartaGuiaInt']);

Route::match(['get','post'], 'getZipCodeDHL', ['uses' => 'consumirWSController@getZipCodeDHL', 'as' => 'getZipCodeDHL']);

Route::match(['get','post'], 'getCiudadesDHL', ['uses' => 'consumirWSController@getCiudadesDHL', 'as' => 'getCiudadesDHL']);

Route::post('uploadFileXML', ['uses' => 'PruebasController@uploadFileXML', 'as' => 'uploadFileXML']);

Route::match(['get','post'],'pruebaDistribucionMontos', ['uses' => 'PagosController@pruebaDistribucionMontos', 'as' => 'pruebaDistribucionMontos']);

//\App::abort(500);

Route::get('plantillaPrueba', function() {
	return view('plantillaPrueba');
})->name('plantillaPrueba');

Route::get('CiudadZipCodeDHL', function() {
	return view('CiudadZipCodeDHL');
})->name('CiudadZipCodeDHL');

Route::get('CiudadZipCodeDHL2', function() {
	return view('CiudadZipCodeDHL2');
})->name('CiudadZipCodeDHL2');


Route::match(['get','post'],'crearXML', ['uses' => 'PruebasController@crearXML', 'as' => 'crearXML']);

Route::get('verGuias', function() {
	return view('verGuias');
})->name('verGuias');


Route::match(['get','post'],'getDataCache', ['uses' => 'PruebasController@getDataCache', 'as' => 'getDataCache']);

Route::match(['get','post'],'setDataCache', ['uses' => 'PruebasController@setDataCache', 'as' => 'setDataCache']);

Route::match(['get','post'],'clearCache', ['uses' => 'PruebasController@clearCache', 'as' => 'clearCache']);


Route::match(['get','post'],'generarLicencia', function() {
	return view('generarLicencia');
})->name('generarLicencia');


Route::match(['get','post'],'printTextPrinter', ['uses' => 'PruebasController@printTextPrinter', 'as' => 'printTextPrinter']);

Route::match(['get'],'pruebasCache', function() {
	return view('pruebasCache');
})->name('pruebasCache');

Route::match(['get','post'],'showLogs', ['uses' => 'PruebasController@showLogs', 'as' => 'showLogs']);

//getTrackingDHL
Route::match(['post'],'getTrackingDHL', ['uses' => 'consumirWSController@getTrackingDHL', 'as' => 'getTrackingDHL']);

Route::match(['get','post'],'testEncriptCert', ['uses' => 'consumirWSController@testEncriptCert', 'as' => 'testEncriptCert']);

Route::match(['get','post'],'getDolarTodayWs', ['uses' => 'consumirWSController@getDolarTodayWs', 'as' => 'getDolarTodayWs']);

Route::match(['get','post'],'cleanSpecialCar', ['uses' => 'consumirWSController@cleanSpecialCar', 'as' => 'cleanSpecialCar']);

Route::match(['get','post'],'cleanCacheLaravel', ['uses' => 'consumirWSController@cleanCacheLaravel', 'as' => 'cleanCacheLaravel']);

Route::match(['get'],'LoginPrueba', function() {
	return view('LoginPrueba');
})->name('LoginPrueba');

Route::match(['get','post'],'consultarPagosE', ['uses' => 'consumirWSController@consultarPagosE', 'as' => 'consultarPagosE']);