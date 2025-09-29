@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Verifikasi Data Pengajuan</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="verificationTable">
                            <thead class="table-dark">
                                <tr>
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
                                @foreach($data as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox" 
                                                    data-field="nama" 
                                                    data-item-id="{{ $item->id }}" 
                                                    id="nama-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('nama') ? 'checked' : '' }}>
                                            </div>
                                            <label for="nama-{{ $item->id }}" class="mb-0 {{ $item->getFieldVerificationStatus('nama') ? 'verified-field' : '' }}">
                                                {{ $item->nama }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox" 
                                                    data-field="no_ktp" 
                                                    data-item-id="{{ $item->id }}" 
                                                    id="ktp-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('no_ktp') ? 'checked' : '' }}>
                                            </div>
                                            <label for="ktp-{{ $item->id }}" class="mb-0 {{ $item->getFieldVerificationStatus('no_ktp') ? 'verified-field' : '' }}">
                                                {{ $item->no_ktp }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox" 
                                                    data-field="no_telp" 
                                                    data-item-id="{{ $item->id }}" 
                                                    id="telp-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('no_telp') ? 'checked' : '' }}>
                                            </div>
                                            <label for="telp-{{ $item->id }}" class="mb-0 {{ $item->getFieldVerificationStatus('no_telp') ? 'verified-field' : '' }}">
                                                {{ $item->no_telp }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-2">
                                                <input class="form-check-input field-verification" type="checkbox" 
                                                    data-field="alamat" 
                                                    data-item-id="{{ $item->id }}" 
                                                    id="alamat-{{ $item->id }}"
                                                    {{ $item->getFieldVerificationStatus('alamat') ? 'checked' : '' }}>
                                            </div>
                                            <div>
                                                <label for="alamat-{{ $item->id }}" class="mb-0 d-block {{ $item->getFieldVerificationStatus('alamat') ? 'verified-field' : '' }}">
                                                    {{ $item->alamat_jalan }}, 
                                                    RT {{ $item->rt ?? '-' }}/RW {{ $item->rw ?? '-' }}, 
                                                    {{ $item->kelurahan }}, {{ $item->kecamatan }}, 
                                                    {{ $item->kabupaten_kota }} {{ $item->kode_pos }}
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->izinPengajuan->first()->jenisIzin->nama_izin ?? '-' }}</td>
                                    <td>
                                        @if($item->is_verified)
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
                                            <button type="button" 
                                                    class="btn btn-sm btn-success verify-btn" 
                                                    data-id="{{ $item->id }}"
                                                    data-verified="1">
                                                <i class="fas fa-check"></i> Setuju
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger verify-btn" 
                                                    data-id="{{ $item->id }}"
                                                    data-verified="0">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-info view-details"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailModal"
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
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel">Detail Data Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content will be loaded dynamically via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
    .table th, .table td {
        vertical-align: middle;
    }
    .verified-field {
        text-decoration: line-through;
        color: #28a745;
        opacity: 0.7;
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
        
        // Show loading state
        const $checkbox = $(this);
        $checkbox.prop('disabled', true);
        
        // Toggle the verified-field class on the label
        if (isChecked) {
            $label.addClass('verified-field');
        } else {
            $label.removeClass('verified-field');
        }
        
        // Save verification status
        saveVerificationStatus(itemId, field, isChecked, $checkbox);
    });

    // Function to save verification status via AJAX
    function saveVerificationStatus(itemId, field, isVerified, $checkbox) {
        $.ajax({
            url: '{{ route("field.verification.update") }}',
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
                    const message = isVerified 
                        ? 'Kolom berhasil diverifikasi' 
                        : 'Status verifikasi kolom berhasil dihapus';
                    
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

    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#verificationTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });

        // Handle verification buttons
        $('.verify-btn').on('click', function() {
            const id = $(this).data('id');
            const isVerified = $(this).data('verified');
            
            $('#verificationId').val(id);
            $('#verificationStatus').val(isVerified);
            $('#verificationNotes').val('');
            
            if (isVerified == 1) {
                $('#notesModalLabel').html('<i class="fas fa-check-circle me-2"></i>Verifikasi Data');
            } else {
                $('#notesModalLabel').html('<i class="fas fa-times-circle me-2"></i>Tolak Data');
            }
            
            $('#notesModal').modal('show');
        });

        // Submit verification
        $('#submitVerification').on('click', function() {
            const formData = {
                _token: '{{ csrf_token() }}',
                id: $('#verificationId').val(),
                is_verified: $('#verificationStatus').val(),
                notes: $('#verificationNotes').val()
            };

            $.ajax({
                url: '{{ route("personal-data.verify") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    console.error(xhr.responseText);
                }
            });
        });

        // View details
        $('.view-details').on('click', function() {
            const item = $(this).data('item');
            let detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Pribadi</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>${item.nama}</td>
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
            
            $('#detailModalBody').html(detailsHtml);
        });
    });
</script>
@endpush
