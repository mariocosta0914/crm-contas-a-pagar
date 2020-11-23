<?php

namespace App\Exports;

use App\Relatorios as AppRelatorios;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Relatorios implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $params = [];

    public function __construct($data_inicial, $data_final, $dados, $headings)
    {
        $this->data_inicial = $data_inicial;
        $this->data_final = $data_final;
        $this->dados = $dados;
        $this->headings = $headings;
    }

    public function collection()
    {
        return AppRelatorios::getRelatorio($this->data_inicial, $this->data_final, $this->dados);
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
