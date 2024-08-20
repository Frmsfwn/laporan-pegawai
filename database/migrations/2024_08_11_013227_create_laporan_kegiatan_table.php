<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kegiatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_tim_kegiatan')->references('id')->on('tim_kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_tahun_kegiatan')->references('id')->on('tahun_kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status_laporan',['Diterima','Ditolak'])->nullable();
            $table->string('judul_laporan');
            $table->string('nama_tim_kegiatan');
            $table->string('informasi_kegiatan');
            $table->string('lampiran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kegiatan');
    }
};
