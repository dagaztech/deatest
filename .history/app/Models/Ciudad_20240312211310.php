<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $table = 'tbl_ciudades';

    protected $fillable = [
        'id_departamento'   ,     
        'nombre'        
    ];

    
}