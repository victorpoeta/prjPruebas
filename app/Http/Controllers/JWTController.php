<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Validator;
use Exception;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTController extends Controller
{

    // Función (WS) que permite invalidar un token activo (generado desde el login, con la función JWTAuth)
    public function invalidateToken(Request $request) {
        $reglas = Validator::make($request->only('token'), ['token' => 'required']);

        if ($reglas->fails()) {
            $mensaje = ['error_jwt' => 'Token requerido.'];
        } else {
            try {
                JWTAuth::invalidate($request->input('token'));
                $mensaje = ['ok_jwt' => 'Token invalidado.'];
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                    $mensaje = ['error_jwt'=> 'Token ha sido invalidado.'];
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    $mensaje = ['error_jwt'=> 'Token invalido.'];
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    $mensaje = ['error_jwt'=> 'Token ha expirado.'];
                } else {
                    $mensaje = ['error_jwt'=> 'Error al invalidar el token.'];
                }
            }

        }
        return response()->json($mensaje);
    }

    // Función (WS) que permite refrescar el token que se envía como parámetro, generando otro token actualizado,
    // y el que se envía queda invalidado (extiende el tiempo de expiración a 30 minutos).
    public function refreshToken(Request $request) {
        $reglas = Validator::make($request->only('token'), ['token' => 'required']);

        if ($reglas->fails()) {
            $mensaje = ['error_jwt' => 'Token requerido.'];
        } else {
            try {
                $refreshed = JWTAuth::refresh($request->input('token'));
                $mensaje = ['ok_jwt' => $refreshed];
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                    $mensaje = ['error_jwt'=> 'Token se encuentra invalidado.'];
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    $mensaje = ['error_jwt'=> 'Token invalido.'];
                } else {
                    $mensaje = ['error_jwt'=> 'Error al refrescar el token.'];
                }
            }
        }
        return response()->json($mensaje);
    }

    // Función (WS) que permite verificar si el token enviado es válido y se encuentra activo.
    // Si el token está activo, devuelve el payload (datos básicos del token, y las fechas/horas de creación y expiración).
    public function getInfoToken(Request $request) {
        $reglas = Validator::make($request->only('token'), ['token' => 'required']);

        if ($reglas->fails()) {
            $mensaje = ['error_jwt' => 'Token requerido.'];
        } else {
            try {
                //$token = JWTAuth::toUser($request->input('token'));
		        // $token = JWTAuth::parseToken()->authenticate();

            	//// $token = JWTAuth::getToken();
            	$token = JWTAuth::decode(JWTAuth::getToken());

                $payload = explode('.', $request->input('token'));
                $payloadDecode = json_decode(base64_decode($payload[1]));
                $mensaje = ['ok_jwt' => 'Token valido.', 'payload' => $payloadDecode,
                            'created_token' => date('d/m/Y H:i:s', $payloadDecode->iat), 'expire_token' => date('d/m/Y H:i:s', $payloadDecode->exp)];

            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                    $mensaje = ['error_jwt'=> 'Token ha sido invalidado.'];
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    $mensaje = ['error_jwt'=> 'Token invalido.'];
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    $mensaje = ['error_jwt'=> 'Token ha expirado.'];
                } else {
                    $mensaje = ['error_jwt'=> 'Error al verificar el token.' . $e->getMessage() . '; ' . $e->getLine() . '; ' . $e->getFile()];
                } 
            }
        }
        return response()->json($mensaje);
    }

    // Función (WS) que permite crear un token generico (de acuerdo a los parámetros/customClaims definidos)
    public function createGenericToken(Request $request) {
        $id = $request->input('id');
        $nombre = trim(strtoupper($request->input('nombre')));
        $duracionTokenSegundos = $request->input('duracion_token');
        $key = $request->input('key');

        $reglas = Validator::make($request->only('id', 'nombre', 'duracion_token', 'key'),
                                 ['id' => 'required', 'nombre' => 'required', 'duracion_token' => 'integer|min:60', 'key' => 'required']);

        if ($reglas->fails()) {
            $mensaje = ['error_jwt' => 'id, nombre y key son requeridos.'];
        } else {
            try {
                if ($key=='D3sarr0ll0') {

                    if ($duracionTokenSegundos=='' || $duracionTokenSegundos==null) {
                        // Si no se envia valor de duración del token, queda como valor
                        // predeterminado 3600 segundos = 1 hora.
                        $tiempoExpiracion = strtotime('+3600 seconds');
                    } else {
                        $tiempoExpiracion = strtotime("+" . $duracionTokenSegundos . " seconds");
                    }

                    $customClaims = ['sub' => $id, 'nombre' => $nombre, 'token_generico' => 'SI',
                                     'exp' => $tiempoExpiracion];


/*                    for ($i=0; $i < 5000; $i++) { 
                    	$customClaims = ['sub' => $id, 'nombre' => $nombre . $i, 'token_generico' => 'SI',
                                         'exp' => $tiempoExpiracion];

                    	$payload[$i] = JWTFactory::make($customClaims);
                    	$mensaje[$i] = ['token' => (string) JWTAuth::encode($payload[$i])];
                    }
*/
                    //dump($mensaje);

                    $payload = JWTFactory::make($customClaims);
                    $mensaje = ['token' => (string) JWTAuth::encode($payload)];

                    // Crear archivo y guardar el token generado
/*                    $id = fopen('jwt_tokens.txt', 'a');
                    for ($i=0; $i < 5000; $i++) { 
                    	 fwrite($id, $mensaje[$i]['token'] . chr(13).chr(10) );
                    }
                    fclose($id);*/
                    // ------------------------------

                } else {
                    $mensaje = ['error_jwt' => 'El key ingresado es invalido.'];
                }

            } catch (Exception $e) {
                $mensaje = ['error_jwt' => 'Ha ocurrido un error al generar el token generico. ' . $e->getMessage() ];
            }
        }

        return $mensaje;
    }
}
