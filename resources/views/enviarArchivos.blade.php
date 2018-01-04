<!DOCTYPE html>
<html>
<head>
	<title>Ejemplo de subida de archivos pdf</title>

	<script type="text/javascript" src="{{ url('/js/jquery-3.1.0.min.js') }}"></script>

	<script type="text/javascript">
		/*function DoSubmit() {
			var num = '$.'+btoa(btoa(btoa(document.getElementById('txtClave').value)))+'#';
			document.getElementById("txtClave").value = num;
  			return true;
		}*/

		$(function() {

			$("#btnSendFilesAjax").click(function(e) {
				e.preventDefault();
				
	            var valToken = $("#token").val();

	            //var url = "http://10.0.3.49/prjPruebas/public/enviarArchivosPost";
	            //var url = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/createPagoArchivoWs";
	            var url = "http://10.0.3.49/prjPruebas/public/uploadFileXML";
	            //var url = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/createGuiaPreAlertWs";

	            //var params = {idpago:valIdpago,token:valToken,archivos:$("#archivos")[0]};
	            //alert(JSON.stringify(params));

	            var form = new FormData();
				//form.append("token", valToken );
				//form.append("archivo", $("#archivo").val());
				form.append("filexml", $('#filexml')[0].files[0] );
				form.append("nombre_original_archivo", $("#filexml").val() );
				//form.append("nombre_original_archivo", $('input[type=file]').val() );

				$.ajax({ 
					async: true,
			  		//crossDomain: true,
					/*headers: {
						'X-CSRF-TOKEN': valToken, 
						"cache-control": "no-cache",
						//"postman-token": "b14a75a8-c67d-9ad8-b4d5-1b5c672a6742"
					},*/
					url: url,
					type: 'POST', 
					//method: 'POST',
					//dataType: 'json',
					//mimeType: "multipart/form-data",
					//cache: false,
					contentType: false, 
					processData: false,  
					data: form, 
					success: function (data) { 
						//alert('Data: ' + data );

						//var datos = JSON.stringify(data);
						$('#respuesta').html(data);
						/*$('#objeto').html('Parametros: ' + params);*/
					}, 
					beforeSend: function() {
						$('#respuesta').html('<div class="error">Espere...</div>');
					},
					error: function(mensaje) {
						$('#respuesta').html('<div class="error">Error: ' + JSON.stringify(mensaje) + '</div>');
					}

				});

			});


		});

	</script>
</head>
<body>
	<h3>Ejemplo de subida de archivos</h3>
	<?php
		$urlWs = "http://desarrollo3.grupozoom.com/baaszoom/public/canguroazul/createGuiaPreAlertWs";

		$token = "";

		echo "<form name='conectarSFTP' id='conectarSFTP' action='" . $urlWs . "' method='post' enctype='multipart/form-data'>
				<input type='file' name='filexml' id='filexml' style='background-color:aliceblue;color:blue;border:1px solid blue;width:350px;padding:5px 5px 5px 5px;' accept='.xml'><br>
		  		<input type='hidden' name='token' id='token' size='100' value=" . $token . " ><br>
		  		<input type='button' id='btnSendFilesAjax' name='btnSendFilesAjax' value='Enviar archivos (AJAX)' />
		  		<input type='submit' />
			  </form>";

		// Clave: <input type='text' name='txtClave' id='txtClave' value='123321' ><br><br>

		//$encrypted = \Crypt::encrypt('1234');
		//$decrypted = \Crypt::decrypt($encrypted);
		//dump($encrypted, $decrypted);

		//echo \Form::open(array('url' => '/uploadfile','files'=>'true')); 

	?>

	<br>

	<div id="objeto" style="width:100%;background-color: lightgray;">
		
	</div>

	<div id="respuesta" style="width:100%;background-color: lightgray;">
		
	</div>
	

</body>
</html>

