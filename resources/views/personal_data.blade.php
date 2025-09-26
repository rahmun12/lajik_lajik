<!-- @extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h3>Formulir Pengajuan Izin</h3>

    <form action="{{ route('pengajuan.izin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        Data Diri
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Diri</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Jalan <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_jalan" class="form-control" value="{{ old('alamat_jalan') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">RT</label>
                                    <input type="text" name="rt" class="form-control" value="{{ old('rt') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">RW</label>
                                    <input type="text" name="rw" class="form-control" value="{{ old('rw') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota') }}" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                            <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}" maxlength="5" pattern="\d{5}" title="Masukkan 5 digit kode pos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. Telp/WA</label>
                            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. KK</label>
                            <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload Foto KTP <span class="text-danger">*</span></label>
                                    <input type="file" name="foto_ktp" class="form-control" required>
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload Foto KK <span class="text-danger">*</span></label>
                                    <input type="file" name="foto_kk" class="form-control" required>
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

        Data Pengajuan Izin
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Pengajuan Izin</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Jenis Izin <span class="text-danger">*</span></label>
                    <select name="jenis_izin" class="form-select" required>
                        <option value="">-- Pilih Jenis Izin --</option>
                        @foreach($jenisIzins as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_izin') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_izin }}
                            </option>
                        @endforeach
                    </select>
                </div>

                Daftar Persyaratan
                <div class="mt-4">
                    <h6>Persyaratan yang dibutuhkan:</h6>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Fotokopi KTP
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Fotokopi KK
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Surat Pengantar RT/RW
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
    });
</script>
@endpush

@endsection -->