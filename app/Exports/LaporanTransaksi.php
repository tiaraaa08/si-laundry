<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTransaksi implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::where('keterangan', 'selesai')->with('layanan')->get();
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->tanggal_transaksi,
            $transaksi->berat,
            $transaksi->nominal,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Berat (KG)',
            'Nominal',
        ];
    }
}
