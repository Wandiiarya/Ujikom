<?php

namespace App\Http\Controllers;

use App\Models\Rincian;
use App\Models\Ruangan;
use App\Models\Detail_ruangan;
use App\Models\Barang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DetailRuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $detail_ruangan = Detail_ruangan::all();
        confirmDelete('Delete', 'Are you sure?');
        return view('detail_ruangan.index', compact('detail_ruangan'));
    }

    public function create()
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        return view('detail_ruangan.create', compact('barang', 'ruangan'));
    }

    public function store(Request $request)
    {

        $detailRuangan = new Detail_ruangan();
        $detailRuangan->id_ruangan = $request->id_ruangan;
        $detailRuangan->save();

        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);

            if ($barang->jumlah < $request->jumlah_pinjam[$index]) {
                Alert::error('Error', 'Stok barang tidak mencukupi!')->autoClose(2000);
                return redirect()->back();
            }            $barang->save();

            Rincian::create([
                'id_detail_ruangan' => $detailRuangan->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
                'kondisi' => $request->kondisi[$index],
            ]);
        }

        Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);
        return redirect()->route('detail_ruangan.index');
    }

    public function edit($id)
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $detail_ruangan = Detail_ruangan::findOrFail($id);
        return view('detail_ruangan.edit', compact('detail_ruangan', 'barang', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_barang' => 'required|array',
            'jumlah_pinjam' => 'required|array',
            'jumlah_pinjam.*' => 'integer|min:1',
            'kondisi' => 'required|array',
        ]);

        $detailRuangan = Detail_ruangan::findOrFail($id);
        $detailRuangan->id_ruangan = $request->id_ruangan;
        $detailRuangan->save();

        Rincian::where('id_detail_ruangan', $id)->delete();

        foreach ($request->id_barang as $index => $id_barang) {
            $barang = Barang::findOrFail($id_barang);
            $barang->jumlah -= $request->jumlah_pinjam[$index];
            $barang->save();

            Rincian::create([
                'id_detail_ruangan' => $detailRuangan->id,
                'id_barang' => $id_barang,
                'jumlah_pinjam' => $request->jumlah_pinjam[$index],
                'kondisi' => $request->kondisi[$index],
            ]);
        }

        Alert::success('Success', 'Data berhasil diperbarui')->autoClose(1000);
        return redirect()->route('detail_ruangan.index');
    }

    public function destroy($id)
    {
        $detailRuangan = Detail_ruangan::findOrFail($id);
        $rincian = Rincian::where('id_detail_ruangan', $id)->get();

        foreach ($rincian as $item) {
            $barang = Barang::findOrFail($item->id_barang);
            $barang->jumlah += $item->jumlah_pinjam;
            $barang->save();
            $item->delete();
        }

        $detailRuangan->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('detail_ruangan.index');
    }
}
