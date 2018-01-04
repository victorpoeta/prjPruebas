<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'usuario';
    protected $primaryKey = 'codusuario';
    protected $codusuario;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   /* protected $fillable = [
        'name', 'email', 'password',
    ];*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
/*    protected $hidden = [
        'password', 'remember_token',
    ];*/

}
