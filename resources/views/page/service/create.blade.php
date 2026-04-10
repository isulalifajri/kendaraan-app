@extends('layouts.main')

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Monitoring BBM /</span> Tambah
</h4>

<div class="card">
    <div class="card-body">

        <form action="{{ route('service.store') }}" method="POST">
    
            @include('page.service._form')

            <div class="d-flex justify-content-end">
                <a href="{{ route('service.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>
</div>

@endsection