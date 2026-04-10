<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

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
