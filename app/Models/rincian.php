<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rincian extends Model
{
    use HasFactory;
protected $table = 'rincian';
    protected $fillable = ['id_detail_ruangan', 'id_barang', 'jumlah_pinjam','kondisi'];

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
     public function detail_ruangan()
    {
        return $this->belongsTo(detail_ruangan::class, 'id_detail_ruangan');
    }
    
}