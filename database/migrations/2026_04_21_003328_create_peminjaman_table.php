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
        
        // Foreign key to the users table
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Foreign key to the alat table
        $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade'); 
        
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali')->nullable();
        
        // Enum for status: dipinjam or dikembalikan
        $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
        
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
