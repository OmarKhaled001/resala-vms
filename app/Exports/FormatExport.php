<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{

    protected $mainHeaders;
    protected $data;

    public function __construct(array $mainHeaders, array $data)
    {
        $this->mainHeaders = $mainHeaders;
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            $this->mainHeaders,
        ];
    }

    public function array(): array
    {
        return $this->data; 
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setRightToLeft(true);
        $lastColumn = chr(64 + count($this->mainHeaders));

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Cairo',
                'color' => ['rgb' => 'ffffff'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '1f497d',
                ],
            ],
        ]);

        $sheet->getStyle("A1:{$lastColumn}" . (count($this->data) + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], 
                  
                ],
            ],
            'font' => [
                'size' => 9,
                'name' => 'Cairo',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return $sheet;
    }
  
}
