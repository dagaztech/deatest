<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    public function mostrarGraficas()
    {
        $url = "https://dea.wearesmart.co/form-values/7/download";
        $response = Http::get($url);
    
        if ($response->ok()) {
            $data = $response->json(); // Verifica si el formato es JSON válido
            if (!is_array($data) || empty($data)) {
                return back()->withErrors(['error' => 'Los datos obtenidos no son válidos o están vacíos.']);
            }
        } else {
            return back()->withErrors(['error' => 'No se pudo obtener los datos.']);
        }
    
        $procesado = $this->analizarDatos($data);
        return view('user-administrador.graficasbi', compact('procesado'));
    }
    

    private function analizarDatos($data)
{
    if (empty($data)) {
        return [
            'totales' => [],
            'otra_estadistica' => [],
        ];
    }

    // Asegúrate de que las claves existen antes de usarlas
    $totales = array_count_values(array_column($data, 'columna_interes') ?? []);
    $promedio = collect($data)->avg('otra_columna') ?? 0;

    return [
        'totales' => $totales,
        'otra_estadistica' => [
            'promedio' => $promedio,
        ],
    ];
}

} 