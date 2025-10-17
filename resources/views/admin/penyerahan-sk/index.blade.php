@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penyerahan SK Izin</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.penyerahan-sk.export') }}" class="btn btn-success btn-sm ms-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
</div>


<div class="card shadow-sm border-0">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th width="15%">Nama Pemohon</th>
                        <th width="15%">Jenis Izin</th>
                        <th width="15%" class="text-center">No. SK Izin</th>
                        <th width="12%" class="text-center">Tanggal Terbit</th>
                        <th width="12%" class="text-center">Tanggal Penyerahan</th>
                        <th width="15%">Petugas Menyerahkan</th>
                        <th width="15%">Pemohon Menerima</th>
                        <th width="10%" class="text-center">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->personalData->nama ?? 'N/A' }}</td>
                        <td>{{ $item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A' }}</td>
                        <td>{{ $item->no_sk_izin ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_terbit)->format('d/m/Y') }}</td>
                        <td>
                            @if(!empty($item->tanggal_penyerahan))
                                {{ \Carbon\Carbon::parse($item->tanggal_penyerahan)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->petugas_menyerahkan }}</td>
                        <td>{{ $item->pemohon_menerima }}</td>
                        <td class="text-center">
                            @if($item->foto_penyerahan)
                                <a href="{{ asset('storage/' . $item->foto_penyerahan) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p class="mb-0">Tidak ada data penyerahan SK</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        margin: 1.5rem auto;
        max-width: 99%;
        width: 100%;
    }

    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #fff;
        background-color: #212529;
        border: none;
        padding: 10px 12px;
        white-space: nowrap;
        vertical-align: middle;
        height: 46px;
    }

    .table td {
        padding: 10px 12px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        font-size: 0.9rem;
        color: #333;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .empty-state {
        padding: 2rem 0;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>
@endpush
