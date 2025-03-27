@extends('layouts.index-welcome')
@section('content')

<div class="container">
    <div class="card shadow-lg">
    <img src="{{ url('storage/property_images/' . $property->image) }}" class="card-img-top" alt="{{ $property->name }}">
        <div class="card-body">
            <h3 class="fw-bold">{{ $property->name }}</h3> {{-- Mengganti property_name ke name --}}
            <p>{{ $property->description ?? 'Deskripsi tidak tersedia' }}</p>
            <h5 class="text-success fw-bold">Rp {{ number_format($property->price, 0, ',', '.') }}/bulan</h5>
            <a href="{{ route('landingpage') }}" class="btn btn-primary mt-3">Kembali</a>
        </div>
    </div>
</div>

@endsection
