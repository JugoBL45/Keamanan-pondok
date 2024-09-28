<!-- Modal Tambah Santri -->
<div class="modal fade" id="modalTambahSantri" tabindex="-1" role="dialog" aria-labelledby="modalTambahSantriLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Adjusted to modal-lg for wider modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSantriLabel">Tambah Santri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nis" placeholder="Masukkan NIS">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <div class="input-group">
                                    <select class="form-control" id="kelas">
                                        <option value="X-A">X-A</option>
                                        <option value="X-B">X-B</option>
                                        <option value="XI-A">XI-A</option>
                                        <option value="XI-B">XI-B</option>
                                        <option value="XII-A">XII-A</option>
                                        <option value="XII-B">XII-B</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wali">Wali</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="wali" placeholder="Masukkan Nama Wali">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nomorWali">Nomor Wali</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="nomorWali" placeholder="Masukkan Nomor Wali">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto">
                                        <label class="custom-file-label" for="foto">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12"> <!-- Full width column for Alamat -->
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="alamat" placeholder="Masukkan Alamat" rows="3"></textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batalkan</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit Santri -->
<div class="modal fade" id="modalEditSantri" tabindex="-1" role="dialog" aria-labelledby="modalEditSantriLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditSantriLabel">Edit Santri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNIS">NIS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="editNIS" placeholder="Masukkan NIS" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editNama">Nama</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="editNama" placeholder="Masukkan Nama">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editKelas">Kelas</label>
                                <div class="input-group">
                                    <select class="form-control" id="editKelas">
                                        <option value="X-A">X-A</option>
                                        <option value="X-B">X-B</option>
                                        <option value="XI-A">XI-A</option>
                                        <option value="XI-B">XI-B</option>
                                        <option value="XII-A">XII-A</option>
                                        <option value="XII-B">XII-B</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editWali">Wali</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="editWali" placeholder="Masukkan Nama Wali">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editNomorWali">Nomor Wali</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="editNomorWali" placeholder="Masukkan Nomor Wali">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editfoto">Foto</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="editfoto">
                                        <label class="custom-file-label" for="editfoto">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editAlamat">Alamat</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="editAlamat" placeholder="Masukkan Alamat" rows="3"></textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batalkan</button>
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
