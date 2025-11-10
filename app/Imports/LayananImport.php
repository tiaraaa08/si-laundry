<?php

namespace App\Imports;

use App\Models\Layanan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LayananImport implements ToModel, WithStartRow
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

        return new Layanan([
            'nama_layanan' => $row[1],
            'deskripsi'    => $row[2],
            'harga'        => $row[3],
        ]);
    }
}
