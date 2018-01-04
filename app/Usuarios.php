<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    //
    protected $table = 'usuario';
    protected $primaryKey = 'codusuario';

    //protected $fillable = ['id_usuario','login','clave'];

    //protected $guarded = ['update_at','created_at'];

    // En false, no permite guardar los valores en los campos 'created_at' y 'updated_at'
    public $timestamps = false; 
    
}
