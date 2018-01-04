<?php

	include_once('NumberToLetterConverter.php');
	include_once('NumeroALetras.php');
	require_once 'dompdf/autoload.inc.php';
	
	//include_once('Net/SFTP.php');

	function sortArrayByCol(&$arr, $col, $dir = SORT_ASC) {
	    $sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

	    array_multisort($sort_col, $dir, $arr);
	}

	function encryptAES256_ECB($cadena, $clave, $decodeBase64=true) {
		$cifrado = MCRYPT_RIJNDAEL_256;
		$modo = MCRYPT_MODE_ECB;

		$encriptado=mcrypt_encrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));

		if ($decodeBase64==true) {
			return base64_encode($encriptado);
		} else {
			return $encriptado;
		}
		
	}

	function decryptAES256_ECB($cadena, $clave, $decodeBase64=true) {
		$cifrado = MCRYPT_RIJNDAEL_256;
		$modo = MCRYPT_MODE_ECB;

		if ($decodeBase64==true) {
			$cadena = base64_decode($cadena);
		}
		
		$desencriptado=mcrypt_decrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));

		return $desencriptado;

	}

	function link_CURL($url, $data) {
		$handler = curl_init();  
		
		curl_setopt($handler, CURLOPT_URL, $url); 
		curl_setopt($handler, CURLOPT_POST, 1); 
		curl_setopt($handler, CURLOPT_POSTFIELDS, $data);  
		curl_setopt($handler,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($handler, CURLOPT_FOLLOWLOCATION, 1);

		return (curl_exec($handler));
	}

/*	function conectar_SFTP($host, $port) {
		$obj = new Net_SFTP($host, $port);		
		return $obj;
	}*/


?>