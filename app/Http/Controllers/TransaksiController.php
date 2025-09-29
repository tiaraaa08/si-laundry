<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all()->keyBy('id');
        $transaksi = Transaksi::with('layanan')->get();

        $transaksiGrouped = $transaksi->groupBy(function ($item) {
            return $item->nama_pelanggan . '|' . $item->tanggal_transaksi;
        })->map(function ($group) {
            $namaLayanan = $group->map(function ($item) {
                return $item->layanan->nama_layanan ?? '-';
            })->implode(', ');

            $totalBerat = $group->sum('berat');
            $tanggal = $group->first()->tanggal_transaksi;
            return (object)[
                'id' => $group->first()->id,
                'nama_pelanggan' => $group->first()->nama_pelanggan,
                'tanggal_transaksi' => $group->first()->tanggal_transaksi,
                'nama_layanan' => $namaLayanan,
                'berat' => $totalBerat,
                'nominal' => $group->first()->nominal,
                'keterangan' => $group->first()->keterangan,
                //   'tanggal_transaksi' => $group->first()->tanggal_transaksi,
            ];
        });

        return view('transaksi.transaksi', compact('transaksiGrouped', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'id_layanan' => 'required|array',
            'id_layanan.*' => 'exists:layanan,id',
            'tanggal_transaksi' => 'required|date',
            'berat' => 'required|array',
            'berat.*' => 'numeric|min:0',
            'nominal' => 'required',
        ]);

        $nama = $request->nama_pelanggan;
        $tanggal = $request->tanggal_transaksi;

        foreach ($request->id_layanan as $i => $layananId) {
            Transaksi::create([
                'nama_pelanggan' => $nama,
                'tanggal_transaksi' => $tanggal,
                'id_layanan' => $layananId,
                'berat' => $request->berat[$i] ?? 0,
                'nominal' => (int) str_replace(['Rp', '.', ','], '', $request->nominal), // kalau mau simpan total
                'keterangan' => 'belum',
            ]);
        }
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'nama_pelanggan'     => 'required',
            'id_layanan'         => 'required|exists:layanan,id',
            'tanggal_transaksi'  => 'required|date',
            'berat'              => 'required|numeric|min:0',
            'keterangan'         => 'required|in:belum,diproses,selesai',
            'nominal'            => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($validatedData);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $transaksi = transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'transaksi berhasil dihapus!');
    }
}
