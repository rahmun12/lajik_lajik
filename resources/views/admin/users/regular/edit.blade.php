@extends('admin.layouts.sidebar')

@section('title', 'Edit Data Penerimaan SK')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Data Penerimaan SK</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.regular.update', $penerimaanSk->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Pemohon</label>
                <input type="text" class="form-control mb-2" value="{{ $penerimaanSk->personalData->nama ?? 'N/A' }}" readonly>
                
                <label class="form-label">Alamat</label>
                <input type="text" class="form-control" 
                       value="{{ $penerimaanSk->personalData->alamat_jalan ?? 'N/A' }}, RT {{ $penerimaanSk->personalData->rt ?? '' }}/RW {{ $penerimaanSk->personalData->rw ?? '' }}, {{ $penerimaanSk->personalData->kelurahan ?? '' }}, {{ $penerimaanSk->personalData->kecamatan ?? '' }}" 
                       readonly>
                
                <input type="hidden" name="personal_data_id" value="{{ $penerimaanSk->personal_data_id }}">
            </div>
            
            <div class="mb-3">
                <label for="no_sk_izin" class="form-label">No. SK Izin</label>
                <input type="text" class="form-control @error('no_sk_izin') is-invalid @enderror" 
                       id="no_sk_izin" name="no_sk_izin" 
                       value="{{ old('no_sk_izin', $penerimaanSk->no_sk_izin) }}" required>
                @error('no_sk_izin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            
            
            <div class="mb-3">
                <label for="petugas_menyerahkan" class="form-label">Petugas Menyerahkan</label>
                <input type="text" class="form-control @error('petugas_menyerahkan') is-invalid @enderror" 
                       id="petugas_menyerahkan" name="petugas_menyerahkan" 
                       value="{{ old('petugas_menyerahkan', $penerimaanSk->petugas_menyerahkan) }}" required>
                @error('petugas_menyerahkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="petugas_menerima" class="form-label">Petugas Menerima</label>
                <input type="text" class="form-control @error('petugas_menerima') is-invalid @enderror" 
                       id="petugas_menerima" name="petugas_menerima" 
                       value="{{ old('petugas_menerima', $penerimaanSk->petugas_menerima) }}" required>
                @error('petugas_menerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.regular.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
