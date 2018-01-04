<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Model\PagosDoc;

class Pagos extends Model
{
    //protected $connection = '';
    protected $table = 'pagos';
    protected $idpago;
    protected $primaryKey = 'idpago';

    protected $fillable = ['idpago'];

    //protected $guarded = ['update_at','created_at'];

    // En false, no permite guardar los valores en los campos 'created_at' y 'updated_at'
    public $timestamps = false; 

    // Pruebas de creación de registros de pagos, usando transacciones
    public function crearPagos($datos) {
    
        try {

            DB::beginTransaction();

            $queryPagos = Pagos::get();
            //dump($queryPagos);

            for ($i=0; $i < 3; $i++) { 
                $pagos[$i] = new Pagos();
                $pagos[$i]->idestatuspago = $datos['idestatuspago'];
                $pagos[$i]->idempresa     = $datos['idempresa'];
                $pagos[$i]->idtransbanc   = $datos['idtransbanc'];
                $pagos[$i]->montototal    = $datos['montototal'] * ($i+1);
                $pagos[$i]->emailpagador  = $datos['emailpagador'];
                $pagos[$i]->codusuario    = 3333 + $i;                
                $pagos[$i]->save();

                if ($i == 2) {
                    throw new \PDOException("Error Lanzado de tipo PDOException", 1);
                    //throw new \Exception("Error Processing Request", 2);
                    //throw new \Illuminate\Validation\ValidationException('');
                    
                    //\App::abort(404, 'Error inesperado');
                    //\App::abort(403, 'Access denied');
                    //\App::abort(500, 'Something bad happened. Internal Server Error');
                }

                $query2Pagos = DB::table('pagos')->get();

                $nroPago = $pagos[$i]->attributes['idpago'];
                //dd($pagos[$i]->attributes['idpago'], $nroPago);

                if ($nroPago!='' || $nroPago!=null) {
                    $pagosDoc[$i] = new PagosDoc();
                    $pagosDoc[$i]->idpago = $nroPago;
                    $pagosDoc[$i]->tipodoc =  $datos['docs']['tipodoc'][$i];
                    $pagosDoc[$i]->nrodoc = $datos['docs']['nrodoc'][$i];
                    $pagosDoc[$i]->monto = $datos['docs']['monto'][$i];
                    $pagosDoc[$i]->save();
                }

            }

            DB::commit();

            return $pagos;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage(), 'tipo_error' => get_class($e)];
        }

    }

    public function infoPagos() {
        $pagos = Pagos::with('listpagosdoc')->get();

        return $pagos;
    }

    public function listpagosdoc() {
        return $this->hasMany(PagosDoc::class,'idpago','idpago');
    }
    
}