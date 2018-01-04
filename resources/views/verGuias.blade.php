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

<div class="title" id="title1">Visualizar guía en PDF (Guía Electrónica):</div>

<br>

Ruta: 
<!--<input type="text" name="txtDir" id="txtDir" size="12">-->
<select name="cboDir" id="cboDir">
	<option value="des_ge">des_ge</option>
	<option value="sandbox_ge">sandbox_ge</option>
	<option value="sandbox2_ge">sandbox2_ge</option>
	<option value="prod_ge">prod_ge</option>
</select>

Nro Guía: <input type="text" name="txtNroGuia" id="txtNroGuia">
<input type="hidden" name="txtKeyProd" id="txtKeyProd" value="*D3sarr0ll0@Z00m*">


<input type="button" name="btnVerGuiaPDF" id="btnVerGuiaPDF" value="Ver Guía PDF">

<br><br>
<div id="info">
	
</div>

<div id="contentGE" style="border:1px solid gray;width: 700px;">

</div>


<script type="text/javascript">

$(function() {

    /*$.ajaxSetup({
    	//headers: {"X-Requested-With":"XMLHttpRequest"}
    	//headers: {'Authorization': "Basic " + btoa('vpoeta' + ":" + 'Victorp.402')}
    })*/

	/*$("#btnLimpiarEP").click (function() {
		$('#idestatuspago').val(''); $('#respuestaEstatusPago').html('');
	});
	$("#btnLimpiarPago").click (function() {
		$('#idpago').val(''); $('#respuestaPago').html('');
	});
	$("#btnLimpiarMonto").click (function() {
		$('#numerofac, #codguia, #montodoc, #totalpagado, #montopagar').val(''); 
		$('#respuestaMontoDoc').html('');
	});
	$('#totalpagado, #montodoc, #montototal').attr('disabled',true);
	
	$('#tipoDoc').click (function() {
		if ($('#tipoDoc').val()=='optguia') {
			$('#numerofac').val(''); $("#codguia").focus();
		} else if ($('#tipoDoc').val()=='optfactura') {
			$('#codguia').val(''); $("#numerofac").focus();
		} 
	});*/

	//$('#title1').click (function() { $('#marco1').toggle(); });

	$("#btnVerGuiaPDF").click(function(e) {
		//alert($("#cboDir").val());
		//clave usuario 1: jrmafd
		e.preventDefault();
		$.ajax({ 
			type: 'GET', 
			//dataType: 'json', 
			data: "dir=" + $("#cboDir").val() + "&webservice=generarPDF&key=" + $("#txtKeyProd").val() + 
				  "&codigo_cliente=400933&clave=309205820&numero_guia=" + $("#txtNroGuia").val(),
			//url: 'http://desarrollo3.grupozoom.com/baaszoom/public/callWSOld',
			url: 'http://desarrollo3.grupozoom.com/prjPruebas/public/callWebServicesOld',
			  //crossDomain: true,
			  //dataType: "jsonp",
			success: function (data) { 
				//alert(JSON.stringify(data) );

				$('#info, #contentGE').html('');

				var objGuiaPdf = JSON.stringify(data.objetopdf);
				
				console.log(objGuiaPdf);

				if (objGuiaPdf != '' || objGuiaPdf != null || objGuiaPdf != 'undefined' ) {
					objGuiaPdf = objGuiaPdf.replace("\"", "");
				}

				$("#contentGE").prepend("<object id='pdf' data=\"data:application/pdf;base64," + objGuiaPdf + "\" type='application/pdf' width='700' height='800'> </object>");
				
			}, 
			beforeSend: function() {
				$('#info').html('Espere...');
			},
			error: function(mensaje) {
				$('#info').html('Error: ' + mensaje.errormessage);
			}
		});
	});

	
});

</script>
</body>
</html>