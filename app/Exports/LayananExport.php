<?php

namespace App\Exports;

use App\Models\Layanan;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LayananExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Layanan::all();
    }

    public function map($layanan): array
    {
        return [
            $layanan->nama_layanan,
            // kalau relasi ke layanan, ambil nama layanan, kalo enggak, tinggal pakai $layanan->layanan aja
            $layanan->deskripsi,
            $layanan->harga,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Layanan',
            'Deskripsi',
            'Harga perKG',
        ];
    }
}
