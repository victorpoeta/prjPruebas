<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estatus_pago extends Model
{
    
    protected $table = 'estatuspago';
    protected $primaryKey = 'idestatuspago';

    /* Cuando el valor es false, no se actualizan los valores en los 
       campos: created_at y updated_at (en caso que existan) */
    public $timestamps = false; 
    
}
