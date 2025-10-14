@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penyerahan SK Izin</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
                        <th width="12%" class="text-center">Tanggal</th>
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
                        <td>{{ $item->petugas_menyerahkan }}</td>
                        <td>{{ $item->pemohon_menerima }}</td>
                        <td>
                            @if($item->foto_penyerahan)
                                <a href="{{ asset('storage/' . $item->foto_penyerahan) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <!-- <td>
                            <a href="{{ route('admin.penyerahan-sk.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.penyerahan-sk.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td> -->
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
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
    /* Table Styling */
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        margin: 1.5rem auto;
        max-width: 99%;
        width: 100%;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table {
        margin-bottom: 0;
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
        line-height: 1.4;
        color: #333;
    }

    .table tbody tr {
        transition: background-color 0.15s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table > :not(:first-child) {
        border-top: none;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-buttons .btn {
        padding: 4px 8px;
        font-size: 0.8rem;
    }

    /* Button Styles */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        line-height: 1.5;
        border-radius: 0.25rem;
    }

    .btn i {
        margin-right: 0.25rem;
    }

    /* Empty State */
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

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table {
            font-size: 0.85rem;
        }
        
        .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
</style>
@endpush
