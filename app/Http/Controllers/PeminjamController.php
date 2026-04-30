<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    // 1. Menampilkan Halaman Dashboard Peminjam
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Mengambil data alat, jika ada pencarian maka difilter
        $alats = Alat::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_alat', 'like', "%{$search}%");
            })->get();

        // Mengambil riwayat peminjaman khusus user yang sedang login
        $riwayats = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('peminjam.dashboard', compact('alats', 'riwayats'));
    }

    // 2. Memproses Pengajuan Peminjaman
    public function store(Request $req)
    {
        // Validasi input
        $req->validate([
            'alat_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ], [
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam minimal hari ini.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali salah.',
        ]);

        $alat = Alat::findOrFail($req->alat_id);

        // Cek apakah jumlah yang dipinjam melebihi stok
        if ($req->jumlah > $alat->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        // Simpan data Peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $req->alat_id,
            'jumlah' => $req->jumlah,
            'tanggal_pinjam' => $req->tanggal_pinjam,
            'tanggal_kembali' => $req->tanggal_kembali,
            'status' => 'menunggu'
        ]);

        // Kurangi stok alat (Diperbaiki dari PDF agar stok benar-benar berkurang)
        $alat->stok -= $req->jumlah;
        $alat->save();

        return back()->with('success', 'Peminjaman Berhasil Diajukan');
    }
}