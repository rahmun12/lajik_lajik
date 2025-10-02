@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Penerimaan SK</h1>
        <a href="{{ route('penerimaan-sk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('penerimaan-sk.update', $penerimaanSk->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.penerimaan-sk._form')
            </form>
        </div>
    </div>
</div>
@endsection
