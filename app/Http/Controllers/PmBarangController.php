<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Ruangan;
use App\Models\pm_barang;
use App\Models\peminjaman_details;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Illuminate\Http\Request;

class PmBarangController extends Controller
{
    public function viewPDF(Request $request)
    {
        $pm_barang = pm_barang::findOrFail($request->idPeminjaman);

        $data = [
            'date' => date('m/d/Y'),
            'pm_barang' => $pm_barang,
        ];

        $pdf = PDF::loadView('pm_barang.export-pdf', $data)->setPaper('a4', 'portrait');

        return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }

    public function viewBARANG(Request $request)
    {
        $pm_barang = pm_barang::findOrFail($request->idPeminjaman);

        $isi = [
            'date' => date('m/d/Y'),
            'pm_barang' => $pm_barang,
        ];

        $pdf = PDF::loadView('pm_barang.export-barang', $isi)
            ->setPaper('a4', 'portrait');

        return response($pdf->stream(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pm_barang = pm_barang::all();
        confirmDelete('Delete','Are you sure?');
          $anggota = Anggota::all();

        return view('pm_barang.index', compact('pm_barang'));
    }

  public function create()
{
    $barang = Barang::all();
    $ruangan = Ruangan::all();
    $anggota = Anggota::all();

    // Generate kode peminjaman otomatis
    $latest = Pm_Barang::latest()->first();
    $kodePeminjaman = $latest ? 'PM-' . str_pad($latest->id + 1, 4, '0', STR_PAD_LEFT) : 'PM-0001';

    return view('pm_barang.create', compact('barang', 'ruangan', 'anggota', 'kodePeminjaman'));
}


       public function store(Request $request)
{
    // Validasi request (tambahkan aturan sesuai kebutuhan)

    // Simpan data utama ke pm_barang
    $pm_barang = new pm_barang();
    $pm_barang->code_peminjaman = $request->code_peminjaman;
    $pm_barang->id_anggota = $request->id_anggota;
    $pm_barang->jenis_kegiatan = $request->jenis_kegiatan;
    $pm_barang->id_ruangan = $request->id_ruangan;
    $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
    $pm_barang->waktu_peminjaman = $request->waktu_peminjaman;
    $pm_barang->id_barang = $request->id_barang;

    $pm_barang->save();

    // Simpan detail barang yang dipinjam
    foreach ($request->id_barang as $id_barang) {
        $detail = new peminjaman_details(); // Gunakan tabel detail
        $detail->id_peminjaman = $pm_barang->id;
        $detail->id_barang = $id_barang;
        $detail->save();
    }

    // Handle file upload untuk cover (opsional)
    if ($request->hasFile('cover')) {
        $img = $request->file('cover');
        $name = rand(1000, 9999) . $img->getClientOriginalName();
        $img->move('images/pm_barang', $name);
        $pm_barang->cover = $name;
        $pm_barang->save(); // Simpan kembali setelah update cover
    }

    // Notifikasi sukses
    Alert::success('Success', 'Data berhasil disimpan')->autoClose(1000);

    // Redirect ke halaman index
    return redirect()->route('pm_barang.index');
}


    public function show(pm_barang $barang)
    {
        //
    }

    public function edit($id)
    {
        $barang = Barang::all();
        $ruangan = Ruangan::all();
        $anggota = Anggota::all();
        $pm_barang = pm_barang::findOrFail($id);
        return view('pm_barang.edit', compact('pm_barang', 'barang', 'ruangan', 'anggota'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code_peminjaman' => 'required',
            'jenis_kegitan' => 'required',
            'tanggal_peminjaman' => 'required',
            'waktu_pengerjaan' => 'required',
            'cover' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:1024',
        ]);

        $pm_barang = pm_barang::findOrFail($id);
        $pm_barang->code_peminjaman = $request->code_peminjaman;
        $pm_barang->id_anggota = $request->id_anggota;
        $pm_barang->jenis_kegitan = $request->jenis_kegitan;
        $pm_barang->id_barang = $request->id_barang;
        $pm_barang->id_ruangan = $request->id_ruangan;
        $pm_barang->tanggal_peminjaman = $request->tanggal_peminjaman;
        $pm_barang->waktu_pengerjaan = $request->waktu_pengerjaan;

        if ($request->hasFile('cover')) {
            $img = $request->file('cover');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/pm_barang', $name);
            $pm_barang->cover = $name;
        }

        Alert::success('Success','Data berhasil diubah')->autoClose(1000);
        $pm_barang->save();
        return redirect()->route('pm_barang.index');
    }

    public function destroy($id)
    {
        $pm_barang = pm_barang::findOrFail($id);
        $pm_barang->delete();
        Alert::success('Success','Data berhasil dihapus');
        return redirect()->route('pm_barang.index');
    }
}
