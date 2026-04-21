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
    Schema::create('alats', function (Blueprint $table) {
        $table->id();
        // foreignId ini untuk menghubungkan ke tabel kategoris
        $table->foreignId('kategori_id')->constrained('categories')->onDelete('cascade');
        $table->string('nama_alat');
        $table->integer('stok');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
