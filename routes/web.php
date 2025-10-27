<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index'])->name('beranda.index');
// Route::get('/transaksi', function () {
//     return view('transaksi.transaksi');
// });
// Route::get('/layanan', function () {
//     return view('layanan');
// });

Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
Route::post('/layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/struk/{kode_pesanan}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
Route::post('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan.index');

Route::post('/layanan/import', [LayananController::class, 'import'])->name('layanan.import');
Route::get('/layanan/export', [LayananController::class, 'export'])->name('layanan.export');
