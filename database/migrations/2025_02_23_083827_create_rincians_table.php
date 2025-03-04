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
        Schema::create('rincians', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_detail_ruangan');
            $table->unsignedBigInteger('id_barang')->nullable();
            $table->integer('jumlah_pinjam');
            $table->Integer('kondisi')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincians');
    }
};
