<div class="modal fade" id="editTransaksi-{{ $loop->iteration }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('transaksi.update', $t->id)}}" method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nama</label>
                            <input type="text" class="form-control" id="namaInput-edit" name="nama_pelanggan"
                                value="{{$t->nama_pelanggan}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Tanggal</label>
                            <input type="date" class="form-control" id="tanggalInput-edit" name="tanggal_transaksi"
                                value="{{ date('Y-m-d', strtotime($t->tanggal_transaksi)) }}">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        @foreach ($t->layanan_detail as $index => $layanans)
                        <div class="form-group col-md-8">
                            <label for="layananInput-edit">Layanan</label>
                            <select class="custom-select layananInput-edit" id="layananInput-edit-{{ $index }}" name="id_layanan[]">
                                <option selected disabled>Pilih Layanan</option>
                                @foreach ($layanan as $item) {{-- ganti $layananSemua dengan variabel yg isinya semua layanan --}}
                                    <option value="{{ $item->id }}"
                                        data-nominal="{{ $item->harga }}"
                                        {{ $layanans->id_layanan == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="beratInput-edit-{{ $index }}">Berat (kg)</label>
                            <input type="number" class="form-control beratInput-edit" id="beratInput-edit-{{ $index }}" name="berat[]"
                            value="{{ $layanans->berat }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputEmail4">Nominal</label>
                            <input type="text" readonly class="form-control" id="nominalInput-edit"
                                value="{{'Rp ' . number_format($t->nominal, 0, ',', '.')}}" name="nominal">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="statusInput-edit">Status</label>
                            <select class="custom-select" id="statusInput-edit" name="keterangan">
                                <option disabled>Pilih Status</option>
                                <option value="belum" {{ $t->keterangan == 'belum' ? 'selected' : '' }}>Belum</option>
                                <option value="diproses" {{ $t->keterangan == 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="selesai" {{ $t->keterangan == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                        </div>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="editTransaksi-"]').forEach(function (modal) {
        const layananSelects = modal.querySelectorAll('.layananInput-edit');
        const beratInputs = modal.querySelectorAll('.beratInput-edit');
        const nominalInput = modal.querySelector('#nominalInput-edit');

        function updateNominal() {
            let total = 0;
            layananSelects.forEach((select, i) => {
                const selectedOption = select.options[select.selectedIndex];
                const harga = parseFloat(selectedOption.getAttribute('data-nominal')) || 0;
                const berat = parseFloat(beratInputs[i].value) || 0;
                total += harga * berat;
            });
            nominalInput.value = 'Rp ' + total.toLocaleString('id-ID');
        }

        layananSelects.forEach((select, i) => {
            select.addEventListener('change', updateNominal);
            beratInputs[i].addEventListener('input', updateNominal);
        });
    });
});
</script>

