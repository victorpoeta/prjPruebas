<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="css/main.css" />-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ejemplo con JQuery</title>
	<meta name="keywords" content="WS Login - Zoom International Services." />
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<!--<script type="text/javascript" src="../resources/views/lib/jquery.zoomwebservices.js"></script>-->

	<!--<script type="text/javascript" src="https://rawgit.com/ricmoo/aes-js/master/index.js"></script>-->
	<script type="text/javascript" src="js/aes-js-master/index.js"></script>

</head>
<body style="font-family: tahoma;font-size: 14px;">

<div align="center">
<h3>Login (usuarios internos y externos):</h3>
<br>

<form method="POST" action="">

	<table style="width:400px;padding:10px;background-color: whitesmoke;border:1px solid lightgray;text-align:center;">
	<tr>
		<td><label><b>Tipo Usuario:</b></label></td>
		<td>
		<select name="tipoLogin" id="tipoLogin">
		  <option value="1">Usuario Externo (usuario_casint)</option>
		  <option value="2">Usuario Guía Electrónica</option>
		  <option value="3">Usuario Orinoco</option>
		  <option value="4">Ususario Interno (canguroazul)</option>
		</select>
		</td>
	</tr>

	<tr>
	  <td><label><b>Login:</b></label></td>
	  <td>
	  	<input type="text" size="26" maxlength="60" name="txtLogin" id="txtLogin" required="required" />
	  </td>
	</tr>
	<tr>
	  <td><label><b>Clave:</b></label></td>
	  <td>
	  	<input type="password" size="26" maxlength="64" name="txtClave" id="txtClave" required="required" />
	  </td>
	</tr>

	<tr>
		<td><b>Encriptada:</b></td>
		<td>
			<input type="checkbox" name="encript" id="encript">
			<input type="keyencript" name="keyencript" id="keyencript" value="0123456789abcdef">
		</td>
	</tr>
	<tr style="text-align:center;">
	  <td></td>
	  <td>
	  <hr>
	  	<input type="button" id="btnEntrar" class="boton" value="Entrar"  />
	  	<input type="reset" id="btnLimpiar" class="boton" value="Limpiar" />
	  </td>
	</tr>
	</table>

	<input type="hidden" size="60" name="_token" id='_token' value="{{ csrf_token() }}">
</form>
<br>
<div id="claveEnc256"></div>
<div style="background-color:whitesmoke;height:150px;font-size:14px;word-wrap:break-word;" id="respuesta"></div>

</div>

<script type="text/javascript">

var urlServicio = 'http://localhost:150/consumirAjax';

$(function() {		


	$("#btnLimpiar").click(function() {
		$("#respuesta").html('');
	});

	$("#btnEntrar").click(function() {
		
		var pagina = 'http://10.0.10.13/baaszoom/public/';
		var ws = 'login';
		var metodo = 'post';
		
		var enc = ($("#encript").prop("checked")==true) ? 1 : 0;

		if ($("#tipoLogin").val()=='1') {
			var prefijo = 'canguroazul/registro/';
		} else if ($("#tipoLogin").val()=='2') {
			var prefijo = 'guiaelectronica/';
		} else if ($("#tipoLogin").val()=='3') {
			var prefijo = 'orinoco/';
		} else if ($("#tipoLogin").val()=='4') {
			var prefijo = 'canguroazul/';
		}
		
		var campos = ['login','claveenc','encript','keyencript'];
		var valores = [$('#txtLogin').val(), $('#txtClave').val(), enc, $("#keyencript").val()];
		var token = $('#_token').val();
		
		var data={metodo:metodo,webservice:ws,campos:campos,valores:valores,pagina:pagina,prefijo:prefijo,token:token};


		// ------------------------------------------------------
		var key = aesjs.util.convertStringToBytes("0123456789abcdef");

		// Convert text to bytes
		var text = 'V-16952402\0\0\0\0\0\0';
		var textBytes = aesjs.util.convertStringToBytes(text);

		var aesEcb = new aesjs.ModeOfOperation.ecb(key);
		var encryptedBytes = aesEcb.encrypt(textBytes);

		//var encText = aesjs.util.convertBytesToString(encryptedBytes);

		// Since electronic codebook does not store state, we can
		// reuse the same instance.
		// var aesEcb = new aesjs.ModeOfOperation.ecb(key);
		var decryptedBytes = aesEcb.decrypt(encryptedBytes);

		// Convert our bytes back into text
		var decryptedText = aesjs.util.convertBytesToString(decryptedBytes);
		//$("#claveEnc256").html(encText);
		$("#claveEnc256").html(encryptedBytes + '');

		// ------------------------------------------------------------------

		//alert(JSON.stringify(data, null, 4));

		$.ajax({ 
			beforeSend: function (request) {
                //request.setRequestHeader("X_CSRF_TOKEN", token);
                $("#respuesta").html('Espere unos segundos...');
            },
            type: 'GET', 
			url:  urlServicio,
			data: data, 
			dataType: 'json',
			contenType: 'application/json',
			success: function (response) { 
				//alert(response.codrespuesta.length);

				//alert(JSON.stringify(response, null, 4));

				var tabla = '';
				codRes = response.codrespuesta;

				if (codRes == 'COD_000') {

					tabla = '<br><font color=blue>Usuario Autenticado. <br>Token: ' + response.entidadRespuesta.token + '<font>' ;

				} else {

					if ($("#tipoLogin").val()=='1') {
						if (codRes == "CODE_002") {
							// if (response.entidadRespuesta.login) {
							// 	errLogin = (response.entidadRespuesta.login==undefined) ? '' : response.entidadRespuesta.login;
							// }
							
							// if (response.entidadRespuesta.claveenc) {
							// 	errClave = (response.entidadRespuesta.claveenc==undefined) ? '' : response.entidadRespuesta.claveenc;
							// }
							
							// if (errLogin=='' && errClave=='') {
							//  	errCredInv = (response.entidadRespuesta.length==0) ? '' : response.entidadRespuesta;
							// } else {
							// 	errCredInv = '';
							// }
							
							// tabla = tabla + '<br><font color=red>' + response.mensaje + ': <br>' + 
							// 				errLogin + '<br>' + 
							// 				errClave + '<br>' + 
							// 				errCredInv + '<br>' + '</font>';

							tabla = '<br><font color=red>' + response.codrespuesta + ': ' + response.mensaje + '<font>' ;
						}

					} else {
						tabla = '<br><font color=red>' + response.codrespuesta + ': ' + response.mensaje + '<font>' ;
					}
					
				}

				$("#respuesta").html(tabla);

			}, 
			error: function(mensaje) {
				//alert('Error: ' + mensaje.length);	
				//console.log('Error:', mensaje);
				$("#respuesta").html('Error indefinido.');
			}

		});



	});
});
</script>

</body>
</html>