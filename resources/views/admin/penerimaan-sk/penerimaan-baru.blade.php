@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penerimaan SK Izin Baru</h1>
        <a href="{{ route('admin.penerimaan-sk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penerimaan SK</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.penerimaan-sk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pemohon</label>
                        <input type="text" class="form-control" name="nama_pemohon" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Izin</label>
                        <select class="form-control" name="jenis_izin" required>
                            <option value="">Pilih Jenis Izin</option>
                            @foreach($jenisIzin as $izin)
                                <option value="{{ $izin->id }}">{{ $izin->nama_izin }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. SK Izin</label>
                        <input type="text" class="form-control" name="no_sk_izin" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hari, Tanggal</label>
                        <input type="text" class="form-control" value="{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}" readonly>
                        <input type="hidden" name="tanggal_terbit" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Petugas yang Menyerahkan</label>
                        <input type="text" class="form-control" name="petugas_menyerahkan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pemohon yang Menerima</label>
                        <input type="text" class="form-control" name="pemohon_menerima" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Upload Foto</label>
                        <input type="file" class="form-control" name="foto_penerimaan" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
    }
    .btn i {
        margin-right: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const fileInput = document.querySelector('input[type="file"]');
        const fileSize = fileInput.files[0] ? fileInput.files[0].size / 1024 / 1024 : 0; // in MB
        
        if (fileSize > 2) {
            e.preventDefault();
            alert('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
            return false;
        }
        
        // Validasi lainnya bisa ditambahkan di sini
        return true;
    });
</script>
@endpush
