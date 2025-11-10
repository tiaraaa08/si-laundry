<div class="modal fade" id="editLayanan-{{$l->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('layanan.update', $l->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nama Layanan</label>
                            <input type="text" class="form-control" name="nama_layanan" id="inputEmail4" required value="{{$l->nama_layanan}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Harga</label>
                            <input type="number" name="harga" class="form-control" id="inputPassword4" required value="{{$l->harga}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="inputEmail4">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" id="inputEmail4" required value="{{$l->deskripsi}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
