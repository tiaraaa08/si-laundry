<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pembayaran - SiLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', monospace;
            max-width: 480px;
            margin: 20px auto;
            padding: 15px;
            border: 1px dashed #333;
            border-radius: 10px;
        }

        h1,
        h2,
        h3,
        h4,
        p {
            margin: 0;
            padding: 0;
        }

        .borderless td,
        .borderless th {
            border: none !important;
        }

        hr {
            border-top: 2px dashed #000;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h1 class="fw-bold">Si-Laundry</h1>
        <h6>Jl. Jendral Sudirman No. 86 Beru, Wlingi, Blitar, Jawa Timur</h6>
    </div>

    <hr>

    <div class="mb-3">
        <h4 class="mb-3 text-center">STRUK PEMBAYARAN</h4>
        <p><strong>Tanggal :</strong> {{ $dataUtama->nama_pelanggan }}</p>
        <p><strong>Kode Pesanan :</strong>
            {{ $dataUtama->kode_pesanan }}</p>
        <p><strong>Pelanggan :</strong> {{ $dataUtama->nama_pelanggan }}</p>
    </div>

    <hr>

    <table class="table table-sm borderless">
        <thead class="border-bottom border-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Layanan</th>
                <th scope="col">Berat</th>
                <th scope="col">Harga</th>
                <th scope="col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $i => $t)
                @php
                    $harga = optional($t->layanan)->harga ?? ($t->harga ?? 0);
                    $subtotal = $harga * ($t->berat ?? 0);
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ optional($t->layanan)->nama_layanan ?? '—' }}</td>
                    <td>{{ $t->berat ?? 0 }} kg</td>
                    <td>Rp{{ number_format($harga, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <div class="d-flex justify-content-between">
        <h5>Total :</h5>
        <h5><strong>Rp{{ number_format($dataUtama->nominal, 0, ',', '.') }}</strong></h5>
    </div>
    <hr>

    <p class="mt-3 text-center">✨ Terima Kasih Telah Menggunakan Jasa Kami ✨<br>
        <small>Barang yang sudah dicuci tidak dapat diklaim lebih dari 24 jam setelah pengambilan</small>
    </p>
    <p>
        Nama = Azzahra Nurayu Mutiara
    </p>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = () => {
                window.location.href = "{{ route('transaksi.index') }}";
            };
        };
    </script>
</body>

</html>
