<!DOCTYPE html>
<html>
<head>
	<title>Pruebas con algoritmos Hash: SHA1, Rjindael 256</title>
</head>
<style type="text/css">
	body {
		font-family:sans-serif;
		/*font-size:15px;*/
		margin-left: 15px;
		margin-top: 15px;
		background-color: #272822;
		color: white;
	}
	table {
		border:1px solid lightgray;
		/*background-color:whitesmoke;*/
		margin-top:10px;
		color: #A6E22E;
	}
	input {
		background-color: lightgray;
		border:2px solid whitesmoke;
		font-size: 14px;
	}
	input:hover {
		border:2px solid cyan;
	}
	.titulo {
		height:25px;
		width:220px;
		display:inline;
	}
	.valor {
		color:#FD971F;
	}
	.error {
		color: #F92672;
		margin-top: 10px;
	}

</style>
<body>

@if (\Session::has('login'))

<form name="formulario" action="{{ url('/pruebaHash') }}" method="post">
	<b>Cadena a encriptar: </b>
	<input type="text" name="txtCadena" id="txtCadena" size="50" /><br><br>
	<b>Clave (AES/Ryindael): </b>
	<input type="text" name="txtKey" id="txtKey" size="30" maxlength="32" />
	<input type="submit" name="btnEncriptar" value="Encriptar" />

	<div class='respuesta'>
		<?php 

		try {
			//throw new Exception('error');

			$cadena = @$_REQUEST['txtCadena'];
			$varKey = @$_REQUEST['txtKey'];

			if (isset($cadena)) {
				$encryptMD5 = md5($cadena);
				$encryptSHA1 = sha1($cadena);
				$encryptAESRyindael_256= "";

				if (strlen($varKey) > 0) {
					if (strlen($varKey) > 32) {
						echo "<div class='error'>La clave debe tener como longitud: 16, 24 o 32 caracteres. </div>"; 
					 	exit();
					}
					if (strlen($varKey)>0 and strlen($varKey)<=16) {
						$contNull = 16 - strlen($varKey);

						for ($i=0; $i < $contNull; $i++) { $varKey = $varKey . chr(0); }
					}
					if (strlen($varKey)>16 and strlen($varKey)<=24) {
						$contNull = 24 - strlen($varKey);

						for ($i=0; $i < $contNull; $i++) { $varKey = $varKey . chr(0); }
					}
					if (strlen($varKey)>24 and strlen($varKey)<=32) {
						$contNull = 32 - strlen($varKey);

						for ($i=0; $i < $contNull; $i++) { $varKey = $varKey . chr(0); }
					}

					$encryptAESRyindael_256 = encryptAES256_ECB($cadena, $varKey);

					$encryptAESRyindael_256_masSHA1 = encryptAES256_ECB($encryptSHA1, $varKey);		
				}

				$arrayTitulos = ['<b>Cadena original:</b>', 'Base 64:', 'MD5:', 'SHA1:', 'Rjindael 256 (Modo ECB):', 'SHA1 + Rjindael 256 (Modo ECB):'];
				$arrayValores = ['<b>'. $cadena . '</b>', base64_encode($cadena), $encryptMD5, $encryptSHA1, $encryptAESRyindael_256, $encryptAESRyindael_256_masSHA1];

				echo "<table>";
				for ($i=0; $i < count($arrayTitulos); $i++) { 
					echo "<tr> 
							<td class='titulo'>$arrayTitulos[$i]</td> 
							<td class='valor'>$arrayValores[$i]</td> 
						  </tr>";
				}
				echo "</table>";
			} else {
				echo "";
			}
		
		} catch (Exception $e) {
			echo "<div class='error'>Ha ocurrido un error inesperado: <br>" . 
			     "Codigo: " . $e->getCode() . ', Mensaje: ' . $e->getMessage() . ', Linea: ' . $e->getLine() . ', Archivo: ' . $e->getFile() . '</div>';
		}

		?>
	</div>
</form>

@else
	<font color='brown'> Debe estar autenticado para ver esta página. </font>
@endif

</body>
</html>