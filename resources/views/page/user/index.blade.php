@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Page /</span> {{  request()->path() }} </h4>

    @foreach($users->sortByDesc('updated_at')->take(1) as $dt)
        <p style="font-size: 11px;">Data last updated {{ $dt->updated_at->diffForHumans() }} <em> ({{ $dt->updated_at->format('d M Y - H:i:s') }})</em></p>
    @endforeach
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Tabel Data User</h5>
            </div>
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href=#0 class="dt-button create-new btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span><i class="bx bx-plus me-sm-1"></i> 
                            <span class="d-none d-sm-inline-block">Add New User</span>
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
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $paginate => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $paginate }}</td>
                        <td class="t-wrap">{{$user->name }}</td>  
                        
                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-success">Admin</span>
                            @else
                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                            @endif
                        </td>
            
                        <td> 
                            <div class="d-flex gap-1">
                                <a class="btn btn-warning btn-sm text-white" href="#0" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $user->id }}"> 
                                <i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <form method="POST" action="{{ route('user.destroy', $user->id) }}" enctype="multipart/form-data" >
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
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama User" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Email User" required />
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" name="role" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="penyetuju">Penyetuju</option>
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
        @foreach ($users as $user)
            <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama User" required />
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