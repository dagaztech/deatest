<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    public function mostrarGraficas()
    {
        $url = "https://dea.wearesmart.co/form-values/7/download";
        $response = Http::get($url);

        if (!$response->ok()) {
            return back()->withErrors(['error' => 'No se pudo obtener los datos desde la API.']);
        }

        $data = $response->json(); // Asegúrate de que la respuesta es JSON
        if (!is_array($data) || empty($data)) {
            return back()->withErrors(['error' => 'Los datos obtenidos no son válidos o están vacíos.']);
        }

        $procesado = $this->analizarDatos($data);

        // Verifica que el análisis es válido
        if (empty($procesado['totales'])) {
            return back()->withErrors(['error' => 'No se pudieron procesar los datos.']);
        }

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

        try {
            // Asegúrate de que las claves existen antes de usarlas
            $totales = array_count_values(array_column($data, 'columna_interes') ?? []);
            $promedio = collect($data)->avg('otra_columna') ?? 0;

            return [
                'totales' => $totales,
                'otra_estadistica' => [
                    'promedio' => $promedio,
                ],
            ];
        } catch (\Exception $e) {
            // Captura errores durante el procesamiento
            return [
                'totales' => [],
                'otra_estadistica' => [],
                'error' => $e->getMessage(),
            ];
        }
    }
}