@extends('layouts.admin')

@section('admin-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3 mb-0 text-gray-800">Daftar Penyerahan SK</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="20%">Nama Pemohon</th>
                            <th width="20%">Jenis Izin</th>
                            <th width="15%" class="text-center">Tanggal Terbit</th>
                            <th width="20%" class="text-center">No. SK</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ $item->personalData->nama ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $item->personalData->izinPengajuan->first()->jenisIzin->nama_izin ?? 'N/A' }}
                                </td>
                                {-- Tanggal Terbit --}}
                                <td>
                                    @php
                                        $isSerahTerima = is_array($item) ? $item['is_serah_terima'] ?? false : false;
                                        $tanggalTerbit = is_array($item)
                                            ? $item['tanggal_terbit'] ?? now()->toDateString()
                                            : $item->tanggal_terbit ?? now()->toDateString();
                                        $formattedDate = \Carbon\Carbon::parse($tanggalTerbit)->format('d/m/Y');
                                        $personalDataId = is_array($item)
                                            ? $item['personal_data_id'] ?? ($item['id'] ?? '')
                                            : $item->personal_data_id ?? '';
                                    @endphp
                                    <div class="view-mode">
                                        <span class="value">{{ $formattedDate }}</span>

                                    </div>

                                    <input type="hidden" class="tanggal-terbit" value="{{ $tanggalTerbit }}" />
                                </td>

                                <td class="text-center">
                                    {{ $item->no_sk_izin ?? '-' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.penyerahan-sk.create', ['penerimaan_sk_id' => $item->id]) }}"
                                        class="btn btn-sm btn-success" title="Proses Penyerahan SK">
                                        <i class="fas fa-check"></i> Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="empty-state py-5">
                                        <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                                        <p class="mb-0 text-muted">Tidak ada data yang perlu diproses</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 0.5rem;
        }

        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #fff;
            background-color: #212529;
            border: none;
            padding: 12px 15px;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            font-size: 0.9rem;
            color: #333;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
@endpush
