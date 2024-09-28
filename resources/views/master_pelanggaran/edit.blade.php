@extends('layout.main')

@section('title', 'Edit Santri')
@section('subtitle', 'Edit Santri')

@section('kont')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Santri</h3>
  </div>
  <div class="card-body">
    <form action="{{ route('santri.update', $santri->id_santri) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $santri->nama }}" required>
      </div>
      <div class="form-group">
        <label for="kelas">Kelas</label>
        <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $santri->kelas }}" required>
      </div>
      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" required>{{ $santri->alamat }}</textarea>
      </div>
      <div class="form-group">
        <label for="walisantri">Wali Santri</label>
        <input type="text" class="form-control" id="walisantri" name="walisantri" value="{{ $santri->walisantri }}" required>
      </div>
      <div class="form-group">
        <label for="no_wali">No Wali</label>
        <input type="text" class="form-control" id="no_wali" name="no_wali" value="{{ $santri->no_wali }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
