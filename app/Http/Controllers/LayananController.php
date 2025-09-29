<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

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

    public function destroy ($id){
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
