<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//use App\User;
use App\Usuarios;
use App\Agencia;
use App\EstatusPago;
use Curl;
use App\Sessions;

use App\Http\Controllers\SFTPController;

use Crypt;
use CurlFile;

use Monolog\Handler\StreamHandler;

class PruebasController extends Controller
{

	public function __construct() {
	 	//dd( "Constructor de la clase");
	}

	public function index() {

		//throw new \Exception('Error lanzado a proposito');

		// Función para combinar arreglos
		$campos = ['idpago[]','numlote[]','idestatus[]',null];
		$valores = [[100,101,[103,110]],'1','',''];

		if (count($campos)==count($valores)) {
			$param = array_combine($campos, $valores);
			//dd($param);
		} else {
			echo 'No coinciden los elementos del array';
		}
		
		$rifcipagador = '1-16952402';
		//echo substr($rifcipagador,0,1) . '<br>';
		$caracter= substr($rifcipagador,0,1);

		if (is_numeric(substr($rifcipagador,0,1))) {
			echo "Numeric: ";

			$a = explode('-', $rifcipagador);
			foreach ($a as $key => $value) {
				echo $a[$key] . '|';
			}
		} else {
			echo "string: " . $rifcipagador;
		}
		
		echo "Conteo: " . $this->contarArray($a);

		//echo strstr($rifcipagador, '-' ,true) . '<br>';
		//echo strstr($rifcipagador, '-' ,false);

		echo '<br>-----------------------------------------<br>';
		echo 'Comparación función in_array() <br>';
		$empresas = ['1','2','3','4','5','6','7','8'];

		$a = ['1','2','5'];

		if (in_array(1, $empresas)) {
			echo "Existe: 1" . '<br>';
		}

		if (array_intersect($empresas, $a)) {
			echo "array_intersect - Coincidencias: " . count(array_intersect($empresas, $a));
		}
		echo '<br>-----------------------------------------<br>';

		$campos = ['empresa', 'codguia', 'codfactura', 'montodoc', 
		           'codbanco','idcuentabanco','montototal', 'nompagador', 'emailpagador'];

		$valores = [['1','2','3','4','5','6','7','8'],
		            ['S','S','S','S','S','S','S','S'],
		            ['N','N','N','S','S','S','S','S'],
		            ['N','N','N','S','S','S','S','S'],
		            ['N','N','N','S','S','S','S','S'],
		            ['N','N','N','S','S','S','S','S'],
		            ['S','S','S','S','S','S','S','S'],
		            ['S','S','S','S','S','S','S','S'],
		            ['S','S','S','S','S','S','S','S'],];

		//array_push($campos, 'idestatuspago');
		$reglas = array_combine($campos, $valores);

		//var_dump($reglas);
		//dd($reglas);

/*		foreach ($reglas as $i => $value) {
			echo $i . ': ';
			echo $reglas[$i][0]; echo '<br>';
		} */
		
		// $arrayA = ['empresa'=> 
		//             [
		//                 '1'=>['datosEnvio'=>'S','datosPagador'=>'S','datosTransf'=>'S'], 
		//                 '2'=>['datosEnvio'=>'N','datosPagador'=>'N','datosTransf'=>'S'], 
		//                 '3'=>['datosEnvio'=>'N','datosPagador'=>'N','datosTransf'=>'S']
		//             ] 
		//           ];
		
		// $arrayB = ['empresa'       =>[1,2,3,4], 
		// 		   'datosEnvio'    =>['S','N','N','S'], 
		// 		   'datosPagador'  =>['S','S','S','S'],
		// 		   'datosTransfer' =>['S','S','S','S'] ];

		// $arrayC = ['columnName' => ['empresa', 'datosEnvio', 'datosPagador', 'datosTransfer'], 
		// 		   '1' => ['1','S','S','S'], 
		// 		   '2' => ['2','N','S','S'], 
		// 		   '3' => ['3','N','S','S'],
		// 		   '4' => ['4','S','S','S'] ];

		// $arrayCJson= json_encode($arrayC);

		//dump($arrayCJson);
		//echo $arrayB['empresa'][0];
		//exit();

		/* foreach ($arrayC as $i => $value) {
			echo $i . '|';
		} */

		/*foreach ($arrayC as $key => $value) {
			echo '|';
			echo $arrayC[$key][0] . '|';
			echo $arrayC[$key][1] . '|';
			echo $arrayC[$key][2] . '|';
			echo $arrayC[$key][3] . '|';
			echo '<br>';
		}
		
		$helpers = ['app_path' => app_path(), 'base_path' => base_path(), 
					'resource_path' => resource_path(), 'token'=>csrf_token(), 
		            'path' => config_path(), 'public_path' => public_path(), 
		            'database_path' => database_path()];
		
		dump($helpers);

		$claves = ['idpago','numlote','idestatuspago'];
		$reglas = array_fill_keys(['a','b','c'], 'array');

		$reglas['d'] = 'required|integer';

		$valores = ['1'=>'one','2'=>'two','3'=>'three', '4'=>'four'];
		$plainText = implode('/', (array_values($valores)));
		dump($reglas, $plainText);*/

		//echo phpinfo();
 
        $url = \Request::url();
        
        $prefijo = explode('/', $url);

        dump($prefijo[(count($prefijo) - 1)]); 
    
	}

	public function arrays() {
		/*$a = ['id_pagotarjeta' => [105,125,126,210,255],
			  'lote' => [2,2,2,4,56], 
			  'afiliado' => [14001,14001,15023,19002,23401],
			  'monto' => [1200,242,1900,540,880],
			 ];

		$b['lote'] = $a['lote'];
		$b['afiliado'] = $a['afiliado'];

		dump($a, $b);

		$aa['lote'] = array_unique($a['lote']);

		// $grupoAA = array_values(array_map("unserialize", array_unique(array_map("serialize", $b))));
		$grupoAA = array_values(array_map("unserialize", array_unique(array_map("serialize", $b))));

		dump($aa, $grupoAA);*/

		// $b = array_count_values($a['lote']);

		// $c = array_sum($a['monto']);

		// $a['cuenta'] = $c;

		// dump($a, $b, $c);

		// throw new \Illuminate\Database\QueryException(['Error lanzado a proposito'], ['1'], []);
		//$us = Usuarios::select('vcodusuario')->first();

		$tipoDoc = ['1','1','2'];
		$nroDoc = ['1421012','1852114','02S01-000001'];
		$montoDoc = ['240.52','12000','3100'];
		$sortDocs = ['20160205','20160124','20160111'];	

		for ($i=0; $i < count($tipoDoc); $i++) { 
			$Docs[$i] = ['tipodoc' => $tipoDoc[$i],
						 'nrodoc' => $nroDoc[$i],
						 'montodoc' => $montoDoc[$i],
						 'sortdoc' => $sortDocs[$i] ];
		}

		dump($Docs); 

	    /*foreach ($Docs as $key => $row) {
	        $aux[$key] = $row['montodoc']; // Indica campo a ordenar
	    }
	    
		array_multisort($aux, SORT_ASC, $Docs);*/

		//$this->array_sort_by_column($Docs, 'montodoc');
		sortArrayByCol($Docs, 'montodoc', SORT_DESC); // Helper

		foreach ($Docs as $key => $row) {
			/*$tipoDocSorted[$key] = $row['tipodoc'];
	        $nroDocSorted[$key] = $row['nrodoc'];
	        $montoDocSorted[$key] = $row['montodoc'];*/
	        $tipoDoc[$key] = $row['tipodoc'];
	        $nroDoc[$key] = $row['nrodoc'];
	        $montoDoc[$key] = $row['montodoc'];
		}

		dump($Docs, $tipoDoc, $nroDoc, $montoDoc); 

		$enc1 = encryptAES256_ECB(sha1("Abcd.1234"), 'usuariocasint' . chr(0) . chr(0) . chr(0));
		echo $enc1;

		$enc2 = decryptAES256_ECB($enc1, 'usuariocasint' . chr(0) . chr(0) . chr(0));
		echo "<br>" . $enc2;
	}

	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	    $sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

