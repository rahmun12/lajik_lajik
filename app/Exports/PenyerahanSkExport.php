<?php

namespace App\Exports;

use App\Models\PenyerahanSk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenyerahanSkExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return PenyerahanSk::with('personalData.izinPengajuan.jenisIzin')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pemohon',
            'Jenis Izin',
            'No. SK Izin',
            'Tanggal Terbit',
            'Tanggal Penyerahan',
            'Petugas Menyerahkan',
            'Pemohon Menerima',
            'Status',
            'Keterangan'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->personalData->nama ?? 'N/A',
            $row->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A',
            $row->no_sk_izin,
            $row->tanggal_terbit ? \Carbon\Carbon::parse($row->tanggal_terbit)->format('d/m/Y') : '-',
            $row->tanggal_penyerahan ? \Carbon\Carbon::parse($row->tanggal_penyerahan)->format('d/m/Y') : '-',
            $row->petugas_menyerahkan,
            $row->pemohon_menerima,
            $row->status,
            $row->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9EAD3']
                ]
            ],
            // Set border for all cells
            'A1:J' . ($this->collection()->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
