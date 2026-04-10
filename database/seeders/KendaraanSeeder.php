<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kendaraan::insert([
            [
                'nama_kendaraan' => 'Avanza',
                'jenis' => 'angkutan orang',
                'kepemilikan' => 'perusahaan',
                'nomor_polisi' => 'L 1234 AB',
                'status' => 'tersedia'
            ],
            [
                'nama_kendaraan' => 'Truck',
                'jenis' => 'angkutan barang',
                'kepemilikan' => 'sewa',
                'nomor_polisi' => 'L 5678 CD',
                'status' => 'tersedia'
            ]
        ]);
    }
}
