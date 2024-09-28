<!DOCTYPE html>
<html>
<head>
    <title>Laporan Santri</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 50px; }
        .header img { width: 100px; }
        .footer { position: fixed; bottom: 0; text-align: center; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('path/to/your/kopSholawat.png') }}" alt="Logo">
        <h1>Laporan Pelanggaran Santri</h1>
    </div>
    <h2>Nama: {{ $santri->nama }}</h2>
    <p>Kelas: {{ $santri->kelas->nama_kelas }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggaran</th>
                <th>Larangan</th>
                <th>Tanggal</th>
                <th>Level</th>
                <th>Hukuman</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($violations as $violation)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $violation->masterPelanggaran->nama }}</td>
                <td>{{ $violation->masterPelanggaran->larangan }}</td>
                <td>{{ $violation->tanggal }}</td>
                <td>{{ $violation->masterPelanggaran->level }}</td>
                <td>{{ $violation->masterPelanggaran->hukuman }}</td>
                <td>{{ 'Rp ' . number_format($violation->masterPelanggaran->denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">Total Denda</th>
                <th>{{ 'Rp ' . number_format($totalDenda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Dicetak oleh: {{ $user }}</p>
        <p>Tanggal: {{ now()->format('d-m-Y') }}</p>
    </div>
</body>
</html>
