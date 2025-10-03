@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> Terdapat kesalahan dalam inputan Anda.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(isset($penerimaanSk) && $penerimaanSk->exists)
<input type="hidden" name="_method" value="PUT">
@endif

@if(isset($personalData) && $personalData->count() > 0 && !isset($penerimaanSk))
<div class="form-group mb-3">
    <label for="personal_data_id" class="form-label">Pemohon</label>
    <select class="form-select" id="personal_data_id" name="personal_data_id" required>
        <option value="">-- Pilih Pemohon --</option>
        @foreach($personalData as $data)
        <option value="{{ $data->id }}" {{ old('personal_data_id') == $data->id ? 'selected' : '' }}>
            {{ $data->nama }} - {{ $data->nik }}
        </option>
        @endforeach
    </select>
</div>
@elseif(isset($item) && $item->penerimaanSk)
<input type="hidden" name="personal_data_id" value="{{ $item->id }}">
<div class="form-group mb-3">
    <label class="form-label">Nama Pemohon</label>
    <input type="text" class="form-control" value="{{ $item->nama }} ({{ $item->nik }})" readonly>
</div>
@endif

<div class="form-group mb-3">
    <label for="no_sk_izin" class="form-label">No. SK Izin</label>
    <input type="text" class="form-control" id="no_sk_izin" name="no_sk_izin"
        value="{{ old('no_sk_izin', $penerimaanSk->no_sk_izin ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
    <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit"
        value="{{ old('tanggal_terbit', isset($penerimaanSk->tanggal_terbit) ? \Carbon\Carbon::parse($penerimaanSk->tanggal_terbit)->format('Y-m-d') : '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="petugas_menyerahkan" class="form-label">Petugas Menyerahkan</label>
    <input type="text" class="form-control" id="petugas_menyerahkan" name="petugas_menyerahkan"
        value="{{ old('petugas_menyerahkan', $penerimaanSk->petugas_menyerahkan ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="petugas_menerima" class="form-label">Petugas Menerima</label>
    <input type="text" class="form-control" id="petugas_menerima" name="petugas_menerima"
        value="{{ old('petugas_menerima', $penerimaanSk->petugas_menerima ?? '') }}" required>
</div>

<div class="form-group text-end mt-4">
    <a href="{{ route('admin.penerimaan-sk.index') }}" class="btn btn-secondary me-2">Batal</a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> Simpan
    </button>
</div>