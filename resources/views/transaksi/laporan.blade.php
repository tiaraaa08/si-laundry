@extends('master')
@section('content')
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <button type="button" data-toggle="modal" data-target="#exampleModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            tambah
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
        <div class="btn-group">
            <a href="{{ route('laporan.export') }}" id="exportExcel" class="btn btn-sm btn-success shadow-sm">
                <i class="fa-solid fa-file-excel"></i> Export
            </a>
        </div>
    </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Jumlah Berat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('Y-m-d', strtotime($t->tanggal_transaksi)) }}</td>
                                <td>{{ $t->berat }} KG</td>
                                <td>Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Jumlah Berat</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
