@extends('layout.main')

@section('title', 'Input Pelanggaran Harian')
@section('subtitle', 'Formulir Input Pelanggaran Harian')

@section('kont')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Input Pelanggaran Santri</h3>
        </div>
        <div class="card-body">
            <form id="pelanggaranForm" action="{{ route('pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
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
                            <option value="{{ $masterPelanggaran->id_mp }}">{{ $masterPelanggaran->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_larangan">Larangan</label>
                    <select class="form-control select2bs4" id="id_larangan" name="id_larangan" required>
                        @foreach ($masterPelanggarans as $masterPelanggaran)
                            <option value="{{ $masterPelanggaran->id_larangan }}">{{ $masterPelanggaran->nama_larangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pelanggaran.harian.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih',
                allowClear: true
            });
        });
    </script>
@endpush
