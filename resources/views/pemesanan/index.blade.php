@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Page /</span> Pemesanan
</h4>

@foreach($data->sortByDesc('updated_at')->take(1) as $dt)
    <p style="font-size: 11px;">
        Data last updated {{ $dt->updated_at->diffForHumans() }}
        <em>({{ $dt->updated_at->format('d M Y - H:i:s') }})</em>
    </p>
@endforeach

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tabel Pemesanan Kendaraan</h5>

        <a href="{{ route('pemesanan.create') }}" class="btn btn-primary">
            + Tambah Pemesanan
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Kendaraan</th>
                    <th>Driver</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>{{ $p->user->name ?? '-' }}</td>

                        <td>
                            {{ $p->kendaraan->nama_kendaraan ?? '-' }}
                            <br>
                            <small>{{ $p->kendaraan->nomor_polisi ?? '' }}</small>
                        </td>

                        <td>{{ $p->driver->nama ?? '-' }}</td>

                        <td>
                            {{ $p->tanggal_mulai }} <br>
                            s/d {{ $p->tanggal_selesai }}
                        </td>

                        <td>{{ $p->tujuan }}</td>

                        <td>
                            @if($p->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($p->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1">

                                @if($p->status == 'menunggu')
                                    <a href="{{ route('pemesanan.edit', $p->id) }}" 
                                    class="btn btn-warning btn-sm text-white">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('pemesanan.destroy', $p->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('pemesanan.show', $p->id) }}" 
                                        class="btn btn-info btn-sm text-white">
                                        View
                                    </a>
                                @endif

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection