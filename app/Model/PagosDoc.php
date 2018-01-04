<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PagosDoc extends Model
{
    //protected $connection = '';
    protected $table = 'pagos_doc';
    protected $id;
    protected $primaryKey = 'id';
    protected $idpago;

    protected $fillable = ['id','idpago'];

    //protected $guarded = ['update_at','created_at'];

    // En false, no permite guardar los valores en los campos 'created_at' y 'updated_at'
    public $timestamps = false; 
    
}