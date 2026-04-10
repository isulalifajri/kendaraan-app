<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bbm extends Model
{
    protected $fillable = ['kendaraan_id','tanggal','liter','biaya','keterangan'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
