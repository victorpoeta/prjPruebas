<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Curl;

class consumirWSController extends Controller
{
    public function ejemploWsCurl() { 

		echo "Web Services (CURL):"; 

		$url = "http://10.0.10.13/baaszoom/public/";

		//$codRes = substr($Result, 17,7);
		//print_r($Result);
		/*
		if ($codRes=='COD_000') {
			echo "Login exitoso.";
		} else {
			echo $Result;
		}*/

		//echo "<br><br><b>getInfoPagoWs</b>";
		//$Res = $this->consumirPorPost('getInfoPagoWs', ['idpago' => ['593','594']], $url, 'canguroazul/');
		//dump($Res);

		echo "<br><br><b>login (usuario_casint):</b>";
		$postData = ["login" => "victorpoeta@gmail.com", "claveenc" => "V-16952402", 'lang' => "2"];
		$Res = $this->consumirPorPost('login', $postData, $url, 'canguroazul/registro/');

		dump($Res, $Res['codrespuesta']);

	}

	public function infoPagosPendientesWS() {
		$url = "http://desarrollo3.grupozoom.com/baaszoom/public/";

		//echo "Web Services (CURL):";
		//echo "<br><br><b>infoPagosPendientesWS</b>";

		$Res = $this->consumirPorPost('infoPagosPendientesWs', ['idcuentabanco' => '213', 'idtipotransbanc' => 24, 'enviaremail' => 1], $url, 'canguroazul/');

		//dump($Res);

		return $Res;


	}


	public function loginAppMovil(Request $request) {
		$login = $request->input('login');
		$clave = $request->input('claveenc');
		$newlogin = $request->input('newlogin');
		$lang = $request->input('lang');

		$url = "http://desarrollo3.grupozoom.com/baaszoom/public/"; 
		$postData = ["login" => $login, "claveenc" => $clave, 'newlogin' => 1, 'lang' => $lang];

		/*
		// Primer login a usuario_casint
		$Res1 = $this->consumirPorPost('login', $postData, $url, 'canguroazul/registro/');
		
		if (count($Res1) > 0) {
			if ($Res1['codrespuesta']=='COD_000') {
				$Result = $Res1;
			} elseif ($Res1['codrespuesta']=='CODE_002') {
				if ($Res1['entidadRespuesta']) {
					$Result = $Res1;
				} else {
					// Si la autenticación falló en usuario_casint, se hace login en guiaelectronica
					$Res2 = $this->consumirPorPost('login', $postData, $url, 'guiaelectronica/');

					if (count($Res2) > 0) {
						$Result = $Res2;
					}
				}
			}
		}
		*/

		// Primer login en guiaelectronica
		$ResGE = $this->consumirPorPost('login', $postData, $url, 'guiaelectronica/');
		
		if (count($ResGE) > 0) {
			if ($ResGE['codrespuesta']=='COD_000') {
				// Si la autenticación es exitosa, se muestra el resultado.
				$Result = $ResGE;
			} elseif ($ResGE['codrespuesta']=='CODE_002') {
				// Si la autenticación falló en guiaelectronica, se hace login en usuario_casint
				$postData['newlogin']= 0;
				$ResUCI = $this->consumirPorPost('login', $postData, $url, 'canguroazul/registro/');

				if (count($ResUCI) > 0) {
					if ($ResUCI['codrespuesta']=='COD_000') {
						$Result = $ResUCI;
					} elseif ($ResUCI['codrespuesta']=='CODE_002') {

						$postData['newlogin']= 1;
						$ResCCZ = $this->consumirPorPost('loginCCZ', $postData, $url, 'orinoco/');

						$Result = $ResCCZ;
						
					}
				}
			}
		}

		return $Result;

	}

