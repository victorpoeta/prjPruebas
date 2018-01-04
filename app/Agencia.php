<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    
    protected $table = 'agencia';
    protected $primaryKey = 'codagencia';

    public $timestamps = false; 
    
}
