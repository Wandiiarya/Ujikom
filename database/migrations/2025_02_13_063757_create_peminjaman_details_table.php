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
        Schema::create('peminjaman_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pm_barang');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah_pinjam');
            $table->timestamps();

            // $table->foreign('id_peminjaman')->references('id')->on('pm_barangs')->onDelete('cascade');
            // $table->foreign('id_barang')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_details');
    }
};
