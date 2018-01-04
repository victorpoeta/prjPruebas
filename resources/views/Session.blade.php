<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="css/main.css" />-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ejemplo de Sesiones - Laravel</title>
	<meta name="keywords" content="" />
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/aes-js-master/index.js"></script>

	<script src="assets/js/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<style type="text/css">
		/*body {
			font-family: "tahoma";
			font-size: 14px;
		}*/
		ul {
			margin-left: 5px;
			margin-right: 5px;
			margin-top: 5px;
			list-style-type: none;
		}
	</style>
</head>
<body>

<div align="center" style="background-color: lightgray; height:700px; width:90%; min-width:360px; margin-left:5%;">
<hr>
<h3>Ejemplos Varios - PHP Laravel :</h3>
<hr>

@if (session('message'))
	<div id="msgInfo" style="background-color:lightblue; color:blue; padding:5px; "> {{ session('message') }} </div>
@endif

@if (\Session::has('login'))
	
	<div style="padding-right:5px;background-color:whitesmoke; text-align:right; width: 99%" class="collapse navbar-collapse">
		Bienvenido(a): <b> {{\Session::get('login')}} </b> 
		@if (Session::has('user_admin')) 
			<strong> (Administrador) </strong> 
		@endif
		| <a href="{{ route('cierre_sesion') }}">Cerrar Sesión</a>
	</div>

	<div style="display:inline-flex;width:100%;">
		<div align="left" style="width:250px; height:360px;">
		<ul style="text-align: left;" class="list-group">
			@if (\Session::has('user_admin'))
				<li class="list-group-item">
					<a href="{{ route('mostrarTablaSesiones') }}" target="marco">Ver tabla de sesiones (mysql)</a>
				</li>
				<li class="list-group-item">
					<a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('auth0') }}" target="marco">Autenticación con Auth0</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('regenerateSessions') }}" target="marco">Regenerar Sesión</a>
				</li>
			@endif

			<li class="list-group-item">
				<a href="{{ route('pruebaHash') }}" target="marco">Encriptación de cadena</a>
			</li>
			<!-- <li>
				<a href="{{ route('arrays') }}" target="marco">Ejemplo de arrays</a>
			</li> -->
			<li class="list-group-item">
				Generador Password: <br>
				<a href="{{ route('encriptarCampos') }}?length=32" target="marco">32 caracteres</a><br>
				<a href="{{ route('encriptarCampos') }}?length=40" target="marco">40 caracteres</a><br>
				<a href="{{ route('encriptarCampos') }}?length=64" target="marco">64 caracteres</a>
			</li>

			<li class="list-group-item">
				<a href="{{ route('LoginPrueba') }}" target="marco">Consumir WS Login Ajax</a><br>
			</li>
		</ul>
		</div>

		<iframe class="navbar" name="marco" src="" style="margin-top:5px;margin-right:5px;background-color:white;width:100%;height:550px;border:1px solid lightblue;font-size:10px;">
		
		</iframe>
		
	</div>
	<hr>
@else
<form method="GET" action="{{ route('crear_sesion') }}">

	<table style="min-width:320px;padding:10px;background-color: whitesmoke;border:1px solid lightgray;text-align:center;">
		<tr>
		  <td><label><b>Ingrese login:</b></label></td>
		  <td>
		  	<input type="text" maxlength="20" name="txtLogin" id="txtLogin" required="required" value="admin" />
		  </td>
		</tr>
		<tr>
		  <td><label><b>Clave:</b></label></td>
		  <td>
		  	<input type="password" maxlength="15" name="txtClave" id="txtClave" required="required" value="admin" />
		  </td>
		</tr>
		<tr>
		 	<td colspan="2"><input type="submit" name="txtEnviar" id="txtEnviar" value="Ingresar" style="margin-top:10px;width:100%;"></td>
		</tr>
	</table>

	<input type="hidden" size="60" name="_token" id='_token' value="{{ csrf_token() }}">
</form>
<br>
@endif

<script type="text/javascript">

	$( document ).ready(function() {
	  // Handler for .ready() called.
	   $("#msgInfo").fadeOut(5000);
	});

</script>

</div>
</body>
</html>