<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="30">
	<title>Tabla de Sesiones - Laravel</title>
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>

</head>
<body style="font-family: tahoma;font-size: 12px;">

<h3>Sesiones de usuarios:</h3>
<h5>(La página se actualiza cada 30 segundos)</h5>

@if (session('message'))
	<div style="background-color:lightblue; color:blue; padding:10px; "> {{ session('message') }} </div>
@endif

{{-- {{ dump($Resultado, count($Resultado)) }} --}}

@if (\Session::has('login'))
	
	<table border='1' cellspacing='0' style='font-size:11px;border: 1px solid lightgray;' >
		
		<tr style='background-color:lightgray;'>
			<td>#</td>
			<td>ID</td>
			<td>USER_ID</td>
			<td>IP_ADDRESS</td>
			<td>USER_AGENT</td>
			<td>LOGIN (PAYLOAD)</td>
			<td>PAYLOAD (DECODE)</td>
			<td>LAST_ACTIVITY</td>
			<td>LOGIN</td>
			<td></td>
		</tr>

		{{-- {{ dump((($Resultado[0]['payload_decode']))) }} --}}

		@for ($i = 0; $i < count($Resultado); $i++)
			<tr>
				@php 
					$objectPayload = json_decode($Resultado[$i]['payload_decode']);
					$fechaCreacion = date('d-m-Y h:i:s', (string) $objectPayload->_sf2_meta->c);
				@endphp

				<td> {{ ($i + 1) }} </td>
				<td> {{ $Resultado[$i]['id'] }} </td>
				<td> {{ $Resultado[$i]['user_id'] }} </td>
				<td> {{ $Resultado[$i]['ip_address'] }} </td>
				<td style='width:170px;'> {{ $Resultado[$i]['user_agent'] }} </td>
				<td> {{ $Resultado[$i]['login_payload'] }} </td>

				<td>
					Payload: {{ $Resultado[$i]['payload_decode'] }} <br><br>
					Login: {{ $objectPayload->login or 'null' }} <br>
					User ID: {{ $objectPayload->user_id or 'null'}} <br>
					URL Previo: {{ $objectPayload->_previous->url or 'null' }} <br>
					Fecha creacion: {{ $fechaCreacion }} <br>
				</td>

				{{--<td> {{ $Resultado[$i]['payload_decode'] }} </td>--}}
				<td> {{ $Resultado[$i]['last_activity']}} </td>
				<td> {{ $Resultado[$i]['login']}} </td>

				<td>
					<form name='borrarSesion' method='get' action='borrar_sesion'>
						<input type='hidden' name='txtSessionId' id='txtSessionId' value="{{ $Resultado[$i]['id']  }}" maxlength='40' />
						<input type='submit' name='btnBorrarSession' style='border:1px solid red;color:red;font-size:18px;background-color: lightyellow;' value='X' title='Borrar Sesión' onclick="return confirm('¿Desea borrar la sesión de usuario?');">
					</form> 
				</td>
			</tr>
		@endfor

	</table>
	<br>
	<i>Total Sesiones:  {{ count($Resultado) }} </i>

	<br><br>

@else

	<font color="brown">Debe estar autenticado para ver está página.</font>
	
@endif

</body>
</html>