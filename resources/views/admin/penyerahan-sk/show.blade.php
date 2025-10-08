@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Penyerahan SK Izin</h1>
        <a href="{{ route('admin.penyerahan-sk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pemohon</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $item->personalData->nama ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Izin</th>
                            <td>{{ $item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>No. SK Izin</th>
                            <td>{{ $item->no_sk_izin ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        @if($item->foto_penyerahan)
                            <img src="{{ asset('storage/' . $item->foto_penyerahan) }}" alt="Foto Penyerahan" class="img-fluid" style="max-height: 200px;">
                            <p class="mt-2">Foto Penyerahan</p>
                        @else
                            <div class="text-muted">
                                <i class="fas fa-image fa-4x mb-2"></i>
                                <p>Tidak ada foto penyerahan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Penyerahan</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Tanggal Penyerahan</th>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <th>Petugas Menyerahkan</th>
                            <td>{{ $item->petugas_menyerahkan }}</td>
                        </tr>
                        <tr>
                            <th>Pemohon Menerima</th>
                            <td>{{ $item->pemohon_menerima }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $item->created_at->isoFormat('dddd, D MMMM Y HH:mm:ss') }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui Pada</th>
                            <td>{{ $item->updated_at->isoFormat('dddd, D MMMM Y HH:mm:ss') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.penyerahan-sk.edit', $item->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.penyerahan-sk.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        width: 40%;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush
