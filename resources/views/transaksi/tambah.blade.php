<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('transaksi.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama_pelanggan">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal_transaksi">
                        </div>
                    </div>
                    <div class="form-row">
                        <div id="wrapper-layanan-tambah">
                            <div class="mt-2 row produk-row">
                                <div class="col-md-9">
                                    <label class="form-label">Layanan</label>
                                    <select class="custom-select produk-select" name="id_layanan[]" required>
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($layanan as $item)
                                            <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                                {{ $item->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Berat(kg)</label>
                                    <input type="number" min="0" class="form-control jumlah-berat" name="berat[]">
                                </div>
                            </div>
                        </div>
                        <div class="mt-1">
                            <button type="button" class="btn btn-sm btn-primary" id="tambah-layanan">+ Tambah
                                Layanan</button>
                        </div>
                    </div>
                    <div class="mt-2 form-row">
                        <label for="inputEmail4">Nominal</label>
                        <input type="text" readonly class="form-control" id="nominalInput" name="nominal">
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
        const layananSelect = document.getElementById('layananSelect');
        const beratInput = document.getElementById('beratInput');
        const nominalInput = document.getElementById('nominalInput');

        function updateNominal() {
            const selectedOption = layananSelect.options[layananSelect.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const berat = parseFloat(beratInput.value) || 0;

            const total = harga * berat;
            nominalInput.value = total;
        }

        layananSelect.addEventListener('change', updateNominal);
        beratInput.addEventListener('input', updateNominal);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('wrapper-layanan-tambah');
        const tambahBtn = document.getElementById('tambah-layanan');
        const nominalInput = document.getElementById('nominalInput');

        function hitungNominal() {
            let total = 0;
            const rows = wrapper.querySelectorAll('.produk-row');
            rows.forEach(row => {
                const harga = parseFloat(row.querySelector('.produk-select').selectedOptions[0].dataset.harga || 0);
                const berat = parseFloat(row.querySelector('.jumlah-berat').value || 0);
                total += harga * berat;
            });
            nominalInput.value = `Rp${total.toLocaleString()}`;
        }

        tambahBtn.addEventListener('click', () => {
            const firstRow = wrapper.querySelector('.produk-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelector('.produk-select').value = '';
            newRow.querySelector('.jumlah-berat').value = '';

            newRow.querySelectorAll('label').forEach(label => label.remove());

            newRow.className = 'row produk-row align-items-end';
            newRow.innerHTML = `
        <div class="col-md-8">
            <select class="form-control produk-select" name="id_layanan[]" required>
                <option value="">Pilih Layanan</option>
                @foreach ($layanan as $item)
                    <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                        {{ $item->nama_layanan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" min="0" class="form-control jumlah-berat" name="berat[]" placeholder="Berat (kg)">
        </div>
        <div class="col-md-1">
            <button type="button" class="remove-produk btn btn-danger btn-sm">✖</button>
        </div>
    `;
            wrapper.appendChild(newRow);
        });

        wrapper.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-produk')) {
                e.target.closest('.produk-row').remove();
                hitungNominal();
            }
        });

        wrapper.addEventListener('input', (e) => {
            if (e.target.classList.contains('produk-select') || e.target.classList.contains('jumlah-berat')) {
                hitungNominal();
            }
        });
    });
</script>
