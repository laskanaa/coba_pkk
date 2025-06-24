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
        Schema::create('program_unggulans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program'); // Contoh: "POKJA I"
            $table->string('deskripsi');    // Deskripsi singkat
            $table->text('ikon_svg')->nullable(); // Untuk menyimpan kode SVG ikon
            $table->string('warna_tema')->nullable(); // Contoh: "red-100"
            $table->integer('urutan')->default(0); // Untuk mengurutkan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_unggulans');
    }
};
