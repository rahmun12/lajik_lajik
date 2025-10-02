@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penerimaan SK Izin</h1>
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
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemohon</th>
                        <th>No. KTP</th>
                        <th>Jenis Izin</th>
                        <th>No. SK Izin</th>
                        <th>Tanggal Terbit</th>
                        <th>Petugas Menyerahkan</th>
                        <th>Petugas Menerima</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->personalData->nama ?? 'N/A' }}</td>
                        <td>{{ $item->personalData->no_ktp ?? 'N/A' }}</td>
                        <td>
                            @if(isset($item->personalData->izinPengajuan) && $item->personalData->izinPengajuan->isNotEmpty())
                                {{ $item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>

                        {{-- No SK Izin --}}
                        <td>
                            <div class="view-mode">
                                <span class="value">{{ $item->no_sk_izin ?? 'N/A' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $item->no_sk_izin }}" />
                                    <button class="btn btn-success save-btn" data-field="no_sk_izin" data-id="{{ $item->personal_data_id }}"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-secondary cancel-btn"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </td>

                        {{-- Tanggal Terbit --}}
                        <td>
                            <div class="view-mode">
                                <span class="value">
                                    {{ $item->tanggal_terbit ? \Carbon\Carbon::parse($item->tanggal_terbit)->format('d/m/Y') : 'N/A' }}
                                </span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="date" class="form-control" value="{{ $item->tanggal_terbit }}" />
                                    <button class="btn btn-success save-btn" data-field="tanggal_terbit" data-id="{{ $item->personal_data_id }}"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-secondary cancel-btn"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </td>

                        {{-- Petugas Menyerahkan --}}
                        <td>
                            <div class="view-mode">
                                <span class="value">{{ $item->petugas_menyerahkan ?? 'N/A' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $item->petugas_menyerahkan }}" />
                                    <button class="btn btn-success save-btn" data-field="petugas_menyerahkan" data-id="{{ $item->personal_data_id }}"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-secondary cancel-btn"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </td>

                        {{-- Petugas Menerima --}}
                        <td>
                            <div class="view-mode">
                                <span class="value">{{ $item->petugas_menerima ?? 'N/A' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $item->petugas_menerima }}" />
                                    <button class="btn btn-success save-btn" data-field="petugas_menerima" data-id="{{ $item->personal_data_id }}"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-secondary cancel-btn"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </td>

                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data penerimaan SK</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .edit-btn { cursor: pointer; }
    .view-mode, .edit-mode { min-height: 38px; display: flex; align-items: center; }
    .edit-mode .input-group { min-width: 200px; }
    .edit-mode .form-control { max-width: 200px; }
    .table th, .table td { vertical-align: middle; }
    .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // ✅ Toast Notification
        window.showToast = function(message, type = 'success') {
            const toast = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                    <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>`;
            $('body').append(toast);
            $('.toast').toast('show');
            setTimeout(() => $('.toast').remove(), 3000);
        };

        // ✅ Masuk mode edit
        $(document).on('click', '.edit-btn', function() {
            const $td = $(this).closest('td');
            $('.edit-mode').addClass('d-none');
            $('.view-mode').removeClass('d-none');
            $td.find('.view-mode').addClass('d-none');
            $td.find('.edit-mode').removeClass('d-none').find('input').focus().select();
        });

        // ✅ Batal edit
        $(document).on('click', '.cancel-btn', function() {
            const $td = $(this).closest('td');
            $td.find('.edit-mode').addClass('d-none');
            $td.find('.view-mode').removeClass('d-none');
        });

        // ✅ Simpan perubahan via AJAX
        $(document).on('click', '.save-btn', function() {
            const $btn = $(this);
            const $td = $btn.closest('td');
            const $input = $td.find('input');
            const field = $btn.data('field');
            const value = $input.val().trim();
            const id = $btn.data('id');

            if (!value) {
                showToast('Field tidak boleh kosong', 'warning');
                $input.focus();
                return;
            }

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: `/admin/penerimaan-sk/update-field/${id}`,
                type: 'PUT',
                data: {
                    field: field,
                    value: value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $td.find('.view-mode .value').text(value);
                        $td.find('.edit-mode').addClass('d-none');
                        $td.find('.view-mode').removeClass('d-none');
                        showToast('Data berhasil disimpan', 'success');
                    } else {
                        showToast(response.message || 'Gagal menyimpan data', 'danger');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    showToast('Terjadi kesalahan, coba lagi', 'danger');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-check"></i>');
                }
            });
        });

        // ✅ Enter = Save
        $(document).on('keypress', '.edit-mode input', function(e) {
            if (e.which === 13) {
                $(this).closest('.edit-mode').find('.save-btn').click();
            }
        });
    });
</script>
@endpush
