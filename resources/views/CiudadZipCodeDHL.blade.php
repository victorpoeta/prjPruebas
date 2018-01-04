<?php session_start() ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ciudades y Zip Codes DHL</title>
	</head>
	<script type="text/javascript">

		function enviarDatos(tipoPlantilla='GE', ciudad=0, zipCode=0, suburbio=0) {

			if (tipoPlantilla == 'GE') {
				window.opener.document.getElementById('ciudad').value = ciudad;
				window.opener.document.getElementById('zip_code').value = zipCode;
				window.opener.document.getElementById('suburbio').value = suburbio;
			}

			//window.close();
		}

		function busqueda() {
			var input, filter, table, tr, td, i;
			input = document.getElementById("txtBusqueda");
			filter = input.value.toUpperCase();
			table = document.getElementById("tabla");
			tr = table.getElementsByTagName("tr");
			
			var contadorFilas = 0;
			for (i = 0; i < tr.length; i++) {
			    td = tr[i].getElementsByTagName("td")[0];
			    if (td) {
			      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
			        tr[i].style.display = "";
			        contadorFilas = contadorFilas + 1;
			      } else {
			        tr[i].style.display = "none";
			      }
			    }       
			}

			document.getElementById("totalReg").value = contadorFilas;
		}

	</script>
	<style type="text/css">
		body {
			font-family: Arial;
			font-size: 11px;
		}
		input {
			font-size: 11px;
		}
		input[type=button] {
			background-color: lightblue;
			color:white;
			border:1px solid gray;
		}
		input[type=button]:hover {
			background-color: blue;
		}
		table {
			min-width: 400px;
		}
		tr:hover {
			background-color: lightblue;
		}

		.title {
			font-size: 13px;
			font-weight: bold;
			color: blue;
			background-color: ghostwhite;
			padding: 5px 5px 5px 5px;
		}
		.error {
			background-color: lightgray;
			color: brown;
			font-weight: bold;
			padding: 5px 5px 5px 5px;
		}

	</style>

	<body>
		<div class='title'> Ciudades y Zip Codes DHL </div>

		<?php 

			$siglasPais = @$_REQUEST['siglas_pais']; 
			$nombrePais = @$_REQUEST['nombre_pais']; 
			$plantilla = @$_REQUEST['plantilla'];

			$urlWs = "http://desarrollo3.grupozoom.com/baaszoom/public/CiudadZipWs";

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $urlWs . '?siglas_pais=' . $siglasPais); 
			curl_setopt($ch, CURLOPT_POST, 0); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
				
			$response = curl_exec($ch);
			curl_close($ch);

			$res = (array) json_decode($response);
			

			if (isset($res['Codigo']) && ($res['Codigo']=='SUCESS' && count($res) > 0) ) {

				echo "<table id='tabla' style='border:1px solid lightgray;width:100%;'>";

				if ($nombrePais) {
					echo "<b style='margin-left:5px;'>Pa&iacute;s: " . $nombrePais . "</b>";
					echo "<div align='right' style='padding-bottom:10px;'>Buscar: <input type='text' name='txtBusqueda' id='txtBusqueda' onkeyup='busqueda();' ></div>";
				}
				
				echo "<tr style='font-weight:bold;background-color:lightgray;'> 
						<th width='10%'></th> <th width='30%'>Ciudad</th> <th width='30%'>Zip Code</th> <th width='30%'>Suburbio</th>
					  </tr>";

				foreach ($res['Mensaje'] as $key => $value) {
					
					$TotalReg = count($res['Mensaje']);

					if (is_object($value)) {
						$valores = array($value->nombre_ciudad, $value->zip_code, $value->suburb);
					} elseif (is_array($value)) {
						$valores = array($value['nombre_ciudad'], $value['zip_code'], $value['suburb']);
					}

					if ($valores[1]=='' || $valores[1]==null) {
						$valores[1] = 0;
					}

					echo "<tr>  
							<td> <input type='button' id='btnPasarValores' name='btnPasarValores' value='<<' 
							     onclick='enviarDatos(\"" . $plantilla . "\", \"" . $valores[0] . "\", \"" . $valores[1] . "\", \"" . $valores[2] . "\");' > </td>
					   		<td> " . $valores[0] . " </td>
							<td> " . $valores[1] . " </td>
							<td> " . $valores[2] . " </td>
						 </tr>";
				}

				echo "</table>";

				echo "<hr>Total Registros: <input type='text' disabled id='totalReg' size='5' value=" . $TotalReg . " >";

			} else {

				if (isset($res['Codigo'])) {
					echo "<div class='error'>" . $res['Codigo'] . ": ";
					foreach ($res['Mensaje'] As $key => $value) {
						print_r($value[0]);
					}	
					echo "</div>";

				} else {
					if (isset($res['codrespuesta'])) {
						echo "<div class='error'>" . $res['codrespuesta'] . ': ' . $res['mensaje'] . '<br>' . $res['entidadRespuesta']->info . '</div>';					
					} else {
						echo "<div class='error'>Error inesperado. Intente nuevamente.</div>";
					}
					
				}
			}

		?>

	</body>
</html>