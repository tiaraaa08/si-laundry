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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
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
                            {{-- <th>Berat</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($transaksiGrouped as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->nama_pelanggan }}</td>
                                <td>{{ $t->nama_layanan }}</td>
                                <td>{{ date('Y-m-d', strtotime($t->tanggal_transaksi)) }}</td>
                                <td>{{ $t->berat }} KG</td>
                                <td>Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                                <td>{{ $t->keterangan }}</td>
                                <td>
                                    <div class="justify-content-start-2 d-flex">
                                        <button type="button" class="btn btn-sm btn-primary mx-2" data-toggle="modal"
                                            data-target="#editTransaksi-{{ $loop->iteration }}">Edit</button>
                                        <form action="{{ route('transaksi.destroy', $t->id ?? '') }}" method="POST"
                                            class="hapus-transaksi-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @include('transaksi.edit')
                        @endforeach --}}
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
