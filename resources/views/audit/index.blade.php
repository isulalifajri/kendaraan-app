@extends('layouts.main')

@section('content')
    
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Page /</span> {{  request()->path() }} </h4>

    @foreach($logs->sortByDesc('updated_at')->take(1) as $dt)
        <p style="font-size: 11px;">Data last updated {{ $dt->updated_at->diffForHumans() }} <em> ({{ $dt->updated_at->format('d M Y - H:i:s') }})</em></p>
    @endforeach
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Log Activity</h5>
            </div>
        </div>
        <div class="card-datatable table-responsive text-nowrap">
            <table id="example" class="datatables-basic table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Model</th>
                    <th>Perubahan</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($logs as $paginate => $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $paginate }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ $log->event }}</td>
                        <td>{{ class_basename($log->auditable_type) }}</td>
                        <td style="width:350px; word-wrap:break-word; white-space:normal;word-break: break-word;">
                            {{ json_encode($log->new_values) }}
                        </td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center">Data Table is Not Found</td></tr>
                    @endforelse
            </tbody>
            </table>
        </div>

        <div class="p-2">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection