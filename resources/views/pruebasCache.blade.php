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
<h3>Pruebas Cache:</h3>
<br>

<form method="POST" action="">


	<table style="width:600px;padding:5px;background-color: whitesmoke;border:1px solid lightgray;">
	<tr>
		<td><label><b>Pago: </b></label></td>
		<td>
			<input type="text" locked="locked" id="" name="pago_580" value="580" size="5" />
		</td>
		<td>
			<input type="button" id="btnDetalle" class="boton" value="Detalle" />
		</td>
	</tr>

	<tr>
	  	<td><label><b>Pago: </b></label></td>
		<td>
			<input type="text" locked="locked" id="" name="pago_583" value="583" size="5" />
		</td>
		<td>
			<input type="button" id="btnDetalle" class="boton" value="Detalle" />
		</td>
	</tr>

	<tr>
		<td><label><b>Pago: </b></label></td>
		<td>
			<input type="text" locked="locked" id="" name="pago_612" value="612" size="5" />
		</td>
		<td>
			<input type="button" id="btnDetalle" class="boton" value="Detalle" />
		</td>
	</tr>

	<tr>
		<td><label><b>Pago: </b></label></td>
		<td>
			<input type="text" locked="locked" id="" name="pago_674" value="674" size="5" />
		</td>
		<td>
			<input type="button" id="btnDetalle" class="boton" value="Detalle" />
		</td>
	</tr>


	</table>

	<input type="hidden" size="60" name="_token" id='_token' value="{{ csrf_token() }}">
</form>
<br>

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



	});
});
</script>

</body>
</html>