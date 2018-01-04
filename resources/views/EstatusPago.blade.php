	
<?php //header("Access-Control-Allow-Origin: *"); ?>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="css/app.css" />-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ejemplo con JQuery</title>
	<meta name="keywords" content="Zoom International Services." />
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<!--<script type="text/javascript" src="../resources/views/lib/jquery.zoomwebservices.js"></script>-->
</head>
<body>
<h3>Ejemplo de Servicio &quot;getListaEstatusPagoWs&quot;. (Requiere jQuery)</h3>
<br />
<fieldset style="padding:10px;"> 
<table class="">

<tr>
  <td width="20px;">Código de Estatus:</td>
  <td width="90%">
  <input type="text" size="10" name="idestatuspago" id="idestatuspago" style="text-align:left" /></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="button" id="btnBuscarEstatusPago" class="boton" value="Buscar - Estatus de Pago" /></td>
  <td>&nbsp;</td>
</tr>
</table>
<form method="POST" action="">
    <input type="hidden" size="60" name="_token" id='_token' value="{{ csrf_token() }}">
</form>

<div style="background-color:whitesmoke;" id="respuesta"></div>
</fieldset>
<script type="text/javascript">
//var urlServicio = 'http://10.0.10.13/baaszoom/public/canguroazul/';
var urlServicio = 'http://localhost:150/consumirAjax';

$(function() {		

	$("#btnBuscarEstatusPago").click(function() {
		//$("#respuesta").html('Error');
		var ws = 'getInfoEstatusPagoWs';
		var pagina = 'http://10.0.10.13/baaszoom/public/';
		var prefijo = 'canguroazul/';
		var campos = ["idestatuspago"];
		var valores = [[$('#idestatuspago').val()]];
		var metodo = 'post';
		var token = $('#_token').val();

		var data={metodo:metodo,webservice:ws,campos:campos,valores:valores,token:token,pagina:pagina,prefijo:prefijo};

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
				
				//alert(response.entidadRespuesta.length);

				var tabla = '';
				codRes = response.codrespuesta;

				if (codRes == 'COD_000') {
					tabla = tabla + '<table border=1>' + '<thead style=\"font-weight:bold;\">' +
									  '<td>Código</td>' + 
									  '<td>Nombre</td>' + 
								      '</thead>';					
					for(i=0; i<response.entidadRespuesta.length; i++) {						
						f = response.entidadRespuesta[i];
						tabla = tabla + '<tr>' +
								 		  '<td>' + f.idestatuspago + '</td>' +
										  '<td>' + f.nombre + '</td>' +
								 		'</tr>';
					}
					tabla = tabla + '</table>';
				} else {

					tabla = '<font color=red>' + codRes + ': ' + response.mensaje + '</font>';

					/*fila = response.entidadRespuesta[0].'idestatuspago.0';
					if (codRes == "CODE_002") {
						tabla = tabla + '<br><font color=red>' + fila + '</font>';
					}*/

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