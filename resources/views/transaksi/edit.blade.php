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
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama_pelanggan"
                                value="{{$t->nama_pelanggan}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_transaksi"
                                value="{{ date('Y-m-d', strtotime($t->tanggal_transaksi)) }}">
                        </div>
                    </div>
                    <div class="wrapper-layanan-edit">
                        @foreach ($t->layanan_detail as $index => $layanans)
                            <div class="row produk-row align-items-center mb-2">
                                @if ($index > 0)
                                    <div class="col-md-7">
                                        <label for="layananInput-edit-{{ $index }}" class="form-label">Layanan</label>
                                        <select class="form-control layananInput-edit" id="layananInput-edit-{{ $index }}"
                                            name="id_layanan[]" required>
                                            <option value="">Pilih Layanan</option>
                                            @foreach ($layanan as $item)
                                                <option value="{{ $item->id }}" data-nominal="{{ $item->harga }}" {{ $layanans->id_layanan == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_layanan }} (Rp{{ number_format($item->harga, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="beratInput-edit-{{ $index }}" class="form-label">Berat (kg)</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control jumlah-berat"
                                                id="beratInput-edit-{{ $index }}" name="berat[]" placeholder="Masukkan berat"
                                                required value="{{ $layanans->berat }}">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>

                                    <div class="col-md-1 d-flex justify-content-center">
                                        <button type="button" class="remove-produk btn btn-danger btn-sm align-self-center"
                                            style="margin-top: 33px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            ✖
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-8">
                                        <label for="layananInput-edit-{{ $index }}" class="form-label">Layanan</label>
                                        <select class="form-control layananInput-edit" id="layananInput-edit-{{ $index }}"
                                            name="id_layanan[]" required>
                                            <option value="">Pilih Layanan</option>
                                            @foreach ($layanan as $item)
                                                <option value="{{ $item->id }}" data-nominal="{{ $item->harga }}" {{ $layanans->id_layanan == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_layanan }} (Rp{{ number_format($item->harga, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="beratInput-edit-{{ $index }}" class="form-label">Berat (kg)</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control jumlah-berat"
                                                id="beratInput-edit-{{ $index }}" name="berat[]" placeholder="Masukkan berat"
                                                required value="{{ $layanans->berat }}">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>

                                    <div class="col-md-1 d-flex justify-content-center">
                                        {{-- <div style="height: 35px; width: 35px;"></div> --}}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div class="mt-1">
                            <button type="button" class="btn btn-sm btn-primary" id="edit-tambah-layanan">+ Tambah
                                Layanan</button>
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="form-group col-md-8">
                            <label>Nominal</label>
                            <input type="text" readonly class="form-control nominalInput-edit"
                                value="{{'Rp ' . number_format($t->nominal, 0, ',', '.')}}" name="nominal">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select class="custom-select" name="keterangan">
                                <option disabled>Pilih Status</option>
                                <option value="belum" {{ $t->keterangan == 'belum' ? 'selected' : '' }}>Belum</option>
                                <option value="diproses" {{ $t->keterangan == 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="selesai" {{ $t->keterangan == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="sudah diambil" {{ $t->keterangan == 'sudah diambil' ? 'selected' : '' }}>sudah diambil
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
            const wrapper = modal.querySelector('.wrapper-layanan-edit');
            const nominalInput = modal.querySelector('.nominalInput-edit');
            const tambahBtn = modal.querySelector('#edit-tambah-layanan'); // ⬅️ ini yang diubah

            // fungsi buat hitung nominal
            function hitungNominal() {
                let total = 0;
                wrapper.querySelectorAll('.produk-row').forEach(row => {
                    const select = row.querySelector('.layananInput-edit, .produk-select');
                    const berat = parseFloat(row.querySelector('.jumlah-berat').value) || 0;
                    const harga = parseFloat(select?.selectedOptions[0]?.dataset.nominal || select?.selectedOptions[0]?.dataset.harga || 0);
                    total += harga * berat;
                });
                nominalInput.value = 'Rp ' + total.toLocaleString('id-ID');
            }

            // listener update nominal
            wrapper.addEventListener('input', e => {
                if (e.target.classList.contains('layananInput-edit') || e.target.classList.contains('jumlah-berat')) {
                    hitungNominal();
                }
            });

            // hapus row
            wrapper.addEventListener('click', e => {
                if (e.target.classList.contains('remove-produk')) {
                    const rows = wrapper.querySelectorAll('.produk-row');
                    // biar minimal 1 row tetep ada
                    if (rows.length > 1) {
                        e.target.closest('.produk-row').remove();
                        hitungNominal();
                    }
                }
            });

            // tambah row baru
            // tambah row baru
            tambahBtn.addEventListener('click', () => {
                const newRow = document.createElement('div');
                newRow.className = 'row produk-row align-items-center mb-2';
                newRow.innerHTML = `
                    <div class="col-md-7">
                        <label class="form-label">Layanan</label>
                        <select class="form-control layananInput-edit" name="id_layanan[]" required>
                            <option value="">Pilih Layanan</option>
                            @foreach ($layanan as $item)
                                <option value="{{ $item->id }}" data-nominal="{{ $item->harga }}">
                                    {{ $item->nama_layanan }} (Rp{{ number_format($item->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Berat (kg)</label>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control jumlah-berat"
                                name="berat[]" placeholder="Masukkan berat" required>
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center">
                        <button type="button" class="remove-produk btn btn-danger btn-sm align-self-center"
                            style=" margin-top: 34px; height: 35px; display: flex; align-items: center; justify-content: center;">✖</button>
                    </div>
                `;
                wrapper.insertBefore(newRow, tambahBtn.parentNode); // naro row di atas tombol
            });

        });
    });
</script>
