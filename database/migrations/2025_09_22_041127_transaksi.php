<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->text('id_layanan');
            $table->dateTime('tanggal_transaksi');
            $table->integer('berat');
            $table->string('nama_pelanggan');
            $table->string('kode_pesanan');
            $table->enum('keterangan', ['belum', 'diproses', 'selesai', 'sudah diambil'])->default('belum');
            $table->integer('nominal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
