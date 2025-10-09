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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Izin</th>
                        <th>No. SK Izin</th>
                        <th>Tanggal</th>
                        <th>Petugas Menyerahkan</th>
                        <th>Pemohon Menerima</th>
                        <th>Foto</th>
                        
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
                        <td colspan="9" class="text-center">Tidak ada data penyerahan SK</td>
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
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    .btn i {
        margin-right: 0.25rem;
    }
</style>
@endpush
