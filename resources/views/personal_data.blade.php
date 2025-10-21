@extends('layouts.app')

@push('styles')
<style>
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-bounce {
        animation: bounce 1s infinite;
    }

    body {
        font-size: 1.05rem;
        color: #080b08;
        background-color: #ffffff;
    }

    .container {
        max-width: 1100px;
    }

    /* Input & Select */
    .form-control,
    .form-select {
        border-radius: 10px !important;
        background-color: #ffffff;
        border: 1.5px solid rgb(165, 165, 165);
        color: #080b08;
        padding: 0.9rem 1rem;
        font-size: 1rem;
        transition: all 0.25s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #a6a6a6;
        box-shadow: 0 0 0 0.25rem rgba(140, 140, 140, 0.25);
    }

    label.form-label {
        font-size: 1rem;
        margin-bottom: 0.4rem;
        color: #080b08;
    }

    /* Button */
    .btn {
        font-size: 1.1rem !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px !important;
        background-color: #6b7280 !important;
        /* gray-500 */
        color: #ffffff !important;
        border: none !important;
        transition: all 0.25s ease-in-out !important;
    }

    .btn:hover {
        background-color: #9ca3af !important;
        /* gray-400 */
        color: #1a1a1a !important;
        transform: translateY(-2px) !important;
    }



    /* Alerts */
    .alert {
        font-size: 1rem;
        padding: 1.1rem 1.4rem;
        border-radius: 10px !important;
        background-color: #fbfcfb;
        color: #080b08;
        border: 1.5px solid #a6a6a6;
    }

    /* Persyaratan List */
    .requirements-list {
        display: none;
        background-color: rgb(255, 255, 255);
        border-radius: 8px;
        border: 1px solid #a6a6a6;
        padding: 1rem 1.5rem;
        margin-top: 0.75rem;
    }

    .requirements-list.show {
        display: block;
    }

    .requirements-list li {
        font-size: 0.95rem;
        padding: 0.3rem 0;
        color: #080b08;
    }

    h5.fw-semibold {
        font-size: 1.25rem;
        border-bottom: 2px solid #d9d9d9 !important;
        color: #080b08;
    }

    h3.fw-bold {
        font-size: 2rem;
        color: #080b08;
    }

    p.text-muted {
        font-size: 1rem;
        color: rgb(145, 144, 144) !important;
    }

    /* Responsif */
    @media (max-width: 768px) {

        .form-control,
        .form-select {
            font-size: 0.95rem;
            padding: 0.8rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush


@section('content')
<div class="min-vh-100 py-5" style="background-color:#ffffff;">
    <div class="container">

        {{-- Alert sukses --}}
        @if (session('success'))
        <div class="alert alert-success border-0 shadow-lg rounded-4 mb-4 position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color:#155724; border-left: 5px solid #28a745;"
            role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <svg class="w-6 h-6 text-success animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex-grow-1">
                    <h6 class="alert-heading fw-bold mb-1">
                        <i class="fas fa-check-circle me-2"></i>Berhasil!
                    </h6>
                    <p class="mb-0 fs-6 fw-medium">{{ session('success') }}</p>
                    @if (session('message'))
                    <small class="text-muted">{{ session('message') }}</small>
                    @endif
                    {{-- Alert gagal (error sistem) --}}
                    @if (session('error'))
                    <div class="alert alert-danger border-0 shadow-lg rounded-4 mb-4 position-relative overflow-hidden"
                        style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color:#721c24; border-left: 5px solid #dc3545;"
                        role="alert">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <svg class="w-6 h-6 text-danger animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8 4a1 1 0 100-2 1 1 0 000 2zm0-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading fw-bold mb-1">
                                    <i class="fas fa-times-circle me-2"></i>Gagal!
                                </h6>
                                <p class="mb-0 fs-6 fw-medium">{{ session('error') }}</p>

                                @if (session('message'))
                                <small class="text-muted">Detail: {{ session('message') }}</small>
                                @endif
                            </div>
                            <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"
                                data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25"
                            style="background: linear-gradient(45deg, transparent 30%, rgba(220, 53, 69, 0.1) 50%, transparent 70%); animation: shimmer 2s ease-in-out infinite alternate;"></div>
                    </div>
                    @endif

                </div>
                <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"
                    data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25"
                style="background: linear-gradient(45deg, transparent 30%, rgba(40, 167, 69, 0.1) 50%, transparent 70%); animation: shimmer 2s ease-in-out infinite alternate;"></div>
        </div>
        @endif

        {{-- Error handling --}}
        @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-lg rounded-4 mb-4 position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color:#721c24; border-left: 5px solid #dc3545;"
            role="alert">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0 me-3">
                    <svg class="w-6 h-6 text-danger animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex-grow-1">
                    <h6 class="alert-heading fw-bold mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>Oops! Ada Kesalahan
                    </h6>
                    <ul class="mb-2 ps-3" style="list-style-type: '✗ '; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                        <li class="mb-1 fs-6 fw-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <small class="text-muted">Mohon periksa kembali form Anda dan pastikan semua field yang wajib diisi telah terisi dengan benar.</small>
                </div>
                <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"
                    data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25"
                style="background: linear-gradient(45deg, transparent 30%, rgba(220, 53, 69, 0.1) 50%, transparent 70%); animation: shimmer 2s ease-in-out infinite alternate;"></div>
        </div>
        @endif

        {{-- Header --}}
        <div class="text-center mb-5">
            <h3 class="fw-bold" style="color:#36393a;">Formulir Pengajuan Izin</h3>
            <p class="text-muted mb-0" style="color:#7a7a7a;">Silakan isi data di bawah ini dengan lengkap dan benar</p>
        </div>

        <form action="{{ route('pengajuan.izin.store') }}" method="POST" enctype="multipart/form-data"
            class="mx-auto shadow-lg p-5 bg-white rounded-4" style="max-width:1000px;">
            @csrf

            {{-- Section Judul --}}
            <h5 class="fw-semibold mb-3 pb-2 border-bottom" style="color:#36393a; border-color:#7a7a7a;">Data Diri</h5>

            {{-- Data Diri --}}
            <div class="row">
                {{-- kolom kiri --}}
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Jalan <span class="text-danger">*</span></label>
                        <input type="text" name="alamat_jalan" class="form-control" value="{{ old('alamat_jalan') }}"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">RT</label>
                            <input type="text" name="rt" class="form-control" value="{{ old('rt') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">RW</label>
                            <input type="text" name="rw" class="form-control" value="{{ old('rw') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <select name="kabupaten_kota" id="kabupaten" class="form-select" required>
                            <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                            @foreach ([['id' => '3519', 'name' => 'KABUPATEN MAGETAN']] as $kabupaten)
                            <option value="{{ $kabupaten['id'] }}"
                                {{ old('kabupaten_kota') == $kabupaten['id'] ? 'selected' : '' }}>
                                {{ $kabupaten['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                        <select name="kecamatan" id="kecamatan" class="form-select" required>
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @if (old('kecamatan'))
                            <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kelurahan/Desa <span class="text-danger">*</span></label>
                        <select name="kelurahan" id="kelurahan" class="form-select" required>
                            <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                            @if (old('kelurahan'))
                            <option value="{{ old('kelurahan') }}" selected>{{ old('kelurahan') }}</option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control"
                            value="{{ old('kode_pos') }}" readonly>
                    </div>
                </div>

                {{-- kolom kanan --}}
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. Telp/WA</label>
                        <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. KTP</label>
                        <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. KK</label>
                        <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Foto KTP <span
                                class="text-danger">*</span></label>
                        <input type="file" name="foto_ktp" class="form-control" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Foto KK <span
                                class="text-danger">*</span></label>
                        <input type="file" name="foto_kk" class="form-control" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                    </div>
                </div>
            </div>

            {{-- Data Pengajuan Izin --}}
            <h5 class="fw-semibold mt-5 mb-3 pb-2 border-bottom" style="color:#36393a; border-color:#7a7a7a;">Data
                Pengajuan Izin</h5>

            <div class="mb-4">
                <label class="form-label fw-semibold">Jenis Izin <span class="text-danger">*</span></label>
                <select name="jenis_izin" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Jenis Izin --</option>
                    @foreach ($jenisIzins as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('jenis_izin') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_izin }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <h6 class="fw-bold" style="color:#36393a;">Persyaratan:</h6>
                @foreach ($jenisIzins as $jenis)
                <div id="requirements-{{ $jenis->id }}" class="requirements-list">
                    <ul class="list-unstyled ps-2 mt-2">
                        @foreach ($jenis->persyaratans as $persyaratan)
                        <li class="mb-1 d-flex align-items-center" style="color:#36393a; cursor: pointer;"
                            onclick="toggleCheck(this)">
                            <i class="far fa-circle me-2" style="color:#36393a;"></i>
                            {{ $persyaratan->nama_persyaratan }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-lg px-5 py-3" style="background-color:#a6a6a6; color:#ffffff;">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Fungsi reset kelurahan
        function resetKelurahan() {
            $('#kelurahan').html('<option value="" disabled selected hidden>Pilih Kelurahan/Desa</option>');
            $('#kode_pos').val('');
        }

        // Fungsi untuk memuat data kecamatan
        function loadKecamatan(kabupatenId) {
            if (!kabupatenId) {
                $('#kecamatan').html('<option value="" disabled selected hidden>Pilih Kecamatan</option>');
                resetKelurahan();
                return;
            }

            $('#kecamatan').html('<option value="" disabled selected hidden>Memuat data kecamatan...</option>');
            $.get(`/api/kecamatan/${kabupatenId}`)
                .done(function(data) {
                    const $kec = $('#kecamatan');
                    $kec.html('<option value="" disabled selected hidden>Pilih Kecamatan</option>');
                    (data || []).forEach(function(item) {
                        $kec.append(new Option(item.name, item.id));
                    });
                    resetKelurahan();
                })
                .fail(function() {
                    $('#kecamatan').html(
                        '<option value="" disabled selected hidden>Gagal memuat kecamatan</option>');
                    resetKelurahan();
                });
        }

        // Fungsi untuk memuat data kelurahan
        function loadKelurahan(kecamatanId) {
            if (!kecamatanId) {
                resetKelurahan();
                return;
            }

            $('#kelurahan').html('<option value="" disabled selected hidden>Memuat data kelurahan...</option>');
            $.get(`/api/kelurahan/${kecamatanId}`)
                .done(function(data) {
                    const $kel = $('#kelurahan');
                    $kel.html('<option value="" disabled selected hidden>Pilih Kelurahan/Desa</option>');
                    (data || []).forEach(function(item) {
                        $kel.append(
                            $('<option>', {
                                value: item.id,
                                text: item.name,
                                'data-kodepos': item.kode_pos
                            })
                        );
                    });
                    $('#kode_pos').val('');
                })
                .fail(function() {
                    $('#kelurahan').html(
                        '<option value="" disabled selected hidden>Gagal memuat kelurahan</option>');
                    $('#kode_pos').val('');
                });
        }

        // Event handler saat kabupaten berubah
        $('#kabupaten').on('change', function() {
            loadKecamatan($(this).val());
        });

        // Event handler saat kecamatan berubah
        $('#kecamatan').on('change', function() {
            loadKelurahan($(this).val());
        });

        // Event handler saat kelurahan berubah
        $('#kelurahan').on('change', function() {
            const kodepos = $(this).find(':selected').data('kodepos') || '';
            $('#kode_pos').val(kodepos);
        });

        // Toggle persyaratan checklist
        $('select[name="jenis_izin"]').on('change', function() {
            const id = $(this).val();
            $('.requirements-list').removeClass('show');
            if (id) {
                $(`#requirements-${id}`).addClass('show');
            }
        });

        // Saat form reload (validation error)
        if ($('select[name="jenis_izin"]').val()) {
            $(`#requirements-${$('select[name="jenis_izin"]').val()}`).addClass('show');
        }
    });

    // Centang manual persyaratan
    function toggleCheck(element) {
        const icon = element.querySelector('i');

        if (icon.classList.contains('fa-circle')) {
            // dari kosong → jadi centang
            icon.classList.remove('fa-circle');
            icon.classList.add('fa-check-circle');

            // Lingkaran abu-abu, centang putih
            icon.style.color = '#ffffff';
            icon.style.backgroundColor = '#7a7a7a';
            icon.style.borderRadius = '50%';
            icon.style.padding = '2px';
        } else {
            // dari centang → jadi kosong
            icon.classList.remove('fa-check-circle');
            icon.classList.add('fa-circle');

            // Kembali ke abu-abu polos
            icon.style.color = '#9ca3af';
            icon.style.backgroundColor = 'transparent';
            icon.style.padding = '0';
        }
    }

    // Cegah submit jika belum semua persyaratan dicentang
    $('form').on('submit', function(e) {
        const jenisId = $('select[name="jenis_izin"]').val();
        if (!jenisId) return; // kalau belum pilih jenis izin, biar validasi biasa yang jalan

        const $list = $(`#requirements-${jenisId}`);
        const total = $list.find('li').length;
        const checked = $list.find('i.fa-check-circle').length;

        if (checked < total) {
            e.preventDefault(); // stop kirim form
            alert(`Mohon centang semua persyaratan sebelum mengirim pengajuan (${checked}/${total})`);
            return false;
        }
    });
</script>
@endpush