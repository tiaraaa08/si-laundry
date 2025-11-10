<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $layanan = Layanan::count();
        $transaksiJuml = transaksi::count();
        $pendapatanHariIni = transaksi::whereDate('tanggal_transaksi', Carbon::today())
        ->where('keterangan', 'selesai')
        ->sum('nominal');
        $belumDiambil = transaksi::where('keterangan', 'selesai')->count();
        $pesananTerbaru = DB::table('transaksi')
            ->select(
                'tanggal_transaksi',
                'nama_pelanggan',
                DB::raw('GROUP_CONCAT(id_layanan SEPARATOR ", ") as layanan'),
                DB::raw('SUM(nominal) as total'),
                DB::raw('SUM(berat) as total_berat')
            )
            ->groupBy('tanggal_transaksi', 'nama_pelanggan')
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get();

            // dd($pesananTerbaru);
        $bulan = $request->get('bulan', Carbon::now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();

        $transaksi = DB::table('transaksi')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->get();

        $labels = [];
        $data = [];

        $totalMinggu = ceil($end->day / 7);
        for ($i = 1; $i <= $totalMinggu; $i++) {
            $labels[] = "Minggu $i";
            $data[] = 0;
        }

        foreach ($transaksi as $t) {
            $day = Carbon::parse($t->tanggal_transaksi)->day;
            $mingguKe = ceil($day / 7);
            $data[$mingguKe - 1] += $t->nominal;
        }

        return view('beranda', compact('labels', 'data', 'bulan', 'pesananTerbaru', 'layanan', 'transaksiJuml', 'pendapatanHariIni', 'belumDiambil'));
    }
}
