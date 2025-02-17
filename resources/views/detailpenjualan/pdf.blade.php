<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Detail Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Detail</th>
                <th>Penjualan ID</th>
                <th>Produk</th>
                <th>Jumlah Produk</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailPenjualan as $dp)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dp->DetailID }}</td>
                <td>{{ $dp->penjualan->PenjualanID }}</td>
                <td>{{ $dp->produk->NamaProduk }}</td>
                <td>{{ $dp->JumlahProduk }}</td>
                <td>Rp {{ number_format($dp->Subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
