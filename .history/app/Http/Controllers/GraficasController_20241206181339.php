<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client; // Librería Goutte

class GraficasController extends Controller
{
    // Método para mostrar la vista
    public function mostrarGraficas()
    {
        return view('user-administrador.graficasbi');
    }

    // Método para obtener datos de la tabla HTML
    public function obtenerDatosDesdeTabla(Request $request)
    {
        $url = $request->query('url', 'https://dea.wearesmart.co/form-values/7/view');

        try {
            // Crear cliente Goutte para scraping
            $client = new Client();
            $crawler = $client->request('GET', $url);

            // Buscar la tabla por ID
            $tabla = $crawler->filter('#forms-table');

            if ($tabla->count() === 0) {
                return response()->json(['error' => 'No se encontró una tabla con el ID especificado.'], 404);
            }

            // Extraer datos de la tabla
            $datos = $tabla->filter('tr')->each(function ($fila, $indice) {
                // Ignorar la última columna de cada fila
                $columnas = $fila->filter('td')->each(function ($columna, $index) {
                    return $columna->text();
                });

                // Eliminar última columna si existen más de una
                array_pop($columnas);
                return $columnas;
            });

            // Ignorar el encabezado
            $encabezados = $datos[0] ?? [];
            array_shift($datos);

            // Procesar los datos para las gráficas
            $procesado = $this->procesarDatos($datos, $encabezados);

            return response()->json($procesado);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al procesar la tabla: ' . $e->getMessage()], 500);
        }
    }

    // Método para procesar datos extraídos
    private function procesarDatos($datos, $encabezados)
    {
        $totales = [];
        $otraEstadistica = [];

        foreach ($datos as $fila) {
            foreach ($fila as $index => $valor) {
                if (!isset($totales[$encabezados[$index]])) {
                    $totales[$encabezados[$index]] = 0;
                }
                $totales[$encabezados[$index]] += is_numeric($valor) ? (int)$valor : 1;
            }
        }

        return [
            'totales' => $totales,
            'otra_estadistica' => $otraEstadistica, // Aquí puedes agregar más estadísticas
        ];
    }
}