<div class="modal fade" id="tambahSantriModal" tabindex="-1" role="dialog" aria-labelledby="tambahSantriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahSantriModalLabel">Tambah Santri</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="tambahSantriForm" action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="nis">NIS</label>
              <input type="text" class="form-control" id="nis" name="nis" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
              <label for="kelas_id">Kelas</label>
              <select class="form-control" id="kelas_id" name="kelas_id" required>
                @foreach($kelas as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" required></textarea>
            </div>
            <div class="form-group">
              <label for="walisantri">Wali Santri</label>
              <input type="text" class="form-control" id="walisantri" name="walisantri" required>
            </div>
            <div class="form-group">
              <label for="no_wali">No Wali</label>
              <input type="text" class="form-control" id="no_wali" name="no_wali" required>
            </div>
            <div class="form-group">
              <label for="foto">Foto</label>
              <input type="file" class="form-control" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  