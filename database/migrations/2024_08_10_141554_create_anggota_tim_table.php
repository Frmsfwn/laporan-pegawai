<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_tim', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_tim_kegiatan')->references('id')->on('tim_kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_anggota')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_tim');
    }
};
