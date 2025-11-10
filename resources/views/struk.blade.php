
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pembayaran - SiLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .header p {
            font-size: 11px;
            margin: 0;
        }

        .info {
            margin-bottom: 5px;
        }

        .info p {
            margin: 0;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        th,
        td {
            padding: 2px 0;
            text-align: left;
            font-size: 11px;
        }

        th {
            border-bottom: 1px dashed #000;
            font-weight: bold;
        }

        tfoot td {
            border-top: 1px dashed #000;
            font-weight: bold;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 5px;
            font-size: 10px;
        }

        .right {
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
                width: 80mm;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🧺 Si-Laundry</h1>
        <p>Jl. Jend. Sudirman No. 86 Beru, Wlingi</p>
        <p>Blitar - Jawa Timur</p>
    </div>

    <div class="info">
        <p><strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($dataUtama->tanggal_transaksi)->format('d/m/Y') }}</p>
        <p><strong>Kode :</strong> {{ $dataUtama->kode_pesanan }}</p>
        <p><strong>Pelanggan :</strong> {{ $dataUtama->nama_pelanggan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan & Berat</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
            @php
                    $namaLayanan = $item->nama_layanan ?? '-';
                    $harga = $item->harga ?? 0;
                    $berat = $item->berat ?? 0;
                    $subtotal = $harga * $berat;
                @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $namaLayanan }} ({{ $berat }}kg)
                </td>
                <td class="right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td class="right">Rp{{ number_format($dataUtama->nominal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>✨ Terima Kasih Telah Menggunakan Jasa Kami ✨</p>
        <p><small>Barang sudah dicuci tidak dapat diklaim lebih dari 24 jam</small></p>
        <p><small>— SiLaundry —</small></p>
    </div>

    <script>
        window.onload = function () {
            window.print();
            window.onafterprint = () => {
                window.location.href = "{{ route('transaksi.index') }}";
            };
        };
    </script>
</body>

</html>


{{-- <!doctype html>
<html lang="id">

<head>
    <!-- head sama persis seperti yang kamu punya -->
</head>

<body>
    <div class="header">
        <h1>🧺 Si-Laundry</h1>
        <p>Jl. Jend. Sudirman No. 86 Beru, Wlingi</p>
        <p>Blitar - Jawa Timur</p>
    </div>

    <div class="info">
        <p><strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($dataUtama->tanggal_transaksi)->format('d/m/Y') }}</p>
        <p><strong>Kode :</strong> {{ $dataUtama->kode_pesanan }}</p>
        <p><strong>Pelanggan :</strong> {{ $dataUtama->nama_pelanggan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                @php
                    // karena detail berasal dari view SQL, kolom langsung ada di $item
                    $namaLayanan = $item->nama_layanan ?? '-';
                    $harga = $item->harga ?? 0;
                    $berat = $item->berat ?? 0;
                    $subtotal = $harga * $berat;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $namaLayanan }} ({{ $berat }}kg)</td>
                    <td class="right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td class="right">Rp{{ number_format($dataUtama->nominal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>✨ Terima Kasih Telah Menggunakan Jasa Kami ✨</p>
        <p><small>Barang sudah dicuci tidak dapat diklaim lebih dari 24 jam</small></p>
        <p><small>— SiLaundry —</small></p>
    </div>

    <script>
        window.onload = function () {
            window.print();
            window.onafterprint = () => {
                window.location.href = "{{ route('transaksi.index') }}";
            };
        };
    </script>
</body>

</html>
 --}}
