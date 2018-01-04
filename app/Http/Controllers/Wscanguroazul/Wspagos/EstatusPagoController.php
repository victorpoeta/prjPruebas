<?php

namespace App\Http\Controllers\Wscanguroazul\Wspagos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wscanguroazul\Model\Wspagos\EstatusPago;
use App\Wscanguroazul\Dal\Wspagos\EstatusPagoDAL;

class EstatusPagoController extends Controller
{
	private $EstatusPago;
	private $EstatusPagoDAL;
	
	public function __construct() {
		$this->EstatusPago= new EstatusPago();
		$this->EstatusPagoDAL= new EstatusPagoDAL();
	}

	public function getListaEstatusPago(Request $request) {
		$id= $request->get('idestatuspago');
		//$id= $request->idestatuspago;
		dd($request->all());

		if (!empty($id)) {
			$Result = $this->EstatusPagoDAL->getInfoEstatusPago($id);
			
			if (empty($Result) || $Result=='[]') {
				$Result='No existen registros';
			}
			
		} else {
			$Result = $this->EstatusPagoDAL->getInfoEstatusPago(null);
		}
		
		return response()->json($Result);
	}

	public function newEstatusPago() {
		echo 'newEstatusPago';
	}
	
}
