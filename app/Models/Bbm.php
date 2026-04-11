<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Bbm extends Model implements Auditable
{
    use AuditableTrait;

    protected $fillable = ['kendaraan_id','tanggal','liter','biaya','keterangan'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
