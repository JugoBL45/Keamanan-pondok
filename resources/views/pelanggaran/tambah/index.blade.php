@extends('layout.main')
@section('title', 'Input Pelanggaran Santri')
@section('subtitle', 'Formulir Input Pelanggaran Santri')
@section('home', 'Pelanggaran')
@section('page', 'Tambah Pelanggaran')

@section('kont')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Input Pelanggaran Santri</h3>
        </div>
        @if (session('success'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 1500 // Auto close after 1.5 seconds
                    });
                });
            </script>
        @endif
        <div class="card-body">
            <form id="pelanggaranForm" action="{{ route('pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_santri">Santri</label>
                    <select class="form-control select2bs4" id="id_santri" name="id_santri" required>
                        <option value="">Pilih Santri</option>
                        @foreach ($santris as $santri)
                            <option value="{{ $santri->id_santri }}">{{ $santri->nis }} | {{ $santri->nama }} |
                                {{ $santri->kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="larangan">Larangan</label>
                    <select class="form-control select2bs4" id="larangan">
                        <option value="">Pilih Larangan</option>
                        @foreach ($larangans as $larangan)
                            <option value="{{ $larangan }}">{{ $larangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_mp">Pelanggaran</label>
                    <select class="form-control " id="id_mp" name="id_mp" required>
                        <option value="">Pilih Pelanggaran</option>
                        @foreach ($masterPelanggarans as $masterPelanggaran)
                            <option value="{{ $masterPelanggaran->id_mp }}"
                                data-larangan="{{ $masterPelanggaran->larangan }}">{{ $masterPelanggaran->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih',
                allowClear: true
            });

            // Filter pelanggaran berdasarkan larangan
            $('#larangan').on('change', function() {
                var selectedLarangan = $(this).val();
                $('#id_mp option').each(function() {
                    var pelanggaranLarangan = $(this).data('larangan');
                    if (pelanggaranLarangan === selectedLarangan || selectedLarangan === "") {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#id_mp').val(null).trigger('change'); // Clear selected pelanggaran
            });
        });
    </script>
@endpush
