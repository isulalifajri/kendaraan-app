@extends('layouts.main')

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Page /</span> Persetujuan
</h4>

@foreach($data->take(1) as $dt)
    <p style="font-size: 11px;">
        Data last updated {{ $dt->updated_at->diffForHumans() }}
        <em>({{ $dt->updated_at->format('d M Y - H:i:s') }})</em>
    </p>
@endforeach

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tabel Persetujuan Kendaraan</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pemesanan</th>
                    <th>Level 1</th>
                    <th>Level 2</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $i => $p)
                    @php
                        $lvl1 = $p->persetujuan->where('level', 1)->first();
                        $lvl2 = $p->persetujuan->where('level', 2)->first();
                    @endphp

                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            #{{ $p->id }} <br>
                            <small>{{ $p->kendaraan->nama_kendaraan }} - {{ $p->kendaraan->nomor_polisi }}</small>
                        </td>

                        <!-- LEVEL 1 -->
                        <td>
                            @if($lvl1)
                                <div>
                                    <small>{{ $lvl1->penyetuju->name }}</small><br>
                                    <span class="badge bg-{{ 
                                        $lvl1->status == 'disetujui' ? 'success' : 
                                        ($lvl1->status == 'ditolak' ? 'danger' : 'warning') }}">
                                        {{ $lvl1->status }}
                                    </span>
                                </div>
                            @endif
                        </td>

                        <!-- LEVEL 2 -->
                        <td>
                            @if($lvl2)
                                <div>
                                    <small>{{ $lvl2->penyetuju->name }}</small><br>

                                    @if($lvl1 && $lvl1->status == 'disetujui')
                                        <span class="badge bg-{{ 
                                            $lvl2->status == 'disetujui' ? 'success' : 
                                            ($lvl2->status == 'ditolak' ? 'danger' : 'warning') }}">
                                            {{ $lvl2->status }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Menunggu Level 1
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <!-- STATUS PEMESANAN -->
                        <td>
                            @if($p->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($p->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection