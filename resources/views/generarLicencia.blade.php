<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="../resources/views/lib/estilo.css"/>-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Generar Licencia</title>
	<meta name="keywords" content="Zoom International Services." />
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

<div class="title" id="title1">Generar Licencia:</div>

<br>
<form method='post' action=''>
	Código Cliente: <br>
	<input type="text" name="txtCodCliente" id="txtCodCliente"><br><br>
	Doc. Identidad (RIF/Cedula/Pasaporte): <br>
	<input type="text" name="txtDocCliente" id="txtDocCliente"><br><br>
	Fecha Generación Licencia: <br>
	<input type='text' name='txtFechaGenLic' id='txtFechaGenLic' value="<?php echo date('d-m-Y'); ?>" > <br><br>
	Fecha Vencimiento Licencia: <br>
	<input type='text' name='txtFechaVenLic' id='txtFechaVenLic' value="<?php echo date('d-m-Y'); ?>" > <br><br>

	<input type='submit' name='btnGenerarLic' id='btnGenerarLic' value='Generar Licencia'>	

</form>

<br><br>

<?php
	
	$CodCliente = @$_REQUEST['txtCodCliente'];
	$DocCliente = @$_REQUEST['txtDocCliente'];
	$FechaGenLic = @$_REQUEST['txtFechaGenLic'];
	$FechaVenLic = @$_REQUEST['txtFechaVenLic'];

	if ($CodCliente!='') {
		$concatVal = $CodCliente . ";" . $DocCliente . ";" . $FechaGenLic . ";" . $FechaVenLic;
		
		$enc1 = md5(sha1($concatVal));
		$enc2 = base64_encode(base64_encode($CodCliente . "|" . $DocCliente . "|" . $FechaGenLic . "|" . $FechaVenLic));
	
		$Licencia = "$1$." . $enc1 . '.' . $enc2;

		$DecB64 = base64_decode(base64_decode($enc2));

		$ArrayDecB64 = explode('|',$DecB64);

	} else {
	 	$Licencia = '';
	 	$ArrayDecB64 = '';
	}
	
	echo "<h3>" . $Licencia . "</h3>";
	echo "Información decodificable de la licencia: ";
	print_r ($ArrayDecB64) . "<br>";

?>


<script type="text/javascript">


</script>

</body>
</html>