@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Penerimaan SK Izin</h1>
        <a href="{{ route('admin.penerimaan-sk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pemohon</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $item->nama ?? 'N/A' }}</td>
                        </tr>
                        @if(isset($item->jenisIzin) && $item->jenisIzin)
                        <tr>
                            <th>Jenis Izin</th>
                            <td>{{ $item->jenisIzin->nama_izin }}</td>
                        </tr>
                        @else
                        <tr>
                            <th>Jenis Izin</th>
                            <td class="text-danger">Data jenis izin tidak ditemukan</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penerimaan SK</h6>
        </div>
        <div class="card-body">
            <form id="penerimaanSkForm">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. SK Izin</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="no_sk_izin"
                                value="{{ $item->penerimaanSk ? $item->penerimaanSk->no_sk_izin : '' }}"
                                data-field="no_sk_izin"
                                data-item-id="{{ $item->id }}">
                            <button class="btn btn-outline-secondary" type="button" id="saveNoSk">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                        <small class="text-muted">* Klik tombol simpan untuk menyimpan perubahan</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Terbit</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="tanggal_terbit"
                                value="{{ $item->penerimaanSk ? $item->penerimaanSk->tanggal_terbit : '' }}"
                                data-field="tanggal_terbit"
                                data-item-id="{{ $item->id }}">
                            <button class="btn btn-outline-secondary" type="button" id="saveTanggal">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Petugas Menyerahkan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="petugas_menyerahkan"
                                value="{{ $item->penerimaanSk ? $item->penerimaanSk->petugas_menyerahkan : '' }}"
                                data-field="petugas_menyerahkan"
                                data-item-id="{{ $item->id }}">
                            <button class="btn btn-outline-secondary" type="button" id="savePetugasMenyerahkan">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Petugas Menerima</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="petugas_menerima"
                                value="{{ $item->penerimaanSk ? $item->penerimaanSk->petugas_menerima : '' }}"
                                data-field="petugas_menerima"
                                data-item-id="{{ $item->id }}">
                            <button class="btn btn-outline-secondary" type="button" id="savePetugasMenerima">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        width: 30%;
    }

    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery first, then other JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    // Pastikan jQuery sudah dimuat
    if (typeof jQuery == 'undefined') {
        console.error('jQuery is not loaded!');
    }
    
    // Definisikan fungsi showToast di luar document.ready agar bisa diakses secara global
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

        // Hapus toast yang sudah ada
        $('.toast-container').remove();

        // Tambahkan toast baru
        $('body').append(toast);
        $('.toast').toast('show');

        // Hapus toast setelah 3 detik
        setTimeout(() => {
            $('.toast').remove();
        }, 3000);
    };
    
    $(document).ready(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Save field function
        function saveField(field, value, itemId) {
            if (!value) {
                showToast('Harap isi field terlebih dahulu', 'warning');
                return;
            }

            const $button = $(`#save${field.charAt(0).toUpperCase() + field.slice(1)}`);
            const $input = $(`#${field}`);
            const originalValue = $input.val();
            const originalHtml = $button.html();

            // Show loading state
            $button.html('<span class="spinner-border spinner-border-sm"></span>');
            $button.prop('disabled', true);

            // Send AJAX request
            $.ajax({
                url: '{{ route("admin.penerimaan-sk.update-field", "") }}/' + itemId,
                type: 'PUT',
                data: JSON.stringify({
                    field: field,
                    value: value
                }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        showToast('Data berhasil disimpan');
                        // Update input value with the response data if available
                        if (response.data && response.data[field] !== undefined) {
                            $input.val(response.data[field]);
                        }
                    } else {
                        // Revert input value on error
                        $input.val(originalValue);
                        showToast(response ? (response.message || 'Gagal menyimpan data') : 'Response tidak valid', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    
                    // Revert input value on error
                    $input.val(originalValue);
                    
                    let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response && response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }
                    showToast(errorMessage, 'error');
                },
                complete: function() {
                    // Restore button state
                    $button.html('<i class="fas fa-save"></i>');
                    $button.prop('disabled', false);
                }
            });
        }

        // Save buttons click handlers
        $(document).on('click', '#saveNoSk', function() {
            const value = $('#no_sk_izin').val();
            const itemId = '{{ $item->id }}';
            saveField('no_sk_izin', value, itemId);
        });

        $(document).on('click', '#saveTanggal', function() {
            const value = $('#tanggal_terbit').val();
            const itemId = '{{ $item->id }}';
            saveField('tanggal_terbit', value, itemId);
        });

        $(document).on('click', '#savePetugasMenyerahkan', function() {
            const value = $('#petugas_menyerahkan').val();
            const itemId = '{{ $item->id }}';
            saveField('petugas_menyerahkan', value, itemId);
        });

        $(document).on('click', '#savePetugasMenerima', function() {
            const value = $('#petugas_menerima').val();
            const itemId = '{{ $item->id }}';
            saveField('petugas_menerima', value, itemId);
        });

        // Allow saving with Enter key
        $(document).on('keypress', 'input[type="text"], input[type="date"]', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                const field = $(this).data('field');
                $(`#save${field.charAt(0).toUpperCase() + field.slice(1)}`).click();
            }
        });
    });
</script>
@endpush