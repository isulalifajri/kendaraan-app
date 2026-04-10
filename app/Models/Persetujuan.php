<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'penyetuju_id',
        'level',
        'status',
        'tanggal_persetujuan'
    ];

    // Relasi
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function penyetuju()
    {
        return $this->belongsTo(User::class, 'penyetuju_id');
    }
    
}
