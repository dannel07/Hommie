@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Akun Owner</h1>
    <a href="{{ route('super_admin.entrepreneurs.create') }}" class="btn btn-primary">Tambah Akun Owner Baru</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entrepreneurs as $entrepreneur)
            <tr>
                <td>{{ $entrepreneur->id }}</td>
                <td>{{ $entrepreneur->name }}</td>
                <td>{{ $entrepreneur->email }}</td>
                <td>
                    <a href="{{ route('super_admin.entrepreneurs.edit', $entrepreneur->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('super_admin.entrepreneurs.destroy', $entrepreneur->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection