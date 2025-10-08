@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Penyerahan SK Izin</h1>
        <a href="{{ route('admin.penerimaan-sk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar Penerimaan SK
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(!isset($penerimaanSk))
        <div class="alert alert-danger">
            Data penerimaan SK tidak ditemukan.
        </div>
    @else
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penyerahan SK</h6>
        </div>
        <div class="card-body">
            <form id="penyerahanSkForm" action="{{ route('admin.penyerahan-sk.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="penerimaan_sk_id" value="{{ $penerimaanSk->id }}">
                <input type="hidden" name="personal_data_id" value="{{ $penerimaanSk->personal_data_id }}">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                        <input type="text" 
                               id="nama_pemohon"
                               class="form-control" 
                               value="{{ $penerimaanSk->personalData->nama }}" 
                               readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_izin" class="form-label">Jenis Izin</label>
                        <input type="text" 
                               id="jenis_izin"
                               class="form-control" 
                               value="{{ $penerimaanSk->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'Tidak ada data' }}" 
                               readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_sk_izin" class="form-label">No. SK Izin</label>
                        <input type="text" 
                               id="no_sk_izin"
                               class="form-control" 
                               name="no_sk_izin" 
                               value="{{ $penerimaanSk->no_sk_izin ?? '' }}"
                               required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit SK</label>
                        <input type="date" 
                               id="tanggal_terbit"
                               class="form-control" 
                               name="tanggal_terbit" 
                               value="{{ old('tanggal_terbit', now()->format('Y-m-d')) }}"
                               required
                               oninvalid="this.setCustomValidity('Mohon isi tanggal terbit SK')"
                               oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="petugas_menyerahkan" class="form-label">Petugas yang Menyerahkan</label>
                        <input type="text" 
                               id="petugas_menyerahkan"
                               class="form-control" 
                               name="petugas_menyerahkan" 
                               value="{{ Auth::user()->name }}"
                               required>
                    </div>
                    <div class="col-md-6">
                        <label for="pemohon_menerima" class="form-label">Nama Penerima</label>
                        <input type="text" 
                               id="pemohon_menerima"
                               class="form-control" 
                               name="pemohon_menerima" 
                               value="{{ old('pemohon_menerima', $penerimaanSk->personalData->nama) }}"
                               required
                               oninvalid="this.setCustomValidity('Mohon isi nama penerima')"
                               oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_penyerahan" class="form-label">Tanggal Penyerahan</label>
                        <input type="date" 
                               id="tanggal_penyerahan"
                               class="form-control" 
                               name="tanggal_penyerahan" 
                               value="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>
                    <div class="col-md-6">
                        <label for="foto_penyerahan" class="form-label">Foto Penyerahan</label>
                        <input type="file" 
                               id="foto_penyerahan"
                               class="form-control" 
                               name="foto_penyerahan" 
                               accept="image/*" 
                               required>
                        <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Pastikan semua data sudah benar sebelum menyimpan. Data yang sudah disimpan tidak dapat diubah.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('admin.penerimaan-sk.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data Penyerahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('penyerahanSkForm');
        
        form.addEventListener('submit', function(event) {
            // Validasi client-side sebelum submit
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.reportValidity();
                    isValid = false;
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            
            // Tampilkan loading indicator
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            }
            
            return true;
        });
    });
</script>
@endpush

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