<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Imports\LayananImport;
use Maatwebsite\Excel\Facades\Excel;
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
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $path = $request->file('file')->store('temp');
        $fullPath = storage_path('app/' . $path);

        Log::info('📂 File import path:', ['path' => $fullPath, 'exists' => file_exists($fullPath)]);

        if (!file_exists($fullPath)) {
            throw new \Exception("File tidak ditemukan di path: {$fullPath}");
        }

        Excel::import(new LayananImport, $fullPath);

        return back()->with('success', 'Data layanan berhasil diimport!');
    } catch (\Exception $e) {
        Log::error('❌ Error import:', ['message' => $e->getMessage()]);
        return back()->with('error', 'Gagal import: ' . $e->getMessage());
    }
}
}
