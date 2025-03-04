<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_ruangan extends Model
{
    use HasFactory;
    protected $fillable = ['id','id_ruangan'];
    public $timestamps = true;

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');

    }
     public function rincian()
    {
        return $this->hasMany( rincian::class, 'id_detail_ruangan');
    }
}
