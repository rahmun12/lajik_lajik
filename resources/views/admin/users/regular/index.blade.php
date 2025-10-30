@extends('admin.layouts.sidebar')

@section('title', 'Kelola Penerimaan SK')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar User</h5>
        <!-- <a href="{{ route('admin.users.regular.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a> -->
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No. SK Izin</th>
                        <th>Alamat</th>
                        <th>Petugas Menyerahkan</th>
                        <th>Petugas Menerima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerimaanSk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->personalData->nama ?? 'N/A' }}</td>
                        <td>{{ $item->no_sk_izin }}</td>
                        <td>{{ $item->personalData->alamat_jalan ?? 'N/A' }}, RT {{ $item->personalData->rt ?? '' }}/RW {{ $item->personalData->rw ?? '' }}, {{ $item->personalData->kelurahan ?? '' }}, {{ $item->personalData->kecamatan ?? '' }}</td>
                        <td>{{ $item->petugas_menyerahkan }}</td>
                        <td>{{ $item->petugas_menerima }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.users.regular.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.regular.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data penerimaan SK.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $penerimaanSk->links() }}
        </div>
    </div>
</div>
@endsection
