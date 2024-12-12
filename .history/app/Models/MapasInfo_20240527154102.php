<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapasInfo extends Model
{
    use HasFactory;

    protected $table = 'tb_mapas';
    public $timestamps = false; // Asumiendo que no hay columnas created_at y updated_at

    protected $fillable = [
        'id',
        'Coordenada: Longitud',
        'Coordenada: Latitud',
        'created_at', // Asegúrate de tener una columna de fecha en tu tabla para ordenar
    ];
}