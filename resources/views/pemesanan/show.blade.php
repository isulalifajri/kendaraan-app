@extends('layouts.main')

@section('content')

<h4 class="mb-4">Detail Pemesanan</h4>

<div class="row">

    <!-- LEFT: DETAIL -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header fw-bold">
                Informasi Pemesanan
            </div>

            <div class="card-body">

                <div class="mb-2">
                    <small class="text-muted">Pengguna</small>
                    <div>{{ $data->user->name }}</div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Kendaraan</small>
                    <div>
                        {{ $data->kendaraan->nama_kendaraan }} 
                        <span class="text-muted">({{ $data->kendaraan->nomor_polisi }})</span>
                    </div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Driver</small>
                    <div>{{ $data->driver->nama ?? '-' }}</div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Tanggal</small>
                    <div>
                        {{ $data->tanggal_mulai }} <br>
                        <small class="text-muted">s/d {{ $data->tanggal_selesai }}</small>
                    </div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Tujuan</small>
                    <div>{{ $data->tujuan }}</div>
                </div>

                <div class="mt-3">
                    <small class="text-muted">Status</small><br>

                    <span class="badge px-3 py-2 bg-{{ 
                        $data->status == 'disetujui' ? 'success' : 
                        ($data->status == 'ditolak' ? 'danger' : 'warning') }}">
                        {{ ucfirst($data->status) }}
                    </span>
                </div>

            </div>
        </div>
    </div>


    <!-- RIGHT: PERSETUJUAN -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                Timeline Persetujuan
            </div>

            <div class="card-body">

                @foreach($data->persetujuan->sortBy('level') as $ps)
                    <div class="d-flex mb-3 align-items-start">

                        <!-- ICON -->
                        <div class="me-3">
                            <span class="badge rounded-circle p-2 bg-{{ 
                                $ps->status == 'disetujui' ? 'success' : 
                                ($ps->status == 'ditolak' ? 'danger' : 'secondary') }}">
                                {{ $ps->level }}
                            </span>
                        </div>

                        <!-- CONTENT -->
                        <div>
                            <div class="fw-semibold">
                                {{ $ps->penyetuju->name }}
                            </div>

                            <small class="text-muted">
                                Level {{ $ps->level }}
                            </small>

                            <div class="mt-1">
                                <span class="badge bg-{{ 
                                    $ps->status == 'disetujui' ? 'success' : 
                                    ($ps->status == 'ditolak' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($ps->status) }}
                                </span>
                            </div>

                            @if($ps->tanggal_persetujuan)
                                <small class="text-muted d-block mt-1">
                                    {{ \Carbon\Carbon::parse($ps->tanggal_persetujuan)->format('d M Y - H:i') }}
                                </small>
                            @endif

                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr class="my-2">
                    @endif
                @endforeach

            </div>
        </div>
    </div>

</div>

<a href="{{ route('pemesanan.index') }}" class="btn btn-secondary mt-3">
    Kembali
</a>

@endsection