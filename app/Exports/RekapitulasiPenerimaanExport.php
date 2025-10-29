<?php

namespace App\Exports;

use App\Models\PenyerahanSk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
            'No',
            'Tanggal Penyerahan',
            'Nama Pemohon',
            'Alamat',
            'No. SK Izin',
            'Petugas Lajik',
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
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9EAD3']
                ]
            ],
        ];
    }
}