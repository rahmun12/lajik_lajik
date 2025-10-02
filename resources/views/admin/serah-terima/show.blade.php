@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Serah Terima</h1>
    <div>
        <a href="{{ route('admin.serah-terima.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <form action="{{ route('admin.serah-terima.destroy', $serahTerima->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i> Hapus
            </button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Serah Terima</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Pemohon</th>
                        <td>{{ $serahTerima->personalData->nama ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Izin</th>
                        <td>{{ $serahTerima->jenisIzin->nama_izin ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Petugas Menyerahkan</th>
                        <td>{{ $serahTerima->petugas_menyerahkan }}</td>
                    </tr>
                    <tr>
                        <th>Petugas Menerima</th>
                        <td>{{ $serahTerima->petugas_menerima }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Serah Terima</th>
                        <td>{{ $serahTerima->waktu_serah_terima->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $serahTerima->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $serahTerima->updated_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Foto Berkas</h5>
            </div>
            <div class="card-body text-center">
                @if($serahTerima->foto_berkas)
                    <img src="{{ asset('storage/' . $serahTerima->foto_berkas) }}" 
                         alt="Foto Berkas" 
                         class="img-fluid img-thumbnail mb-3"
                         style="max-height: 400px;">
                    <div>
                        <a href="{{ asset('storage/' . $serahTerima->foto_berkas) }}" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-expand me-1"></i> Lihat Ukuran Penuh
                        </a>
                    </div>
                @else
                    <div class="text-muted py-4">
                        <i class="fas fa-image fa-4x mb-3"></i>
                        <p class="mb-0">Tidak ada foto berkas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.serah-terima.edit', $serahTerima->id) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-1"></i> Edit
    </a>
    <a href="{{ route('admin.serah-terima.index') }}" class="btn btn-secondary">
        <i class="fas fa-list me-1"></i> Daftar Serah Terima
    </a>
</div>
@endsection
