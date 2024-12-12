<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    public function mostrarGraficas()
    {
        $url = "https://dea.wearesmart.co/form-values/7/download";

        // Configurar encabezados y desactivar redirecciones
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'LaravelApp/1.0',
        ])->withoutRedirecting()->get($url);

        // Verificar si la API responde correctamente
        if (!$response->ok()) {
            return back()->withErrors(['error' => 'No se pudo obtener los datos desde la API.']);
        }

        $data = $response->json();
        if (!is_array($data) || empty($data)) {
            return back()->withErrors(['error' => 'Los datos obtenidos no son válidos o están vacíos.']);
        }

        $procesado = $this->analizarDatos($data);

        return view('user-administrador.graficasbi', compact('procesado'));
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