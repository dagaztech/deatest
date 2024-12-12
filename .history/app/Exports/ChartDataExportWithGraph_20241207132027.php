<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Charts\ChartBuilder;

class ChartDataExportWithGraph implements FromArray, WithTitle, WithCharts
{
protected $title;
protected $data;
protected $chart;

public function __construct($title, $data, $chart)
{
$this->title = $title;
$this->data = $data;
$this->chart = $chart;
}

// Exportar los datos como un arreglo
public function array(): array
{
return $this->data;
}

// Definir el título de la hoja
public function title(): string
{
return $this->title;
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