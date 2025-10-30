@extends('admin.layouts.sidebar')

@section('title', 'Tambah Data Penerimaan SK')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Data Penerimaan SK</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.regular.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="personal_data_id" class="form-label">Nama Pemohon</label>
                <select class="form-select @error('personal_data_id') is-invalid @enderror" id="personal_data_id" name="personal_data_id" required>
                    <option value="">-- Pilih Pemohon --</option>
                    @foreach($availablePersonalData as $id => $nama)
                        <option value="{{ $id }}" {{ old('personal_data_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                @error('personal_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <div id="alamat-display" class="form-control bg-light">
                    Pilih pemohon untuk menampilkan alamat
                </div>
            </div>
            <div class="mb-3">
                <label for="no_sk_izin" class="form-label">No. SK Izin</label>
                <input type="text" class="form-control @error('no_sk_izin') is-invalid @enderror" id="no_sk_izin" name="no_sk_izin" value="{{ old('no_sk_izin') }}" required>
                @error('no_sk_izin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                <input type="date" class="form-control @error('tanggal_penerimaan') is-invalid @enderror" 
                       id="tanggal_penerimaan" name="tanggal_penerimaan" 
                       value="{{ old('tanggal_penerimaan') }}" required>
                @error('tanggal_penerimaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="petugas_menyerahkan" class="form-label">Petugas Menyerahkan</label>
                <input type="text" class="form-control @error('petugas_menyerahkan') is-invalid @enderror" id="petugas_menyerahkan" name="petugas_menyerahkan" value="{{ old('petugas_menyerahkan') }}" required>
                @error('petugas_menyerahkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="petugas_menerima" class="form-label">Petugas Menerima</label>
                <input type="text" class="form-control @error('petugas_menerima') is-invalid @enderror" id="petugas_menerima" name="petugas_menerima" value="{{ old('petugas_menerima') }}" required>
                @error('petugas_menerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.regular.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const personalDataSelect = document.getElementById('personal_data_id');
        const alamatDisplay = document.getElementById('alamat-display');
        
        // Store addresses data
        const addresses = @json($availablePersonalData->mapWithKeys(function($item) {
            $personalData = \App\Models\PersonalData::find($item['id']);
            return [
                $item['id'] => [
                    'alamat_jalan' => $personalData->alamat_jalan ?? '',
                    'rt' => $personalData->rt ?? '',
                    'rw' => $personalData->rw ?? '',
                    'kelurahan' => $personalData->kelurahan ?? '',
                    'kecamatan' => $personalData->kecamatan ?? ''
                ]
            ];
        }));

        function updateAddress() {
            const selectedId = personalDataSelect.value;
            
            if (!selectedId) {
                alamatDisplay.textContent = 'Pilih pemohon untuk menampilkan alamat';
                return;
            }
            
            const address = addresses[selectedId];
            if (!address) {
                alamatDisplay.textContent = 'Alamat tidak tersedia';
                return;
            }
            
            const alamatParts = [
                address.alamat_jalan || 'N/A',
                address.rt ? `RT ${address.rt}` : '',
                address.rw ? `RW ${address.rw}` : '',
                address.kelurahan || '',
                address.kecamatan || ''
            ].filter(Boolean);
            
            alamatDisplay.textContent = alamatParts.join(', ');
        }

        // Update on page load if there's a selected value
        updateAddress();
        
        // Update when selection changes
        personalDataSelect.addEventListener('change', updateAddress);
    });
</script>
@endpush

@endsection
