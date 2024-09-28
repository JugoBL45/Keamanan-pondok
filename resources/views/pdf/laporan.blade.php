<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran Santri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .additional-info {
            margin-top: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assetadmin/dist/img/kopSholawat.png') }}" alt="logo" style="width: 700px; height: 145px;">
        <hr style="border: 1px solid #000; margin-top: 10px;">
    </div>
    <div class="additional-info">
        <p>Kepada Bapak/Ibu <strong>{{ $santri->walisantri }}</strong> yang terhormat,</p>
        <p>Dengan ini kami sampaikan bahwa santri <strong>{{ $santri->nama }}</strong> telah tercatat melakukan beberapa pelanggaran yang memerlukan perhatian. Total denda yang terakumulasi akibat pelanggaran tersebut adalah sebesar Rp {{ number_format($totalDenda, 0, ',', '.') }}. Kami mohon perhatian dan kerjasamanya dalam menangani masalah ini.</p>
        <p><strong>Konsekuensi:</strong> Santri ini tidak dapat mengambil rapor atau mengikuti ujian tamrin dan ujian akhir apabila denda pelanggarannya tidak dilunaskan.</p>
    </div>
    <table>
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
            @endphp
            @foreach ($santri->pelanggaran as $pelanggaran)
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
                            <img src="{{ asset('storage/' . $pelanggaran->foto) }}" alt="Foto Pelanggaran" width="50">
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
    <div class="footer">
        <p>Hormat kami,</p>
        <p><b>{{ Auth::user()->name }}</b></p>
    </div>
</body>
</html>
