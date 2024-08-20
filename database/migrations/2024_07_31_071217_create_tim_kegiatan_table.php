<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_kegiatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status_laporan',['Selesai','Belum Selesai'])->default('Belum Selesai');
            $table->string('nama');
            $table->foreignUuid('id_tahun_kegiatan')->references('id')->on('tahun_kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_kegiatan');
    }
};
