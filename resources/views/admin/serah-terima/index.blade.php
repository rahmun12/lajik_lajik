@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Serah Terima</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Izin</th>
                        <th>Foto Berkas</th>
                        <th>Petugas Menyerahkan</th>
                        <th>Petugas Menerima</th>
                        <th>Waktu Serah Terima</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama ?? 'N/A' }}</td>
                        <td>{{ $item->jenisIzin->nama_izin ?? 'N/A' }}</td>
                        <td class="foto-berkas-cell">
                            @if($item->serahTerima && $item->serahTerima->foto_berkas)
                                <div class="document-preview">
                                    @php
                                        $extension = pathinfo($item->serahTerima->foto_berkas, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $item->serahTerima->foto_berkas) }}" 
                                             class="img-thumbnail document-image" 
                                             style="max-width: 100px; max-height: 100px; cursor: pointer;"
                                             onclick="viewImage(this)"
                                             data-doc="foto_berkas">
                                    @else
                                        <a href="{{ asset('storage/' . $item->serahTerima->foto_berkas) }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                            <div class="mt-1">
                                                <small class="text-muted">Lihat Dokumen</small>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                            <div class="upload-form d-none">
                                <form class="upload-foto-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="foto_berkas" class="form-control form-control-sm" accept="image/*,.pdf" required>
                                    <div class="btn-group btn-group-sm mt-1">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary cancel-upload">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div class="view-mode">
                                <span class="value">{{ $item->serahTerima->petugas_menyerahkan ?? '-' }}</span>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-2 edit-btn" data-field="petugas_menyerahkan">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" value="{{ $item->serahTerima->petugas_menyerahkan ?? '' }}">
                                    <button class="btn btn-outline-success save-btn" type="button"
                                        data-id="{{ $item->id }}" data-field="petugas_menyerahkan">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary cancel-btn" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="view-mode">
                                <span class="value">{{ $item->serahTerima->petugas_menerima ?? '-' }}</span>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-2 edit-btn" data-field="petugas_menerima">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" value="{{ $item->serahTerima->petugas_menerima ?? '' }}">
                                    <button class="btn btn-outline-success save-btn" type="button"
                                        data-id="{{ $item->id }}" data-field="petugas_menerima">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary cancel-btn" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->serahTerima ? ($item->serahTerima->waktu_serah_terima ? \Carbon\Carbon::parse($item->serahTerima->waktu_serah_terima)->format('d/m/Y H:i') : 'Belum diserahkan') : 'Belum diserahkan' }}</td>
                        <td>
                            @if($item->serahTerima && $item->serahTerima->petugas_menyerahkan && $item->serahTerima->petugas_menerima)
                            <span class="badge bg-success">Selesai</span>
                            @else
                            <span class="badge bg-warning">Belum Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data serah terima.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .edit-btn,
    .upload-foto-btn,
    .edit-foto-btn {
        cursor: pointer;
        z-index: 10;
        position: relative;
    }

    .view-mode,
    .edit-mode,
    .foto-berkas-cell {
        min-height: 38px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .foto-berkas-cell {
        flex-direction: column;
        align-items: flex-start;
    }

    .upload-form {
        display: none;
        margin-top: 5px;
        width: 100%;
    }

    .upload-form.active {
        display: block;
    }

    .edit-mode .input-group {
        width: auto;
        min-width: 200px;
    }

    .edit-mode .form-control {
        max-width: 200px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to view image in modal
    function viewImage(element) {
        const imgSrc = $(element).attr('src');
        const modal = `
            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="${imgSrc}" class="img-fluid" alt="Document Preview">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="${imgSrc}" class="btn btn-primary" download>Unduh</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modal);
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
        
        // Remove modal from DOM after it's hidden
        $('#imageModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    }

    $(document).ready(function() {
        // Show toast function
        window.showToast = function(message, type = 'success') {
            const toast = `
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `;

            // Remove any existing toasts
            $('.toast-container').remove();

            // Add new toast
            $('body').append(toast);
            $('.toast').toast('show');

            // Remove toast after 3 seconds
            setTimeout(() => {
                $('.toast').remove();
            }, 3000);
        };
        // Toggle edit mode with better event delegation
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const $td = $btn.closest('td');

            // Debug log
            console.log('Edit button clicked');

            // Hide all other edit modes first
            $('.edit-mode').addClass('d-none');
            $('.view-mode').removeClass('d-none');

            // Show this edit mode
            $td.find('.view-mode').addClass('d-none');
            const $editMode = $td.find('.edit-mode');
            $editMode.removeClass('d-none');

            // Focus and select the input
            const $input = $editMode.find('input');
            if ($input.length) {
                $input.focus().select();
            } else {
                console.error('Input field not found in edit mode');
            }
        });

        // Cancel edit
        $(document).on('click', '.cancel-btn', function() {
            const $row = $(this).closest('td');
            $row.find('.edit-mode').addClass('d-none');
            $row.find('.view-mode').removeClass('d-none');
        });

        // Save changes
        $(document).on('click', '.save-btn', function() {
            const $btn = $(this);
            const $row = $btn.closest('tr');
            const $input = $btn.closest('.edit-mode').find('input');
            const field = $btn.data('field');
            const value = $input.val().trim();
            const id = $btn.data('id');

            // Validate input
            if (!value) {
                showToast('Nama petugas tidak boleh kosong', 'warning');
                $input.focus();
                return;
            }

            // Show loading state
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            // Make AJAX request
            const updateUrl = '{{ url("admin/serah-terima/update-field") }}';
            $.ajax({
                url: `${updateUrl}/${id}`,
                type: 'PUT',
                data: {
                    field: field,
                    value: value,
                    _token: '{{ csrf_token() }}'
                },
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response.success) {
                        // Update view
                        $row.find('.view-mode .value').text(value);
                        $row.find('.edit-mode').addClass('d-none');
                        $row.find('.view-mode').removeClass('d-none');

                        // Show success message
                        showToast('Nama petugas berhasil disimpan', 'success');

                        // Update status badge if both officers are filled
                        if (response.data) {
                            const {
                                petugas_menyerahkan,
                                petugas_menerima,
                                waktu_serah_terima
                            } = response.data;

                            // Update the other field if it's being displayed
                            if (field === 'petugas_menyerahkan') {
                                $row.siblings().find('.view-mode .value').first().text(petugas_menerima || '-');
                            } else if (field === 'petugas_menerima') {
                                $row.siblings().find('.view-mode .value').first().text(petugas_menyerahkan || '-');
                            }

                            // Update timestamp if available
                            if (waktu_serah_terima) {
                                const waktu = new Date(waktu_serah_terima);
                                $row.closest('tr').find('.waktu-serah-terima').text(
                                    waktu.toLocaleString('id-ID', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                );

                                // Update status badge
                                const $statusBadge = $row.closest('tr').find('.badge');
                                if ($statusBadge.length) {
                                    $statusBadge.removeClass('bg-warning').addClass('bg-success')
                                        .text('Selesai');
                                }
                            }
                        }
                    } else {
                        showToast(response.message || 'Gagal menyimpan data', 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }

                    showToast(errorMessage, 'danger');

                    // Re-enable the input for correction
                    $input.focus();
                },
                complete: function() {
                    $row.find('.save-btn').html('<i class="fas fa-check"></i>');
                    $row.find('.save-btn, .cancel-btn').prop('disabled', false);
                }
            });
        });

        // Toggle upload form
        $(document).on('click', '.upload-foto-btn, .edit-foto-btn', function() {
            const $btn = $(this);
            const $container = $btn.closest('td').find('.foto-berkas-cell');
            const $uploadForm = $container.find('.upload-form');

            $container.find('.upload-foto-btn, .edit-foto-btn, a').hide();
            $uploadForm.removeClass('d-none').addClass('active');
        });

        // Cancel upload
        $(document).on('click', '.cancel-upload', function() {
            const $form = $(this).closest('form')[0];
            if ($form) $form.reset();

            const $container = $(this).closest('td').find('.foto-berkas-cell');
            $container.find('.upload-form').addClass('d-none').removeClass('active');
            $container.find('.upload-foto-btn, .edit-foto-btn, a').show();
        });

        // Handle file upload
        $(document).on('submit', '.upload-foto-form', function(e) {
            e.preventDefault();

            const $form = $(this);
            const formData = new FormData(this);
            const $btn = $form.find('button[type="submit"]');
            const originalBtnText = $btn.html();
            const id = $form.closest('tr').find('.save-btn').data('id');

            // Show loading state
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            // Add field name to form data
            formData.append('field', 'foto_berkas');
            formData.append('_token', '{{ csrf_token() }}');

            // Make AJAX request
            $.ajax({
                url: `/admin/serah-terima/update-field/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Reload the page to show the new file
                        window.location.reload();
                    } else {
                        showToast(response.message || 'Gagal mengunggah file', 'danger');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat mengunggah file';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showToast(errorMessage, 'danger');
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // Handle Enter key in input
        $(document).on('keypress', '.edit-mode input', function(e) {
            if (e.which === 13) { // Enter key
                $(this).closest('.edit-mode').find('.save-btn').click();
            }
        });

        // Handle document upload
        $(document).on('click', '.upload-doc, .change-doc', function(e) {
            e.preventDefault();
            const docType = $(this).data('doc');
            const itemId = $(this).data('item-id');
            const $button = $(this);
            const $row = $(this).closest('tr');

            // Create file input
            const $fileInput = $('<input type="file" accept="image/*,.pdf" style="display: none;">');

            $fileInput.on('change', function() {
                const file = this.files[0];
                if (!file) return;

                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showToast('Ukuran file maksimal 2MB', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('id', itemId);
                formData.append('doc_type', docType);
                formData.append('document', file);

                // Show loading state
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengunggah...');

                // Upload file
                $.ajax({
                    url: '/admin/serah-terima/upload-document',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Reload the page to reflect changes
                            window.location.reload();
                        } else {
                            showToast(response.message || 'Gagal mengunggah dokumen', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat mengunggah dokumen';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showToast(errorMessage, 'error');
                    },
                    complete: function() {
                        $button.html('<i class="fas fa-upload"></i> ' + ($button.hasClass('change-doc') ? 'Ganti' : 'Unggah')).prop('disabled', false);
                    }
                });
            });

            // Trigger file input click
            $fileInput.click();
        });

        // Show toast notification
    });
</script>
@endpush