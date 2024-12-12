<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ChartDataExportWithGraph implements FromArray, WithDrawings, WithTitle
{
    protected $data;
    protected $chartImage;

    public function __construct($data, $chartImage)
    {
        $this->data = $data;
        $this->chartImage = $chartImage;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function drawings()
    {
        if ($this->chartImage) {
            $drawing = new Drawing();
            $drawing->setName('Chart Image');
            $drawing->setDescription('Chart Image');
            $drawing->setPath($this->chartImage);
            $drawing->setHeight(300);

            return [$drawing];
        }

        return [];
    }

    public function title(): string
    {
        return 'Datos y Gráfico';
    }

    
}