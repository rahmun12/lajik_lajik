@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 mb-0 text-gray-800">Rekapitulasi Penerimaan Permohonan Perizinan Layanan Khusus</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
       
<a href="{{ route('admin.rekapitulasi-penerimaan.export') }}" class="btn btn-success btn-sm ms-2" id="exportExcel">
    <i class="fas fa-file-excel"></i> Export Excel
</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="rekapitulasiTable">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Nama Pemohon</th>
                        <th>Alamat</th>
                        <th>Jenis Izin</th>
                        <th>Nama Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items ?? [] as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_penerimaan)->format('d/m/Y') }}</td>
                        <td>{{ $item->nama_pemohon ?? 'N/A' }}</td>
                        <td>{{ $item->alamat ?? 'N/A' }}</td>
                        <td>{{ $item->jenis_izin ?? 'N/A' }}</td>
                        <td>{{ $item->nama_petugas ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#rekapitulasiTable').DataTable({
            "pageLength": 10,
            "order": [
                [1, 'desc']
            ], // Default sort by date descending
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        // Export to Excel
        $('#exportExcel').on('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route("admin.rekapitulasi-penerimaan.export") }}';
        });
    });
</script>
@endpush

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .table> :not(:first-child) {
        border-top: none;
    }
</style>
@endsection