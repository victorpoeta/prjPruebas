<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Pagos;


class PagosController extends Controller
{
    private $pagos;

    public function crearPagosWs(Request $request) {

    	$params = ['idestatuspago' => 1, 
    			   'idempresa'	   => 1,
    			   'idtransbanc'   => 24,
    			   'montototal'	   => 1520.75,
    			   'emailpagador'  => 'vpoeta@grupozoom.com',
    			   'docs' => ['tipodoc' => ['1','2','1'], 
    			   			  'nrodoc' => ['123456712','01E105-00001102','91500121'], 
    			   			  'monto' => [250, 1170.75, 100] ] ];

    	$pagos = new Pagos();
    	$Res = $pagos->crearPagos($params);

    	if (count($Res) > 0) {
    		$message = $Res;
    	} else {
    		$message = ['No se pudo guardar los datos'];
    	}

    	return $message;
    }

    public function getInfoPagosWs(Request $request) {
    	$pagos = new Pagos();
    	$Res = $pagos->infoPagos();

    	return $Res;
    }

    public function pruebaDistribucionMontos(Request $request) {
        //$monto = ['1306.13','-250'];
        $monto = ['1250.25','80','-250', '102.52'];

        $montoTotal = $request->input('montoTotal');

        $MontosRes = $this->getDistribucionMontoPag($monto, (string) $montoTotal);

        $Res = ['montos_doc' => $monto, 'montos_distrib' => $MontosRes];

        return $Res;

    }

    private function getDistribucionMontoPag($montosDoc, $montoPagado) {
        $MontoRest= $montoPagado;
        foreach ($montosDoc as $key => $value) {
            if ($MontoRest >= $montosDoc[$key]) {
                $MontoRest = $MontoRest - $montosDoc[$key];
            } elseif ($montosDoc[$key] >= $MontoRest) {
                $montosDoc[$key] = "$MontoRest";
                $MontoRest = 0;
            } elseif ($MontoRest <= 0 ) {
                $montosDoc[$key] = 0;
            }
            $montosDoc[$key] = (string) abs($montosDoc[$key]);
        }
        return $montosDoc;
    }

}
