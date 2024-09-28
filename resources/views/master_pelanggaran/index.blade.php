@extends('layout.main')

@section('title', 'Master Pelanggaran')
@section('subtitle', 'Daftar Master Pelanggaran')
@section('home', 'Master')
@section('page', 'Master Pelanggaran')

@section('kont')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Master Pelanggaran</h3>
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#masterPelanggaranCreateModal" id="createMasterPelanggaranBtn">
                <i class="fas fa-plus mr-1"></i>Tambah Master Pelanggaran
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="masterPelanggaranTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Larangan</th>
                            <th class="text-center">Level</th>
                            <th>Denda</th>
                            <th>Hukuman</th>
                            <th class="text-center">Max</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterPelanggarans as $masterPelanggaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $masterPelanggaran->nama }}</td>
                                <td>{{ $masterPelanggaran->larangan }}</td>
                                <td class="text-center">{{ $masterPelanggaran->level }}</td>
                                <td class="rupiah">{{ $masterPelanggaran->denda }}</td>
                                <td>{{ $masterPelanggaran->hukuman }}</td>
                                <td class="text-center">{{ $masterPelanggaran->max }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning editMasterPelanggaranBtn" data-id="{{ $masterPelanggaran->id_mp }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form action="{{ route('master_pelanggaran.destroy', $masterPelanggaran->id_mp) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
    <div class="modal fade" id="masterPelanggaranCreateModal" tabindex="-1" role="dialog" aria-labelledby="masterPelanggaranCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="masterPelanggaranCreateModalLabel">Tambah Master Pelanggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="masterPelanggaranCreateForm" method="POST" action="{{ route('master_pelanggaran.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="larangan">Larangan</label>
                            <select class="form-control" id="larangan" name="larangan" required>
                                <option value="">Pilih Larangan</option>
                                <option value="ADMINISTRASI">Administrasi</option>
                                <option value="ORGANISASI">Organisasi</option>
                                <option value="KEAMANAN">Keamanan</option>
                                <option value="ETIKA">Etika</option>
                                <option value="KEBERSIHAN/KESEHATAN/FASILITAS">Kebersihan/Kesehatan/Fasilitas</option>
                                <option value="PENDIDIKAN DAN IBADAH">Pendidikan dan Ibadah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                @foreach ($masterLevels as $level)
                                    <option value="{{ $level->level }}" data-denda="{{ $level->denda }}" data-hukuman="{{ $level->hukuman }}">
                                        {{ $level->level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="denda">Denda</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="denda" name="denda" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hukuman">Hukuman</label>
                            <input type="text" class="form-control" id="hukuman" name="hukuman" readonly>
                        </div>
                        <div class="form-group">
                            <label for="max">Max</label>
                            <input type="number" class="form-control" id="max" name="max" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="masterPelanggaranEditModal" tabindex="-1" role="dialog" aria-labelledby="masterPelanggaranEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="masterPelanggaranEditModalLabel">Edit Master Pelanggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="masterPelanggaranEditForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editMasterPelanggaranId" name="id">
                        <div class="form-group">
                            <label for="editNama">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="editLarangan">Larangan</label>
                            <select class="form-control" id="editLarangan" name="larangan" required>
                                <option value="">Pilih Larangan</option>
                                <option value="ADMINISTRASI">Administrasi</option>
                                <option value="ORGANISASI">Organisasi</option>
                                <option value="KEAMANAN">Keamanan</option>
                                <option value="ETIKA">Etika</option>
                                <option value="KEBERSIHAN/KESEHATAN/FASILITAS">Kebersihan/Kesehatan/Fasilitas</option>
                                <option value="PENDIDIKAN DAN IBADAH">Pendidikan dan Ibadah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editLevel">Level</label>
                            <select class="form-control" id="editLevel" name="level" required>
                                @foreach ($masterLevels as $level)
                                    <option value="{{ $level->level }}" data-denda="{{ $level->denda }}" data-hukuman="{{ $level->hukuman }}">
                                        {{ $level->level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editDenda">Denda</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="editDenda" name="denda" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editHukuman">Hukuman</label>
                            <input type="text" class="form-control" id="editHukuman" name="hukuman" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editMax">Max</label>
                            <input type="number" class="form-control" id="editMax" name="max" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Event handler for level change in create form
            $('#level').change(function() {
                const selectedLevel = $(this).find('option:selected');
                const denda = selectedLevel.data('denda');
                const hukuman = selectedLevel.data('hukuman');
                $('#denda').val(denda);
                $('#hukuman').val(hukuman);
            });

            // Event handler for level change in edit form
            $('#editLevel').change(function() {
                const selectedLevel = $(this).find('option:selected');
                const denda = selectedLevel.data('denda');
                const hukuman = selectedLevel.data('hukuman');
                $('#editDenda').val(denda);
                $('#editHukuman').val(hukuman);
            });

            // Edit button click event
            $('.editMasterPelanggaranBtn').click(function() {
                const id = $(this).data('id');
                $.get(`/master_pelanggaran/${id}/edit`, function(data) {
                    $('#editMasterPelanggaranId').val(data.id_mp);
                    $('#editNama').val(data.nama);
                    $('#editLarangan').val(data.larangan);
                    $('#editLevel').val(data.level).trigger('change'); // Trigger change to update denda and hukuman
                    $('#editMax').val(data.max);
                    $('#masterPelanggaranEditForm').attr('action', `/master_pelanggaran/${id}`);
                    $('#masterPelanggaranEditModal').modal('show');
                });
            });
        });
    </script>
@endsection
