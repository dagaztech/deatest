<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ChartDataExport implements FromArray
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
}