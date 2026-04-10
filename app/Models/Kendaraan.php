<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kendaraan',
        'jenis',
        'kepemilikan',
        'nomor_polisi',
        'status'
    ];

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'kendaraan_id');
    }

    public function bbm()
    {
        return $this->hasMany(Bbm::class);
    }
}
