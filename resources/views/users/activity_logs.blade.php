@extends('layout.main')

@section('title', 'User Activity Logs')
@section('subtitle', 'Log Aktifitas Pengguna')

@section('kont')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Log Aktifitas Pengguna</h3>
        <div class="d-flex align-items-center">
            <select id="filterMonth" class="form-control mr-2" style="width: auto;">
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}"
                        {{ $month == request('month', \Carbon\Carbon::now()->month) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select id="filterYear" class="form-control mr-2" style="width: auto;">
                @foreach (range(\Carbon\Carbon::now()->year - 5, \Carbon\Carbon::now()->year + 5) as $year)
                    <option value="{{ $year }}"
                        {{ $year == request('year', \Carbon\Carbon::now()->year) ? 'selected' : '' }}>
                        {{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="activityLogsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Pengguna</th>
                        <th>Aktifitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    @if($log->activity != 'GET users/activity-logs')
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->user->name }} (Role: {{ $log->user->role }})</td>
                        <td>{{ $log->activity }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assetadmin') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assetadmin') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#activityLogsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        });

        $('#filterMonth, #filterYear').on('change', function() {
            var month = $('#filterMonth').val();
            var year = $('#filterYear').val();
            var url = '{{ route('users.activity.logs') }}?month=' + month + '&year=' + year;
            window.location.href = url;
        });
    });
</script>
@endpush
