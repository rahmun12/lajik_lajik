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
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
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
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $item->nama ?? 'N/A' }}</td>
                        <td class="align-middle">{{ $item->jenisIzin->nama_izin ?? 'N/A' }}</td>
                        <td class="foto-berkas-cell" style="min-width: 120px;">
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
                                <div class="text-truncate petugas_menyerahkan-value" style="max-width: 200px;" 
                                     title="{{ $item->serahTerima->petugas_menyerahkan ?? '-' }}">
                                    {{ $item->serahTerima->petugas_menyerahkan ?? '-' }}
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-2 edit-btn" 
                                        data-field="petugas_menyerahkan" 
                                        data-bs-toggle="tooltip" 
                                        title="Edit">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group input-group-sm">
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ $item->serahTerima->petugas_menyerahkan ?? '' }}"
                                           placeholder="Nama Petugas">
                                    <button class="btn btn-outline-success save-btn" 
                                            type="button"
                                            data-id="{{ $item->serahTerima->id ?? $item->id }}" 
                                            data-field="petugas_menyerahkan">
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
                                <div class="text-truncate petugas_menerima-value" style="max-width: 200px;" 
                                     title="{{ $item->serahTerima->petugas_menerima ?? '-' }}">
                                    {{ $item->serahTerima->petugas_menerima ?? '-' }}
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 ms-2 edit-btn" 
                                        data-field="petugas_menerima" 
                                        data-bs-toggle="tooltip" 
                                        title="Edit">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group input-group-sm">
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ $item->serahTerima->petugas_menerima ?? '' }}"
                                           placeholder="Nama Petugas">
                                    <button class="btn btn-outline-success save-btn" 
                                            type="button"
                                            data-id="{{ $item->serahTerima->id ?? $item->id }}" 
                                            data-field="petugas_menerima">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary cancel-btn" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($item->serahTerima && $item->serahTerima->waktu_serah_terima)
                                <div class="d-flex flex-column">
                                    <span class="text-nowrap">{{ \Carbon\Carbon::parse($item->serahTerima->waktu_serah_terima)->translatedFormat('d M Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->serahTerima->waktu_serah_terima)->translatedFormat('H:i') }}</small>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->serahTerima && $item->serahTerima->petugas_menyerahkan && $item->serahTerima->petugas_menerima)
                                <span class="badge bg-success bg-opacity-10 text-success">Selesai</span>
                            @else
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">Tidak ada data serah terima</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <div class="text-muted small">
                @if($data->count() > 0)
                    Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} data
                @else
                    Tidak ada data yang ditampilkan
                @endif
            </div>
            <div>
                @if($data->hasPages())
                    {{ $data->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        margin: 1.5rem auto;
        max-width: 99%;  /* Almost full width */
        width: 100%;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table {
        margin-bottom: 0;
    }

    /* Table Header - Using Bootstrap table-dark */
    .table thead th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 12px;
        white-space: nowrap;
        vertical-align: middle;
        height: 46px;
        border-bottom-width: 2px;
    }

    /* Table Cells */
    .table td {
        padding: 10px 12px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        font-size: 0.9rem;
        line-height: 1.4;
        color: #333;
    }

    .table tbody tr {
        transition: background-color 0.15s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table > :not(:first-child) {
        border-top: none;
    }

    .table.table-dark {
        --bs-table-bg: #212529;
        --bs-table-striped-bg: #2c3034;
        --bs-table-striped-color: #fff;
        --bs-table-active-bg: #373b3e;
        --bs-table-active-color: #fff;
        --bs-table-hover-bg: #323539;
        --bs-table-hover-color: #fff;
        color: #fff;
        border-color: #373b3e;
    }

    .table-hover > tbody > tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .edit-btn,
    .upload-foto-btn,
    .edit-foto-btn {
        cursor: pointer;
        z-index: 10;
        position: relative;
        transition: opacity 0.2s;
    }

    /* Edit and View Mode Styling */
    .edit-btn {
        transition: all 0.2s ease;
    }
    
    .edit-btn:hover {
        opacity: 0.8;
        transform: translateY(-1px);
    }

    /* View/Edit Mode */
    .view-mode,
    .edit-mode {
        min-height: 42px;
        display: flex;
        align-items: center;
        position: relative;
        width: 100%;
        padding: 8px 10px;
        border-radius: 4px;
        transition: all 0.15s ease;
        font-size: 0.9rem;
        margin: 2px 0;
    }

    .view-mode {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }

    .edit-mode {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    /* Foto Berkas Cell */
    .foto-berkas-cell {
        min-height: 42px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        padding: 8px 10px;
        width: 100%;
        font-size: 0.9rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-buttons .btn {
        padding: 4px 8px;
        font-size: 0.8rem;
    }

    .foto-berkas-cell .badge {
        margin-top: 4px;
        font-size: 0.8rem;
        padding: 3px 6px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .document-preview {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border-radius: 0.25rem;
        overflow: hidden;
        transition: all 0.2s;
        margin: 0 auto;
    }

    .document-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }

    .document-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.2s;
    }

    .document-image:hover {
        transform: scale(1.05);
    }

    .upload-form {
        display: none;
        margin-top: 8px;
        width: 100%;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 0.375rem;
    }

    .upload-form.active {
        display: block;
    }

    .edit-mode .input-group {
        width: 100%;
        min-width: 200px;
        max-width: 250px;
    }

    .edit-mode .form-control {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }

    .badge {
        padding: 0.4em 0.8em;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        padding: 0.5rem 0.75rem;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
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
        $('#imageModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }

    // Function to show toast message
    window.showToast = function(message, type = 'success') {
        const toast = `
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>`;
        $('.toast-container').remove();
        $('body').append(toast);
        $('.toast').toast('show');
        setTimeout(() => { $('.toast').remove(); }, 3000);
    };

    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Toggle edit mode
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $btn = $(this);
            const $td = $btn.closest('td');
            
            // Hide all other edit modes
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
            const baseUrl = '{{ url("/") }}';
            const updateUrl = `${baseUrl}/admin/serah-terima/update-field/${id}`;
            $.ajax({
                url: updateUrl,
                type: 'PUT',
                data: {
                    field: field,
                    value: value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Update the view
                        $row.find(`.${field}-value`).text(value);
                        $row.find('.edit-mode').addClass('d-none');
                        $row.find('.view-mode').removeClass('d-none');
                        showToast('Data berhasil diperbarui');
                    } else {
                        showToast('Gagal memperbarui data', 'danger');
                    }
                },
                error: function() {
                    showToast('Terjadi kesalahan saat menghubungi server', 'danger');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-check"></i>');
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

        // Handle Enter key in input fields
        $(document).on('keypress', '.edit-mode input', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
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
                        $button.html('<i class="fas fa-upload"></i> ' + 
                            ($button.hasClass('change-doc') ? 'Ganti' : 'Unggah'))
                            .prop('disabled', false);
                    }
                });
            });

            // Trigger file input click
            $fileInput.click();
        });
    });
</script>
@endpush