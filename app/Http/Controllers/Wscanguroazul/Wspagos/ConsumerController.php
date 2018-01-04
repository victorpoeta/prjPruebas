<?php

/* Clase para consumir Web Services */
/************************************/

namespace App\Http\Controllers\Wscanguroazul\Wspagos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Curl; 

use App\Http\Controllers\Wscanguroazul\Wspagos\EstatusPagoController;


class ConsumerController extends Controller
{
      private $EP;   
      //private $ruta_inicial;

      public function __construct() {
         $this->EP= new EstatusPagoController();
      } 

      /*
      
   	public function __construct() {
   		$this->ruta_inicial= 'http://127.0.0.1/prjPruebas/public/';
   	}
   	
      
   	public function consumerConsultaEstatusPago() {
   		$idestatuspago="1";

   		$response= Curl::to($this->ruta_inicial . 'ListaEP?')
                    ->withData(array('idestatuspago' => "$idestatuspago"))->get();
         
   		return $response;
         //return Response()->json($response);
         
   	}
      */

      public function listaEstatusPago(Request $request) {
         //$request->idestatuspago=1;

         $ListaEP= new EstatusPagoController;

         return $ListaEP->getListaEstatusPago($request);

      }

      /*
      public function mostrarMsg() {
         echo "mostrarMsg";
      }
      */
      

}
