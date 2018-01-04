<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="../resources/views/lib/estilo.css"/>-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ejemplo con JQuery</title>
	<meta name="keywords" content="Zoom International Services." />
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<style type='text/css'>
		body, table {
			font-family: arial;
			font-size: 11px;
		}
		table {
			border-spacing: 2px;
			background-color: whitesmoke;
		}
		td, th { padding:3px 3px 3px 3px; }
		table>thead {
			font-weight: bold; 
			color: white;
			background-color: steelblue;
		}
		input[type=button] {
			background-color: steelblue;
			color: white; 
			border: 1px solid black;
		} 
		label {
			color: darkblue; 
			padding: 5px; 
		}
		.title {
			width: 500px; padding-left: 10px;
			background-color: whitesmoke;
			font-size: 14px; font-weight: bold;
			padding-bottom: 5px; padding-top: 2px;
			cursor: hand; 
		}
		.marco {
			padding: 0px 5px 5px 10px;
			border:1px solid gray;
		}
		.error {
			color: red;
			background-color: lightyellow;
		}
	</style>
</head>
<body>

<hr style='border:1px solid lightgray;'>

<div class="title" id="title1">Registros de Pagos electrónicos:</div>

<br>

Nro. Pago: <input type="text" name="txtIdPago" id="txtIdPago">

<input type="button" name="btnEnviar" id="btnEnviar" value="Enviar">

<br><br>

<div id="info">
	
</div>

<script type="text/javascript">

	$( document ).ready(function() {
		/*$.ajaxSetup({
	    	//headers: {"X-Requested-With":"XMLHttpRequest"}
	    	//headers: {'Authorization': "Basic " + btoa('vpoeta' + ":" + 'Victorp.402')}
	    })*/

		//$('#title1').click (function() { $('#marco1').toggle(); });

		$("#btnEnviar").click(function(e) {
			
			e.preventDefault();
			$.ajax({ 
				type: 'POST', 
				//async: false,
				dataType: "json",
				//crossDomain: true,
				//data: "login=" + $("#txtLogin").val() + "&claveenc=" + $("#txtClave").val(),
				//data: 'token=Op5TiUuFM611C3KL88Naw9tcRQ7S4I53',
				url: 'http://10.0.3.49/prjPruebas/public/consultarPagosE',
				//jsonp: 'jsonp',
                contentType : 'application/json',
				success: function (data) { 
					//alert('success');
					
					var datos = '<thead>' + 
									'<th>idpago</th>' + 
									'<th>fechapago</th>' + 
									'<th>idestatuspago</th>' + 
									'<th>montototal</th>' + 
									'<th>datospagador</th>' + 
								'</thead>';

					if (data.codrespuesta=='COD_000') {
						for (var i = 0; i < data.entidadRespuesta.length; i++) {
							f = data.entidadRespuesta[i];

							datos = datos + '<tr>' + 
										'<td>' + f.idpago + '</td>' + 
										'<td>' + f.fechapago + '</td>' + 
										'<td>' + f.idestatuspago + '</td>' + 
										'<td>' + f.montototal + '</td>' + 
										'<td>' + f.rifcipagador + ', ' + f.nombrepagador + ',' + f.emailpagador + '</td>' + 
									'</tr> \n';

						}

						$("#info").html('<table>' + datos + '</table>');
						//$("#info").html(JSON.stringify(data.entidadRespuesta));

					}

				}, 
				beforeSend: function() {

					$('#info').html('Espere...');
				},
				error: function(mensaje) {
					$('#info').html('Error: ' + JSON.stringify(mensaje));
				}
			});
		});

	});


</script>
</body>
</html>