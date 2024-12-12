<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    public function mostrarGraficas()
    {
        // Obtener datos desde el enlace
        $url = "https://dea.wearesmart.co/form-values/7/download";
        $response = Http::get($url);

        if ($response->ok()) {
            $data = $response->json(); // Si el archivo es JSON
            // $data = array_map('str_getcsv', explode("\n", $response->body())); // Si es CSV
        } else {
            return back()->withErrors(['error' => 'No se pudo obtener los datos']);
        }

        // Analizar y preparar datos
        $procesado = $this->analizarDatos($data);

        // Retornar la vista con los datos procesados
        return view('graficasbi', compact('procesado'));
    }

    private function analizarDatos($data)
    {
        // Analiza y prepara los datos para cada gráfica
        $analisis = [
            'totales' => array_count_values(array_column($data, 'columna_interes')),
            'otra_estadistica' => [
                'promedio' => collect($data)->avg('otra_columna'),
            ],
        ];
        return $analisis;
    }
}