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
                        <th>Jenis Izin</th>
                        <th>Tanggal Terbit</th>
                        <th>No. SK Izin</th>
                        <th>Petugas Menyerahkan</th>
                        <th>Petugas Menerima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @php
                            if (is_array($item)) {
                            $nama = $item['personal_data']['nama'] ?? 'N/A';
                            } else {
                            $nama = $item->personalData ? $item->personalData->nama : 'N/A';
                            }
                            @endphp
                            {{ $nama }}
                        </td>
                        <td>
                            @php
                            if (is_array($item)) {
                            if (isset($item['jenis_izin']) && is_array($item['jenis_izin'])) {
                            $jenisIzin = $item['jenis_izin']['nama_izin'] ?? 'N/A';
                            } else {
                            // For serah_terima records, get jenis_izin from the relationship
                            $jenisIzin = isset($item['personal_data']['izin_pengajuan'][0]['jenis_izin']['nama_izin'])
                            ? $item['personal_data']['izin_pengajuan'][0]['jenis_izin']['nama_izin']
                            : 'N/A';
                            }
                            } else {
                            $jenisIzin = $item->personalData && $item->personalData->izinPengajuan->isNotEmpty()
                            ? ($item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A')
                            : 'N/A';
                            }
                            @endphp
                            {{ $jenisIzin }}
                        </td>

                        {{-- Tanggal Terbit --}}
                        <td>
                            @php
                            $isSerahTerima = is_array($item) ? ($item['is_serah_terima'] ?? false) : false;
                            $tanggalTerbit = is_array($item) ?
                            ($item['tanggal_terbit'] ?? now()->toDateString()) :
                            ($item->tanggal_terbit ?? now()->toDateString());
                            $formattedDate = \Carbon\Carbon::parse($tanggalTerbit)->format('d/m/Y');
                            $personalDataId = is_array($item) ?
                            ($item['personal_data_id'] ?? $item['id'] ?? '') :
                            ($item->personal_data_id ?? '');
                            @endphp
                            <div class="view-mode">
                                <span class="value">{{ $formattedDate }}</span>
                                @if(!$isSerahTerima)
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                                @endif
                            </div>
                            @if(!$isSerahTerima)
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="date" class="form-control" value="{{ $tanggalTerbit }}" />
                                    <button class="btn btn-success save-btn" data-field="tanggal_terbit" data-id="{{ $personalDataId }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-secondary cancel-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <input type="hidden" class="tanggal-terbit" value="{{ $tanggalTerbit }}" />
                        </td>

                        {{-- No SK Izin --}}
                        <td>
                            @php
                            $noSkIzin = is_array($item) ? ($item['no_sk_izin'] ?? '') : ($item->no_sk_izin ?? '');
                            $personalDataId = is_array($item) ? ($item['personal_data_id'] ?? $item['id'] ?? '') : $item->personal_data_id;
                            @endphp
                            <div class="view-mode">
                                <span class="value">{{ $noSkIzin ?: 'isi no sk' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $noSkIzin }}" />
                                    <button class="btn btn-success save-btn" data-field="no_sk_izin" data-id="{{ $personalDataId }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-secondary cancel-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                        {{-- Petugas Menyerahkan --}}
                        <td>
                            @php
                            // Get the petugas_menerima value to show in petugas_menyerahkan field
                            $petugasMenyerahkan = is_array($item) ? ($item['petugas_menerima'] ?? '') : ($item->petugas_menerima ?? '');
                            $personalDataId = is_array($item) ? ($item['personal_data_id'] ?? $item['id'] ?? '') : $item->personal_data_id;
                            @endphp
                            <div class="view-mode">
                                <span class="value">{{ $petugasMenyerahkan ?: 'isi nama' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $petugasMenyerahkan }}" />
                                    <button class="btn btn-success save-btn" data-field="petugas_menyerahkan" data-id="{{ $personalDataId }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-secondary cancel-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                        {{-- Petugas Menerima --}}
                        <td>
                            @php
                            // Get the petugas_menyerahkan value to show in petugas_menerima field
                            $petugasMenerima = is_array($item) ? ($item['petugas_menyerahkan'] ?? '') : ($item->petugas_menyerahkan ?? '');
                            $personalDataId = is_array($item) ? ($item['personal_data_id'] ?? $item['id'] ?? '') : $item->personal_data_id;
                            @endphp
                            <div class="view-mode">
                                <span class="value">{{ $petugasMenerima ?: 'isi nama' }}</span>
                                <button class="btn btn-sm btn-link edit-btn"><i class="fas fa-edit"></i></button>
                            </div>
                            <div class="edit-mode d-none">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $petugasMenerima }}" />
                                    <button class="btn btn-success save-btn" data-field="petugas_menerima" data-id="{{ $personalDataId }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-secondary cancel-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                            // Debug: Tampilkan data item untuk pengecekan
                            if (app()->environment('local')) {
                                echo "<script>console.log('Item Data:', " . json_encode($item) . ")</script>";
                            }
                            
                            // Default status adalah Menunggu
                            $status = 'Menunggu';
                            $badgeClass = 'bg-warning';
                            $hasPenyerahanSk = false;
                            
                            // Cek apakah ini data dari tabel penerimaan_sk atau serah_terima
                            $isFromPenerimaan = !isset($item['id']) || !is_string($item['id']) || !str_starts_with($item['id'], 'st-');
                            
                            if ($isFromPenerimaan) {
                                // Jika dari penerimaan_sk, cek apakah sudah ada penyerahan_sk
                                if (is_array($item)) {
                                    // Cek langsung dari is_serah_terima jika ada
                                    if (isset($item['is_serah_terima'])) {
                                        $hasPenyerahanSk = (bool)$item['is_serah_terima'];
                                    } 
                                    // Jika tidak ada, cek dari penyerahan_sk
                                    elseif (isset($item['penyerahan_sk']) && is_array($item['penyerahan_sk'])) {
                                        $hasPenyerahanSk = !empty($item['penyerahan_sk']);
                                    }
                                    
                                    // Debug log
                                    if (app()->environment('local')) {
                                        $logData = [
                                            'is_serah_terima' => $item['is_serah_terima'] ?? null,
                                            'has_penyerahan_sk' => $hasPenyerahanSk,
                                            'penyerahan_sk_exists' => isset($item['penyerahan_sk'])
                                        ];
                                        $logDataJson = json_encode($logData);
                                        $itemId = is_array($item) ? ($item['id'] ?? 'unknown') : $item->id;
                                        echo "<script>
                                            console.log('Pengecekan Status - ID: " . $itemId . "', " . addslashes($logDataJson) . ");
                                        </script>";
                                    }
                                } else {
                                    $hasPenyerahanSk = $item->relationLoaded('penyerahanSk') && $item->penyerahanSk !== null;
                                }
                                
                                if ($hasPenyerahanSk) {
                                    $status = 'Sudah Diproses';
                                    $badgeClass = 'bg-success';
                                }
                            } else {
                                // Jika dari serah_terima, selalu tampilkan Sudah Diproses
                                $status = 'Sudah Diproses';
                                $badgeClass = 'bg-success';
                                $hasPenyerahanSk = true;
                            }
                            @endphp
                            <span class="badge {{ $badgeClass }}" title="{{ $status }}">{{ $status }}</span>
                        </td>
                        <td>
                            @if(!$hasPenyerahanSk)
                            @php
                                $penerimaanId = is_array($item) ? $item['id'] : $item->id;
                                $url = route('admin.penyerahan-sk.create', ['penerimaan_sk_id' => $penerimaanId]);
                                if (app()->environment('local')) {
                                    echo "<script>console.log('URL Proses:', {url: '$url', penerimaan_sk_id: '$penerimaanId'})</script>";
                                }
                            @endphp
                            <a href="{{ $url }}"
                                class="btn btn-sm btn-success btn-proses"
                                title="Terima dan Lanjutkan ke Penyerahan SK"
                                data-id="{{ $penerimaanId }}">
                                <i class="fas fa-check"></i> Proses
                            </a>
                            @else
                            <a href="#" class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-check"></i> Selesai
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data penerimaan SK</td>
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
@push('scripts')
<script>
$(document).ready(function() {
    // Debug tombol proses
    $('.btn-proses').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var penerimaanId = $(this).data('id');
        
        console.log('Tombol Proses diklik');
        console.log('URL:', url);
        console.log('penerimaan_sk_id:', penerimaanId);
        
        // Coba akses URL dengan AJAX untuk debugging
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                console.log('Response dari server:', response);
                // Jika berhasil, arahkan ke halaman
                window.location.href = url;
            },
            error: function(xhr, status, error) {
                console.error('Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });
                alert('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
});
</script>
@endpush

@endsection

@push('styles')
<style>
    .edit-btn {
        cursor: pointer;
    }

    .view-mode,
    .edit-mode {
        min-height: 38px;
        display: flex;
        align-items: center;
    }

    .edit-mode .input-group {
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
    }
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