	public function menusUsuarioWs(Request $request) {
		$url = "http://10.0.10.13/baaszoom/public/"; 
		$postData = ["relacion_codusuario" => '6078'];

		$Result = $this->consumirPorGet('getInfoUsuarioperfilWs', $postData, $url, 'canguroazul/');

		for ($i=0; $i < count($Result); $i++) { 

			for ($j=0; $j < count($Result['entidadRespuesta'][$i]['listperfil']['listmenuperfil']); $j++) { 
				$a['modulos'][$i][$j] = $Result['entidadRespuesta'][$i]['listperfil']['listmenuperfil'][$j]['listmenu']['listmodulo']['nombre'];
				
				$a['menuspadres2'][$i][$j] = $Result['entidadRespuesta'][$i]['listperfil']['listmenuperfil'][$j]['listmenu']['listmenupadre']['listmenupadre2']['nombre'];

				$a['menuspadres'][$i][$j] = $Result['entidadRespuesta'][$i]['listperfil']['listmenuperfil'][$j]['listmenu']['listmenupadre']['nombre'];

				$a['menus'][$i][$j] = $Result['entidadRespuesta'][$i]['listperfil']['listmenuperfil'][$j]['listmenu']['nombre'];
			}	
		}
		
		for ($i=0; $i < count($a['modulos']); $i++) { 
			for ($j=0; $j < count($a['modulos'][$i]); $j++) { 
				$b[$i][$j] = [$a['modulos'][$i][$j], $a['menuspadres2'][$i][$j], $a['menuspadres'][$i][$j], $a['menus'][$i][$j] ];
			}
		}

		return $b;

	}


	public function consumirAjax(Request $request) {
		$token= $request->get('token');
		$page= $request->get('pagina');
		$prefijo = $request->get('prefijo');
		$method= $request->get('metodo');
		$webservice= $request->get('webservice');
		$campos= $request->get('campos');
		$valores= $request->get('valores');

		// for($i=0; $i<count($campos); $i++){
		//  	$param = array ( $campos[$i] => $valores[$i],);	
		// }

		$param = array_combine($campos, $valores);

		//return $param;

		if(!empty($token)) {
			$pagina=$page;
			$param=array_merge($param, ['token'=>$token]);
		}

		$pagina=(!empty($page)) ? $page : '';

		//dd($method, $page, $webservice, $token, $campos, $valores, $param);

		if (strtolower($method)=='get') {
			$res = $this->consumirPorGet($webservice, $param, $page, $prefijo);
		} elseif (strtolower($method)=='post') {
			$res = $this->consumirPorPost($webservice, $param, $page, $prefijo);
		}

		return $res;
	}

    public function consumirPorGet($webservice,$parametros,$url='customs.url_baaszoom',$pagina='/'){
		//$url=config($url);

    	//return 'consumirPorGet: ' . $url.$pagina.$webservice;;

		$response = Curl::to($url.$pagina.$webservice)
						->withData($parametros)
						->asJson(true)
						->withContentType('application/json')
						->get();
		//$ruta="RUTA:".$url.$pagina.$webservice;
//		print_r($ruta);
		return $response;
	}

	public function consumirPorPost($webservice,$parametros,$url='customs.url_baaszoom',$pagina='/'){
		//$url=config($url);

		//return 'consumirPorPost: ' . $url.$pagina.$webservice;
		//return $parametros;

		$response = Curl::to($url.$pagina.$webservice)
						->withData($parametros)
						//->withOption('FAILONERROR', false)
						//->enableDebug('/var/www/html/cubesum/logFile.txt')
						->asJson(true)
						->withContentType('multipart/form-data')
						//->withContentType('application/json')
						->post();
		//$ruta="RUTA:".$url.$pagina.$webservice;
		
		return $response;
	}



	public function enviarArchivosPost(Request $request) {
		$params['idpago'] = $request->get('idpago');
		$params['token'] = $request->get('token');
		$params['archivos'] = $request->file('archivos');
		$params['file1'] = $request->input('file1')->getClientOriginalName();
		//$params['archivos'] = $_FILES['archivos']['tmp_name'];
		/*$params['file1'] = '@' . $_FILES['file1']['tmp_name'] . 
						   ';filename=' . $_FILES['file1']['name'] .
						   ';type='     . $_FILES['file1']['type'];*/

		//->getClientOriginalName();
		//dd(($params['archivos']));
		//$params['file1'] = $request->file('file1');

		return $params;

		$url = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/createPagoArchivoWs" . "?token=" . $params['token'];
		//dump ( ['params' => $params ] );

		$response = Curl::to($url)
						->withHeader("cache-control: no-cache")
						->withContentType('multipart/form-data')
						->withHeader("token: " . $params['token'])
						->withData(($params))
						//->withOption('FAILONERROR', false)
						//->enableDebug('/var/www/html/cubesum/logFile.txt')
						->containsFile()
						//->asJson(true)
						//->asJsonResponse(true)
						//->withContentType('application/json')
						->post();

		//print_r($response);
		return $response;
		
	}



