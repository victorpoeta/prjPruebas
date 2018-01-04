<?php session_start() ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ciudades y Zip Codes DHL</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	</head>

	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>

	<script type="text/javascript">
        function enviarDatos(tipoPlantilla, ciudad, zipCode, suburbio) {
            if (tipoPlantilla == 'plantilla9') {
                window.opener.document.getElementById('ciudaddesint').value = ciudad;
                window.opener.document.getElementById('zipcodes').value = zipCode;
                window.opener.document.getElementById('suburbio').value = suburbio;
                //if (zipCode==0 && suburbio.length > 0) { }
                window.close();
            }
            if (tipoPlantilla == 'agregarDest') {
                window.opener.document.getElementById('ciudaddes22').value = ciudad;
                window.opener.document.getElementById('cmbzpint').value = zipCode;
                window.opener.document.getElementById('estadodes').value = suburbio;
                window.close();
            }
            if (tipoPlantilla == 'editarDest') {
                window.opener.document.getElementById('ciudaddes22').value = ciudad;
                window.opener.document.getElementById('codzp2').value = zipCode;
                window.opener.document.getElementById('estadodes').value = suburbio;
                window.close();
            }
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

		function getCiudadesDHL() {
			var urlWsDHL = "http://webservices.grupozoom.com/baaszoom/public/CiudadZipWs?siglas_pais=" + "<?php echo strtoupper(@$_REQUEST['siglas_pais']); ?>";

			<?php
				$plantilla = @$_REQUEST['plantilla'];
				$plantilla = ($plantilla==null || $plantilla=='') ? $plantilla='0' : $plantilla;

				$filtroCiudad = @$_REQUEST['filtroCiudad'];
			?>
			var plantilla = <?php echo $plantilla; ?>;
			var wordFiltroC = "<?php echo $filtroCiudad; ?>";
			var rxwFiltroC = new RegExp( wordFiltroC, 'g' );

			if (wordFiltroC=='' || wordFiltroC==null) {
				$("#info").html('Debe ingresar 3 o más caracteres para filtrar la Ciudad Destino');
				return false;
			}

			$.ajax ({
				async: true,
				url: urlWsDHL,
				type: "GET",
				cache: false,
				dataType: "json",
				success: function(result) {
					
					if (result.Codigo=='SUCESS'){
						var totalReg=result.Mensaje.length; //Total de registros
						//alert(totalReg);

						if (totalReg > 0) {

							var arrayFiltroC = $.grep( result.Mensaje, function( n, i ) { 
								if (wordFiltroC!='') {
									return n.nombre_ciudad.match(rxwFiltroC); 
								} else {
									return n.nombre_ciudad; 
								}
							});
							var totalRegF = arrayFiltroC.length;	

							$("#info").html('');
							$("#info").append("<table id='tabla' style='border:1px solid lightgray;width:100%;'>");
							$("#info > table").append("<tr style='font-weight:bold;background-color:lightgray;'> <th width='10%'></th> <th width='30%'>Ciudad</th> <th width='30%'>Zip Code</th> <th width='30%'>Suburbio</th></tr>");
							
							for (i = 0; i < totalRegF; i++) {

								/*var vals = [filtroC.Mensaje[i].nombre_ciudad, 
										    filtroC.Mensaje[i].zip_code, 
										    filtroC.Mensaje[i].suburb];*/
								var vals = [arrayFiltroC[i]['nombre_ciudad'], arrayFiltroC[i]['zip_code'], arrayFiltroC[i]['suburb'] ];

								if (vals[1]=='' || vals[1]==null) {
									vals[1] = 0;
								}

								$("#info > table").append('<tr>' +
														  "<td> <input type='button' id='btnPasarValores' name='btnPasarValores' value='<<' onclick='enviarDatos(\"" + plantilla + "\", \"" + vals[0] + "\", \"" + vals[1] + "\", \"" + vals[2] + "\");' ></td>" + 
														  "<td>" + vals[0] + "</td>" + 
														  "<td>" + vals[1] + "</td>" + 
														  "<td>" + vals[2] + "</td>" + 
														  '</tr>');

							}

							$("#totalReg").val(totalRegF);
							$("#span_totalreg").show();
						}
						else	{
							alert (result.mensaje);
							$("#span_totalreg").hide();
						}
					}
					else {
		                $('#info').html('No se pudo obtener los datos del servicio: ' + JSON.stringify(result));
		                $("#span_totalreg").hide();
					}
				},
				beforeSend: function() {
					$('#info').html('<b>Estimado usuario, espere unos segundos mientras se carga la informaci&oacute;n...</b>');
				},
				error: function(e) {
					$('#info').html("<font color='brown'>Error en la consulta al servicio: " + JSON.stringify(e) + "</font>");
				},
				complete: function(){
				    // Handle the complete event
				}
			});


		}

		$(document).ready(function() {
		    getCiudadesDHL();
		    $("#span_totalreg").hide();
		});

		$("#txtBusqueda").keyup(function(e) {
			busqueda();
		});

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
            border:1px solid lightgray;
            width:100%;
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
            text-align: center;
        }
        .error {
            background-color: lightgray;
            color: brown;
            font-weight: bold;
            padding: 5px 5px 5px 5px;
            font-size:13px;
        }

	</style>

	<body>
		<div class='title'> Ciudades y Zip Codes DHL </div>

		<br>
		<b style='margin-left:5px;'>Pa&iacute;s: <?php echo strtoupper(@$_REQUEST['nombre_pais']); ?> </b>
		<div align='right' style='padding-bottom:10px;'>Buscar: <input type='text' name='txtBusqueda' id='txtBusqueda' onkeyup='busqueda();' ></div>

		<div id="info" style="width:100%">
			
		</div>

		<span id='span_totalreg'>
			<hr>Total Registros: <input type='text' disabled id='totalReg' size='5' >	
		</span>
		
	</body>
</html>