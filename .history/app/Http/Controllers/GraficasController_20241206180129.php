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
        $url = "https://dea.wearesmart.co/form-values/7/view";
    
        try {
            $response = Http::get($url);
    
            if (!$response->ok()) {
                \Log::error('Error al obtener datos de la API externa: ' . $response->status());
                return response()->json(['error' => 'No se pudo obtener los datos desde la API externa.'], 500);
            }
    
            $data = $response->json();
    
            if (!is_array($data) || empty($data)) {
                \Log::error('Datos inválidos o vacíos desde la API externa.');
                return response()->json(['error' => 'Los datos obtenidos no son válidos o están vacíos.'], 500);
            }
    
            // Procesar los datos
            $procesado = $this->analizarDatos($data);
    
            return response()->json($procesado);
    
        } catch (\Exception $e) {
            \Log::error('Excepción al obtener datos: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al procesar la solicitud.'], 500);
        }
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