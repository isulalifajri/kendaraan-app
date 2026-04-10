@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Page /</span> {{  request()->path() }} </h4>

    @foreach($kendaraans->sortByDesc('updated_at')->take(1) as $dt)
        <p style="font-size: 11px;">Data last updated {{ $dt->updated_at->diffForHumans() }} <em> ({{ $dt->updated_at->format('d M Y - H:i:s') }})</em></p>
    @endforeach
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabel Data Kendaraan</h5>
            </div>
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href=#0 class="dt-button create-new btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span><i class="bx bx-plus me-sm-1"></i> 
                            <span class="d-none d-sm-inline-block">Add New Kendaraan</span>
                        </span>
                    </a> 
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive text-nowrap">
            <table id="example" class="datatables-basic table table-hover table-striped">
            <thead>
                <tr>
                <th>No</th>
                <th>Nama Kendaraan</th>
                <th>jenis</th>
                <th>Kepemilikan</th>
                <th>Nomor Polisi</th>
                <th>Status</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($kendaraans as $paginate => $kendaraan)
                    <tr>
                        <td>{{ $kendaraans->firstItem() + $paginate }}</td>
                        <td class="t-wrap">{{$kendaraan->nama_kendaraan }}</td>  
                        <td>{{ $kendaraan->jenis }}</td>
                        <td>{{ $kendaraan->kepemilikan }}</td>
                        <td>{{ $kendaraan->nomor_polisi }}</td>
                        <td>
                            @if($kendaraan->status == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif($kendaraan->status == 'digunakan')
                                <span class="badge bg-primary">Digunakan</span>
                            @else
                                <span class="badge bg-warning">Service</span>
                            @endif
                        </td>
            
                        <td> 
                            <div class="d-flex gap-1">
                                <a class="btn btn-warning btn-sm text-white" href="#0" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $kendaraan->id }}"> 
                                <i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <form method="POST" action="{{ route('kendaraan.destroy', $kendaraan->id) }}" enctype="multipart/form-data" >
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-2"></i> Trash</button>
                                </form>
                            </div>     
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center">Data Table is Not Found</td></tr>
                    @endforelse
            </tbody>
            </table>
        </div>

        <div class="p-2">
            {{ $kendaraans->links('pagination::bootstrap-5') }}
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Kendaraan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('kendaraan.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Kendaraan</label>
                                <input type="text" class="form-control" name="nama_kendaraan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="form-select" name="jenis" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="angkutan orang">Angkutan Orang</option>
                                    <option value="angkutan barang">Angkutan Barang</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kepemilikan</label>
                                <select class="form-select" name="kepemilikan" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="perusahaan">Perusahaan</option>
                                    <option value="sewa">Sewa</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Polisi</label>
                                <input type="text" class="form-control" name="nomor_polisi" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="digunakan">Digunakan</option>
                                    <option value="service">Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        @foreach ($kendaraans as $kendaraan)
            <div class="modal fade" id="exampleModal{{ $kendaraan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kendaraan</label>
                                    <input type="text" class="form-control" name="nama_kendaraan"
                                        value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis</label>
                                    <select class="form-select" name="jenis" required>
                                        <option value="angkutan orang" {{ $kendaraan->jenis == 'angkutan orang' ? 'selected' : '' }}>Angkutan Orang</option>
                                        <option value="angkutan barang" {{ $kendaraan->jenis == 'angkutan barang' ? 'selected' : '' }}>Angkutan Barang</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kepemilikan</label>
                                    <select class="form-select" name="kepemilikan" required>
                                        <option value="perusahaan" {{ $kendaraan->kepemilikan == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                        <option value="sewa" {{ $kendaraan->kepemilikan == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Polisi</label>
                                    <input type="text" class="form-control" name="nomor_polisi"
                                        value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="tersedia" {{ $kendaraan->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="digunakan" {{ $kendaraan->status == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                                        <option value="service" {{ $kendaraan->status == 'service' ? 'selected' : '' }}>Service</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection