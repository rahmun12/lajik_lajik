@extends('layouts.admin')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Form Penyerahan SK Izin</h1>
            <a href="{{ route('admin.penerimaan-sk.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar Penerimaan SK
            </a>
        </div>

        @if (!isset($penerimaanSk))
            <div class="alert alert-danger">
                Data penerimaan SK tidak ditemukan.
            </div>
        @else
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Penyerahan SK</h6>
                </div>
                <div class="card-body">
                    <form id="penyerahanSkForm" action="{{ route('admin.penyerahan-sk.store') }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="penerimaan_sk_id" value="{{ $penerimaanSk->id }}">
                        <input type="hidden" name="personal_data_id" value="{{ $penerimaanSk->personal_data_id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                                <input type="text" id="nama_pemohon" class="form-control"
                                    value="{{ $penerimaanSk->personalData->nama }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_izin" class="form-label">Jenis Izin</label>
                                <input type="text" id="jenis_izin" class="form-control"
                                    value="{{ $penerimaanSk->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'Tidak ada data' }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="no_sk_izin" class="form-label">No. SK Izin</label>
                                <input type="text" id="no_sk_izin" class="form-control" name="no_sk_izin"
                                    value="{{ $penerimaanSk->no_sk_izin ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_terbit" class="form-label">Tanggal Terbit SK</label>
                                <input type="date" id="tanggal_terbit" class="form-control" name="tanggal_terbit"
                                    value="{{ old('tanggal_terbit', now()->format('Y-m-d')) }}" required
                                    oninvalid="this.setCustomValidity('Mohon isi tanggal terbit SK')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="petugas_mengambil" class="form-label">Petugas Mengambil Berkas <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="petugas_mengambil" name="petugas_mengambil"
                                    class="form-control @error('petugas_mengambil') is-invalid @enderror"
                                    value="{{ old('petugas_mengambil') }}" required>
                                @error('petugas_mengambil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="petugas_menyerahkan" class="form-label">Petugas Menyerahkan <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="petugas_menyerahkan" name="petugas_menyerahkan"
                                    class="form-control @error('petugas_menyerahkan') is-invalid @enderror"
                                    value="{{ old('petugas_menyerahkan') }}" required>
                                @error('petugas_menyerahkan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="pemohon_menerima" class="form-label">Pemohon Menerima <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="pemohon_menerima" name="pemohon_menerima"
                                    class="form-control @error('pemohon_menerima') is-invalid @enderror"
                                    value="{{ old('pemohon_menerima') }}" required>
                                @error('pemohon_menerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_penyerahan" class="form-label">Tanggal Penyerahan</label>
                                <input type="date" id="tanggal_penyerahan" class="form-control" name="tanggal_penyerahan"
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="foto_penyerahan" class="form-label">Foto Penyerahan</label>
                                <!-- Hidden file input for form submission -->
                                <input type="file" id="foto_penyerahan" class="d-none" name="foto_penyerahan"
                                    accept="image/*" required>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-info text-white" id="btn-open-camera">
                                        <i class="fas fa-camera me-2"></i>Ambil Foto
                                    </button>
                                </div>
                                <div id="preview-container" class="mt-2 text-center d-none">
                                    <img id="image-preview" src="#" alt="Preview Foto" class="img-thumbnail"
                                        style="max-height: 200px;">
                                    <div class="mt-2 text-success small">
                                        <i class="fas fa-check-circle"></i> Foto berhasil diambil
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="btn-retake">
                                        <i class="fas fa-redo me-1"></i> Ambil Ulang
                                    </button>
                                </div>
                                <div id="error-message" class="text-danger small mt-1 d-none">
                                    Mohon ambil foto bukti penyerahan.
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Pastikan semua data sudah benar sebelum menyimpan. Data yang sudah disimpan tidak dapat
                                    diubah.
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
    <!-- Camera Modal -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalLabel">Ambil Foto Penyerahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="video-container position-relative bg-dark" style="min-height: 300px;">
                        <video id="camera-stream" autoplay playsinline
                            style="width: 100%; height: auto; display: none;"></video>
                        <canvas id="camera-canvas" style="display: none;"></canvas>
                        <div id="camera-placeholder" class="d-flex justify-content-center align-items-center text-white"
                            style="height: 300px;">
                            <div><i class="fas fa-camera fa-3x mb-3"></i><br>Memulai kamera...</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" id="capture-btn" disabled>
                            <i class="fas fa-camera"></i> Ambil
                        </button>
                        <button type="button" class="btn btn-success d-none" id="retake-modal-btn">
                            <i class="fas fa-redo"></i> Ulangi
                        </button>
                        <button type="button" class="btn btn-info text-white d-none" id="save-photo-btn">
                            <i class="fas fa-save"></i> Simpan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('penyerahanSkForm');
            const fileInput = document.getElementById('foto_penyerahan');
            const btnOpenCamera = document.getElementById('btn-open-camera');
            const btnRetake = document.getElementById('btn-retake');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const errorMessage = document.getElementById('error-message');

            // Modal elements
            const cameraModalEl = document.getElementById('cameraModal');
            let cameraModal;
            if (typeof bootstrap !== 'undefined') {
                cameraModal = new bootstrap.Modal(cameraModalEl);
            }

            const video = document.getElementById('camera-stream');
            const canvas = document.getElementById('camera-canvas');
            const placeholder = document.getElementById('camera-placeholder');
            const captureBtn = document.getElementById('capture-btn');
            const retakeModalBtn = document.getElementById('retake-modal-btn');
            const saveBtn = document.getElementById('save-photo-btn');
            let stream = null;

            // Open Camera
            btnOpenCamera.addEventListener('click', function() {
                // Check if running on https or localhost (required for getUserMedia)
                if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location
                    .hostname !== '127.0.0.1') {
                    alert('Fitur kamera memerlukan koneksi HTTPS aman.');
                    return;
                }

                if (cameraModal) cameraModal.show();

                // Start camera
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment'
                        }
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        video.srcObject = mediaStream;
                        video.onloadedmetadata = function(e) {
                            video.play();
                            video.style.display = 'block';
                            placeholder.style.display = 'none';
                            captureBtn.disabled = false;
                        };
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera: ", err);
                        placeholder.innerHTML =
                            '<div><i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i><br>Gagal mengakses kamera: ' +
                            err.message + '<br><small>Pastikan izin kamera diberikan.</small></div>';
                    });
            });

            // Retake from main form (just re-open camera)
            btnRetake.addEventListener('click', function() {
                btnOpenCamera.click();
            });

            // Capture photo in modal
            captureBtn.addEventListener('click', function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);

                video.style.display = 'none';
                canvas.style.display = 'block';
                canvas.style.width = '100%';

                captureBtn.classList.add('d-none');
                retakeModalBtn.classList.remove('d-none');
                saveBtn.classList.remove('d-none');
            });

            // Retake photo in modal
            retakeModalBtn.addEventListener('click', function() {
                video.style.display = 'block';
                canvas.style.display = 'none';

                retakeModalBtn.classList.add('d-none');
                saveBtn.classList.add('d-none');
                captureBtn.classList.remove('d-none');
            });

            // Save photo from modal
            saveBtn.addEventListener('click', function() {
                canvas.toBlob(function(blob) {
                    const file = new File([blob], "penyerahan_sk_" + Date.now() + ".jpg", {
                        type: "image/jpeg"
                    });

                    // Create DataTransfer to set file input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Update preview
                    imagePreview.src = URL.createObjectURL(blob);
                    previewContainer.classList.remove('d-none');
                    btnOpenCamera.parentElement.classList.add('d-none'); // Hide the initial button
                    errorMessage.classList.add('d-none');

                    // Close modal
                    if (cameraModal) cameraModal.hide();

                }, 'image/jpeg', 0.8);
            });

            // Stop stream function
            function stopStream() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }

            // Cleanup on modal close
            cameraModalEl.addEventListener('hidden.bs.modal', function() {
                stopStream();
                // Reset Modal UI
                video.style.display = 'none';
                canvas.style.display = 'none';
                placeholder.style.display = 'flex';
                placeholder.innerHTML =
                    '<div><i class="fas fa-camera fa-3x mb-3"></i><br>Memulai kamera...</div>';
                captureBtn.disabled = true;
                captureBtn.classList.remove('d-none');
                retakeModalBtn.classList.add('d-none');
                saveBtn.classList.add('d-none');
            });

            // Main Form Submit Validation
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Check required fields
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.reportValidity();
                        isValid = false;
                    }
                });

                // Check file input specifically
                if (fileInput.files.length === 0) {
                    errorMessage.classList.remove('d-none');
                    // Scroll to error
                    previewContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    isValid = false;
                } else if (fileInput.files[0].size > 2 * 1024 * 1024) {
                    alert('Ukuran foto terlalu besar (Max 2MB). Silakan ambil ulang.');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                    return false;
                }

                // Show loading indicator
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                }
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

        #camera-canvas {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
@endpush
