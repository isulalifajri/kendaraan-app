@extends('layouts.main')

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Monitoring BBM /</span> Edit
</h4>

<div class="card">
    <div class="card-body">

       <form action="{{ route('bbm.update', $bbm->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('page.bbm._form')

            <div class="d-flex justify-content-end">
                <a href="{{ route('bbm.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>

@endsection