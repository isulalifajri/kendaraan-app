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
                                    {{-- TOMBOL MUNCUL HANYA UNTUK PENYETUJU --}}
                                    @if(auth()->id() == $lvl1->penyetuju_id && $lvl1->status == 'menunggu')
                                        <button class="btn btn-sm btn-primary mt-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLvl1{{ $lvl1->id }}">
                                            Update
                                        </button>
                                    @endif
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

                                        {{-- TOMBOL LEVEL 2 --}}
                                        @if(auth()->id() == $lvl2->penyetuju_id && $lvl2->status == 'menunggu')
                                            <button class="btn btn-sm btn-primary mt-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalLvl2{{ $lvl2->id }}">
                                                Approve
                                            </button>
                                        @endif

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


                    </tr>

                    {{-- MODAL LEVEL 1 --}}
                    @if($lvl1)
                    <div class="modal fade" id="modalLvl1{{ $lvl1->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('approval.update', $lvl1->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Persetujuan Level 1</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <select name="status" class="form-select">
                                            <option value="disetujui">Setujui</option>
                                            <option value="ditolak">Tolak</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif


                    {{-- MODAL LEVEL 2 --}}
                    @if($lvl2)
                    <div class="modal fade" id="modalLvl2{{ $lvl2->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('approval.update', $lvl2->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Persetujuan Level 2</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <select name="status" class="form-select">
                                            <option value="disetujui">Setujui</option>
                                            <option value="ditolak">Tolak</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

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