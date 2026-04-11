<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Driver extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'nama',
        'no_hp',
        'status'
    ];

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'driver_id');
    }
}