	private function funcionCURL($url, $data) {
		$handler = curl_init();  

		curl_setopt($handler, CURLOPT_URL, $url); 
		curl_setopt($handler, CURLOPT_POST, 1); 
		curl_setopt($handler, CURLOPT_POSTFIELDS, $data);  
		curl_setopt($handler, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($handler, CURLOPT_FOLLOWLOCATION, 1);

		return (curl_exec($handler));
	}


	// Implementacion del objeto proxy (PHP4)
	/*class ZoomJsonService {
	    var $URL;
		
	    function ZoomJsonService($url)
	    {
	        $this->URL = $url;
	    }
		
		function setUrl($url) {
			$this->URL = $url;	
		}
		
	    function call($method, $args, $successCallback = false, $errorCallback = false)
	    {
	        $ch = curl_init();		
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	        curl_setopt($ch, CURLOPT_URL, $this->URL."/".$method);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array_map(utf8_encode,$args)));
	        $resposeText = curl_exec($ch);
	        $resposeInfo = curl_getinfo($ch);   
	        if($resposeInfo["http_code"] == 200)
	        {
	            if($successCallback)
	                call_user_func($successCallback, json_decode($resposeText));
	        }
	        else
	        {
	            if($errorCallback)
	                call_user_func($errorCallback, json_decode($resposeText));
	        }
	    }
	}*/

	// Función de prueba para consumir WS viejos (http://desarrollo.grupozoom.com/internet/servicios/webservices)
	public function callWebServicesOld__(Request $request) {

		try {
			
			if ($request->get('url')=='' || $request->get('url')==null) {
				return response()->json(['errormessage' => 'La dirección url del webservice es requerida']);
			}
			if ($request->get('webservice')=='') {
				return response()->json(['errormessage' => "El campo webservice es requerido"]);
			}

			$url = $request->get('url');
			// $url = "http://desarrollo.grupozoom.com/internet/servicios/webservices";
			// $url = "http://desarrollo3.grupozoom.com/proveedores/frontend/webservicesge";

			$ws = $request->get('webservice');
			$fields = $request->get('fields');
			$values = $request->get('values');
			
			if (!is_array($fields) || !is_array($values)) {
				return response()->json(['errormessage' => "Los parametros fields y values deben ser de tipo array"]);
			}

			if (count($fields)>0 && count($values)>0) {
				if (count($fields) == count($values)) {
					$args = array_combine($fields, $values);
				} else {
					return response()->json(['errormessage' => "Los parametros fields y values no contienen el mismo numero de elementos"]);
				}
			} else {
				$args = [0 => ''];
			}

	        $response = Curl::to($url . "/" . $ws)
							->withData($args)
							->withOption('FAILONERROR', false)
							->withOption('CURLOPT_RETURNTRANSFER', true)
							//->asJson(true)
							->withContentType('application/json')
							->post();

	        //return (array) json_decode($response);
	        return $response;

	    } catch (\Exception $e) {
			return response()->json(['errormessage' => "Error inesperado: " . $e->getMessage()]);
		}

	}

	public function callWebServicesOld(Request $request) {
		try {

			if ($request->get('dir')=='' || $request->get('dir')==null) {
				return response()->json(['errormessage' => 'El campo dir es requerido']);
			}
			if ($request->get('webservice')=='') {
				return response()->json(['errormessage' => "El campo webservice es requerido"] );
			}

            switch ($request->get('dir')) {
                case 'des': $url = "http://desarrollo.grupozoom.com/internet/servicios/webservices"; break;
                case 'des_ge': $url = "http://desarrollo3.grupozoom.com/proveedores/frontend/webservicesge"; break;
                case 'sandbox': $url = "http://sandbox.grupozoom.com/localhost/htdocs/internet/servicios/webservices"; break;
                case 'sandbox_ge': $url = "http://sandbox.grupozoom.com/localhost/htdocs/proveedores_desarrollo_pg9/frontend/webservicesge"; break;
                case 'sandbox2': $url = "http://192.168.101.20/internet/servicios/webservices"; break;
                case 'sandbox2_ge': $url = "http://192.168.101.20/proveedores_desarrollo_pg9/frontend/webservicesge"; break;
                case 'prod': $url = "https://www.grupozoom.com/servicios/webservices"; break;
                case 'prod_ge': $url = "http://ge.grupozoom.com/webservicesge"; break;
                default: return response()->json(['errormessage' => 'Debe ingresar una direccion (campo dir) valida']); break;
            }

			$ws = $request->get('webservice');

			if ($request->get('dir')=='prod' || $request->get('dir')=='prod_ge' || $request->get('dir')=='prod2') {
			    if ($request->get('key') != '*D3sarr0ll0@Z00m*') {
                    return response()->json(['errormessage' => 'Valor key invalido']);
                }
            }
			
			$args = $request->except('dir','webservice','url','key');

			/*$fields = $request->get('fields');
			$values = $request->get('values');

			if (count($fields)>0 && count($values)>0) {
				if (count($fields) == count($values)) {
                    if (!is_array($fields) || !is_array($values)) {
                        return response()->json(['errormessage' => "Los parametros fields y values deben ser de tipo array (fields[], values[], o numerados: fields[0], values[0]...)"]);
                    }
					$args = array_combine($fields, $values);
				} else {
					return response()->json(['errormessage' => "Los parametros fields y values no contienen el mismo numero de elementos"]);
				}

			} else {
				$args = [0 => ''];
			}*/

	        $response = Curl::to($url . "/" . $ws)
							->withData($args)
							->withOption('FAILONERROR', false)
								->withOption('SSL_VERIFYPEER', false)
								//->withOption('RETURNTRANSFER', true)
							->asJson(true)
							->withContentType('application/json')
							->post();

	        return $response;

	    } catch (\Exception $e) {
			return response()->json(['errormessage' => "Error inesperado: " . $e->getMessage()]);
		}
	}

	public function getZipCodeDHL(Request $request) {
		$args = ['siglas_pais' => $request->get('siglas_pais') ];
		
		set_time_limit(3); 

		$response = Curl::to("http://desarrollo3.grupozoom.com/baaszoom/public/CiudadZipWs")
							->withData($args)
							->withOption('FAILONERROR', false)
							->asJson(true)
							->withContentType('application/json')
							->post();

		if ($response['Codigo'] == 'SUCESS' && is_array($response['Mensaje'])) {
			echo "<input type='text' size='30' disabled value='Ciudad' >";
			echo "<input type='text' size='10' disabled value='Zip Code' >";
			echo "<input type='text' size='30' disabled value='Suburbio' ><br>";

			foreach ($response['Mensaje'] as $key => $value) {
				//$res['ciudad'][$key] = $value['nombre_ciudad'];
				//dd($value);
				echo "<input type='text' name='nombre_ciudad[]' id='nombre_ciudad[]' size='30' value='" . $value['nombre_ciudad'] . "' >";
				echo "<input type='text' name='zip_code[]' id='zip_code[]' size='10' value='" . $value['zip_code'] . "' >";
				echo "<input type='text' name='suburb[]' id='suburb[]' size='30' value='" . $value['suburb'] . "' >";
				echo "<br>";
			}

			echo "Total Registros: " . count($response['Mensaje']);
		} else {
			echo "<p style='color:brown;font-weight:bold;'>No existen registros para mostrar.</p>";
		}

		//return $res;

	    //return $response;
	}

	public function getCiudadesDHL(Request $request) {
		if ($request->input('siglas_pais')=='' || $request->input('siglas_pais')==null) {
			return response()->json(['error' => "Debe ingresar las Siglas del Pais"]);
		}

		$args = ['siglas_pais' => strtoupper($request->input('siglas_pais')) ];

		$response = Curl::to("http://desarrollo3.grupozoom.com/baaszoom/public/CiudadZipWs")
							->withData($args)
							->withOption('FAILONERROR', false)
							->asJson(true)
							->withContentType('application/json')
							->post();

		if ($response['Codigo'] == 'SUCESS' && is_array($response['Mensaje'])) {
			$ZipCode = trim($request->input('zipcode'));
			$Suburbio = strtoupper(trim($request->input('suburbio')));

			$Res = ['Codigo' => 'ERROR'];

			if ($ZipCode != '' || $Suburbio != '')  {
				foreach ($response['Mensaje'] as $key => $value) {
					if ($ZipCode != '' && $ZipCode == $value['zip_code']) {
						//$Res = ['Codigo' => 'SUCESS', 'Mensaje' => $value]; break;	
						$Res['Codigo'] = 'SUCESS';
						$Res['Mensaje'][$key] = $value;
						//array_chunk($Res['Mensaje'], $value);
					}
					if ($Suburbio!='' && $Suburbio == $value['suburb']) {
						$Res = ['Codigo' => 'SUCESS', 'Mensaje' => $value]; break;	
					}
				}
				$Res['Mensaje'] = array_values($Res['Mensaje']);

			} else {
				$Res = $response;
			}

		} else {
			$Res = ['Codigo' => 'ERROR'];
		}

		return $Res;

	}

	public function getTrackingDHL(Request $request) {
		$codGuiaDHL = $request->input('guiaDHL');

		/*if (count($codGuiaDHL) > 5) {
			return ["No puede exceder de 5 guias"];
		}

		$xmlGuiasDHL = '';
		for ($i=0; $i < count($codGuiaDHL); $i++) { 
			if ($codGuiaDHL[$i]!='' || $codGuiaDHL[$i]!=null) {
				$xmlGuiasDHL = $xmlGuiasDHL . "<AWBNumber>" . $codGuiaDHL[$i] . "</AWBNumber>\n";
			}
		}*/

		$xmlData = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <req:KnownTrackingRequest xmlns:req=\"http://www.dhl.com\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.dhl.com TrackingRequestKnown.xsd\">
                    <Request>
                        <ServiceHeader>
                        <MessageTime>" . date('Y-m-d').'T'.date('h:m:s')."-04:00</MessageTime>
                        <MessageReference>ZOOM QUERY123456789012345678</MessageReference>
                        <SiteID>xmlZOOMINTER</SiteID>
                        <Password>zCW9h4Vab5</Password>
                        </ServiceHeader>
                    </Request>
                    <LanguageCode>es</LanguageCode>
                    <AWBNumber>" . $codGuiaDHL . "</AWBNumber>
                    <LevelOfDetails>LAST_CHECK_POINT_ONLY</LevelOfDetails>
                    <PiecesEnabled>P</PiecesEnabled>
                    </req:KnownTrackingRequest>";

        //$url='https://xmlpitest-ea.dhl.com/XMLShippingServlet?isUTF8Support=true'; // Desarrollo
        $url='https://xmlpi-ea.dhl.com/XMLShippingServlet?isUTF8Support=true'; // Producción

        $cH = curl_init();
        curl_setopt($cH, CURLOPT_URL, $url);
        curl_setopt($cH, CURLOPT_PORT , 443);
        curl_setopt($cH, CURLOPT_VERBOSE, 0);
        curl_setopt($cH, CURLOPT_HEADER, 0);
        curl_setopt($cH, CURLOPT_POST, 1);
        curl_setopt($cH, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cH, CURLOPT_POSTFIELDS, $xmlData);
        curl_setopt($cH, CURLOPT_HTTPHEADER, ["Content-Type: text/xml", "Content-length: ".strlen($xmlData)]);
        
        //curl_setopt($cH, CURLOPT_NOBODY, true);
        //curl_setopt($cH, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

		curl_setopt($cH, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($cH, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($cH, CURLOPT_PROXY, '10.0.98.3'); // proxy.laurbina.grupozoom.com
		curl_setopt($cH, CURLOPT_PROXYPORT, '3128'); 

        $response = curl_exec($cH);
        $error = curl_error($cH);
        curl_close($cH);

        $response = @simplexml_load_string($response);
        $response = json_decode(json_encode($response));

        dump($response);

        if ($error == '' || $error == null) {

        	$infoStatus = (is_array(@$response->AWBInfo)) ? @$response->AWBInfo[0]->Status->ActionStatus : @$response->AWBInfo->Status->ActionStatus;

        	if ($infoStatus=='success') {
        		//dump($infoStatus);

        		$piezas = (is_array(@$response->AWBInfo)) ? @$response->AWBInfo[0]->Pieces->PieceInfo : @$response->AWBInfo->Pieces->PieceInfo;

        		if (count($piezas) == 1) {
        			$res[0] = @$piezas->PieceDetails->LicensePlate;	
        		} else if (count($piezas) > 1) {
        			foreach ($piezas as $key => $value) {
        				$res[$key] = @$value->PieceDetails->LicensePlate;
        			}
        		} else {
        			$res[0] = "";
        		}

        		$result = ['success' => true, 'data' => array_values($res)];
        	
        	} else {
        		$result = ['success' => false, 'data' => [$infoStatus]];
        	}

	        return $result;

        } else {
            return ['success' => false, 'data' => [$error]];
        }
	}


	public function testEncriptCert(Request $request) {

		//$IP = $_SERVER;
		//return $IP;

		$hashGenerado = hash('sha512', $request->input('clave'));
		//return $hashGenerado;

		$clave = ['clave' => [$hashGenerado, ''],
				  'hash' => 'sha512'];
		/*echo "<pre>";
		print_r(json_encode($clave, JSON_PRETTY_PRINT));
		echo "</pre>";*/
		echo (gettype(json_encode($clave)));
		echo(json_encode($clave));
		exit();
		return json_encode($clave);

		$clave = md5($request->input('clave'));
		$certif = crypt($request->input('codcliente') . $clave . $request->input('token'), "$1$" . $request->input('fraseprivada'));

		return $certif;
	}


	public function getDolarTodayWs(Request $request) {
		$url='https://s3.amazonaws.com/dolartoday/data.json';
		
        $cH = curl_init();
        curl_setopt($cH, CURLOPT_URL, $url);
        curl_setopt($cH, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cH, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($cH, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cH, CURLOPT_PROXY, '10.0.98.3');
		curl_setopt($cH, CURLOPT_PROXYPORT, '3128');

        $response = curl_exec($cH);
        $error = curl_error($cH);
        curl_close($cH);

        if ($error == '' || $error == null) {	
        	//return $response;
        	$response = json_decode($response);
        	return @$response->USD->transferencia;
        } else {
        	return $error;
        }

	}

	public function cleanSpecialCar(Request $request) {
		$cadena = $request->input('cadena');

		$cadena = str_ireplace(['Á','É','Í','Ó','Ú','Ñ','á','é','í','ó','ú','ñ',';'], ['A','E','I','O','U','N','A','E','I','O','U','N',','], $cadena);
		$cadena = preg_replace('/[^A-Za-z0-9\-\s\,\.\#\(\)]/', '', $cadena); 
		$cadena = trim(strtoupper($cadena));
		
		return $cadena;

		/*$url = 'http://webservices.grupozoom.com/baaszoom/public/canguroazul/login?usuario=admin&claveenc=123456';
		$params = parse_url($url);
		parse_str($params['query'], $params2);
		dump(parse_url($url), $params2);*/

	}

	public function cleanCacheLaravel() {
		/*$valores = ['0','3','4','3',''];
		$a= array_filter(array_unique($valores));
		return $a;*/

		$res = \Artisan::call('cache:clear');
		$res2 = \Artisan::call('view:clear');

		return ["Cache borrada exitosamente"];
	}
	
	
	// Función para mostrar los registros de pagos electronicos
	public function consultarPagosE(Request $request) {

		$url = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/mobileapp/getInfoPagoWs";

		$cH = curl_init();
        curl_setopt($cH, CURLOPT_URL, $url);
        curl_setopt($cH, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cH, CURLOPT_POST, 1);
        curl_setopt($cH, CURLOPT_POSTFIELDS, array('token' => 'Op5TiUuFM611C3KL88Naw9tcRQ7S4I53'));
		//curl_setopt($cH, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($cH, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($cH, CURLOPT_PROXY, '10.0.98.3');
		//curl_setopt($cH, CURLOPT_PROXYPORT, '3128');

        $response = curl_exec($cH);
        $error = curl_error($cH);
        curl_close($cH);

        if ($error == '' || $error == null) {	
        	return $response;
        } else {
        	return "Error: " . $error;
        }

		return response()->json($Res);
	}

}
