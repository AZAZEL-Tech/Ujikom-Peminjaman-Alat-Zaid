<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Alat;
use App\Models\User; 
use App\Models\Peminjaman; // Tambahan untuk memanggil tabel Peminjaman
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Dashboard Utama
    public function index()
    {
        return view('dashboard'); 
    }

    // --- BAGIAN KATEGORI ---

    public function kategori() {
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }

    public function storeKategori(Request $req) {
        Kategori::create($req->all());
        return back()->with('success', 'Kategori Ditambah');
    }

    public function editKategori($id) {
        $kategori = Kategori::findOrFail($id);
        return view('admin.edit_kategori', compact('kategori'));
    }

    public function updateKategori(Request $req, $id) {
        $k = Kategori::findOrFail($id);
        $k->update($req->all());
        return redirect()->route('admin.kategori')->with('success', 'Kategori Diupdate');
    }

    public function destroyKategori($id) {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori Dihapus');
    }

    // --- BAGIAN ALAT ---

    public function alat()
    {
        $alats = Alat::with('kategori')->get(); 
        $kategoris = Kategori::all();
        return view('admin.alat', compact('alats', 'kategoris'));
    }

    public function storeAlat(Request $req)
    {
        Alat::create($req->all());
        return back()->with('success', 'Alat Ditambah');
    }

    public function editAlat($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.edit_alat', compact('alat', 'kategoris'));
    }

    public function updateAlat(Request $req, $id)
    {
        $a = Alat::findOrFail($id);
        $a->update($req->all());
        return redirect()->route('admin.alat')->with('success', 'Alat Diupdate');
    }

    public function destroyAlat($id)
    {
        Alat::destroy($id);
        return back()->with('success', 'Alat Dihapus');
    }

    // --- BAGIAN USER (BERSIH DARI ERROR) ---

    public function user()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function storeUser(Request $req) 
    {
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'role' => $req->role
        ]);

        return back()->with('success', 'User Ditambah');
    }

    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User Dihapus');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $req, $id)
    {
        $u = User::findOrFail($id);
        
        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->role
        ];

        if ($req->password) {
            $data['password'] = bcrypt($req->password);
        }

        $u->update($data);

        return redirect()->route('admin.user')->with('success', 'User Diupdate');
    }

    // --- BAGIAN PEMINJAMAN ---

    public function peminjaman()
    {
        // Mengambil data peminjaman beserta relasi user dan alatnya agar tampil di tabel
        $peminjamans = Peminjaman::with(['user', 'alat'])->get();
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function destroyPeminjaman($id)
    {
        // Fitur hapus data peminjaman
        Peminjaman::destroy($id);
        return back()->with('success', 'Data Peminjaman Berhasil Dihapus');
    }
}