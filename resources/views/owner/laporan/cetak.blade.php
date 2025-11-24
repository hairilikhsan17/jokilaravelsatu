<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Stok</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STOK APOTEK</h1>
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}</p>
        @if(request('id_staff'))
            @php
                $staff = \App\Models\User::find(request('id_staff'));
            @endphp
            @if($staff)
                <p><strong>Staff:</strong> {{ $staff->name }} ({{ ucfirst($staff->role) }})</p>
            @endif
        @endif
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Total Data:</strong> {{ $laporanStok->count() }} laporan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat/Alkes</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Staff</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanStok as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $laporan->obatAlkes->nama ?? '-' }}
                        @if($laporan->obatAlkes && $laporan->obatAlkes->kategori)
                            <br><small style="color: #666;">{{ $laporan->obatAlkes->kategori }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $laporan->jumlah }}</td>
                    <td style="text-align: center;">{{ $laporan->tanggal->format('d/m/Y') }}</td>
                    <td>
                        {{ $laporan->staff->name ?? '-' }}
                        @if($laporan->staff)
                            <br><small style="color: #666;">{{ ucfirst($laporan->staff->role) }}</small>
                        @endif
                    </td>
                    <td>{{ $laporan->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

