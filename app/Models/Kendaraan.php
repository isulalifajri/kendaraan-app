<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Kendaraan extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

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
