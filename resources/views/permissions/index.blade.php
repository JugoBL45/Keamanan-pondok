@extends('layout.main')

@section('title', 'Permissions')
@section('subtitle', 'Daftar Perizinan')
@section('home', 'Perizinan')
@section('page', 'Perizinan')

@push('css_vendor')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assetadmin') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assetadmin') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables (if used) -->
    <link rel="stylesheet" href="{{ asset('assetadmin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endpush

@section('kont')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Perizinan</h3>
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#permissionModal"
                id="createPermissionBtn"><i class="fas fa-plus mr-1"></i>Tambah Izin Santri</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="permissionsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Santri</th>
                            <th>Alasan</th>
                            <th>Tanggal Izin</th>
                            <th>Tanggal Kembali</th>
                            <th>Jam Saat Ini</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr id="permissionRow_{{ $permission->id }}" data-permission-id="{{ $permission->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->santri->nama }}</td>
                                <td>{{ $permission->reason }}</td>
                                <td>{{ $permission->start_time }}</td>
                                <td id="end_time_{{ $permission->id }}">{{ $permission->end_time }}</td>
                                <td id="current_time_{{ $permission->id }}">
                                    {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</td>
                                <td id="status_{{ $permission->id }}">
                                    @if ($permission->status == 'Tepat Waktu')
                                        <span class="font-weight-bold text-success">Tepat Waktu</span>
                                    @elseif ($permission->status == 'Telat')
                                        <span class="font-weight-bold text-danger">Telat</span>
                                    @else
                                        <span class="font-weight-bold">Belum Kembali</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-warning editPermissionBtn mr-1"
                                            data-id="{{ $permission->id }}"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                            class="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mr-1"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                        @if ($permission->status == 'Belum Kembali' && $permission->status != 'telat')
                                            <button class="btn btn-success markReturnedBtn"
                                                data-id="{{ $permission->id }}"><i class="fas fa-check"></i>
                                                Kembali</button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Tambah/Edit Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="permissionForm">
                        @csrf
                        <input type="hidden" id="permission_id">
                        <div class="form-group">
                            <label for="id_santri">Nama Santri</label>
                            <select class="form-control select2bs4" id="id_santri" name="id_santri" required>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id_santri }}">{{ $santri->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reason">Alasan</label>
                            <input type="text" class="form-control" id="reason" name="reason" required>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Waktu Mulai Perizinan</label>
                            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="end_time">Waktu Akhir Perizinan</label>
                            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="savePermissionBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_vendor')
    <script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables (if used) -->
    <script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
@endpush


@push('js')
    <script>
        $(document).ready(function() {
            function updateCurrentDateTime() {
                var currentDateTime = new Date().toLocaleString();
                $('[id^="current_time_"]').text(currentDateTime);
                updateStatus(); // Panggil fungsi updateStatus setiap kali waktu diperbarui
            }

            // Update waktu saat ini setiap detik
            setInterval(updateCurrentDateTime, 1000);

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#permissionsTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });

            $('#createPermissionBtn').on('click', function() {
                try {
                    $('.select2bs4').select2({
                        theme: 'bootstrap4',
                        placeholder: 'Pilih salah satu',
                        allowClear: true
                    });
                } catch (e) {
                    console.error('Error initializing Select2:', e);
                }

                $('#permissionModalLabel').text('Tambah Permission');
                $('#permissionForm').attr('action', '{{ route('permissions.store') }}');
                $('#permissionForm').trigger('reset');
                $('#permission_id').val('');
            });

            $('.editPermissionBtn').on('click', function() {
                var id = $(this).data('id');
                $.get('{{ route('permissions.index') }}/' + id + '/edit', function(data) {
                    $('#permissionModalLabel').text('Edit Permission');
                    $('#permissionForm').attr('action', '{{ route('permissions.index') }}/' + id);
                    $('#permission_id').val(data.id);
                    $('#id_santri').val(data.id_santri).trigger('change');
                    $('#reason').val(data.reason);
                    $('#start_time').val(data.start_time.replace(' ', 'T'));
                    $('#end_time').val(data.end_time.replace(' ', 'T'));
                    $('#permissionModal').modal('show');
                });
            });

            $('#permissionForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#permission_id').val();
                var url = id ? '{{ route('permissions.index') }}/' + id :
                    '{{ route('permissions.store') }}';
                var method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('.markReturnedBtn').on('click', function() {
                var id = $(this).data('id');
                $.post('{{ route('permissions.markReturned') }}', {
                    id: id,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    location.reload();
                }).fail(function(xhr) {
                    console.log(xhr.responseText);
                });
            });

            $('.deleteForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Check and update status based on current time vs end_time
            function updateStatus() {
                $('[id^="permissionRow_"]').each(function() {
                    var permissionId = $(this).data('permission-id');
                    var endDateTime = new Date($('#end_time_' + permissionId).text()).getTime();
                    var currentDateTime = new Date().getTime();

                    if ($('#status_' + permissionId).text().trim() === 'Belum Kembali' && currentDateTime >
                        endDateTime) {
                        // Update status to 'Telat'
                        $('#status_' + permissionId).html(
                            '<span class="font-weight-bold text-danger">Telat</span>');

                        // Update status in database and add violation
                        $.post('{{ route('permissions.updateStatus') }}', {
                            id: permissionId,
                            _token: '{{ csrf_token() }}'
                        }, function(response) {
                            console.log('Status updated in database and violation added');
                        }).fail(function(xhr) {
                            console.log(xhr.responseText);
                        });
                    }
                });
            }

            // Update status initially
            updateStatus();
        });
    </script>
@endpush
