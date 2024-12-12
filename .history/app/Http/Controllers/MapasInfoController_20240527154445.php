<?php

namespace App\Http\Controllers;

use App\Models\Mapa;
use Illuminate\Http\Request;

class MapasInfoController extends Controller
{
    public function index()
    {
        // Obtener los datos del form ID=12 ordenados por fecha
        $datos = Mapa::where('form_id', 12)->orderBy('created_at', 'desc')->get(['id', 'Coordenada: Longitud', 'Coordenada: Latitud', 'created_at']);

        return view('mapa.index', compact('datos'));
    }
}