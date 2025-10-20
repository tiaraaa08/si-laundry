<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Log;

use Exception;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return view('layanan.layanan', compact('layanan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
        ]);

        Layanan::create($validatedData);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($validatedData);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }

  public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    $filePath = $request->file('file')->store('temp');
    $fullPath = storage_path('app/' . $filePath);

    Log::info('📂 File import path:', ['path' => $fullPath]);

    try {
        $rows = SimpleExcelReader::create($fullPath)->getRows();

        foreach ($rows as $row) {
            Log::info('🧾 Row data:', $row);

            Layanan::create([
                'nama_layanan' => $row['Nama Layanan'] ?? '',
                'deskripsi' => $row['Deskripsi Layanan'] ?? '',
                'harga' => (int) filter_var($row['Hrga (per KG)'] ?? 0, FILTER_SANITIZE_NUMBER_INT),
            ]);
        }

        return back()->with('success', 'Data berhasil diimport!');
    } catch (\Exception $e) {
        Log::error('❌ Error import:', ['message' => $e->getMessage()]);
        return back()->with('error', 'Gagal import: ' . $e->getMessage());
    }
}

}
