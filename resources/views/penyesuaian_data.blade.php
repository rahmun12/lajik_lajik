@extends('layouts.admin')

@section('admin-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Verifikasi Data Pengajuan</h1>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="verificationTable">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Dibuat</th>
                                <th>Nama</th>
                                <th>No. KTP</th>
                                <th>No. Telp</th>
                                <th>Alamat</th>
                                <th>Jenis Izin</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td></td> <!-- Leave empty, will be populated by DataTables -->
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox"
                                                    data-field="nama" data-item-id="{{ $item->id }}"
                                                    id="nama-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('nama') ? 'checked' : '' }}>
                                            </div>
                                            <label for="nama-{{ $item->id }}"
                                                class="mb-0 {{ $item->getFieldVerificationStatus('nama') ? 'verified-field' : '' }}">
                                                {{ $item->nama }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox"
                                                    data-field="no_ktp" data-item-id="{{ $item->id }}"
                                                    id="ktp-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('no_ktp') ? 'checked' : '' }}>
                                            </div>
                                            <label for="ktp-{{ $item->id }}"
                                                class="mb-0 {{ $item->getFieldVerificationStatus('no_ktp') ? 'verified-field' : '' }}">
                                                {{ $item->no_ktp }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox"
                                                    data-field="no_telp" data-item-id="{{ $item->id }}"
                                                    id="telp-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('no_telp') ? 'checked' : '' }}>
                                            </div>
                                            <label for="telp-{{ $item->id }}"
                                                class="mb-0 {{ $item->getFieldVerificationStatus('no_telp') ? 'verified-field' : '' }}">
                                                {{ $item->no_telp }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox"
                                                    data-field="alamat" data-item-id="{{ $item->id }}"
                                                    id="alamat-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('alamat') ? 'checked' : '' }}>
                                            </div>
                                            <div>
                                                <label for="alamat-{{ $item->id }}"
                                                    class="mb-0 d-block {{ $item->getFieldVerificationStatus('alamat') ? 'verified-field' : '' }}">
                                                    <div class="address-stack">
                                                        <div>{{ $item->alamat_jalan }}</div>
                                                        <div>RT {{ $item->rt ?? '-' }} / RW {{ $item->rw ?? '-' }}</div>
                                                        <div>{{ $item->kelurahan }}, {{ $item->kecamatan }}</div>
                                                        <div>{{ $item->kabupaten_kota }} {{ $item->kode_pos }}</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->izinPengajuan->first()->jenisIzin->nama_izin ?? '-' }}</td>
                                    <td>
                                        @if ($item->is_verified)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="verification-notes" data-id="{{ $item->id }}">
                                            {{ $item->verification_notes ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-sm btn-success verify-btn"
                                                data-id="{{ $item->id }}" data-verified="1">
                                                <i class="fas fa-check"></i> Setuju
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger verify-btn"
                                                data-id="{{ $item->id }}" data-verified="0">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info view-details"
                                                data-bs-toggle="modal" data-bs-target="#detailModal"
                                                data-item="{{ json_encode($item) }}">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="detailModalLabel">Detail Data Pengajuan</h5>
                        <button type="button" class="btn-close" id="closeDetailModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detailModalBody">
                        <div class="container-fluid">
                            <div id="detailContent">
                                <!-- Content will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Upload Modal -->
        <div class="modal fade" id="documentUploadModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="documentUploadForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="documentItemId">
                            <input type="hidden" name="doc_type" id="documentType">
                            <div class="mb-3">
                                <label for="documentFile" class="form-label">Pilih File</label>
                                <input class="form-control" type="file" id="documentFile" name="document"
                                    accept="image/*,.pdf" required>
                                <div class="form-text">Format: JPG, PNG, atau PDF (Maks. 2MB)</div>
                            </div>
                            <div class="mb-3">
                                <label for="documentNotes" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="documentNotes" name="notes" rows="2"></textarea>
                            </div>
                        </form>
                        <div id="uploadPreview" class="text-center mt-3 d-none">
                            <img id="documentPreview" src="" class="img-fluid mb-2" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="submitDocumentUpload">
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Modal -->
        <div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="notesModalLabel">Catatan Verifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="verificationForm">
                            @csrf
                            <input type="hidden" name="id" id="verificationId">
                            <input type="hidden" name="is_verified" id="verificationStatus">
                            <div class="mb-3">
                                <label for="verificationNotes" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="verificationNotes" name="notes" rows="3"></textarea>
                                <div class="form-text">Berikan catatan jika diperlukan.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="submitVerification">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        <style>
            .verification-notes {
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: inline-block;
            }

            .badge {
                font-size: 0.85em;
            }

            .table th,
            .table td {
                vertical-align: middle;
            }

            .verified-field {
                color: #28a745;
                font-weight: 500;
                position: relative;
                padding-left: 5px;
            }

            .verified-field:before {
                content: '✓';
                margin-right: 5px;
            }

            tr.verified-row {
                background-color: #f8fff8;
            }

            /* Address stacked layout (scoped) */
            .address-stack {
                max-width: 520px;
                /* avoid pushing table too wide */
            }

            .address-stack>* {
                line-height: 1.25;
            }

            .address-stack label {
                white-space: normal;
                word-break: break-word;
            }

            @media (max-width: 992px) {
                .address-stack {
                    max-width: 100%;
                }
            }

            /* Neat borders for verification table (scoped) */
            #verificationTable {
                border-collapse: separate;
                border-spacing: 0;
                width: 100%;
                /* fill container width only */
                max-width: 100%;
                font-size: 0.95rem;
                /* slightly compact text for clean look */
            }

            #verificationTable thead th,
            #verificationTable tbody td {
                border-right: 1px solid rgba(0, 0, 0, 0.06);
                /* softer borders */
                border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            }

            #verificationTable thead th {
                border-bottom: 2px solid rgba(0, 0, 0, 0.08);
                /* slightly stronger header divider */
            }

            #verificationTable tr th:first-child,
            #verificationTable tr td:first-child {
                border-left: 1px solid rgba(0, 0, 0, 0.06);
            }

            /* Optional subtle outer border via first header row */
            #verificationTable thead tr:first-child th {
                border-top: 1px solid rgba(0, 0, 0, 0.06);
            }

            /* Subtle zebra and hover for cleanliness */
            #verificationTable tbody tr:nth-of-type(odd) {
                background-color: #fafafa;
            }

            #verificationTable tbody tr:hover {
                background-color: #f5f5f5;
            }

            /* Reallocate width: balance Name and Address */
            #verificationTable th:nth-child(1),
            #verificationTable td:nth-child(1) {
                /* Nama */
                width: 16%;
            }

            #verificationTable th:nth-child(4),
            #verificationTable td:nth-child(4) {
                /* Alamat */
                width: 38%;
            }

            /* Truncate long names nicely within the narrower column */
            #verificationTable td:nth-child(1) label {
                display: inline-block;
                max-width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Slightly larger spacing for tables on this page (scoped) */
            .card .table th,
            .card .table td {
                padding: 1.15rem 1.05rem;
                /* a bit wider horizontally */
            }

            /* Modal detail tables */
            .modal .table th,
            .modal .table td {
                padding: 1.05rem 1.0rem;
                /* a bit wider horizontally */
            }

            @media (max-width: 992px) {

                .card .table th,
                .card .table td {
                    padding: 1.05rem 0.55rem;
                    /* keep height, trim width further on small screens */
                }

                .modal .table th,
                .modal .table td {
                    padding: 0.95rem 0.50rem;
                }
            }

            /* Align status and actions for tidy look */
            #verificationTable th:nth-child(6),
            #verificationTable td:nth-child(6),
            #verificationTable th:nth-child(8),
            #verificationTable td:nth-child(8) {
                text-align: center;
                white-space: nowrap;
            }

            /* Compact button group spacing */
            #verificationTable .btn-group .btn {
                margin-right: 6px;
            }

            #verificationTable .btn-group .btn:last-child {
                margin-right: 0;
            }

            /* DataTables controls polish (scoped to this table) */
            #verificationTable_wrapper .dataTables_length label,
            #verificationTable_wrapper .dataTables_filter label {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 0.5rem;
                /* normal spacing */
                font-size: 0.95rem;
                /* normal size */
                white-space: nowrap;
                /* keep in one line */
            }

            #verificationTable_wrapper .dataTables_length select {
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 0.45rem 0.75rem;
                /* normal touch target */
                padding-right: 2rem;
                /* give space for native arrow */
                background-color: #fff;
                font-size: 0.95rem;
                width: auto;
                min-width: 90px;
                max-width: 140px;
                /* avoid stretching but prevent crowding */
                vertical-align: middle;
                background-position: right 0.6rem center;
                /* for browsers that render bg icon */
                background-repeat: no-repeat;
            }

            #verificationTable_wrapper .dataTables_filter input {
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 0.5rem 0.75rem;
                /* normal */
                padding-left: 2rem;
                /* space for inside icon */
                background-color: #fff;
                min-width: 220px;
                max-width: 240px;
                /* prevent wrapping and keep in one row */
                font-size: 0.95rem;
            }

            /* Full-width table container */
            .card .table-responsive {
                max-width: none;
                width: 100%;
                margin: 0;
                overflow-x: auto;
            }

            #verificationTable_wrapper {
                max-width: none;
                width: 100%;
                margin: 0;
                padding: 0.25rem 0;
            }

            /* Top controls: length (left) + search (right) on the same line */
            #verificationTable_wrapper .row:first-child {
                display: flex !important;
                flex-wrap: nowrap !important;
                /* keep in one row on wide screens */
                align-items: center !important;
                justify-content: space-between !important;
                /* push to edges */
                gap: 8px;
                width: 100%;
            }

            /* Override Bootstrap grid widths */
            #verificationTable_wrapper .row:first-child>div {
                flex: 0 0 auto !important;
                width: auto !important;
                max-width: none !important;
            }

            #verificationTable_wrapper .dataTables_length {
                order: 1;
            }

            #verificationTable_wrapper .dataTables_filter {
                order: 2;
                margin-left: auto !important;
                display: flex !important;
                align-items: center;
            }

            #verificationTable_wrapper .dataTables_filter label {
                display: inline-flex;
                align-items: center;
            }

            /* Keep labels on one line on wide screens */
            #verificationTable_wrapper .dataTables_length label,
            #verificationTable_wrapper .dataTables_filter label {
                white-space: nowrap;
            }

            /* Bottom info and pagination aligned cleanly */
            #verificationTable_wrapper .row:last-child {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 6px;
            }

            /* Ensure action buttons look consistent */
            #verificationTable .btn-group .btn {
                padding: 0.4rem 0.6rem;
            }

            /* Responsive stacking for small/medium screens */
            @media (max-width: 768px) {
                #verificationTable_wrapper .row:first-child {
                    gap: 6px;
                    flex-wrap: wrap !important;
                }

                #verificationTable_wrapper .dataTables_length,
                #verificationTable_wrapper .dataTables_filter {
                    flex: 1 1 100% !important;
                    order: unset;
                    margin-left: 0 !important;
                }

                #verificationTable_wrapper .dataTables_filter label {
                    width: 100%;
                }

                #verificationTable_wrapper .dataTables_filter input {
                    width: 100%;
                    max-width: 100%;
                }

                #verificationTable_wrapper .dataTables_length label,
                #verificationTable_wrapper .dataTables_filter label {
                    white-space: normal;
                }
            }

            /* Search with icon placed inside the input */
            #verificationTable_wrapper .dataTables_filter label {
                position: relative;
                display: inline-flex;
                align-items: center;
            }

            #verificationTable_wrapper .dataTables_filter label:before {
                content: "\f002";
                /* fa-magnifying-glass */
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                color: #9ca3af;
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                font-size: 0.9rem;
            }

            #verificationTable_wrapper .dataTables_filter input {
                padding-left: 2rem;
            }

            #verificationTable_wrapper .dataTables_length select:focus,
            #verificationTable_wrapper .dataTables_filter input:focus {
                outline: none;
                border-color: #d1d5db;
                box-shadow: 0 0 0 0.15rem rgba(107, 114, 128, 0.15);
            }

            /* Align controls responsively */
            #verificationTable_wrapper .row:first-child {
                align-items: center;
            }

            #verificationTable_wrapper .dataTables_info {
                color: #6b7280;
                /* gray-500 */
                font-size: 0.9rem;
                margin-top: 0.25rem;
            }

            #verificationTable_wrapper .dataTables_paginate .pagination {
                margin: 0.25rem 0 0;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            // Handle field verification checkboxes
            $(document).on('change', '.field-verification', function() {
                const field = $(this).data('field');
                const itemId = $(this).data('item-id');
                const isChecked = $(this).is(':checked');
                const $label = $(`label[for="${field}-${itemId}"]`);
                const $row = $(this).closest('tr');

                // Show loading state
                const $checkbox = $(this);
                $checkbox.prop('disabled', true);

                // Toggle the verified-field class on the label
                if (isChecked) {
                    $label.addClass('verified-field');
                } else {
                    $label.removeClass('verified-field');
                }

                // Check if all fields are verified
                const allFieldsVerified = $row.find('.field-verification:checked').length === $row.find(
                    '.field-verification').length;

                // Toggle row highlight based on verification status
                if (allFieldsVerified) {
                    $row.addClass('verified-row');
                } else {
                    $row.removeClass('verified-row');
                }

                // Save verification status
                saveVerificationStatus(itemId, field, isChecked, $checkbox);
            });

            // Function to save verification status via AJAX
            function saveVerificationStatus(itemId, field, isVerified, $checkbox) {
                $.ajax({
                    url: '{{ route('field.verification.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        item_id: itemId,
                        field: field,
                        is_verified: isVerified ? 1 : 0
                    },
                    success: function(response) {
                        // Show success message
                        if (response.success) {
                            // Enable the checkbox
                            $checkbox.prop('disabled', false);

                            // Show toast notification
                            const message = isVerified ?
                                'Kolom berhasil diverifikasi' :
                                'Status verifikasi kolom berhasil dihapus';

                            toastr.success(message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating verification status', xhr);

                        // Revert the checkbox state on error
                        $checkbox.prop('checked', !isChecked);
                        $checkbox.prop('disabled', false);

                        // Show error message
                        toastr.error('Terjadi kesalahan saat memperbarui status verifikasi');

                        // Revert the label class
                        const $label = $(`label[for="${field}-${itemId}"]`);
                        if (isChecked) {
                            $label.removeClass('verified-field');
                        } else {
                            $label.addClass('verified-field');
                        }
                    }
                });
            }

            // Function to check and update row verification status
            function updateRowVerificationStatus(row) {
                const $row = $(row);
                const allChecked = $row.find('.field-verification').length === $row.find('.field-verification:checked').length;
                if (allChecked) {
                    $row.addClass('verified-row');
                } else {
                    $row.removeClass('verified-row');
                }
            }

            $(document).ready(function() {
                // Initialize DataTable with sorting by created_at in descending order
                var table = $('#verificationTable').DataTable({
                    order: [
                        [1, 'desc']
                    ], // Sort by second column (created_at) in descending order
                    pageLength: 25, // Show 25 entries by default
                    stateSave: true, // Save table state (sorting, pagination, etc.)
                    columnDefs: [{
                            searchable: false,
                            orderable: false,
                            targets: 0,
                            className: 'dt-body-center'
                        },
                        {
                            targets: 1,
                            type: 'date-eu'
                        } // Properly sort date in DD/MM/YYYY format
                    ],
                    // Add row numbers that persist after sorting/filtering
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).html(dataIndex + 1);
                    },
                    // Update row numbers when page changes
                    drawCallback: function() {
                        var api = this.api();
                        var startIndex = api.page.info().start;
                        api.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    },
                    initComplete: function() {
                        // Update row verification status on page load
                        this.api().rows().every(function() {
                            updateRowVerificationStatus($(this.node()));
                        });

                        // Polish search UI: placeholder and remove default label text
                        const $wrapper = $('#verificationTable_wrapper');
                        const $filter = $wrapper.find('.dataTables_filter');
                        $filter.find('input')
                            .attr('placeholder', 'Cari nama, alamat, jenis izin, status...');
                        // Remove the default text node (e.g., 'Cari:') inside label
                        $filter.find('label').contents().filter(function() {
                            return this.nodeType === 3;
                        }).remove();
                    },
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        "decimal": "",
                        "emptyTable": "Tidak ada data yang tersedia",
                        "info": "Menampilkan _START_–_END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                        "infoFiltered": "(disaring dari _MAX_ total data)",
                        "infoPostFix": "",
                        "thousands": ".",
                        "lengthMenu": "Tampilkan _MENU_ / halaman",
                        "loadingRecords": "Memuat...",
                        "processing": "Memproses...",
                        "search": "",
                        "zeroRecords": "Tidak ditemukan data yang sesuai",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        },
                        "aria": {
                            "sortAscending": ": aktifkan untuk mengurutkan kolom naik",
                            "sortDescending": ": aktifkan untuk mengurutkan kolom menurun"
                        }
                    }
                });

                // Handle verification buttons - using event delegation for dynamic content
                $(document).on('click', '.verify-btn', function() {
                    // Verification button click handler
                    const id = $(this).data('id');
                    const isVerified = $(this).data('verified');
                    const $button = $(this);

                    // Disable button to prevent double click
                    $button.prop('disabled', true);

                    // Check if this is a rejection (Tolak)
                    if (isVerified == 0) {
                        $('#verificationId').val(id);
                        $('#verificationStatus').val(0);
                        $('#verificationNotes').val('');
                        $('#notesModalLabel').html('<i class="fas fa-times-circle me-2"></i>Tolak Data');
                        $('#notesModal').modal('show');

                        // Re-enable button when modal is hidden
                        $('#notesModal').on('hidden.bs.modal', function() {
                            $button.prop('disabled', false);
                        });
                    } else {
                        // For approval (Setuju), show confirmation
                        if (confirm('Apakah Anda yakin ingin memverifikasi data ini?')) {
                            const formData = {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                is_verified: 1,
                                notes: 'Data telah diverifikasi.'
                            };

                            $.ajax({
                                url: '/admin/personal-data/verify/' + id,
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        window.location.reload();
                                    } else {
                                        alert(response.message ||
                                            'Terjadi kesalahan. Silakan coba lagi.');
                                        $button.prop('disabled', false);
                                    }
                                },
                                error: function(xhr) {
                                    alert('Terjadi kesalahan. Silakan coba lagi.');
                                    console.error(xhr.responseText);
                                    $button.prop('disabled', false);
                                }
                            });
                        } else {
                            $button.prop('disabled', false);
                        }
                    }
                });

                // Submit verification (for rejection with notes)
                $('#submitVerification').on('click', function() {
                    const $button = $(this);
                    const notes = $('#verificationNotes').val().trim();

                    if (!$('#verificationStatus').val() && !notes) {
                        alert('Harap isi alasan penolakan.');
                        return;
                    }

                    $button.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                        );

                    const id = $('#verificationId').val();
                    const formData = {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        is_verified: $('#verificationStatus').val(),
                        notes: notes || 'Permohonan ditolak.'
                    };

                    $.ajax({
                        url: '/admin/personal-data/verify/' + id,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                window.location.reload();
                            } else {
                                alert(response.message || 'Terjadi kesalahan. Silakan coba lagi.');
                                $button.prop('disabled', false).text('Simpan');
                                $('#notesModal').modal('hide');
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                            console.error(xhr.responseText);
                            $button.prop('disabled', false).text('Simpan');
                        }
                    });
                });

                // View details
                $(document).on('click', '.view-details', function() {
                    const item = $(this).data('item');
                    console.log('View details clicked', item);

                    // Generate requirements status
                    const requirementsHtml = `
                <div class="mb-4">
                    <h6 class="border-bottom pb-2">Verifikasi Persyaratan</h6>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="card-title mb-0">${item.izin_pengajuan ? item.izin_pengajuan[0].jenis_izin.nama_izin : 'Jenis Izin'}</h6>
                                        <span class="badge ${item.is_verified ? 'bg-success' : 'bg-warning'}">
                                            ${item.is_verified ? 'Terverifikasi' : 'Belum Diverifikasi'}
                                        </span>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status Verifikasi</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   id="verification-status" 
                                                   ${item.is_verified ? 'checked' : ''}
                                                   data-item-id="${item.id}">
                                            <label class="form-check-label" for="verification-status">
                                                ${item.is_verified ? 'Sudah Diverifikasi' : 'Belum Diverifikasi'}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                    // Generate document upload section
                    const documentPreviews = `
                <!-- Foto Berkas Section -->
                <div class="mb-4">
                    <h6 class="border-bottom pb-2">Foto Berkas Serah Terima</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                ${item.serah_terima && item.serah_terima.foto_berkas ? 
                                    `<img src="${item.serah_terima.foto_berkas.startsWith('http') ? '' : '/storage/'}${item.serah_terima.foto_berkas}" 
                                                  class="img-fluid img-thumbnail document-preview mb-2" 
                                                  style="max-height: 200px; cursor: pointer;" 
                                                  onerror="this.onerror=null; this.src='/images/image-not-found.jpg';"
                                                  onclick="viewDocument('${item.serah_terima.foto_berkas}')">` :
                                    '<div class="text-muted py-4 border rounded">Belum ada foto berkas diunggah</div>'
                                }
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Foto Berkas</h6>
                                    <p class="text-muted small mb-0">Unggah foto berkas serah terima dalam format JPG, PNG (maks. 2MB)</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary upload-doc" 
                                            data-doc-type="foto_berkas" 
                                            data-item-id="${item.id}">
                                        <i class="fas fa-upload me-1"></i>
                                        ${item.serah_terima && item.serah_terima.foto_berkas ? 'Ganti Foto' : 'Unggah Foto'}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                    // Generate personal information
                    let detailsHtml = `
                <!-- KTP & KK Photos Section -->
                <div class="mb-4">
                    <h6 class="border-bottom pb-2">Dokumen Pribadi</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Foto KTP</h6>
                                </div>
                                <div class="card-body text-center">
                                    ${item.foto_ktp ? 
                                        `<img src="${item.foto_ktp.startsWith('http') ? '' : '/storage/'}${item.foto_ktp}" 
                                                      class="img-fluid img-thumbnail document-preview" 
                                                      style="max-height: 200px; cursor: pointer;" 
                                                      onerror="this.onerror=null; this.src='/images/image-not-found.jpg';"
                                                      onclick="viewImage(this)">
                                                 <div class="mt-2">
                                                     <a href="${item.foto_ktp.startsWith('http') ? '' : '/storage/'}${item.foto_ktp}" 
                                                        target="_blank" 
                                                        class="btn btn-sm btn-outline-primary mt-2">
                                                         <i class="fas fa-download"></i> Unduh KTP
                                                     </a>
                                                 </div>`
                                        : 
                                        '<div class="text-muted">Tidak ada foto KTP</div>'
                                    }
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Foto KK</h6>
                                </div>
                                <div class="card-body text-center">
                                    ${item.foto_kk ? 
                                        `<img src="${item.foto_kk.startsWith('http') ? '' : '/storage/'}${item.foto_kk}" 
                                                      class="img-fluid img-thumbnail document-preview" 
                                                      style="max-height: 200px; cursor: pointer;" 
                                                      onerror="this.onerror=null; this.src='/images/image-not-found.jpg';"
                                                      onclick="viewImage(this)">
                                                 <div class="mt-2">
                                                     <a href="${item.foto_kk.startsWith('http') ? '' : '/storage/'}${item.foto_kk}" 
                                                        target="_blank" 
                                                        class="btn btn-sm btn-outline-primary mt-2">
                                                         <i class="fas fa-download"></i> Unduh KK
                                                     </a>
                                                 </div>`
                                        : 
                                        '<div class="text-muted">Tidak ada foto KK</div>'
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="mb-4">Detail Data Pengajuan</h4>
                    <h6 class="border-bottom pb-2">Data Pribadi</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Nama Lengkap</th>
                                    <td>${item.nama || '-'}</td>
                                </tr>
                            <tr>
                                <th>No. KTP</th>
                                <td>${item.no_ktp || '-'}</td>
                            </tr>
                            <tr>
                                <th>No. KK</th>
                                <td>${item.no_kk || '-'}</td>
                            </tr>
                            <tr>
                                <th>No. Telp/WA</th>
                                <td>${item.no_telp || '-'}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Alamat</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Jalan</th>
                                <td>${item.alamat_jalan || '-'}</td>
                            </tr>
                            <tr>
                                <th>RT/RW</th>
                                <td>${item.rt || '-'}/${item.rw || '-'}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan/Desa</th>
                                <td>${item.kelurahan || '-'}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td>${item.kecamatan || '-'}</td>
                            </tr>
                            <tr>
                                <th>Kabupaten/Kota</th>
                                <td>${item.kabupaten_kota || '-'}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>${item.kode_pos || '-'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                ${requirementsHtml}
                
                ${documentPreviews}
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Informasi Pengajuan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Jenis Izin</th>
                                <td>${item.izin_pengajuan ? item.izin_pengajuan[0].jenis_izin.nama_izin : '-'}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <td>${new Date(item.created_at).toLocaleDateString('id-ID', { 
                                    day: '2-digit', 
                                    month: 'long', 
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</td>
                            </tr>
                            <tr>
                                <th>Status Verifikasi</th>
                                <td>
                                    ${item.is_verified 
                                        ? '<span class="badge bg-success">Terverifikasi</span>' 
                                        : '<span class="badge bg-warning">Menunggu Verifikasi</span>'}
                                </td>
                            </tr>
                            ${item.verification_notes ? `
                                    <tr>
                                        <th>Catatan Verifikasi</th>
                                        <td>${item.verification_notes}</td>
                                    </tr>
                                    ` : ''}
                        </table>
                    </div>
                </div>
            `;

                    // Combine all sections - removed duplicate document upload section
                    const modalContent = `
                <div class="container-fluid">
                    ${detailsHtml}
                </div>
            `;

                    // Update modal content
                    $('#detailModal .modal-body').html(modalContent);

                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Get or create modal instance
                    const modalElement = document.getElementById('detailModal');
                    let modal = bootstrap.Modal.getInstance(modalElement);

                    if (!modal) {
                        modal = new bootstrap.Modal(modalElement, {
                            backdrop: true,
                            keyboard: true
                        });
                    }

                    // Show the modal
                    modal.show();

                    // Ensure body has correct classes
                    $('body').addClass('modal-open');

                    console.log('Modal shown');
                });
            });

            // Handle modal close
            function closeModal() {
                const modalElement = document.getElementById('detailModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
                // Clean up
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }

            // Close button click
            $(document).on('click', '#closeDetailModal, .btn-secondary[data-bs-dismiss="modal"]', function(e) {
                e.preventDefault();
                closeModal();
            });

            // Close when clicking outside
            $(document).on('click', '.modal', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Clean up when modal is hidden
            $('#detailModal').on('hidden.bs.modal', function() {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });

            // Handle requirement verification
            $(document).on('change', '.requirement-check', function() {
                const requirement = $(this).data('requirement');
                const itemId = $(this).data('item-id');
                const isVerified = $(this).is(':checked');
                const $label = $(this).siblings('label');

                // Show loading state
                $(this).prop('disabled', true);

                // Update UI immediately
                if (isVerified) {
                    $label.removeClass('text-muted').addClass('text-success fw-bold');
                    $label.find('.badge')
                        .removeClass('bg-warning')
                        .addClass('bg-success')
                        .text('Terverifikasi');
                } else {
                    $label.removeClass('text-success fw-bold').addClass('text-muted');
                    $label.find('.badge')
                        .removeClass('bg-success')
                        .addClass('bg-warning')
                        .text('Belum Diverifikasi');
                }

                // Send verification status to server
                $.ajax({
                    url: '/admin/personal-data/verify-requirement',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: itemId,
                        requirement: requirement,
                        is_verified: isVerified ? 1 : 0
                    },
                    success: function(response) {
                        if (!response.success) {
                            // Revert on error
                            $(this).prop('checked', !isVerified);
                            alert('Gagal memperbarui status verifikasi');
                        }
                    },
                    error: function() {
                        // Revert on error
                        $(this).prop('checked', !isVerified);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    },
                    complete: function() {
                        $(this).prop('disabled', false);
                    }.bind(this)
                });
            });

            // Handle document upload
            $(document).on('click', '.upload-doc', function(e) {
                e.preventDefault();
                const docType = $(this).data('doc-type');
                const itemId = $(this).data('item-id');
                const $button = $(this);
                const $card = $(this).closest('.card');

                // Create file input
                const acceptTypes = docType === 'foto_berkas' ? 'image/*' : 'image/*,.pdf';
                const $fileInput = $(`<input type="file" accept="${acceptTypes}" style="display: none;">`);

                $fileInput.on('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    // Check file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        showToast('error', 'Ukuran file maksimal 2MB');
                        return;
                    }

                    // Check file type for foto_berkas (only images allowed)
                    if (docType === 'foto_berkas' && !file.type.match('image.*')) {
                        showToast('error', 'Hanya file gambar yang diizinkan untuk foto berkas');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('id', itemId);
                    formData.append('doc_type', docType);
                    formData.append('document', file);

                    // Show loading state
                    $button.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Mengunggah...');

                    // Determine the upload URL based on document type
                    const uploadUrl = docType === 'foto_berkas' ?
                        '/admin/serah-terima/upload-document' :
                        '/admin/personal-data/upload-document';

                    // Upload file
                    $.ajax({
                        url: uploadUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                // Update the document preview in the card
                                const previewContainer = $card.find('.document-preview-container');
                                if (previewContainer.length) {
                                    if (response.file_path) {
                                        const imgSrc = response.file_path.startsWith('http') ?
                                            response.file_path :
                                            `/storage/${response.file_path}`;

                                        previewContainer.html(`
                                        <img src="${imgSrc}" 
                                             class="img-fluid img-thumbnail document-preview mb-2" 
                                             style="max-height: 200px; cursor: pointer;" 
                                             onerror="this.onerror=null; this.src='/images/image-not-found.jpg';"
                                             onclick="viewDocument('${response.file_path}')
                                    `);
                                    }
                                }

                                // Show success message
                                showToast('success', 'Dokumen berhasil diunggah');

                                // Close any open modals
                                $('.modal').modal('hide');

                                // Reload the page to reflect changes
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                showToast('error', response.message || 'Gagal mengunggah dokumen');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat mengunggah dokumen';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showToast('error', errorMessage);
                        },
                        complete: function() {
                            $button.html('<i class="fas fa-upload me-1"></i> Unggah').prop(
                                'disabled', false);
                        }
                    });
                });

                // Trigger file input click
                $fileInput.trigger('click');
            });

            // Helper function to show toast notifications
            function showToast(type, message) {
                const toastContainer = $('.toast-container');

                // Remove any existing toasts
                if (toastContainer.length === 0) {
                    $('body').append(
                        '<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>');
                } else {
                    $('.toast').remove();
                }

                const toast = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

                // Add new toast
                $('.toast-container').append(toast);
                $('.toast').toast('show');

                // Auto-remove after 3 seconds
                setTimeout(() => {
                    $('.toast').toast('hide').remove();
                }, 3000);
            }

            // View image in full screen
            function viewImage(element) {
                const src = $(element).attr('src');

                // Check if it's a placeholder or empty
                if (!src || src.includes('placeholder') || src === '#') {
                    return;
                }

                const modal = `
       <div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-modal="true">
           <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="imageViewerModalLabel">Pratinjau Dokumen</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                   </div>
                   <div class="modal-body text-center p-0">
                       <img src="${src}" class="img-fluid" style="max-height: 80vh;" alt="Pratinjau dokumen">
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                   </div>
               </div>
           </div>
       </div>`;

                // Remove any existing modals
                $('#imageViewerModal').remove();
                $('body').append(modal);
                const modalEl = new bootstrap.Modal(document.getElementById('imageViewerModal'));
                modalEl.show();

                // Remove modal after close
                $('#imageViewerModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            }
        </script>
    @endpush
