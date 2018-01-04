<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\estatus_pago;

class estatus_pagoController extends Controller
{
    
    public function guardarEP() {
		$estatus= new EstatusPago;
		$estatus->nombre=substr('Prueba', 0,40);

		$estatus->save();

		echo "El estatus de pago " . $estatus . " ha sido guardado con éxito!";

	}

	public function mostrarEP() {
		// -----------  Uso de Fluent  ---------------
		//$result= \DB::table('estatuspago')->get();
		
		/*
		$result = \DB::select('SELECT * FROM estatuspago 
							   WHERE idestatuspago = :idestatuspago', 
							   ['idestatuspago' => 2]);
		*/				   
		$result = \DB::select('SELECT * FROM estatuspago LIMIT 15');
		dd($result);
		// -------------------------------------------

		// ----------- Uso de Eloquent ---------------
		// $result= EstatusPago::get();
		// dd($result->toArray());
		// -------------------------------------------
	}

	public function modificarEP() {
		// -----------  Uso de Fluent  ---------------
		$affected = \DB::update("UPDATE estatuspago 
								 SET nombre = 'Estatus 1' 
								 WHERE idestatuspago = :codigo", ['codigo'=>1]);
		// -------------------------------------------
		
		echo "El estatus de pago ha sido modificado!";
	}

	public function eliminarEP($codigo) {
		$affected= \DB::table('estatuspago')
					  ->where('idestatuspago', '=', $codigo)
					  ->delete();

		if ($affected==1)
			echo "El registro (idestatuspago: " . $codigo . ") ha sido eliminado!";
		elseif ($affected==0)
			echo "No se pudo eliminar el registro, o bien ya fue eliminado! (Affected: " . $affected . ")";
	}

	/*
	public function borrarTodosRegEP() {
		$affected= \DB::table('estatuspago')->delete();
	}
	*/
}