	    array_multisort($sort_col, $dir, $arr);
	}

	public function operacionesFechas() {
		$FechaActual = date("d/m/Y", strtotime("now"));

		//$nroDiaActual = date("N", strtotime("now -1 day"));

		$arrayFechas = [];
		$cont = 0;
		for ($i=0; $i < 100; $i++) { 
			$numberDay = date("N", strtotime("now -" . $i . " days"));

			$diasLab = [1,2,3,4,5];

			
			if (in_array($numberDay, $diasLab)) {
				$arrayFechas[$cont] = ['nroDia' => date("N", strtotime("now -" . $i . " days")), 
									'fecha' => date("Y-m-d", strtotime("now -" . $i . " days"))];	
				$cont++;
			}	
			if ($cont==31) { break; }
		}

		//$arrayFechas = array_values($arrayFechas);

		dump($arrayFechas);
	}

	public function PruebasSOAP() {
		$wsdl = "http://server/webservice?wsdl";
		$client = new SoapClient($wsdl);
		$result = $client->webservice($parameters);
		print_r($result);
	}

	public function encriptarClave() {
		echo "Random Text Hex: " . $this->randomTextHex(8,1);
		echo "<br>Crear Token: " . $this->crearToken();
		
		echo '<br>Key (mcrypt_encrypt): ' . 'usuariocasint' . chr(0) . chr(0) . chr(0);

		//$clave1 = sha1('v-16952402');
		$clave1 = sha1('123456789');
		//$clave1 = sha1('12345670');
		//$clave1 = sha1('');
		//$clave1 = '53b2ca3144084f1a8237933357475663b611b437';

		$varKey = 'usuariocasint' . chr(0) . chr(0) . chr(0);
		//$varKey = '0123456789abcdef';
		$claveEnc = base64_encode($this->encriptar($clave1, $varKey ));
		$claveDesEnc = ($this->desencriptar(base64_decode($claveEnc), $varKey ));

		echo "<br>" . "Clave (sin encriptar): " . $clave1;
		echo "<br>" . "Clave Encriptada (mcrypt_encrypt): " . $claveEnc;
		echo "<br>" . "Clave Desencriptada: " . $claveDesEnc;

		//$clave2 = '';
		echo "<br>";
		$varKey2 = 'usuariosorinoco' . chr(0);
		$claveEnc2 = "nhHuFTjjWGvtFN6Kae/gUxCF4R1EJtf6iKg2D850L0Nm35leSnU+xxhvjddbh5hxVwms2AadWlY58zuSatsT6w==";
		$claveDesEnc2 = ($this->desencriptar(base64_decode($claveEnc2), $varKey2 ));
		echo "<br>" . "Clave Desencriptada : " . $claveDesEnc2;
		
		//echo "<br>comprobarClaveEnc: " . $this->comprobarClaveEnc('2111173733637816941311232821299829853026','sha1');
		
		echo "<br>Bcrypt: " . bcrypt('123456Sys0Zm#7348') . '<br>';
		echo \Hash::make('123456Sys0Zm#7348');

		
	}

	private function encriptar($cadena, $clave) {
		$cifrado = MCRYPT_RIJNDAEL_256;
		$modo = MCRYPT_MODE_ECB;
		
		//$iv = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

		$encriptado=mcrypt_encrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));
		//$encriptado=mcrypt_encrypt($cifrado, $clave, $cadena, $modo, $iv);

		return $encriptado;
	}

	private function desencriptar($cadena, $clave) {
		$cifrado = MCRYPT_RIJNDAEL_256;
		$modo = MCRYPT_MODE_ECB;
		
		$desencriptado=mcrypt_decrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));

		return $desencriptado;
	}

	// 
	private function comprobarClaveEnc($clave, $algoritmo) { 
		$long = strlen(trim($clave));
		
		if ($algoritmo=='sha1' && $long==40) {
			if (preg_match('/[0-9a-f]{40}/', $clave, $coincidencia)) {
				return 'OK';
			} else {
				return 'Error: no coincide la expresión regular con el algoritmo SHA1';
			}
			
		} elseif ($algoritmo=='md5' && $long==32) {
			if (preg_match('/[0-9a-f]{32}/', $clave, $coincidencia)) {
				return 'OK';
			} else {
				return 'Error: no coincide la expresión regular con el algoritmo MD5';
			}
		} else {
			return 'Error: algoritmo y/o longitud inválidos.';
		}

	}

	private function randomTextHex($longitud, $mayus=false) {
		$sha1 = sha1(microtime() * time());
		$string = substr($sha1,0,$longitud);
		
	    if ($mayus==1) $string = utf8_decode(mb_strtoupper($string));
		
	    return $string;
	}

	private function crearToken(){
		//funcion para crear el token a enviar al usuario
		
		//alimentamos el generador de aleatorios
		mt_srand (time());
		//generamos un número aleatorio
		//Ahora le agregamos letras 
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
		$numerodeletras=7; //numero de letras para generar el texto
		$cadena = ""; //variable para almacenar la cadena generada  
		for($i = 0;$i < $numerodeletras; ++$i){
		  $cadena.= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
		   entre el rango 0 a Numero de letras que tiene la cadena */
		  $cadena.= mt_rand(1, 15000);
		}
		return $cadena;
	}

	public function wsCurl() {

		echo "Web Services (CURL):";

		/*$url = 'http://10.0.10.13/baaszoom/public/canguroazul/registerUsuarioCasIntWs';*/

        //$url = "http://10.0.10.13/baaszoom/public/canguroazul/registro/login";  
		//$postData = ["login" => "victorpoeta@gmail.com", "claveenc" => "V-16952402"];  

		$url = "http://10.0.10.13/baaszoom/public/canguroazul/login";  
		$postData = ["login" => "vpoeta", "claveenc" => "V-16952402"];


		/*$handler = curl_init();  

		//curl_setopt($handler, CURLOPT_HTTPHEADER, $header);
		curl_setopt($handler, CURLOPT_URL, $url); 
		curl_setopt($handler, CURLOPT_POST, 1); 
		curl_setopt($handler, CURLOPT_POSTFIELDS, $postData);  
		curl_setopt($handler,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($handler, CURLOPT_FOLLOWLOCATION, 1);

		$Result = (curl_exec($handler));*/
		
		$Result = $this->funcionCURL($url, $postData);

		//curl_close($handler); 

		//$codRes = substr($Result, 17,7);
		echo "<pre style='display:block;'>";
		print_r($Result);
		echo "<pre>";
		/*
		if ($codRes=='COD_000') {
			echo "Login exitoso.";
		} else {
			echo $Result;
		}*/

	}

	private function funcionCURL($url, $data, $method_post=1) {
		$handler = curl_init();  

		curl_setopt($handler, CURLOPT_URL, $url); 
		curl_setopt($handler, CURLOPT_POST, $method_post); 
		curl_setopt($handler, CURLOPT_POSTFIELDS, $data);  
		curl_setopt($handler,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($handler, CURLOPT_FOLLOWLOCATION, 1);

		return (curl_exec($handler));
	}

	private function contarArray($a) {
		$valor = count($a);
		return ($valor==1) ? 'uno' : $valor;
	}

	protected function encriptarMD5 ($valor) {
		$cadena='abcdef';
		return "Valor (" . $valor . ") encriptado a MD5: " . md5($cadena);

	}

	public function listaUsuarios() {
		try {
			throw new \InvalidArgumentException('Error lanzado a proposito 2');
			
			echo "Lista de usuarios:" . "<br>";
			//$user = usuarios::find(16952402);
			//echo $user->login;

			$usuarios = usuarios::all();
			foreach( $usuarios as $user ) {
				echo $user->id_usuario; echo "   ";
				echo $user->login; echo "<br>";
			}
		} catch (\Exception $e) {
			return "Error capturado:" . $e->getMessage() . "; Instancia: " . get_class($e);
		}

	}

	public function guardarUsuario() {
		$user=new usuarios;
		$user->id_usuario = '19201';
		$user->login='prueba1920';
		$user->clave=md5('111');

		$user->save();
		
		echo "El registro del usuario ha sido guardado con éxito!";
	}


	public function mostrarAgencias() {
		$ciudad='CARACAS';
		$agencia = agencia::where('ciudad', '=', $ciudad)->get();

		/*
		foreach( $agencia as $ag ) {
			echo $ag->codagencia; echo "      ";
			echo substr($ag->nombre,0,30); echo "      ";
			echo $ag->ciudad; echo "<br>";
		}
		*/
		//echo "Total Registros: " . $ag->count(); // Registros totales
		
		$TotalReg= agencia::where('ciudad', '=', $ciudad)->count();

		return view('agencias', ['resultado'=>$agencia, 
								 'ciudad'=>$ciudad, 
								 'total_reg'=>$TotalReg]);

	}

	public function guardarEstatusPago() {
		$estatus= new EstatusPago;
		$estatus->nombre=substr('Prueba', 0,40);

		$estatus->save();

		echo "El estatus de pago " . $estatus . " ha sido guardado con éxito!";

	}

	public function mostrarEP() {
		//$result= \DB::table('estatuspago')->get();
		$result = \DB::select('SELECT * FROM estatuspago 
							   WHERE idestatuspago = :idestatuspago', 
							   ['idestatuspago' => 2]);

		dd($result);
	}

	public function modificarEP() {
		$affected = \DB::update("UPDATE estatuspago 
								 SET nombre = 'Estatus 1' 
								 WHERE idestatuspago = :codigo", ['codigo'=>1]);
		
		echo "El estatus de pago ha sido modificado!";
	}

	public function consumirWSEstatusPago(Request $request) {
		// $parametros,$url='customs.url_baaszoom',$pagina='canguroazul/'

		$id= $request->get('idestatuspago');
		$url = 'http://localhost/prjPruebas/public/consumirWS';
		$parametros = 'idestatuspago=' . $request->get('idestatuspago');

		//$url=config($url);
		//$nameWS= 'getListaEstatusPago';
		//$parametros='';
		//$response = Curl::to($url.$pagina.$nameWS)

		$response = Curl::to($url)
		->withData($parametros)
		//->withOption('FAILONERROR', false)
		//->enableDebug('/var/www/html/cubesum/logFile.txt')
		->asJson(true)
		//->withContentType('application/json')
		->get();
		
		//echo $url;

		return $response;

	}

	public function enviarCorreo(Request $request) {
		$emailsSends = 0;

		for ($i=1; $i < 2 ; $i++) { 
			$Sent = \Mail::send('contacto', $request->all(), function($msj){
				//$msj->from('victorgabrielpoeta@gmail.com');
				$msj->from('mensajero@grupozoom.com');
            	$msj->subject('Correo de Prueba ZOOM - Pago por transferencia');
            	$msj->to('victorpoeta@gmail.com');
        	});

			if ($Sent) {
				$emailsSends = $emailsSends + 1;
				//return "Correo enviado!";	
			} else {
				//return "No se pudo enviar el correo!";
			}
		}
		
		if ($emailsSends>=1) { 
			Session::flash('message', $emailsSends . ' correo/s enviado/s.');
			return $emailsSends . " correo/s enviado/s.";
		} else {
			return "No se pudo enviar el correo!";
		}
        
	}

	public function envioPost() {
		$style[1]= 'font-size:15px;font-family:verdana;color:darkblue;background-color:lightblue;padding-left:10px;';
		$style[2]= 'color:white;background-color:steelblue;border-radius:6px;padding:5;border:0px;';
		$url = '/recibirPost';
		$urlPT = 'http://10.0.10.13/faaszoom/public/pagoTransferencia/home';

		$FormEmpresa = "<strong>Método POST:</strong><br> <br>
					   <form name='form' style=$style[1] method='POST' action=$url >" .
		 					"<strong>Seleccione Empresa: </strong>" . 
							  "<select name='cboEmpresa' id='cboEmpresa'>" .
							  	  "<option value=''>-</option>" .
							  	  "<option value='1'>Zoom</option>" .
							  	  "<option value='2'>Logistics</option>" .
							  	  "<option value='7'>Casa de Cambio</option>" .
							  "</select>" . 
							" <input type='hidden' name='url' value=$urlPT />" . 
		 					" <button type='submit' style=$style[2]; > Pago por Transferencia </button>" .
		 			   "</form>";
		echo $FormEmpresa . '<hr>';
	}

	public function recibirPost(Request $request) {
		$empresa = $request->input('cboEmpresa');
		$urlPagoTransf = $request->input('url');

		if (!empty($empresa)) {
			return 'Empresa seleccionada: ' .  $empresa . '<br>' . 
			       "<form name='formEnvio' method='POST' action=$urlPagoTransf >".
			       		"<input type='hidden' name='empresa' id='empresa' value=$empresa />" . 
 			       		"<button type='submit'>Pago por Transferencia</button>" .
			       "</form>";
			       
			//"<a href='" . $urlPagoTransf . "'>Pago por Transferencia</a>";

		} else {
			//return "<font color='red'>Debe seleccionar una empresa</font>";
			return redirect()->route('envio.post');
		}
		
	}

	public function directorios() {
		//dump(url('/'));
		$this->listar_directorios_ruta('C:/xampp/htdocs/prjPruebas/app/');
	}

	function listar_directorios_ruta($ruta) { 
	   // abrir un directorio y listarlo recursivo 
	   if (is_dir($ruta)) { 
	      if ($dh = opendir($ruta)) { 
	         while (($file = readdir($dh)) !== false) { 
	            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio 
	            //mostraría tanto archivos como directorios 
	            // echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file); 
	            if (is_dir($ruta . $file) && $file!="." && $file!="..") { 
	               //solo si el archivo es un directorio, distinto que "." y ".." 
	               echo "<br><b>$ruta$file</b>"; 
	               $this->listar_directorios_ruta($ruta . $file . "/"); 
	            } else {
	            	if ($file!='.' && $file!='..') {
	            		$propFile = stat($ruta . $file);
	            		echo "<br><i> $ruta$file</i>" . "  Size: " . number_format(($propFile['size'] / 1024),3) . ' KB';
	            	}
	            }
	         } 
	      closedir($dh); 
	      } 
	   } else 
	      echo "<br>No es ruta valida " . $ruta; 
	}


	public function arrayMenus(Request $request) {

		//dd(config('jwt.user'));
		//dd(\Cache::has('jwt.storage'));

	try {
			
		$url = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/getInfoUsuarioperfilWs";  
		$params = ["relacion_codusuario[]" => 6078];

		$response = Curl::to($url)->withData($params)
						->asJson(true)->withContentType('application/json')
						->get();

		if ($response=='' || $response==null) {
			return "No hay respuesta del servicio web getInfoUsuarioperfilWs";
		}

		sortArrayByCol($response['entidadRespuesta'], 'id_perfil');
		

		if ($response['codrespuesta'] == 'COD_000') {

			$BB = [];

			foreach ($response['entidadRespuesta'] as $clave => $valor) {

				$orden_desc = $response['entidadRespuesta'][$clave]['listmodulo']['nombre'] . ';' .
							  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['nombre'] . ';' .
							  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['nombre'] . ';' .
							  $valor['listmenuperfil']['listmenu']['nombre'];

				$orden_desc = str_replace(";;;", ";;", $orden_desc);
				$orden_desc = str_replace(";;", ";", $orden_desc);

				$mnus[$clave] = ['modulo'    =>  $response['entidadRespuesta'][$clave]['listmodulo']['nombre'], 
								 'icono'     =>  $response['entidadRespuesta'][$clave]['listmodulo']['icono'],
								 'nivel1'    =>  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['nombre'],
								 'nivel2'    =>  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['nombre'], 
								 'id_menu'   =>  $valor['listmenuperfil']['listmenu']['id_menu'], 
								 'menu'      =>  $valor['listmenuperfil']['listmenu']['nombre'], 
								 'ruta_menu' =>  $valor['listmenuperfil']['listmenu']['ruta_vista'], 
								 'orden'	 =>  $orden_desc];
			}
			
			sortArrayByCol($mnus, 'orden');

/*			foreach ($mnus as $key => $value) {
				if (strtoupper($mnus[$key]['modulo'])=='CONCILIACIONES') {
					unset($mnus[$key]);
				}
			}*/
			foreach ($response as $key => $value) {
				dump(gettype($value));
				if (is_array($value)) {
					dump(count($value));
				}
			}

			foreach ($mnus as $key => $value) {
				array_push($BB, "modulo::" . $value['modulo'] . "::" . $value['icono'] );

				if ($value['nivel1']!=null) { 
					array_push($BB, "nivel1::" . $value['nivel1'] ); 
				}

				if ($value['nivel2']!=null) { 
					if ($value['nivel1']==null) {
						array_push($BB, "nivel1::" . $value['nivel2'] ); 
					} else {
						array_push($BB, "nivel2::" . $value['nivel2'] ); 
					}
				}

				if ($value['ruta_menu']!='#' && $value['ruta_menu']!=null && trim($value['ruta_menu'])!='') {
					array_push($BB, "menu::" . $value['menu'] . "::" . $value['ruta_menu'] );
				}
				
			}

			$BB = array_values(array_unique($BB));

			dump($mnus, $BB);

			$menuFinal = [];
			$ModRand = 0; $Nv1sRand = 0; $Nv2Rand = 0;

			for ($i=0; $i < count($BB); $i++) { 
				$nameMenu = explode('::', $BB[$i]);

				if ($nameMenu[0] == 'modulo') {
					$ModRand = rand(1000000,9999999);
					$Nv1Rand = 0; $Nv2Rand = 0;

					$menuFinal['modulo'][$ModRand] = ['nombre' => $nameMenu[1],
											          'icono' => $nameMenu[2], 
											          'mod_rand' => $ModRand];

				} elseif ($nameMenu[0] == 'nivel1') {
					$Nv1Rand = rand(1000000,9999999);
					$Nv2Rand = 0;

					$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand] = ['nombre' => $nameMenu[1], 
																		  'nv1_rand' => $Nv1Rand];

				} elseif ($nameMenu[0] == 'nivel2') {
					$Nv2Rand = rand(1000000,9999999);

					$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$Nv2Rand] = ['nombre' => $nameMenu[1], 
																							  'nv2_rand' => $Nv2Rand];

				} elseif ($nameMenu[0] == 'menu') {

					if ($Nv1Rand == 0 && $Nv2Rand == 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$i] = ['nombre' => $nameMenu[1], 
																		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand > 0 && $Nv2Rand == 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$i] = ['nombre' => $nameMenu[1], 
																					   		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand == 0 && $Nv2Rand >= 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv2Rand]['nivel2'][$i] = ['nombre' => $nameMenu[1], 
																					   		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand > 0 && $Nv2Rand > 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$Nv2Rand]['menu'][$i] = ['nombre' => $nameMenu[1], 
																											  'ruta' => $nameMenu[2]];
					}

				}

			}

			dump($menuFinal);

		}

	} catch (\Exception $e) {
		return $e;
	}

	}



	public function arrayMenus_2(Request $request) {
		$url = "http://10.0.10.13/baaszoom/public/canguroazul/getInfoUsuarioperfilWs";  
		$params = ["relacion_codusuario[]" => 6078];

		$response = Curl::to($url)->withData($params)
						->asJson(true)->withContentType('application/json')
						->get();

		if ($response=='' || $response==null) {
			return "No hay respuesta del servicio web getInfoUsuarioperfilWs";
		}

		if ($response['codrespuesta'] == 'COD_000') {
			dump($response['entidadRespuesta']);

/*			foreach ($response['entidadRespuesta'] as $key => $value) {
				$menu[$key]['modulo'] = [ $value['listmodulo']['nombre'], $value['listmodulo']['icono'] ];

				$menu[$key]['menu'] = [$value['listmenuperfil']['listmenu']['nombre'],
				 					   $value['listmenuperfil']['listmenu']['ruta_vista'] ];

				if ($value['listmenuperfil']['listmenu']['listmenupadre']) {
					$menu[$key]['nivel2'] = [$value['listmenuperfil']['listmenu']['listmenupadre']['nombre'], 
					 						$value['listmenuperfil']['listmenu']['listmenupadre']['ruta_vista']];

				} else {
					$menu[$key]['nivel2'] = ['NT'];
				}

				if ($value['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']) {
					$menu[$key]['nivel1'] = [$value['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['nombre'],
					 						$value['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['ruta_vista']];	

				} else {
					$menu[$key]['nivel1'] = ['NT'];
				}

				$menuGen['modulo'][$menu[$key]['modulo'][0]]['icono'][$menu[$key]['modulo'][1]]['nivel1'][$menu[$key]['nivel1'][0]]
						['nivel2'][$menu[$key]['nivel2'][0]]['menu'][$key] = $menu[$key]['menu'];

			}*/

			// ******************************************************************************
			$BB = [];

			foreach ($response['entidadRespuesta'] as $clave => $valor) {
				$orden = str_pad($response['entidadRespuesta'][$clave]['listmodulo']['id_modulo'], 3,"0", STR_PAD_LEFT) . 
						 str_pad($response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['id_menu'], 3, "0", STR_PAD_LEFT) . 
						 str_pad($response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['id_menu'], 3, "0", STR_PAD_LEFT) . 
						 str_pad($valor['listmenuperfil']['listmenu']['id_menu'], 3, "0", STR_PAD_LEFT);

				$mnus[$clave] = ['modulo'    =>  $response['entidadRespuesta'][$clave]['listmodulo']['nombre'], 
								 'icono'     =>  $response['entidadRespuesta'][$clave]['listmodulo']['icono'],
								 'nivel1'    =>  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['listmenupadre2']['nombre'],
								 'nivel2'    =>  $response['entidadRespuesta'][$clave]['listmenuperfil']['listmenu']['listmenupadre']['nombre'], 
								 'id_menu'   =>  $valor['listmenuperfil']['listmenu']['id_menu'], 
								 'menu'      =>  $valor['listmenuperfil']['listmenu']['nombre'], 
								 'ruta_menu' =>  $valor['listmenuperfil']['listmenu']['ruta_vista'], 
								 'orden'	 =>  $orden ];
			}
			
			// sortArrayByCol($mnus, 'nivel2');
			// sortArrayByCol($mnus, 'nivel1');
			// sortArrayByCol($mnus, 'modulo');
			sortArrayByCol($mnus, 'orden');

			foreach ($mnus as $key => $value) {
				array_push($BB, "modulo::" . $value['modulo'] . "::" . $value['icono']);

				if ($value['nivel1']!=null) { 
					array_push($BB, "nivel1::" . $value['nivel1']); 
				}

				if ($value['nivel2']!=null) { 
					if ($value['nivel1']==null) {
						array_push($BB, "nivel1::" . $value['nivel2']); 
					} else {
						array_push($BB, "nivel2::" . $value['nivel2']); 
					}
				}

				array_push($BB, "menu::" . $value['menu'] . "::" . $value['ruta_menu']);
			}

			$BB = array_values(array_unique($BB));
			dump($mnus, $BB);
			//exit();
			// ***********************************************************************************

			// $A = [];

			/*foreach ($menuGen['modulo'] as $key => $value) {
				//array_push($A, $key);

				foreach ($menuGen['modulo'][$key]['icono'] as $keyIcon => $valueIcon) {

					array_push($A, "modulo::" . $key . '::' . $keyIcon);
					//echo $key . "<br>";
				
					foreach ($menuGen['modulo'][$key]['icono'][$keyIcon]['nivel1'] as $key2 => $value2) {

						if ($key2 != 'NT') {
							array_push($A, "nivel1::" . $key2);
						} 
						//echo "---" . $key2 . "<br>";
						
						foreach ($menuGen['modulo'][$key]['icono'][$keyIcon]['nivel1'][$key2]['nivel2'] as $key3 => $value3) {

						 	if ($key3 != 'NT') {
							 	if ($key2 == 'NT') {
							 		array_push($A,  "nivel1::" . $key3);
							 	} else {
							 		array_push($A,  "nivel2::" . $key3);
							 	}
						 	}
							//echo "------" . $key3 . "<br>" ;

						 	foreach ($menuGen['modulo'][$key]['icono'][$keyIcon]['nivel1'][$key2]['nivel2'][$key3]['menu'] as $key4 => $value4) {

							 	array_push($A, "menu::" . $value4[0] . "::" . $value4[1]);
							 	//echo "---------><b>" . $value4[0] . "</b> (Ruta: " . $value4[1] . ")<br>";
						 	}

						}

					}
				}

			}*/

			//dump ($menuGen, $A);

			$menuFinal = [];

			$ModRand = 0; $Nv1sRand = 0; $Nv2Rand = 0;

			for ($i=0; $i < count($BB); $i++) { 
				$nameMenu = explode('::', $BB[$i]);

				if ($nameMenu[0] == 'modulo') {
					$ModRand = rand(1000000,9999999);
					$Nv1Rand = 0; $Nv2Rand = 0;

					$menuFinal['modulo'][$ModRand] = ['nombre' => $nameMenu[1],
											          'icono' => $nameMenu[2], 
											          'mod_rand' => $ModRand];

				} elseif ($nameMenu[0] == 'nivel1') {
					$Nv1Rand = rand(1000000,9999999);
					$Nv2Rand = 0;

					$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand] = ['nombre' => $nameMenu[1], 
																		  'nv1_rand' => $Nv1Rand];

				} elseif ($nameMenu[0] == 'nivel2') {
					$Nv2Rand = rand(1000000,9999999);

					$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$Nv2Rand] = ['nombre' => $nameMenu[1], 
																							  'nv2_rand' => $Nv2Rand];

				} elseif ($nameMenu[0] == 'menu') {

					if ($Nv1Rand == 0 && $Nv2Rand == 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$i] = ['nombre' => $nameMenu[1], 
																		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand > 0 && $Nv2Rand == 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$i] = ['nombre' => $nameMenu[1], 
																					   		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand == 0 && $Nv2Rand >= 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv2Rand]['nivel2'][$i] = ['nombre' => $nameMenu[1], 
																					   		'ruta' => $nameMenu[2]];
					} elseif ($Nv1Rand > 0 && $Nv2Rand > 0) {
						$menuFinal['modulo'][$ModRand]['nivel1'][$Nv1Rand]['nivel2'][$Nv2Rand]['menu'][$i] = ['nombre' => $nameMenu[1], 
																											  'ruta' => $nameMenu[2]];
					}

				}

			}

			dump($menuFinal);

			foreach ($menuFinal['modulo'] as $k => $v) {
				echo "<ul><b>" . $v['nombre'] . "</b>\n";

				foreach ($menuFinal['modulo'][$k]['nivel1'] as $k2 => $v2) {
					//echo "  <li>" . $v2['nombre'] . "\n";

					if (isset($menuFinal['modulo'][$k]['nivel1'][$k2]['nivel2'])) {
						echo "  <ul>" . $v2['nombre'] . "\n";

						foreach ($menuFinal['modulo'][$k]['nivel1'][$k2]['nivel2'] as $k3 => $v3) {
							$ruta = (isset($v3['ruta'])) ? $v3['ruta'] : '';

							if (isset($menuFinal['modulo'][$k]['nivel1'][$k2]['nivel2'][$k3]['menu'])) {
								echo "    <ul>" . $v3['nombre'] . " " . $ruta . "\n";

								foreach ($menuFinal['modulo'][$k]['nivel1'][$k2]['nivel2'][$k3]['menu'] as $k4 => $v4) {
									echo "      <li>" . $v4['nombre'] . " " . $v4['ruta'] . "</li>" . "\n";
								}

								echo "    </ul> \n";
							} else {
								echo "    <li>" . $v3['nombre'] . " " . $ruta . "</li> \n";
								//dump($v3);
							}

						}

						echo "  </ul>" . "\n";
					} else {
						echo "  <li>" . $v2['nombre'] . "</li> \n";
					}

				}

				echo "</ul>" . "\n";
			}

		}

	}

	public function upload_files(Request $request) {
		//$archivo = $request->input('file_pdf');
		$archivo = $request->file('files');

		dd(count($archivo), $archivo);
		
		foreach ($archivo as $key => $value) {
			//echo $archivo[$key] . '<br>';
			\Storage::disk('archivos')->put('files_' . $key . '.pdf', \File::get($archivo[$key]));
		}
		
		echo "Archivos guardados!";

		$exists = \Storage::disk('host_imagenes')->exists('PruebaVictorPoeta.txt');

		echo $exists;

		exit();

		if ($archivo == '') {
			dd("Debe subir un archivo válido.");
		} else {

			$request->merge(['files[0]' => "Archivo_1.pdf" ]);

			echo "Original Name:" .  $archivo->getClientOriginalName() . "<br>";
			echo 'Original Extension: '. $archivo->getClientOriginalExtension() . "<br>"; 
			echo 'File Real Path: '.$archivo->getRealPath() . "<br>"; 
			echo 'Size: ' . $archivo->getSize() . " bytes<br>"; 
			echo 'Mime Type: ' . $archivo->getMimeType() . "<br>"; 
		}

		// echo "--------------------------------------------- <br>";

		// $encriptarAES = new \Crypt_AES();
		// $encriptarAES->setKey('usuariocasint');
		// $encriptarAES->setKeyLength(224);

		// //dump($encriptarAES);
  		//   	$plaintext = "abcd.1234";

  		//   	echo base64_encode($encriptarAES->encrypt($plaintext));
 		// 	echo $encriptarAES->decrypt($encriptarAES->encrypt($plaintext));

	}


	public function conectarSFTP(Request $request) {
		$file = $request->input('file');

		dd($request->all());

		//$obj = new \Net_SFTP("10.8.16.9", 22, 30);
		$obj = new \Net_SFTP(config('customs.host_files.host'), config('customs.host_files.port'), 30);

    	if (!$obj->login(config('customs.host_files.user'), config('customs.host_files.pass')) ) {
			$Result = ["code" => "error_sftp", "message" => "No se pudo realizar la conexion con el host"];
		} else {
			$Result=["code" => "ok_sftp", "message" => "Conexion exitosa"];
			#$Result['response']['put'] = $obj->put('PruebaVictorPoeta.txt', 'Prueba Victor Poeta, modificado');
			//$Result['response']['mkdir'] = $obj->mkdir("/home/pagotransferencia");
			$Result['response']['pwd'] = $obj->pwd();
			//$listFiles = $obj->nlist("/home/gestioncalidad/");
			$listFiles = $obj->nlist("/home/gestioncalidad/");

			$listaArchivos=[];
			//dd(count($listFiles));

			if (gettype($listFiles) == 'object' || gettype($listFiles) == 'array') {
				foreach ($listFiles as $key => $value) {
					/*if (strpos($value, '.pdf')==true || strpos($value, '.jpg')==true || 
						strpos($value, '.png')==true || strpos($value, '.txt')==true) {*/
					if (strpos($value, '.pdf')==true) {
						$listaArchivos[$key] = utf8_encode($value);
					}
				}
				$listaArchivos = array_values($listaArchivos);

			}

			//dump($listFiles[0]);
			$Result['response']['nlist'] = $listaArchivos;
			$Result['response']['file_exists'] = $obj->file_exists("/home/");
			$Result['response']['is_file'] = $obj->is_file("PruebaVictorPoeta.txt");
			//$Result['response']['dir-size'] = $obj->size("/home/gestioncalidad/imagenes/");
			$Result['response']['size'] = $obj->size("PruebaVictorPoeta.txt");
			$Result['response']['lstat'] = $obj->lstat("PruebaVictorPoeta.txt");

			//$Result['response']['get'] = $obj->get("PruebaVictorPoeta.txt");
			//$Result['response']['get'] = base64_encode($obj->get("UPLOADSFTP_GUIA159.jpg"));

			//$Result['response']['get'] = base64_encode($obj->get("UPLOADSFTP_guiaElectronica1096687759.pdf"));
			$Result['response']['get_2'] = \File::get("UPLOADSFTP_guiaElectronica1096687759.pdf") ;
		}

		$obj->disconnect();
		
		return $Result;

		//return "<img src='data:image/jpeg;base64," . $Result['response']['get'] . "' >";
		//return "<object data='data:application/pdf;base64," . $Result['response']['get'] . "' type='application/pdf' width='400px' height='400px'> </object>";

	}

	public function uploadFilesSFTP(Request $request) {
		$files = $request->file('files');

		foreach ($files as $key => $value) {
			if ($files[$key]->getClientOriginalExtension()!='pdf') {
				return ['codrespuesta' => 'CODE_003', "mensaje" => "ERROR EN LA LLAMADA AL SERVICIO", 
						'entidadRespuesta' => ['Los archivos deben tener únicamente extensión .pdf']];
			}
		}

		$obj = new \Net_SFTP(config('customs.host_files.host'), config('customs.host_files.port'), 30);

    	if (!$obj->login(config('customs.host_files.user'), config('customs.host_files.pass')) ) {
			$Result = ["codrespuesta" 		=> "CODE_003",
					   "mensaje"      		=> "ERROR EN LA LLAMADA AL SERVICIO",
					   "entidadRespuesta" 	=> ["No se pudo realizar la conexion con el servidor de imagenes"] ];

		} else {

			$Result=["codrespuesta" => "COD_001", "mensaje" => "INGRESO REALIZADO EXITOSAMENTE"];
			
			$cambiarDir = $obj->chdir(config('customs.host_files.ini_dir'));
			$Result['entidadRespuesta']['ruta'] = $obj->pwd();

			foreach ($files as $key => $value) {
				$nombreArchivo = 'comprob_' . $key . '_' . $request->get('txtIdPago') . '.pdf';
				$Result['entidadRespuesta']['upload_files'][$key] = ['put' => $obj->put($nombreArchivo, \File::get($files[$key])) ,
													   		   		 'name_file' => $nombreArchivo,
													   		   		 'size' => $files[$key]->getSize() ];
			}

		}

		$obj->disconnect();
		
		return $Result;
	}

	public function uploadFileXML(Request $request) {

		/*$archivoXML = $request->file('archivo');
		$xml = \File::get($archivoXML);
		//return $xml;

		//$A = simplexml_load_string($xml,null, LIBXML_NOWARNING);
		$A = @simplexml_load_string($xml);
		$A->getNamespaces(true);

		print_r($A->reference[4]->getNamespaces());
		//print_r($A->reference[4]);
		//return response()->json($A);*/

		//return $request->file('archivo');

		$url = 'http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/createGuiaPreAlertWs';
		//$parametros = ['archivo' => \File::get($request->file('archivo'))];

		$parametros = ['filexml' => new CurlFile($request->file('filexml')), 
					   //'nombre_original_archivo' => $request->file('archivo')->getClientOriginalName() 
						'ajax_namefilexml' => $request->input('nombre_original_archivo')
						];

		$response = Curl::to($url)
						->withData($parametros)
						//->asJson(true)
						//->withContentType('application/json')
						->withContentType('multipart/form-data')
						->containsFile()
						->post();

		return $response;

	}


	public function encriptarCampos(Request $request) {
		// \App::abort(500);
		//dump($request->server());
		//request()->request->set('param1', ltrim($request->get('param1'), '0') );
		//return $request->all();

		$longClave = $request->input('length');
		if ($longClave==null || $longClave=='') { 
			$longClave = 32;
		} elseif ($longClave > '64') {
			$longClave = 64;
		} elseif ($longClave < '8') {
			$longClave = 5;	
		}

		//$Strings = str_shuffle(str_shuffle(str_shuffle(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz"))));
		$Strings = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789";
		for ($i=0; $i < 100; $i++) { 
			$Strings = str_shuffle($Strings);
		}

		$claveCliente = substr($Strings, 0, $longClave);
		return $claveCliente;
		// --------------------------------------------------

		/*$claveEnc = 'EEF19C0448';

		$nuevaClave = '$' . str_shuffle('TuVWxYMj') . substr($claveEnc,0,5) . str_shuffle('MzYgPQRSTh') . 
					  substr($claveEnc,5,10) . str_shuffle('.vxMUqwZpQ') ;

		$a = range('O', 'Z');

		$ab = '$2y$10$' . base64_encode(base64_encode(base64_encode($claveEnc))) . str_shuffle('.UqWzpQxYr');

		$aes = new \Crypt_Rijndael(CRYPT_MODE_CBC);
		$aes->setKey('zoom');
		$claveAES = base64_encode($aes->encrypt('123456'));

		dd( $claveEnc, $nuevaClave, $ab, $claveAES );
		return $nuevaClave;*/

	}

	public function crearXML() {
		$xml = new \DomDocument('1.0', 'UTF-8');
 
	    $detalle = $xml->createElement('Detalle');
	    $detalle = $xml->appendChild($detalle);
	    
	    for ($i=0; $i < 1000; $i++) { 
	    	$reference = $xml->createElement('reference');
	    	$reference = $detalle->appendChild($reference);

		    // Agregar un atributo a reference
		    $reference->setAttribute('xmlns', 'VP' . $this->randomTextHex(12,1) );
		 
		    $shipmentReference = $xml->createElement('shipmentReference', strtolower($this->randomTextHex(16,1)));
		    $tag1 = $reference->appendChild($shipmentReference);
		 
		    $customerNumber = $xml->createElement('customerNumber','10000123');
		    $tag2 = $reference->appendChild($customerNumber);
		 
		    $remitterName = $xml->createElement('remitterName','VICTOR POETA');
		    $tag3 = $reference->appendChild($remitterName);

		    $remitterPhone = $xml->createElement('remitterPhone','0412' . rand(1000000,9999999));
		    $tag4 = $reference->appendChild($remitterPhone);

		    $remitterAddress = $xml->createElement('remitterAddress','LA URBINA');
		    $tag5 = $reference->appendChild($remitterAddress);

		    $remitterCity = $xml->createElement('remitterCity','CARACAS');
		    $tag6 = $reference->appendChild($remitterCity);

			$countryOrigin = $xml->createElement('countryOrigin','VENEZUELA');
		    $tag7 = $reference->appendChild($countryOrigin);

		    $acronymCountry = $xml->createElement('acronymCountry','VE');
		    $tag8 = $reference->appendChild($acronymCountry);

		    $destinationAddress = $xml->createElement('destinationAddress','MIAMI FLORIDA');
		    $tag9 = $reference->appendChild($destinationAddress);

		    $destinationCompany = $xml->createElement('destinationCompany','COMPANY ONE');
		    $tag10 = $reference->appendChild($destinationCompany);

		    $destinationName = $xml->createElement('destinationName','JOHN WAYNE JR');
		    $tag11 = $reference->appendChild($destinationName);

		    $destinationPhone = $xml->createElement('destinationPhone','0013205559900');
		    $tag12 = $reference->appendChild($destinationPhone);

		    $destinationCity = $xml->createElement('destinationCity','MIAMI');
		    $tag13 = $reference->appendChild($destinationCity);

		    $destinationCountry = $xml->createElement('destinationCountry','UNITED STATES');
		    $tag14 = $reference->appendChild($destinationCountry);

		    $acronymCountryd = $xml->createElement('acronymCountryd','US');
		    $tag15 = $reference->appendChild($acronymCountryd);

		    $zipcode = $xml->createElement('zipcode','33172');
		    $tag16 = $reference->appendChild($zipcode);

		    $suburbs = $xml->createElement('suburbs','0');
		    $tag17 = $reference->appendChild($suburbs);

		    $mailboxNumber = $xml->createElement('mailboxNumber','MIA' . rand(100000,999999) );
		    $tag18 = $reference->appendChild($mailboxNumber);

		    $pieces = $xml->createElement('pieces','1');
		    $tag19 = $reference->appendChild($pieces);

		    $weight = $xml->createElement('weight','0.55');
		    $tag20 = $reference->appendChild($weight);

		    $width = $xml->createElement('width','11.2');
		    $tag21 = $reference->appendChild($width);

		    $height = $xml->createElement('height','1.02');
		    $tag22 = $reference->appendChild($height);

		    $depth = $xml->createElement('depth','1.1');
		    $tag23 = $reference->appendChild($depth);

		    $content = $xml->createElement('content','CONTENT ' . $this->randomTextHex(8,1));
		    $tag24 = $reference->appendChild($content);

		    $declaredValue = $xml->createElement('declaredValue','0');
		    $tag25 = $reference->appendChild($declaredValue);

		    $iValue = $xml->createElement('iValue','0');
		    $tag26 = $reference->appendChild($iValue);

		    $insure = $xml->createElement('insure','N');
		    $tag27 = $reference->appendChild($insure);

		    $shippingType = $xml->createElement('shippingType','P');
		    $tag28 = $reference->appendChild($shippingType);

		    $retainWaybill = $xml->createElement('retainWaybill','False');
		    $tag29 = $reference->appendChild($retainWaybill);
		    
		    $generic1 = $xml->createElement('generic1','0');
		    $tag30 = $reference->appendChild($generic1);

		    $generic2 = $xml->createElement('generic2','0');
		    $tag31 = $reference->appendChild($generic2);

		    $generic3 = $xml->createElement('generic3','0');
		    $tag32 = $reference->appendChild($generic3);

	    }
	 
	    $xml->formatOutput = true;
	    $el_xml = $xml->saveXML();
	    $xml->save('D:/Usuarios/vpoeta/Escritorio/archivos_xml/' . '2704201712345.xml');

    	return "El XML ha sido creado!";
	}



	public function getDataCache() {
		
		//$value = \Cache::tags('tymon.jwt');
		//$value = \Cache::get('key');

		//Cache::put('key', 'value', $minutes);

		//\Cache::store('file')->put('usuario', 'victorpoeta', 2);

		$value = \Cache::get('usuario_activo');
		if ($value == 'vpoeta') {
			return "Ya existe el usuario conectado: " . $value;
		} else {
			return $value;
		}

	}

	public function setDataCache(Request $request) {
		\Cache::store('file')->put('usuario_activo', $request->input('usuario'), 5);
		
		return "Cache generada (usuario)";
	}

	
	public function clearCache(Request $request) {
		\Cache::forget('usuario_activo');
		
		return "Cache cleared!";
	}


	public function printTextPrinter(Request $request) {
		//return "<object ></object>";

		/*$urlbase = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

		return "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
				<html>
				<head>
					<title>HTML applet Tag</title>
					<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				</head>
				<body>
					<p> $urlbase </p>
					<object height=150 width=400 codebase=" . $urlbase . " code='javaprint.class' archive='javaprint/javaprint.jar' style='background-color:lightblue;border:1px solid gray;' > 
						<param name='scriptable' value='false'>
						<param name='data' value='XkZYIEd1aWEgMTAwMDEyODI1NCAocGllemEgMSBkZSAyKSAKQ1R+fkNELH5DQ15+Q1R+Cl5YQX5UQTAwMH5KU05eTFQwXk1OV15NVFReUE9OXlBNTl5MSDAsMF5KTUFeUFI1LDV+U0QxNV5KVVNeTFJOXkNJMF5YWgpeWEEKXk1NVApeUFc3OTkKXkxMMDU1OQpeTFMwCl5GVDMyMCw1Ml5BME4sMjUsMjReRkhcXkZEXkZTCl5GVDExLDQ4N15BME4sMTcsMTZeRkhcXkZEd3d3LlpPT01FTlZJT1MuQ09NLSAwODAwLVNPUy1aT09NKDA4MDAtNzY3LTk2NjYpXkZTCl5GVDksMzMyXkEwTiwyNSwyNF5GSFxeRkRXRUlHSFQ6XkZTCl5GVDQwNiw2MV5BME4sNTEsNDheRkhcXkZEXkZTCl5GVDMyNiwzNDdeQTBOLDQ1LDUwXkZIXF5GRDQ2XkZTCl5GVDEyLDYwXkEwTiw0Niw0NV5GSFxeRkRaT09NXkZTCl5GVDQ4MCw1OF5BME4sNDgsOTFeRkhcXkZEQV5GUwpeRlQ5OCwyMTJeQTBOLDMxLDU3XkZIXF5GRDEwMDAxMjgyNTReRlMKXkZUNzIsMzM2XkEwTiwyNSwyNF5GSFxeRkReRlMKXkZUMTgzLDYzXkEwTiw1OSw1NV5GSFxeRkReRlMKXkZUNTAsMjk1XkEwTiwyNSwyNF5GSFxeRkRWSUNUT1IgUE9FVEFeRlMKXkZUMTA3LDI2Ml5BME4sMjUsMjReRkhcXkZETUlBXkZTCl5GVDEzOCw0NTVeQTBOLDI1LDMxXkZIXF5GRDA3LzAzLzIwMTdeRlMKXkZUMTMsMjU5XkEwTiwyNSwyNF5GSFxeRkRPUklHSU46XkZTCl5GVDEwLDI5N15BME4sMjUsMjReRkhcXkZEVE86XkZTCl5GVDksMzczXkEwTiwyOCwyOF5GSFxeRkRYUFJFU1NORVQgTExDXkZTCl5GVDcsNDEzXkEwTiwyOCwyOF5GSFxeRkRSZWYuIDBeRlMKXkZPNTYxLDExXkdCMjE3LDY0LDY0XkZTCl5GVDU2MSw2Ml5BME4sNTEsMzZeRlJeRkhcXkZEIElOVCAgICAgICAgICAgICBeRlMKXkJZMywzLDgwXkZUMzMsMTcxXkJDTiwsTixOCl5GRD47MTAwMDEyODI1ND42QUFBQkFBQUNDQ1NeRlMKXkJZMzA4LDMwOF5GVDQ3Nyw0OTheQlhOLDE0LDIwMCwwLDAsMQpeRkhcXkZEMTAwMDEyODI1NDswMTswMjswMjUzOzAwNDY7MDAwMzswMDAwMDAwMDswMDAwXkZTCl5GVDM2NSwyNjBeQTBOLDI4LDI4XkZIXF5GRDEvMl5GUwpeUFExLDAsMSxZXlhaCgpeRlggR3VpYSAxMDAwMTI4MjU0IChwaWV6YSAyIGRlIDIpIApDVH5+Q0QsfkNDXn5DVH4KXlhBflRBMDAwfkpTTl5MVDBeTU5XXk1UVF5QT05eUE1OXkxIMCwwXkpNQV5QUjUsNX5TRDE1XkpVU15MUk5eQ0kwXlhaCl5YQQpeTU1UCl5QVzc5OQpeTEwwNTU5Cl5MUzAKXkZUMzIwLDUyXkEwTiwyNSwyNF5GSFxeRkReRlMKXkZUMTEsNDg3XkEwTiwxNywxNl5GSFxeRkR3d3cuWk9PTUVOVklPUy5DT00tIDA4MDAtU09TLVpPT00oMDgwMC03NjctOTY2NileRlMKXkZUOSwzMzJeQTBOLDI1LDI0XkZIXF5GRFdFSUdIVDpeRlMKXkZUNDA2LDYxXkEwTiw1MSw0OF5GSFxeRkReRlMKXkZUMzI2LDM0N15BME4sNDUsNTBeRkhcXkZENDZeRlMKXkZUMTIsNjBeQTBOLDQ2LDQ1XkZIXF5GRFpPT01eRlMKXkZUNDgwLDU4XkEwTiw0OCw5MV5GSFxeRkRBXkZTCl5GVDk4LDIxMl5BME4sMzEsNTdeRkhcXkZEMTAwMDEyODI1NF5GUwpeRlQ3MiwzMzZeQTBOLDI1LDI0XkZIXF5GRF5GUwpeRlQxODMsNjNeQTBOLDU5LDU1XkZIXF5GRF5GUwpeRlQ1MCwyOTVeQTBOLDI1LDI0XkZIXF5GRFZJQ1RPUiBQT0VUQV5GUwpeRlQxMDcsMjYyXkEwTiwyNSwyNF5GSFxeRkRNSUFeRlMKXkZUMTM4LDQ1NV5BME4sMjUsMzFeRkhcXkZEMDcvMDMvMjAxN15GUwpeRlQxMywyNTleQTBOLDI1LDI0XkZIXF5GRE9SSUdJTjpeRlMKXkZUMTAsMjk3XkEwTiwyNSwyNF5GSFxeRkRUTzpeRlMKXkZUOSwzNzNeQTBOLDI4LDI4XkZIXF5GRFhQUkVTU05FVCBMTENeRlMKXkZUNyw0MTNeQTBOLDI4LDI4XkZIXF5GRFJlZi4gMF5GUwpeRk81NjEsMTFeR0IyMTcsNjQsNjReRlMKXkZUNTYxLDYyXkEwTiw1MSwzNl5GUl5GSFxeRkQgSU5UICAgICAgICAgICAgIF5GUwpeQlkzLDMsODBeRlQzMywxNzFeQkNOLCxOLE4KXkZEPjsxMDAwMTI4MjU0PjZBQUFDQUFBQ0NDU15GUwpeQlkzMDgsMzA4XkZUNDc3LDQ5OF5CWE4sMTQsMjAwLDAsMCwxCl5GSFxeRkQxMDAwMTI4MjU0OzAyOzAyOzAyNTM7MDA0NjswMDAzOzAwMDAwMDAwOzAwMDBeRlMKXkZUMzY1LDI2MF5BME4sMjgsMjheRkhcXkZEMi8yXkZTCl5QUTEsMCwxLFleWFoKCgo='>
					</object>
				</body>
				</html>";*/

		$datos = "^XA^FX Top section with company logo, name and address.^CF0,60^FO50,50^GB100,100,100^FS^FO75,75^FR^GB100,100,100^FS^FO88,88^GB50,50,50^FS^FO220,50^FDInternational Shipping, Inc.^FS^XZ";

		return "<script type='text/javascript'>
				  function openWin() {
				    var printWindow = window.open();
				    printWindow.document.open('text/plain');
				    printWindow.document.write('" . $datos . "');
				    printWindow.document.close();
				    printWindow.focus();
				    printWindow.print();
				  }
				</script>
				<input type='button' value='Print code' onclick='openWin()' />";

	}


	public function showLogs(Request $request) {
		//\Log::error('registro Info creado');
		/*$info = \Log::getMonolog();
		dump($info->getHandlers());*/

		//\Log::info('My awesome log message', ['key' => 'value']);

		/*\Event::listen('Laravel.log', function ($level, $message, $context) {
		    // $level => "info"
		    // $message => "My awesome log message"
		    // $context => ["key" => "value"]
		});*/

		$logFile = file(storage_path().'/logs/laravel.log');
		$logCollection = [];
		// Loop through an array, show HTML source as HTML source; and line numbers too.
		foreach ($logFile as $line_num => $line) {
		    $logCollection[] = ['line'=> $line_num, 'content'=> ($line)];
		}
		//dump($logCollection);

		for ($i=0; $i < count($logCollection); $i++) { 
			echo "<div style='font-family:arial; font-size:12px;background-color:lightyellow;color:brown'>" . $logCollection[$i]['content'] . "</div><br>";
		}
	}

}
