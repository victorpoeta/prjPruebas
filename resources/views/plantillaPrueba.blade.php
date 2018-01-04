<!DOCTYPE html>
<html>
	<head>
		<title>Plantilla de Prueba</title>
	</head>
	<script type="text/javascript">
		function abrirVentanaZipCodeDHL(tipoPlantilla) {
			var SiglasPais = document.getElementById("siglas_pais").value;
			var NombrePais = document.getElementById("nombre_pais").value;

			if (SiglasPais=='' || SiglasPais==null || SiglasPais=='undefined') {
				alert('Debe seleccionar el país.'); return false;
			}
			
			miPopup = window.open("CiudadZipCodeDHL?siglas_pais=" + SiglasPais + '&nombre_pais=' + NombrePais + '&plantilla=' + tipoPlantilla, "_blank",
					 "width=680,height=500,scrollbars=yes,resizable=yes,left=300,top=100");
			
			if (window.navigator.userAgent.indexOf('MSIE') > 0) {
				miPopup.alert('Estimado usuario, espere unos segundos mientras se carga la información');
			}
			
			var texto = document.createElement('div');
			texto.innerHTML = '<b>Estimado usuario, espere unos segundos mientras se carga la informaci&oacute;n...</b>';
			miPopup.document.body.appendChild(texto);

   			miPopup.focus();
		}
	</script>
	<body>
		<h3> Plantilla de Prueba </h3>
		<form action="" method="get">
			Nombre País: <input type="text" name="nombre_pais" id="nombre_pais" size="25"> 
			Siglas País: <input type="text" name="siglas_pais" id="siglas_pais" size="3">
			<input type="button" name="consultarZipCode" id="consultarZipCode" value="Consultar Zip Code" onclick="abrirVentanaZipCodeDHL('GE');">
			<br><br>
			Ciudad: <input type="text" disabled name="ciudad" id='ciudad' size="25"> <br>
			Zip Code: <input type="text" disabled name="zip_code" id='zip_code' size="7"> <br>
			Suburbio: <input type="text" disabled name="suburbio" id='suburbio' size="25"> <br> 
		</form>
	</body>
</html>