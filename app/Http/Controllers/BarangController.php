<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        confirmDelete('Delete', 'Are you sure?');
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();


        $latestBarang = Barang::latest()->first();
        $kodeBaru = $latestBarang ? 'BRG-' . str_pad($latestBarang->id + 1, 4, '0', STR_PAD_LEFT) : 'BRG-0001';

        return view('barang.create', compact('kategori', 'kodeBaru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'merk' => 'required',
            'id_kategori' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        // Generate kode barang otomatis
        $latestBarang = Barang::latest()->first();
        $kodeBaru = $latestBarang ? 'BRG-' . str_pad($latestBarang->id + 1, 4, '0', STR_PAD_LEFT) : 'BRG-0001';

        $barang = new Barang();
        $barang->code_barang = $kodeBaru;
        $barang->nama_barang = $request->nama_barang;
        $barang->merk = $request->merk;
        $barang->id_kategori = $request->id_kategori;
        $barang->detail = $request->detail;
        $barang->jumlah = $request->jumlah;
        $barang->save();

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('barang.index');
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'merk' => 'required',
            'id_kategori' => 'required',
            'detail' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->merk = $request->merk;
        $barang->id_kategori = $request->id_kategori;
        $barang->detail = $request->detail;
        $barang->jumlah = $request->jumlah;
        $barang->save();

        Alert::success('Success', 'Data berhasil diperbarui')->autoClose(1000);
        return redirect()->route('barang.index');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('barang.index');
    }
}
