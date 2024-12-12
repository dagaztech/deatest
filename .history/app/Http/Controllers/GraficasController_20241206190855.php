<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficasController extends Controller
{
    public function mostrarGraficas(Request $request)
    {
        // Si hay una URL, procesarla; de lo contrario, usar una predeterminada
        $url = $request->query('url', 'https://dea.wearesmart.co/form-values/7/view');

        // Obtener datos de la tabla
        $datos = $this->extraerDatosDesdeTabla($url);

        // Si hay error, devolver vista con un mensaje
        if (isset($datos['error'])) {
            return view('user-administrador.graficasbi', [
                'error' => $datos['error'],
                'datos' => null,
            ]);
        }

        return view('user-administrador.graficasbi', [
            'error' => null,
            'datos' => $datos,
        ]);
    }

    private function extraerDatosDesdeTabla($url)
{
    try {
        // Usar file_get_contents para obtener el HTML
        $html = file_get_contents($url);

        if ($html === false) {
            return ['error' => 'No se pudo obtener el contenido de la URL.'];
        }

        // Cargar el HTML en DomDocument
        $dom = new \DomDocument();
        libxml_use_internal_errors(true); // Ignorar errores de HTML mal formado
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Usar XPath para encontrar la tabla con la clase .table-responsive.py-4.submitformtable table
        $xpath = new \DomXPath($dom);
        $tabla = $xpath->query('//div[contains(@class, "table-responsive")]//table');

        if ($tabla->length === 0) {
            return ['error' => 'No se encontró una tabla con la clase especificada.'];
        }

        // Extraer filas de la tabla
        $filas = $tabla->item(0)->getElementsByTagName('tr');
        $encabezados = [];
        $datos = [];

        foreach ($filas as $index => $fila) {
            $columnas = $fila->getElementsByTagName('td');
            if ($columnas->length === 0) { // Saltar encabezados
                $encabezados = array_map(
                    fn($th) => trim($th->nodeValue),
                    iterator_to_array($fila->getElementsByTagName('th'))
                );
                continue;
            }

            $filaData = [];
            foreach ($columnas as $i => $columna) {
                if ($i < $columnas->length - 1) { // Ignorar última columna
                    $filaData[] = trim($columna->nodeValue);
                }
            }

            $datos[] = $filaData;
        }

        return $this->procesarDatos($datos, $encabezados);

    } catch (\Exception $e) {
        return ['error' => 'Error al procesar la tabla: ' . $e->getMessage()];
    }
}


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
            'otra_estadistica' => $otraEstadistica,
        ];
    }
}