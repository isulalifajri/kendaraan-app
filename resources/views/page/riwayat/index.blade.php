@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Page /</span> Riwayat Kendaraan
</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pemakaian Kendaraan</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Nama Driver</th>
                    <th>Tanggal Dipakai</th>
                    <th>Tujuan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($riwayats as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $p->kendaraan->nama_kendaraan ?? '-' }}
                            <br>
                            <small>{{ $p->kendaraan->nomor_polisi ?? '' }}</small>
                        </td>

                        <td>{{ $p->driver->nama ?? '-' }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} <br>
                            s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td>{{ $p->tujuan }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak Ada Data
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection