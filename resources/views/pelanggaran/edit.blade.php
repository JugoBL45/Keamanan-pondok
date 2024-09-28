@extends('layout.main')

@section('title', 'Pelanggaran')
@section('subtitle', $jenis == 'daily' ? 'Tambah Pelanggaran Harian' : 'Tambah Pelanggaran Bulanan')

@section('kont')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">{{ $jenis == 'daily' ? 'Tambah Pelanggaran Harian' : 'Tambah Pelanggaran Bulanan' }}</h3>
  </div>
  <div class="card-body">
    <form action="{{ $jenis == 'daily' ? route('pelanggaran.daily.store') : route('pelanggaran.monthly.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="id_santri">Nama Santri</label>
        <select name="id_santri" id="id_santri" class="form-control" required>
          @foreach($santris as $santri)
            <option value="{{ $santri->id_santri }}">{{ $santri->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="kelas">Kelas</label>
        <input type="text" name="kelas" id="kelas" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="nama_pelanggaran">Nama Pelanggaran</label>
        <input type="text" name="nama_pelanggaran" id="nama_pelanggaran" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="jenis">Jenis</label>
        <input type="text" name="jenis" id="jenis" class="form-control" value="{{ $jenis }}" readonly>
      </div>
      <div class="form-group">
        <label for="level">Level</label>
        <input type="number" name="level" id="level" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="foto_p">Foto (optional)</label>
        <input type="file" name="foto_p" id="foto_p" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
