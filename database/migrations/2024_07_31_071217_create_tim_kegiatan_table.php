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
            $table->string('nama');
            $table->foreignUuid('id_tahun_kegiatan')->references('id')->on('tahun_kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_ketua')->nullable()->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_anggota')->nullable()->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_kegiatan');
    }
};
