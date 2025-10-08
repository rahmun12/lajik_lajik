@extends('layouts.app')

@section('content')
<div class="min-vh-100 py-5" style="background-color:#ffffff;">
    <div class="container">

    {{-- Alert sukses (akan diubah jadi popup SweetAlert, jadi ini disembunyikan) --}}
@if(session('success'))
    <div id="success-message" 
         data-success="{{ session('success') }}"
         @if(session('message')) data-detail="{{ session('message') }}" @endif>
    </div>
@endif

{{-- Alert error --}}
@if($errors->any())
<div class="alert alert-danger border-0 shadow-sm rounded-3 px-4 py-3 mb-4" 
     style="background-color:#fdecea; color:#1f1f1f; font-size:1.1rem;">
    <ul class="mb-0 small">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        {{-- Header --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2" style="color:#36393a; font-size:2rem;">Formulir Pengajuan Izin</h2>
            <p class="mb-0" style="color:#7a7a7a; font-size:1.1rem;">Silakan isi data di bawah ini dengan lengkap dan benar</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('pengajuan.izin.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto bg-white shadow-sm p-5 rounded-4" style="max-width:950px; border:1px solid #e0e0e0;">
            @csrf

            {{-- Section Judul --}}
            <h4 class="fw-semibold mb-4 pb-2 border-bottom" style="color:#36393a; border-color:#7a7a7a;">Data Diri</h4>

            {{-- Data Diri --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-lg" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Jalan <span class="text-danger">*</span></label>
                        <input type="text" name="alamat_jalan" class="form-control form-control-lg" value="{{ old('alamat_jalan') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">RT</label>
                            <input type="text" name="rt" class="form-control form-control-lg" value="{{ old('rt') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">RW</label>
                            <input type="text" name="rw" class="form-control form-control-lg" value="{{ old('rw') }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <select name="kabupaten_kota" id="kabupaten" class="form-select form-select-lg" required>
                            <option value="" disabled selected hidden>Pilih Kabupaten/Kota</option>
                            @foreach([["id" => "3519", "name" => "KABUPATEN MAGETAN"]] as $kabupaten)
                                <option value="{{ $kabupaten['id'] }}" {{ old('kabupaten_kota') == $kabupaten['id'] ? 'selected' : '' }}>
                                    {{ $kabupaten['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                        <select name="kecamatan" id="kecamatan" class="form-select form-select-lg" required>
                            <option value="" disabled selected hidden>Pilih Kecamatan</option>
                            @if(old('kecamatan'))
                                <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kelurahan/Desa <span class="text-danger">*</span></label>
                        <select name="kelurahan" id="kelurahan" class="form-select form-select-lg" required>
                            <option value="" disabled selected hidden>Pilih Kelurahan/Desa</option>
                            @if(old('kelurahan'))
                                <option value="{{ old('kelurahan') }}" selected>{{ old('kelurahan') }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control form-control-lg" value="{{ old('kode_pos') }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. Telp/WA</label>
                        <input type="text" name="no_telp" class="form-control form-control-lg" value="{{ old('no_telp') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. KTP</label>
                        <input type="text" name="no_ktp" class="form-control form-control-lg" value="{{ old('no_ktp') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. KK</label>
                        <input type="text" name="no_kk" class="form-control form-control-lg" value="{{ old('no_kk') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-semibold">Upload Foto KTP <span class="text-danger">*</span></label>
                            <input type="file" name="foto_ktp" class="form-control form-control-lg" required>
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-semibold">Upload Foto KK <span class="text-danger">*</span></label>
                            <input type="file" name="foto_kk" class="form-control form-control-lg" required>
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Pengajuan Izin --}}
            <h4 class="fw-semibold mt-5 mb-4 pb-2 border-bottom" style="color:#36393a; border-color:#7a7a7a;">Data Pengajuan Izin</h4>

            <div class="mb-4">
                <label class="form-label fw-semibold">Jenis Izin <span class="text-danger">*</span></label>
                <select name="jenis_izin" class="form-select form-select-lg" required>
                    <option value="" disabled selected hidden>-- Pilih Jenis Izin --</option>
                    @foreach($jenisIzins as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_izin') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_izin }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <h5 class="fw-bold" style="color:#36393a;">Persyaratan:</h5>
                @foreach($jenisIzins as $jenis)
                <div id="requirements-{{ $jenis->id }}" class="requirements-list">
                    <ul class="list-unstyled ps-2 mt-2">
                        @foreach($jenis->persyaratans as $persyaratan)
                        <li class="mb-2" style="color:#7a7a7a; font-size:1.05rem;">
                            <i class="fas fa-check-circle me-2" style="color:#676868;"></i>
                            {{ $persyaratan->nama_persyaratan }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>

            {{-- Tombol --}}
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-lg px-5 py-3 fw-semibold shadow-sm" 
                        style="background-color:#676868; color:#ffffff; border-radius:12px; font-size:1.15rem;">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-control, .form-select {
        border-radius: 10px !important;
        background-color: #ffffff;
        border: 1.5px solid #7a7a7a;
        color: #1f1f1f;
        font-size: 1.05rem;
        transition: all 0.25s ease-in-out;
        padding: 0.8rem 1rem;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.3rem rgba(103,134,143,0.25);
        border-color: #676868;
    }
    label.form-label {
        color: #36393a;
        font-size: 1.05rem;
    }
    .form-select option[disabled] {
        color: #999 !important;
    }
    .requirements-list { display: none; }
    .requirements-list.show { display: block; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {

        // ==== POPUP NOTIFIKASI SUKSES ====
        const successDiv = document.getElementById('success-message');
        if (successDiv) {
            const title = successDiv.dataset.success;
            const text = successDiv.dataset.detail || '';

            Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                position: 'top',
                background: '#e8f5e9',
                color: '#1f1f1f'
            });
        }

        // ==== SCRIPT DROPDOWN ====
        function resetKelurahan() {
            $('#kelurahan').empty().append('<option value="" disabled selected hidden>Pilih Kelurahan/Desa</option>');
            $('#kode_pos').val('');
        }

        function loadKecamatan(kabupatenId) {
            if (!kabupatenId) { 
                $('#kecamatan').html('<option value="" disabled selected hidden>Pilih Kecamatan</option>');
                resetKelurahan(); 
                return; 
            }
            $('#kecamatan').html('<option value="">Memuat data kecamatan...</option>');
            $.get(`/api/kecamatan/${kabupatenId}`)
                .done(function(data) {
                    const $kec = $('#kecamatan');
                    $kec.empty().append('<option value="" disabled selected hidden>Pilih Kecamatan</option>');
                    (data || []).forEach(function(item){
                        $kec.append(new Option(item.name, item.id));
                    });
                    resetKelurahan();
                })
                .fail(function(){
                    $('#kecamatan').html('<option value="">Gagal memuat kecamatan</option>');
                    resetKelurahan();
                });
        }

        function loadKelurahan(kecamatanId) {
            if (!kecamatanId) { resetKelurahan(); return; }
            $('#kelurahan').html('<option value="">Memuat data kelurahan...</option>');
            $.get(`/api/kelurahan/${kecamatanId}`)
                .done(function(data) {
                    const $kel = $('#kelurahan');
                    $kel.empty().append('<option value="" disabled selected hidden>Pilih Kelurahan/Desa</option>');
                    (data || []).forEach(function(item){
                        $kel.append(new Option(item.name, item.name));
                    });
                    $('#kode_pos').val('');
                })
                .fail(function(){
                    $('#kelurahan').html('<option value="">Gagal memuat kelurahan</option>');
                    $('#kode_pos').val('');
                });
        }

        const selectedKab = $('#kabupaten').val();
        if (selectedKab) loadKecamatan(selectedKab);

        $('#kabupaten').on('change', function(){ loadKecamatan($(this).val()); });
        $('#kecamatan').on('change', function(){ loadKelurahan($(this).val()); });

        $('#kelurahan').on('change', function(){
            const kelName = $(this).val();
            const kecId = $('#kecamatan').val();
            if (!kelName || !kecId) { $('#kode_pos').val(''); return; }
            $.get(`/api/kelurahan/${kecId}`)
                .done(function(data){
                    const found = (data || []).find(k => k.name === kelName);
                    $('#kode_pos').val(found ? (found.kode_pos || '') : '');
                })
                .fail(function(){ $('#kode_pos').val(''); });
        });

        const $jenis = $('select[name="jenis_izin"]');
        function toggleReq() {
            const id = $jenis.val();
            $('.requirements-list').removeClass('show');
            if (id) { $(`#requirements-${id}`).addClass('show'); }
        }
        $jenis.on('change', toggleReq);
        if ($jenis.val()) toggleReq();
    });
</script>
@endpush
@endsection
