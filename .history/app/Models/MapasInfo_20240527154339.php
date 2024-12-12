<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use DB;

class MapasInfo extends Model
{
    use HasFactory;

    protected $table = 'tbl_form_values';
    public $timestamps = false; // Asumiendo que no hay columnas created_at y updated_at

    protected $fillable = [
        'id',
        'Coordenada: Longitud',
        'Coordenada: Latitud',
        'created_at', // Asegúrate de tener una columna de fecha en tu tabla para ordenar
    ];
}