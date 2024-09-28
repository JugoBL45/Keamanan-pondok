@extends('layout.main')

@section('title', 'Laporan Pelanggaran')
@section('subtitle', 'Laporan Pelanggaran Harian dan Bulanan')

@section('kont')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Laporan Pelanggaran Santri</h3>
            <div class="d-flex align-items-center">
                <select id="reportType" class="form-control mr-2" style="width: auto;">
                    <option value="daily">Harian</option>
                    <option value="monthly">Bulanan</option>
                </select>
                <input type="date" id="filterDate" class="form-control mr-2" style="width: auto; display: none;">
                <select id="filterMonth" class="form-control mr-2" style="width: auto;">
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $month == request('month', \Carbon\Carbon::now()->month) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <select id="filterYear" class="form-control mr-2" style="width: auto;">
                    @foreach (range(\Carbon\Carbon::now()->year - 5, \Carbon\Carbon::now()->year + 5) as $year)
                        <option value="{{ $year }}" {{ $year == request('year', \Carbon\Carbon::now()->year) ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" id="filterButton">Filter</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="pelanggaranTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>Kelas</th>
                            <th>Nama Pelanggaran</th>
                            <th>Level</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggarans as $pelanggaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pelanggaran->santri->nama }}</td>
                                <td>{{ $pelanggaran->santri->kelas->nama_kelas }}</td>
                                <td>{{ $pelanggaran->masterPelanggaran->nama }}</td>
                                <td>{{ $pelanggaran->masterPelanggaran->level }}</td>
                                <td>{{ $pelanggaran->tanggal }}</td>
                                <td>
                                    @if ($pelanggaran->foto)
                                        <img src="{{ asset('storage/' . $pelanggaran->foto) }}" alt="Foto Pelanggaran" width="50">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" id="printReport">Cetak Laporan</button>
        </div>
    </div>

    <!-- Add Pelanggaran Modal -->
    <div class="modal fade" id="addPelanggaranModal" tabindex="-1" role="dialog" aria-labelledby="addPelanggaranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPelanggaranModalLabel">Tambah Pelanggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pelanggaranForm" enctype="multipart/form-data">
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
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-primary" id="savePelanggaranBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        @media print {
            body, table {
                text-align: center;
            }
            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }
            .additional-info {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                margin: 0 auto;
            }
            table th, table td {
                text-align: center;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            // Initialize Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Initialize DataTables
            $("#pelanggaranTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });

            // Show/hide filters based on report type
            $('#reportType').change(function() {
                if ($(this).val() == 'daily') {
                    $('#filterDate').show();
                    $('#filterMonth, #filterYear').hide();
                } else {
                    $('#filterDate').hide();
                    $('#filterMonth, #filterYear').show();
                }
            }).trigger('change');

            // Filter button click event
            $('#filterButton').click(function() {
                var reportType = $('#reportType').val();
                var date = $('#filterDate').val();
                var month = $('#filterMonth').val();
                var year = $('#filterYear').val();

                // Reload the page with filter parameters
                window.location.href = "{{ route('laporan.pelanggaran') }}" + "?" + 
                                        "type=" + reportType + 
                                        "&date=" + date + 
                                        "&month=" + month + 
                                        "&year=" + year;
            });

            // Add pelanggaran button click event
            $('#addPelanggaranModal').on('show.bs.modal', function(event) {
                $('#pelanggaranForm')[0].reset();
                $('.select2bs4').val(null).trigger('change');
            });

            // Save new pelanggaran
            $('#pelanggaranForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('pelanggaran.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Pelanggaran berhasil ditambahkan!');
                        window.location.reload();
                    },
                    error: function(response) {
                        alert('Terjadi kesalahan saat menambahkan pelanggaran.');
                    }
                });
            });

            // Print functionality
            document.getElementById('printReport').addEventListener('click', function() {
                var printContents = document.getElementById('pelanggaranTable').innerHTML;
                var originalContents = document.body.innerHTML;

                var header = `
                    <div class="print-header">
                        <img src="{{ asset('assetadmin/dist/img/kopSholawat.png') }}" alt="logo" style="width: 800px; height: 200px;">
                        <p style="text-align: center; font-size: 12px;">Jl. Pesantren No. 123, Kota, Provinsi</p>
                    </div>
                `;

                var additionalInfo = `
                    <div class="additional-info style="margin-top: 20px; font-size: 14px; line-height: 1.6;">
                        <p>Kepada Bapak/Ibu <strong>{{ $santri->walisantri }}</strong> yang terhormat,</p>
                        <p>Dengan ini kami sampaikan bahwa santri <strong>{{ $santri->nama }}</strong> telah tercatat melakukan beberapa pelanggaran yang memerlukan perhatian. Total denda yang terakumulasi akibat pelanggaran tersebut adalah sebesar Rp {{ number_format($totalDenda, 0, ',', '.') }}. Kami mohon perhatian dan kerjasamanya dalam menangani masalah ini.</p>
                        <p><strong>Konsekuensi:</strong> Santri ini tidak dapat mengambil rapor atau mengikuti ujian tamrin dan ujian akhir apabila denda pelanggarannya tidak dilunaskan.</p>
                        <p style="text-align: right;">Hormat kami,</p>
                        <p style="text-align: right;">{{ Auth::user()->name }}</p>
                    </div>
                `;

                var printContent = header + additionalInfo + '<table class="table table-bordered">' + printContents + '</table>';

                var newWindow = window.open('', '_blank', 'width=800,height=600');
                newWindow.document.write('<html><head><title>Laporan Pelanggaran Santri</title>');
                newWindow.document.write('<link rel="stylesheet" href="{{ url('css/print.css') }}" type="text/css" />');
                newWindow.document.write('</head><body>');
                newWindow.document.write(printContent);
                newWindow.document.write('</body></html>');
                newWindow.document.close();

                setTimeout(function() {
                    newWindow.print();
                    newWindow.close();
                }, 2000);

                document.body.innerHTML = originalContents;
            });
        });
    </script>
@endpush
