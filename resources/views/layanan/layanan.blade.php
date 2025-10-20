@extends('master')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Layanan</h1>
        <button type="button" data-toggle="modal" data-target="#exampleModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fa-duotone fa-solid fa-plus"></i> tambah
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 justify-content-between d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Layanan Terbaru
            </h6>
            <div>
                <button type="button" data-toggle="modal" data-target="#exportLayanan"
                    class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                  <i class="fa-duotone fa-solid fa-download"></i>Export
                </button>
                <button type="button" data-toggle="modal" data-target="#importLayanan"
                    class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm ms-4">
                    <i class="fa-duotone fa-solid fa-file-import"></i> Import
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga (per kg)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga (per kg)</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($layanan as $l)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$l->nama_layanan}}</td>
                                <td>{{$l->deskripsi}}</td>
                                <td>RP{{number_format($l->harga, 0, ',', '.')}}</td>
                                <td>
                                    <div class="justify-content-start-2 d-flex">
                                        <button type="button" class="btn btn-sm btn-primary mx-2" data-toggle="modal"
                                            data-target="#editLayanan-{{$l->id}}"> <i
                                                class="fa-duotone fa-solid fa-pen-to-square"></i>Edit</button>
                                        <form action="{{ route('layanan.destroy', $l->id) }}" method="POST"
                                            class="hapus-transaksi-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"> <i
                                                    class="fa-duotone fa-solid fa-trash"></i>Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @include('layanan.edit')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layanan.import')
    {{-- @include('layanan.export') --}}
    @include('layanan.tambah')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.hapus-transaksi-form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data transaksi akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
