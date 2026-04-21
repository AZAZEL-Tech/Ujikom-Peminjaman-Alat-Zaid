<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Kabel A to Type C'],
            ['nama_kategori' => 'Type C to Type C'],
            ['nama_kategori' => 'Converter VGA to HDMI'],
            ['nama_kategori' => 'HDMI to Type C'],
            ['nama_kategori' => 'Converter LAN to Type C'],
        ];

        foreach ($data as $k) {
            Kategori::create($k);
        }
    }
}