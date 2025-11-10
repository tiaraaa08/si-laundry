<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::with('layanan')->get();
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->nama_pelanggan,
            // kalau relasi ke layanan, ambil nama layanan, kalo enggak, tinggal pakai $transaksi->layanan aja
            $transaksi->layanan->nama_layanan ?? $transaksi->layanan,
            $transaksi->tanggal_transaksi,
            $transaksi->berat,
            $transaksi->nominal,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pelanggan',
            'Layanan',
            'Tanggal',
            'Berat (KG)',
            'Nominal',
        ];
    }
}
