@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Page /</span> {{  request()->path() }} </h4>

    @foreach($drivers->sortByDesc('updated_at')->take(1) as $dt)
        <p style="font-size: 11px;">Data last updated {{ $dt->updated_at->diffForHumans() }} <em> ({{ $dt->updated_at->format('d M Y - H:i:s') }})</em></p>
    @endforeach
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabel Data Driver</h5>
            </div>
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href=#0 class="dt-button create-new btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span><i class="bx bx-plus me-sm-1"></i> 
                            <span class="d-none d-sm-inline-block">Add New Driver</span>
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
                <th>Nama</th>
                <th>No. HP</th>
                <th>Status</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($drivers as $paginate => $driver)
                    <tr>
                        <td>{{ $drivers->firstItem() + $paginate }}</td>
                        <td class="t-wrap">{{$driver->nama }}</td>  
                        <td>{{ $driver->no_hp }}</td>
                        <td>
                            @if($driver->status == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-warning">Bertugas</span>
                            @endif
                        </td>
            
                        <td> 
                            <div class="d-flex gap-1">
                                <a class="btn btn-warning btn-sm text-white" href="#0" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $driver->id }}"> 
                                <i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <form method="POST" action="{{ route('driver.destroy', $driver->id) }}" enctype="multipart/form-data" >
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
            {{ $drivers->links('pagination::bootstrap-5') }}
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Driver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('driver.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Driver</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Handphone</label>
                                <input type="text" class="form-control" name="no_hp" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="bertugas">Bertugas</option>
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
        @foreach ($drivers as $driver)
            <div class="modal fade" id="exampleModal{{ $driver->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('driver.update', $driver->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama Driver</label>
                                    <input type="text" class="form-control" name="nama"
                                    value="{{ old('nama', $driver->nama) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Handphone</label>
                                    <input type="text" class="form-control" name="no_hp"
                                    value="{{ old('no_hp', $driver->no_hp) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                     <select class="form-select" name="status" required>
                                        <option value="tersedia" {{ $driver->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="bertugas" {{ $driver->status == 'bertugas' ? 'selected' : '' }}>Bertugas</option>
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