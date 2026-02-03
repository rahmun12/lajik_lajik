<?php

namespace App\Exports;

use App\Models\PenyerahanSk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class RekapitulasiPenyerahanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return PenyerahanSk::with(['personalData', 'personalData.izinPengajuan.jenisIzin'])
            ->latest('tanggal_penyerahan')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['Rekapitulasi Penyerahan SK Perizinan Layanan Khusus'],
            [
                'No',
                'Tanggal Penyerahan',
                'Nama Pemohon',
                'Alamat',
                'No. SK Izin',
                'Petugas Lajik',
            ]
        ];
    }

    public function map($item): array
    {
        static $i = 1;
        
        // Build full address from components
        $alamat = [
            $item->personalData->alamat_jalan ?? '',
            $item->personalData->rt ? 'RT ' . $item->personalData->rt : '',
            $item->personalData->rw ? 'RW ' . $item->personalData->rw : '',
            $item->personalData->kelurahan ?? '',
            $item->personalData->kecamatan ?? '',
            $item->personalData->kode_pos ?? ''
        ];
        $alamat_lengkap = implode(', ', array_filter($alamat));
        
        return [
            $i++,
            $item->tanggal_penyerahan ? \Carbon\Carbon::parse($item->tanggal_penyerahan)->format('d/m/Y') : '-',
            $item->personalData->nama ?? 'N/A',
            $alamat_lengkap ?: 'N/A',
            $item->no_sk_izin ?? 'N/A',
            $item->petugas_menyerahkan ?? 'N/A',
        ];
    }

    public function title(): string
    {
        return 'Rekap Penyerahan';
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for title
        $sheet->mergeCells('A1:F1');

        return [
            // Style the title row
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            // Style the header row
            2 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9EAD3']
                ]
            ],
        ];
    }
}