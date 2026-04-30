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
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade'); 
        
        // Kolom jumlah yang mau dipinjam
        $table->integer('jumlah'); 
        
        // Disesuaikan penamaannya dengan Controller (pakai 'tanggal_' bukan 'tgl_')
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali');
        
        // Kolom untuk mencatat tanggal real saat alat benar-benar dikembalikan
        $table->date('tgl_dikembalikan')->nullable(); 
        
        // Enum status disesuaikan dengan PDF
        $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'kembali'])->default('menunggu');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
