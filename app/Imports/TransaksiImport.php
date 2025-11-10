<?php

namespace App\Imports;

use App\Models\Layanan;
use App\Models\transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;

class TransaksiImport implements ToModel, WithStartRow
{
    /**
     * Tentuin mulai baca dari baris ke-3 (karena header kamu di baris 2)
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * Mapping kolom Excel ke kolom database
     */
    public function model(array $row)
    {

        if (!isset($row[1]) || !isset($row[2]) || !isset($row[3])) {
            return null; // skip baris kosong
        }

        return new Transaksi([
            'nama_pelanggan'      => $row[1],
            'id_layanan'          => Layanan::where('nama_layanan', $row[2])->value('id'),
            'tanggal_transaksi'   => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])->format('Y-m-d'),
            'berat'               => $row[4],
            'nominal'             => preg_replace('/[^\d]/', '', $row[5]),
            'keterangan'          => $row[6] ?? 'belum',
            'kode_pesanan'        => $row[7] ??  'PESN-' . date('dm') . '-' . date('Hi') . '-' . strtoupper(Str::random(3)),
        ]);
    }
}
