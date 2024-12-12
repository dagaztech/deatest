<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    // Método para cargar la vista
    public function mostrarGraficas()
    {
        return view('user-administrador.graficasbi');
    }

    // Método para obtener los datos dinámicamente
    public function obtenerDatos()
    {
        $url = "https://dea.wearesmart.co/form-values/7/download";

        // Intentar obtener los datos desde la API
        $response = Http::get($url);

        if (!$response->ok()) {
            return response()->json(['error' => 'No se pudo obtener los datos desde la API.'], 500);
        }

        $data = $response->json();
        if (!is_array($data) || empty($data)) {
            return response()->json(['error' => 'Los datos obtenidos no son válidos o están vacíos.'], 500);
        }

        // Procesar los datos
        $procesado = $this->analizarDatos($data);
        return response()->json($procesado);
    }

    private function analizarDatos($data)
    {
        if (empty($data)) {
            return ['totales' => [], 'otra_estadistica' => []];
        }

        try {
            $totales = array_count_values(array_column($data, 'columna_interes') ?? []);
            $promedio = collect($data)->avg('otra_columna') ?? 0;

            return [
                'totales' => $totales,
                'otra_estadistica' => ['promedio' => $promedio],
            ];
        } catch (\Exception $e) {
            return ['totales' => [], 'otra_estadistica' => [], 'error' => $e->getMessage()];
        }
    }
}