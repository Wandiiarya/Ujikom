<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Ruangan;
use App\Models\Kategori;

class HomeController extends Controller
{
    /**
     * Buat instance controller baru.
     * Middleware `auth` memastikan hanya pengguna yang terautentikasi yang dapat mengakses.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan dashboard aplikasi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Menghitung jumlah data dari setiap tabel
        $kategori = Kategori::count();
        $barang = Barang::count();
        $anggota = Anggota::count();
        $ruangan = Ruangan::count();

        // Mengirim data ke tampilan home.blade.php
        return view('home', compact('kategori', 'barang', 'anggota', 'ruangan'));
    }
}
