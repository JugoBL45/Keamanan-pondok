@extends('layout.main')

@section('title', 'Kelas')
@section('subtitle', 'Master Kelas')
@section('home', 'Master')
@section('page', 'Master Kelas')

@section('kont')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Master Kelas</h3>
    <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#kelasModal" id="createKelasBtn"><i class="fas fa-plus mr-1"></i>Tambah Kelas</button>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Kelas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kelas as $k)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $k->nama_kelas }}</td>
          <td>
            {{-- <button class="btn btn-warning editKelasBtn" data-id="{{ $k->id }}">Edit</button> --}}
            <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kelasModal" tabindex="-1" role="dialog" aria-labelledby="kelasModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kelasModalLabel">Tambah/Edit Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="kelasForm">
          @csrf
          <input type="hidden" id="kelas_id">
          <div class="form-group">
            <label for="nama_kelas">Nama Kelas</label>
            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
          </div>
          <button type="submit" class="btn btn-primary" id="saveKelasBtn">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    // Initialize modal for create
    $('#createKelasBtn').on('click', function() {
      $('#kelasModalLabel').text('Tambah Kelas');
      $('#kelasForm').attr('action', '{{ route("kelas.store") }}');
      $('#kelasForm').trigger('reset');
      $('#kelas_id').val('');
    });

    // Initialize modal for edit
    $('.editKelasBtn').on('click', function() {
      var id = $(this).data('id');
      $.get('{{ route("kelas.index") }}/' + id + '/edit', function(data) {
        $('#kelasModalLabel').text('Edit Kelas');
        $('#kelasForm').attr('action', '{{ route("kelas.index") }}/' + id);
        $('#kelas_id').val(data.id);
        $('#nama_kelas').val(data.nama_kelas);
        $('#kelasModal').modal('show');
      });
    });

    // Handle form submission
    $('#kelasForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#kelas_id').val();
      var url = id ? '{{ route("kelas.index") }}/' + id : '{{ route("kelas.store") }}';
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
  });
</script>
@endpush
