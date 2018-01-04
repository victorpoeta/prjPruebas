<?php

namespace App\Wscanguroazul\Model\Wspagos;

use Illuminate\Database\Eloquent\Model;

class EstatusPago extends Model
{
    protected $table = 'estatuspago'; // Nombre de la tabla
    protected $idestatuspago;
    protected $primaryKey = 'idestatuspago'; // Campo de clave primaria
    protected $nombre;
    
    protected $fillable = ['idestatuspago','nombre'];|

    /* Cuando el valor es false, NO se actualizan los valores en los 
       campos: 'created_at' y 'updated_at' (en caso que existan) */
    public $timestamps = false; 
    
    /* protected $hidden = array('remember_token','deleted_at','created_at','updated_at'); */
    
}
