@extends('layout.main')

@section('title', 'Profil Santri')
@section('subtitle', 'Laporan Pelanggaran')

@section('kont')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note: {{ $santri->id_santri }}</h5>
                    Halaman ini telah ditingkatkan untuk pencetakan. Klik tombol cetak di bagian bawah untuk mencetak
                    laporan.
                </div>

                <div class="row">
                    <div class="col-12 col-sm-3 col-md-12 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                Data Santri
                                <small class="float-right">Tanggal: {{ date('d/m/Y') }}</small>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>{{ $santri->nama }}</b></h2>
                                        <p class="text-muted text-md"><b>Kelas: </b> {{ $santri->kelas->nama_kelas }} </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-lg fa-id-badge"></i></span> NIS: {{ $santri->nis }}
                                            </li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-lg fa-building"></i></span> Alamat:
                                                {{ $santri->alamat }}</li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-lg fa-user-tie"></i></span> Wali Santri:
                                                {{ $santri->walisantri }}</li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> No. HP Wali:
                                                {{ $santri->no_wali }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="{{ url('images/' . $santri->foto) }}" alt="User profile picture"
                                            style="width: 200px; height: 200px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-12">
                                            <button class="btn btn-primary float-right" id="printReport"><i
                                                    class="fas fa-print"></i> Cetak Laporan</button>
                                                    <button class="btn btn-success float-right ml-2" id="kirimWAgateway">
                                                        <i class="fab fa-whatsapp"></i> Kirim WhatsApp
                                                    </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="invoice p-3 mb-3">

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="violationTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggaran</th>
                                        <th>Tanggal</th>
                                        <th>Foto</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalDenda = 0;
                                        $visibleViolations = $santri->pelanggaran->filter(function ($pelanggaran) {
                                            return $pelanggaran->status !== 'Terlaksana';
                                        });
                                    @endphp
                                    @foreach ($visibleViolations as $pelanggaran)
                                        @php
                                            $denda = $pelanggaran->masterPelanggaran->denda ?? 0;
                                            $totalDenda += $denda;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pelanggaran->nama_pelanggaran }}</td>
                                            <td>{{ $pelanggaran->tanggal }}</td>
                                            <td>
                                                @if ($pelanggaran->foto)
                                                    <img src="{{ asset('storage/' . $pelanggaran->foto) }}"
                                                        alt="Foto Pelanggaran" width="50">
                                                @else
                                                    Tidak ada foto
                                                @endif
                                            </td>
                                            <td>Rp.{{ number_format($denda, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Denda</th>
                                        <th>Rp.{{ number_format($totalDenda, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        @media print {

            body,
            table {
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

            table th,
            table td {
                text-align: center;
            }

            footer {
                text-align: right;
                margin-top: 50px;
                position: fixed;
                bottom: 20px;
                right: 20px;
            }

            .fixed-size-img {
                width: 28px;
                /* Set your desired width */
                height: 28px;
                /* Set your desired height */
                object-fit: cover;
                /* Ensure the image covers the area without distortion */
                border-radius: 50%;
                /* Make the image circular */
            }

        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#violationTable').DataTable();
        });

        document.getElementById('printReport').addEventListener('click', function() {
            var printContents = document.querySelector('#violationTable').innerHTML;
            var originalContents = document.body.innerHTML;

            var header = `
        <div class="print-header">
            <img src="{{ asset('assetadmin/dist/img/kopSholawat.png') }}" alt="logo" style="width: 700px; height: 145px;">
            <hr style="border: 1px solid #000; margin-top: 10px;">
        </div>
    `;

            var additionalInfo = `
        <div class="additional-info" style="margin-top: 20px; font-size: 14px; line-height: 1.6;">
            <p>Kepada Bapak/Ibu <strong>{{ $santri->walisantri }}</strong> yang terhormat,</p>
            <p>Dengan ini kami sampaikan bahwa santri <strong>{{ $santri->nama }}</strong> telah tercatat melakukan beberapa pelanggaran yang memerlukan perhatian. Total denda yang terakumulasi akibat pelanggaran tersebut adalah sebesar Rp {{ number_format($totalDenda, 0, ',', '.') }}. Kami mohon perhatian dan kerjasamanya dalam menangani masalah ini.</p>
            <p><strong>Konsekuensi:</strong> Santri ini tidak dapat mengambil rapor atau mengikuti ujian tamrin dan ujian akhir apabila denda pelanggarannya tidak dilunaskan.</p>
        </div>
    `;

            var footer = `
        <footer style="text-align: left; margin-top: 50px;">
            <p>Hormat kami,</p><br>
            <p><b>({{ Auth::user()->name }})</b></p>
        </footer>
    `;

            var parser = new DOMParser();
            var doc = parser.parseFromString('<table>' + printContents + '</table>', 'text/html');
            var table = doc.querySelector('table');

            var headers = table.querySelectorAll('thead th');
            var rows = table.querySelectorAll('tbody tr');
            var footers = table.querySelectorAll('tfoot th');
            footers[footers.length - 1].setAttribute('colspan', '4');

            var printContent = header + additionalInfo + '<table class="table table-bordered">' + table.innerHTML +
                '</table>' + footer;

            var newWindow = window.open('', '_blank', 'width=800,height=600');
            newWindow.document.write('<html><head><title>Laporan Pelanggaran Santri</title>');
            newWindow.document.write(
                '<link rel="stylesheet" href="{{ url('css/print.css') }}" type="text/css" />');
            newWindow.document.write('</head><body>');
            newWindow.document.write(printContent);
            newWindow.document.write(`
        <style>
            .table-bordered {
                width: 100%;
                border-collapse: collapse;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            .table-bordered th:nth-child(1) {
                width: 80%;
            }
            .table-bordered th:nth-child(2) {
                width: 10%;
            }
            .table-bordered th:nth-child(3) {
                width: 15%;
            }
            .table-bordered th:nth-child(4) {
                width: 25%;
            }
            .table-bordered th:nth-child(5) {
                width: 10%;
            }
        </style>
    `);
            newWindow.document.write('</body></html>');
            newWindow.document.close();

            setTimeout(function() {
                newWindow.print();
            }, 1000); // Delay 2 detik sebelum mencetak
        });

        document.getElementById('kirimWAgateway').addEventListener('click', function() {
        var santriId = "{{ $santri->id_santri }}";
        var url = `/send-wa/${santriId}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pesan WhatsApp berhasil dikirim');
                } else {
                    alert('Gagal mengirim pesan WhatsApp');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim pesan WhatsApp');
            });
    });
</script>
        
    </script>
@endpush
