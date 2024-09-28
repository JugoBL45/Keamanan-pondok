@extends('layout.main')

@section('title', 'Pelanggaran Harian')
@section('subtitle', 'Daftar Pelanggaran Harian')
@section('home', 'Pelanggaran')
@section('page', 'Harian')
@section('kont')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Pelanggaran Santri</h3>
            <div class="d-flex align-items-center">
                <input type="date" id="filterDate" class="form-control mr-2" style="width: auto;"
                    value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
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
                            <th>Max</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggarans as $pelanggaran)
                            @php
                                $masterPelanggaran = optional($pelanggaran->masterPelanggaran);
                            @endphp
                            @if ($masterPelanggaran && $masterPelanggaran->larangan == 'PENDIDIKAN DAN IBADAH')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pelanggaran->santri->nis }}</td>
                                    <td>{{ $pelanggaran->santri->nama }}</td>
                                    <td>{{ $pelanggaran->santri->kelas->nama_kelas }}</td>
                                    <td>{{ $pelanggaran->masterPelanggaran->nama }}</td>
                                    <td>{{ $pelanggaran->masterPelanggaran->max }}</td>
                                    <td>{{ $pelanggaran->tanggal }}</td>
                                    <td>
                                        @if ($pelanggaran->foto)
                                            <img src="{{ asset('storage/' . $pelanggaran->foto) }}" alt="Foto Pelanggaran"
                                                width="50">
                                        @else
                                            Tidak ada foto
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-status {{ $pelanggaran->status == 'Terlaksana' ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $pelanggaran->id_pelanggaran }}">
                                            {{ $pelanggaran->status }}
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning editPelanggaranBtn"
                                            data-id="{{ $pelanggaran->id_pelanggaran }}"><i
                                                class="fas fa-edit"></i></button>
                                        <form action="{{ route('pelanggaran.destroy', $pelanggaran->id_pelanggaran) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
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

            // Initialize DataTables
            var table = $('#pelanggaranTable').DataTable();

            // Handle date filter
            $('#filterDate').on('change', function() {
                var date = $('#filterDate').val();
                var url = '{{ route('pelanggaran.harian.index') }}?date=' + date;
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
                $.get('{{ route('pelanggaran.harian.index') }}/' + id + '/edit', function(data) {
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
                    url: '{{ route('pelanggaran.harian.index') }}/' + id,
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
