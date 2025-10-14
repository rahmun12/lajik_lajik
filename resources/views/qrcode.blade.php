@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h3>Scan QR Code untuk membuka halaman web</h3>
    <div class="my-4">
        {{-- Menampilkan QR Code langsung di halaman --}}
        {!! QrCode::size(200)->generate($url) !!}
    </div>
    <p>Atau klik link ini: 
        <a href="{{ $url }}">{{ $url }}</a>
    </p>
</div>
@endsection
