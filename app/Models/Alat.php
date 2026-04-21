<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika kamu tidak menggunakan nama jamak 'alats'
    // Tapi karena tadi kita sudah sepakat pakai standar, biarkan default atau tulis:
    protected $table = 'alats';

    // Daftarkan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_alat',
        'kategori_id',
        'stok',
    ];

    /**
     * Relasi ke Model Kategori
     * Satu alat memiliki satu kategori (Belongs To)
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}