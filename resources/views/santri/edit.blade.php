<div class="modal fade" id="editSantriModal" tabindex="-1" role="dialog" aria-labelledby="editSantriModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSantriModalLabel">Edit Santri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editSantriForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT') <!-- Add this line to include the method field -->
          <input type="hidden" id="edit_santri_id">
          <div class="form-group">
            <label for="edit_nis">NIS</label>
            <input type="text" class="form-control" id="edit_nis" name="nis" required>
          </div>
          <div class="form-group">
            <label for="edit_nama">Nama</label>
            <input type="text" class="form-control" id="edit_nama" name="nama" required>
          </div>
          <div class="form-group">
            <label for="edit_kelas_id">Kelas</label>
            <select class="form-control" id="edit_kelas_id" name="kelas_id" required>
              @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="edit_alamat">Alamat</label>
            <textarea class="form-control" id="edit_alamat" name="alamat" required></textarea>
          </div>
          <div class="form-group">
            <label for="edit_walisantri">Wali Santri</label>
            <input type="text" class="form-control" id="edit_walisantri" name="walisantri" required>
          </div>
          <div class="form-group">
            <label for="edit_no_wali">No Wali</label>
            <input type="text" class="form-control" id="edit_no_wali" name="no_wali" required>
          </div>
          <div class="form-group">
            <label for="edit_foto">Foto</label>
            <input type="file" class="form-control" id="edit_foto" name="foto">
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
