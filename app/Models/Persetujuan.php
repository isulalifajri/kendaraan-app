<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Persetujuan extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

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
