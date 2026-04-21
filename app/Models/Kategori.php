<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Tambahkan baris ini agar Laravel mencari tabel 'category' bukan 'kategoris'
   protected $table = 'categories'; // Pastikan pakai 's' di belakangnya
    protected $fillable = ['nama_kategori'];
}