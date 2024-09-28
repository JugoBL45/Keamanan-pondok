@extends('layout.main')

@section('title', 'Santri')
@section('subtitle', 'Daftar Santri')

@section('kont')
    <div class="card">
        <div class="card-header bd-secondary">
            <h3 class="card-title">Daftar Santri</h3>
            <button class="btn btn-secondary float-right animated-btn" data-toggle="modal" data-target="#addSantriModal" id="createSantriBtn"><i class="fas fa-plus mr-1"></i>Tambah Santri</button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="santriTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Wali Santri</th>
                        <th>No Wali</th>
                        <th>Foto</th>
                        <th width="115px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($santris as $santri)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $santri->nis }}</td>
                            <td>{{ $santri->nama }}</td>
                            <td>{{ $santri->kelas->nama_kelas }}</td>
                            <td>{{ $santri->alamat }}</td>
                            <td>{{ $santri->walisantri }}</td>
                            <td>{{ $santri->no_wali }}</td>
                            <td><img src="{{ url('images/' . $santri->foto) }}" alt="{{ $santri->nama }}" width="50"></td>
                            <td>
                                <a href="{{ route('santri.profil', $santri->id_santri) }}" class="btn btn-info animated-btn viewSantriBtn">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->role == 1)
                                <button class="btn btn-warning animated-btn editSantriBtn" data-id="{{ $santri->id_santri }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                                <form action="{{ route('santri.destroy', $santri->id_santri) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger animated-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Div untuk gambar pop-up -->
    <div class="img-popup" id="imgPopup">
        <img id="popupImage" src="" alt="Popup Image">
    </div>
@endsection

@push('js')
   <!-- Select2 -->
   <script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>
   <!-- DataTables (if used) -->
   <script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
   <!-- Animasi -->
   <style>
       .animated-btn {
           transition: transform 0.2s, background-color 0.2s;
       }
       .animated-btn:hover {
           transform: scale(1.1);
           background-color: #28a745 !important;
       }
       /* CSS untuk gambar pop-up */
       .img-popup {
           position: fixed;
           display: none;
           justify-content: center;
           align-items: center;
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background: rgba(0, 0, 0, 0.8);
           z-index: 1000;
       }

       .img-popup img {
           max-width: 90%;
           max-height: 90%;
           border-radius: 10px;
       }
   </style>
   <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#santriTable').DataTable();

            // Initialize modal for create
            $('#createSantriBtn').on('click', function() {
                $('#addSantriModal').modal('show');
                $('#addSantriModalLabel').text('Tambah Santri');
                $('#santriForm').trigger('reset');
                $('#santri_id').val('');
                $('#santriForm').find('[name="_method"]').remove(); // Remove the _method input for POST
            });

            // Initialize modal for edit
            $('.editSantriBtn').on('click', function() {
                var id = $(this).data('id');
                $.get('{{ route('santri.index') }}/' + id + '/edit', function(data) {
                    $('#editSantriModal').modal('show');
                    $('#editSantriModalLabel').text('Edit Santri');
                    $('#editSantriForm').attr('action', '{{ route('santri.index') }}/' + id);
                    $('#editSantriForm').find('[name="_method"]').remove(); // Remove existing _method input if any
                    $('#editSantriForm').prepend('<input type="hidden" name="_method" value="PUT">'); // Add _method input for PUT
                    $('#santri_id').val(data.id_santri);
                    $('#edit_nis').val(data.nis);
                    $('#edit_nama').val(data.nama);
                    $('#edit_kelas_id').val(data.kelas_id);
                    $('#edit_alamat').val(data.alamat);
                    $('#edit_walisantri').val(data.walisantri);
                    $('#edit_no_wali').val(data.no_wali);
                });
            });

            // Handle form submission for add
            $('#santriForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('santri.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addSantriModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Handle form submission for edit
            $('#editSantriForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#santri_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '{{ route('santri.index') }}/' + id,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#editSantriModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Handle image click event
            $('#santriTable').on('click', 'img', function() {
                var src = $(this).attr('src');
                $('#popupImage').attr('src', src);
                $('#imgPopup').css('display', 'flex');
            });

            // Close popup when clicked
            $('#imgPopup').on('click', function() {
                $(this).css('display', 'none');
            });
        });
    </script>
@endpush
