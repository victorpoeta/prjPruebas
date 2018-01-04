<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $connection = "prueba";
    protected $table = 'sessions';
    protected $login;

    protected $fillable = ['user_id', 'login'];

    //protected $guarded = ['update_at','created_at'];

    // En false, no permite guardar los valores en los campos 'created_at' y 'updated_at'
    public $timestamps = false; 

    // Accesor que retorna el atributo id como string
    public function getIdAttribute($value) {
    	return (string) $value;
    }

    // Accesor que retorna el atributo id como string
/*    public function getIdAttribute($value) {
        return (string) $value;
    }*/

/*    // Accesor que retorna el atributo login como string
    public function getLoginAttribute($value) {
        return (string) $value;
    }*/
}
