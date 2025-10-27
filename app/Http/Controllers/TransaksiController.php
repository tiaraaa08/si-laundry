<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all()->keyBy('id');
        $transaksi = Transaksi::with('layanan')->get()->where('keterangan', '!=', 'selesai');

        $transaksiGrouped = $transaksi->groupBy(function ($item) {
            return $item->nama_pelanggan . '|' . $item->tanggal_transaksi;
        })->map(function ($group) {
            $namaLayanan = $group->map(function ($item) {
                return $item->layanan->nama_layanan ?? '-';
            })->implode(', ');

            return (object)[
                'id' => $group->first()->id,
                'nama_pelanggan' => $group->first()->nama_pelanggan,
                'tanggal_transaksi' => $group->first()->tanggal_transaksi,
                'nama_layanan' => $namaLayanan,
                'layanan_detail' => $group, // <== tambahin ini!
                'berat' => $group->sum('berat'),
                'nominal' => $group->first()->nominal,
                'keterangan' => $group->first()->keterangan,
            ];
        });

        return view('transaksi.transaksi', compact('transaksiGrouped', 'layanan'));
    }

    public function store(Request $request)
    {
        $kodePesanan = 'PESN-' . date('dm') . '-' . date('Hi') . '-' . strtoupper(Str::random(3));
        $nominalBersih = preg_replace('/[^\d]/', '', $request->nominal);

        foreach ($request->id_layanan as $key => $layanan_id) {
            $layanan = Layanan::find($layanan_id);
            $berat = $request->berat[$key];
            $subtotal = $layanan->harga * $berat;

            Transaksi::create([
                'kode_pesanan' => $kodePesanan,
                'nama_pelanggan' => $request->nama_pelanggan,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_layanan' => $layanan_id,
                'berat' => $berat,
                'nominal' => $nominalBersih,
                'keterangan' => 'belum',
            ]);
        }

       return redirect()->route('transaksi.struk', $kodePesanan);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required',
            'id_layanan' => 'required|array',
            'id_layanan.*' => 'exists:layanan,id',
            'tanggal_transaksi' => 'required|date',
            'berat' => 'required|array',
            'berat.*' => 'numeric|min:0',
            'keterangan' => 'required|in:belum,diproses,selesai',
            'nominal' => 'required',
        ]);

        // cari kode pesanan yang sama
        $transaksi = Transaksi::findOrFail($id);
        $kodePesanan = $transaksi->kode_pesanan;

        // hapus transaksi lama dengan kode itu
        Transaksi::where('kode_pesanan', $kodePesanan)->delete();

        // masukin ulang data baru
        foreach ($request->id_layanan as $i => $layananId) {
            Transaksi::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'kode_pesanan' => $kodePesanan,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_layanan' => $layananId,
                'berat' => $request->berat[$i] ?? 0,
                'nominal' => (int) str_replace(['Rp', '.', ','], '', $request->nominal),
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = transaksi::findOrFail($id);
        $hapus = transaksi::where('kode_pesanan', $transaksi->kode_pesanan)->get();
        foreach ($hapus as $h) {
            $h->delete();
        }

        return redirect()->route('transaksi.index')->with('success', 'transaksi berhasil dihapus!');
    }

public function struk($kodePesanan)
{
    // ambil semua transaksi dengan kode yang sama (bisa banyak layanan)
    $detail = Transaksi::with('layanan')
        ->where('kode_pesanan', $kodePesanan)
        ->get();

    if ($detail->isEmpty()) {
        return redirect()->route('transaksi.index')->with('error', 'Kode pesanan tidak ditemukan.');
    }

    // ambil satu aja buat header struk (karna nama pelanggan, tanggal, dll sama)
    $first = $detail->first();

    // siapkan data utama (mirip yang kamu mau pakai di view)
    $dataUtama = (object) [
        'kode_pesanan' => $kodePesanan,
        'nama_pelanggan' => $first->nama_pelanggan,
        'tanggal_transaksi' => $first->tanggal_transaksi,
        // nominal di DB disimpan per baris, tapi kamu menyimpan total sama di setiap row;
        // kalau mau lebih aman, kita hitung total dari detail:
        'nominal' => $detail->sum(function($row) {
            // pakai harga dari relasi layanan kalau ada, fallback ke kolom harga di transaksi
            $harga = optional($row->layanan)->harga ?? ($row->harga ?? 0);
            return $harga * ($row->berat ?? 0);
        }),
    ];

    return view('struk', compact('dataUtama', 'detail'));
}


    public function laporan(Request $request)
    {
        return view('transaksi.laporan');
    }
}
