@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Page /</span> Service
</h4>

@foreach($services->sortByDesc('updated_at')->take(1) as $dt)
    <p style="font-size: 11px;">
        Data last updated {{ $dt->updated_at->diffForHumans() }}
        <em>({{ $dt->updated_at->format('d M Y - H:i:s') }})</em>
    </p>
@endforeach

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tabel Jadwal Service</h5>

        <a href="{{ route('service.create') }}" class="btn btn-primary">
            + Tambah
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Tanggal Service</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($services as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $p->kendaraan->nama_kendaraan ?? '-' }}
                            <br>
                            <small>{{ $p->kendaraan->nomor_polisi ?? '' }}</small>
                        </td>

                        <td>{{ $p->tanggal_service ?? '-' }}</td>

                        <td>
                            {{ $p->keterangan }}
                        </td>

                        <td>
                            @if($p->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>
                            @else
                                <span class="badge bg-info">Selesai</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('service.edit', $p->id) }}" 
                                class="btn btn-warning btn-sm text-white">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('service.destroy', $p->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

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