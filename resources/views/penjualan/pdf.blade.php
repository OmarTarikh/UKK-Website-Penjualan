<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 align="center">Laporan Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->PenjualanID }}</td>
                    <td>{{ $data->TanggalPenjualan }}</td>
                    <td>Rp {{ number_format($data->TotalHarga, 2, ',', '.') }}</td>
                    <td>{{ $data->pelanggan->NamaPelanggan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
