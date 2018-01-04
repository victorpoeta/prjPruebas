<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        $this->handleErrorsWS($e, $request);

        return parent::render($request, $e);
    }

    // Función para interceptar determinados tipos de errores que pueden generar 
    // los servicios web y rutas (vistas), y poder retornar el mensaje en formato JSON
    private function handleErrorsWS($e, $request) {

        // dump(http_response_code());
        // dump(get_class($e));


        $c = basename(str_replace('\\', '/', get_class($e)));

        $arrayMsg = ['codrespuesta' => 'CODE_003',
                     'mensaje' => 'ERROR EN LA LLAMADA AL SERVICIO',
                     'entidadRespuesta' => ['tipoError' => $c] ];

/*        if ($e instanceof \InvalidArgumentException) {
            $arrayMsg['entidadRespuesta']['info'] = htmlentities(utf8_encode($e->getMessage())); 
            response()->json($arrayMsg)->send(); die();
        }*/
        
        // Intercepta posible Error 500
        if ($this->isHttpException($e)==true && $e->getStatusCode()==500) {
            $arrayMsg['entidadRespuesta']['info'] = 'Error ' . $e->getStatusCode(); 
            response()->json($arrayMsg)->send(); die();
        }
        if ($e instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
            $arrayMsg['entidadRespuesta']['info'] = htmlentities(utf8_encode($e->getMessage())) . 
                                                    '. Archivo: ' . $e->getFile() . '. Linea: ' . $e->getLine(); 
            response()->json($arrayMsg)->send(); die();
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $arrayMsg['entidadRespuesta']['info'] = 'Este servicio web no acepta el metodo ' . $request->method();
            response()->json($arrayMsg)->send(); die();
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $arrayMsg['entidadRespuesta']['info'] = 'No existe ruta o servicio ingresado';
            response()->json($arrayMsg)->send(); die();
        }
        if ($e instanceof \Illuminate\Database\QueryException) {
            $arrayMsg['entidadRespuesta']['info'] = htmlentities(utf8_encode($e->getMessage())) . $e->getFile();
            response()->json($arrayMsg)->send(); die();
        }
        if ($e instanceof \PDOException) {
            $arrayMsg['entidadRespuesta']['info'] = 'Error en la conexion a la base de datos: ' . 
                                                    htmlentities(utf8_encode($e->getMessage()) );
            response()->json($arrayMsg)->send(); die();
        }

        
    }

}
