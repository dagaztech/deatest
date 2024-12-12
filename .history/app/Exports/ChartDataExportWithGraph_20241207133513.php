<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCharts; // Si necesitas exportar gráficos también

class ChartDataExportWithGraph implements FromArray, WithTitle, WithCharts
{
    protected $formName; // Nombre del formulario (para usarlo como título de la hoja)
    protected $data; // Datos a exportar (meses y registros)
    protected $chartData; // Datos del gráfico (tipo, labels, data)

    // Constructor que recibe el nombre del formulario, los datos y los datos del gráfico
    public function __construct($formName, $data, $chartData)
    {
        $this->formName = $formName;
        $this->data = $data;
        $this->chartData = $chartData;
    }

    // Método que retorna los datos a exportar
    public function array(): array
    {
        return $this->data;
    }

    // Método que retorna el nombre de la hoja (usamos el nombre del formulario)
    public function title(): string
    {
        return $this->formName; // Nombre de la hoja será el nombre del formulario
    }

// Crear el gráfico
public function charts()
{
$chartBuilder = new ChartBuilder();
return $chartBuilder->createChart(
$this->chart['type'], // Tipo de gráfico
$this->chart['labels'], // Etiquetas (ej. Meses)
$this->chart['data'] // Datos (ej. Registros)
);
}
}