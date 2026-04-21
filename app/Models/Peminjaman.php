<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Force the correct table name
    protected $table = 'peminjaman';

    protected $guarded = ['id'];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Alat
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}