<?php
/************************************************/
/*	Creado por Víctor Poeta
/*	Fecha: 30/06/2016
/*  Clase: EstatusPagoDAL.php
/************************************************/

namespace App\Wscanguroazul\Dal\Wspagos;

//use DB;
use Illuminate\Database\Eloquent\Model;
use App\Wscanguroazul\Model\Wspagos\EstatusPago;

class EstatusPagoDAL extends Model
{
    // Consulta a la tabla estatuspago, ya sea única (por el campo 'idestatuspago') o todos los registros
    public function getInfoEstatusPago($codigo) {
    	if (!empty($codigo)) {
            $pgSQL=EstatusPago::where('idestatuspago','=', $codigo)->get(); 
    	} else {
            $pgSQL=EstatusPago::get(); // Obtiene todos los registros (Usando Eloquent)
    	}
    	return $pgSQL;
    }

    public function createEstatusPago() {
        
    }

}
