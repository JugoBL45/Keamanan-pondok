@extends('layout.main')

@section('title', 'Pelanggaran Bulanan')
@section('subtitle', 'Daftar Pelanggaran Bulanan')
@section('home', 'Pelanggaran')
@section('page', 'Bulanan')
@section('kont')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Pelanggaran Santri</h3>
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
                {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#addPelanggaranModal"
                    id="createPelanggaranBtn">Tambah Pelanggaran</button> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="pelanggaranTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Kelas</th>
                            <th>Nama Pelanggaran</th>
                            <th>Level</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Status</th> <!-- Tambahkan kolom Status -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggarans as $pelanggaran)
                            @php
                                $masterPelanggaran = optional($pelanggaran->masterPelanggaran);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pelanggaran->santri->nis }}</td>
                                <td>{{ $pelanggaran->santri->nama }}</td>
                                <td>{{ $pelanggaran->santri->kelas->nama_kelas }}</td>
                                <td>{{ $pelanggaran->nama_pelanggaran == $pelanggaran->masterPelanggaran->nama ? $pelanggaran->masterPelanggaran->nama : $pelanggaran->nama_pelanggaran }}</td>
                                <td>{{ $pelanggaran->masterPelanggaran->level }}</td>
                                <td>{{ $pelanggaran->tanggal }}</td>
                                <td>
                                    @if ($pelanggaran->foto)
                                        <img src="{{ asset('storage/' . $pelanggaran->foto) }}" alt="Foto Pelanggaran" width="50">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-status {{ $pelanggaran->status == 'Terlaksana' ? 'btn-success' : 'btn-secondary' }}" data-id="{{ $pelanggaran->id_pelanggaran }}">
                                        {{ $pelanggaran->status }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning editPelanggaranBtn" data-id="{{ $pelanggaran->id_pelanggaran }}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('pelanggaran.destroy', $pelanggaran->id_pelanggaran) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
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

    <!-- Add Pelanggaran Modal -->
    <div class="modal fade" id="addPelanggaranModal" tabindex="-1" role="dialog"
        aria-labelledby="addPelanggaranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPelanggaranModalLabel">Tambah Pelanggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pelanggaranForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_santri">Santri</label>
                            <select class="form-control select2bs4" id="id_santri" name="id_santri" required>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id_santri }}">{{ $santri->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_mp">Pelanggaran</label>
                            <select class="form-control select2bs4" id="id_mp" name="id_mp" required>
                                @foreach ($masterPelanggarans as $masterPelanggaran)
                                    <option value="{{ $masterPelanggaran->id_mp }}">{{ $masterPelanggaran->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-primary" id="savePelanggaranBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Pelanggaran Modal -->
    <div class="modal fade" id="editPelanggaranModal" tabindex="-1" role="dialog"
        aria-labelledby="editPelanggaranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPelanggaranModalLabel">Edit Pelanggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPelanggaranForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="pelanggaran_id" name="pelanggaran_id">
                        <div class="form-group">
                            <label for="edit_id_santri">Santri</label>
                            <select class="form-control select2bs4" id="edit_id_santri" name="id_santri" required>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id_santri }}">{{ $santri->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_id_mp">Pelanggaran</label>
                            <select class="form-control select2bs4" id="edit_id_mp" name="id_mp" required>
                                @foreach ($masterPelanggarans as $masterPelanggaran)
                                    <option value="{{ $masterPelanggaran->id_mp }}">{{ $masterPelanggaran->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_foto">Foto</label>
                            <input type="file" class="form-control" id="edit_foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-primary" id="updatePelanggaranBtn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables (if used) -->
    <script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
     
    $(document).ready(function() {
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih',
            allowClear: true
        });

        // Initialize DataTables (if used)
        var table = $('#pelanggaranTable').DataTable({
            // Add DataTables options here if needed
        });

        // Handle month and year filter
        $('#filterMonth, #filterYear').on('change', function() {
            var month = $('#filterMonth').val();
            var year = $('#filterYear').val();
            var url = '{{ route('pelanggaran.bulanan.index') }}?month=' + month + '&year=' + year;
            window.location.href = url;
        });

        // Handle status toggle
        $('.btn-status').on('click', function() {
            var button = $(this);
            var id = button.data('id');

            $.post('{{ route('pelanggaran.toggleStatus', '') }}/' + id, {
                _token: '{{ csrf_token() }}'
            }, function(response) {
                button.text(response.status);
                button.toggleClass('btn-success btn-secondary', response.status == 'Terlaksana');
            });
        });

        // Initialize modal for add
        $('#createPelanggaranBtn').on('click', function() {
            $('#addPelanggaranModal').modal('show');
            $('#addPelanggaranModalLabel').text('Tambah Pelanggaran');
            $('#pelanggaranForm').trigger('reset');
            $('.select2bs4').val(null).trigger('change');
        });

        // Initialize modal for edit
        $('.editPelanggaranBtn').on('click', function() {
            var id = $(this).data('id');
            $.get('{{ route('pelanggaran.bulanan.index') }}/' + id + '/edit', function(data) {
                $('#editPelanggaranModal').modal('show');
                $('#editPelanggaranModalLabel').text('Edit Pelanggaran');
                $('#pelanggaran_id').val(data.id_pelanggaran);
                $('#edit_id_santri').val(data.id_santri).trigger('change');
                $('#edit_id_mp').val(data.id_mp).trigger('change');
                $('#edit_tanggal').val(data.tanggal);
            });
        });

        // Handle form submission for add
        $('#pelanggaranForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('pelanggaran.store') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#addPelanggaranModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

        // Handle form submission for edit
        $('#editPelanggaranForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#pelanggaran_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');

            $.ajax({
                url: '{{ route('pelanggaran.bulanan.index') }}/' + id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editPelanggaranModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

@endpush
