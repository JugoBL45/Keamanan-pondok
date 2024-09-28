@extends('layout.main')

@section('title', 'Master Level')
@section('subtitle', 'Daftar Master Level')
@section('home', 'Master')
@section('page', 'Master Level')

@section('kont')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Master Level</h3>
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#masterLevelCreateModal"
                id="createMasterLevelBtn"><i class="fas fa-plus mr-1"></i>Tambah Master Level</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="masterLevelTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Level</th>
                            <th>Denda</th>
                            <th>Hukuman</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterLevels as $masterLevel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $masterLevel->level }}</td>
                                <td>Rp {{ number_format($masterLevel->denda, 0, ',', '.') }}</td>
                                <td>{{ $masterLevel->hukuman }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning editMasterLevelBtn"
                                        data-id="{{ $masterLevel->id }}"><i class="fa fa-edit"></i></button>
                                    <form action="{{ route('master_level.destroy', $masterLevel->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="masterLevelCreateModal" tabindex="-1" role="dialog" aria-labelledby="masterLevelCreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="masterLevelCreateModalLabel">Tambah Master Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="masterLevelCreateForm" method="POST" action="{{ route('master_level.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="createLevel">Level</label>
                            <input type="number" class="form-control" id="createLevel" name="level" required>
                        </div>
                        <div class="form-group">
                            <label for="createDenda">Denda</label>
                            <input type="text" class="form-control" id="createDenda" name="denda">
                        </div>
                        <div class="form-group">
                            <label for="createHukuman">Hukuman</label>
                            <input type="text" class="form-control" id="createHukuman" name="hukuman">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="masterLevelEditModal" tabindex="-1" role="dialog" aria-labelledby="masterLevelEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="masterLevelEditModalLabel">Edit Master Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="masterLevelEditForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editMasterLevelId" name="id">
                        <div class="form-group">
                            <label for="editLevel">Level</label>
                            <input type="number" class="form-control" id="editLevel" name="level" required>
                        </div>
                        <div class="form-group">
                            <label for="editDenda">Denda</label>
                            <input type="text" class="form-control" id="editDenda" name="denda">
                        </div>
                        <div class="form-group">
                            <label for="editHukuman">Hukuman</label>
                            <input type="text" class="form-control" id="editHukuman" name="hukuman">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#masterLevelTable').DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
        });

        $('#createMasterLevelBtn').on('click', function() {
            $('#masterLevelCreateForm').trigger('reset');
        });

        $('#masterLevelTable').on('click', '.editMasterLevelBtn', function() {
            var id = $(this).data('id');
            $.get('{{ route('master_level.index') }}/' + id + '/edit', function(data) {
                $('#editMasterLevelId').val(data.id);
                $('#editLevel').val(data.level);
                $('#editDenda').val(data.denda);
                $('#editHukuman').val(data.hukuman);
                $('#masterLevelEditForm').attr('action', '{{ route('master_level.update', '') }}/' + id);
                $('#masterLevelEditModal').modal('show');
            });
        });

        $('#masterLevelEditForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#masterLevelEditModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
