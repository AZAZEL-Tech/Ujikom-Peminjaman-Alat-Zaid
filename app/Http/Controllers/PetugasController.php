<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // 1. Menampilkan Daftar Permintaan
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('petugas.dashboard', compact('peminjamans'));
    }

    // 2. Menerima (Approve) Peminjaman
    public function approve($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $alat = Alat::findOrFail($pinjam->alat_id);

        if ($alat->stok > 0) {
            $pinjam->update(['status' => 'disetujui']);
            $alat->decrement('stok', $pinjam->jumlah); // Kurangi stok berdasarkan jumlah pinjam
            
            return back()->with('success', 'Peminjaman Disetujui');
        }

        return back()->with('error', 'Gagal disetujui, Stok Habis!');
    }

    // 3. Menolak (Reject) Peminjaman
    public function reject($id)
    {
        Peminjaman::where('id', $id)->update(['status' => 'ditolak']);
        return back()->with('success', 'Peminjaman Ditolak');
    }

    // 4. Memproses Pengembalian (Return)
    public function return($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        
        $pinjam->update([
            'status' => 'kembali', 
            'tgl_dikembalikan' => now()
        ]);

        // Tambahkan stok kembali sesuai jumlah yang dipinjam
        Alat::where('id', $pinjam->alat_id)->increment('stok', $pinjam->jumlah);

        return back()->with('success', 'Barang Berhasil Dikembalikan');
    }
}