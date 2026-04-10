<?php

namespace Database\Seeders;

use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::insert([
            [
                'nama' => 'Budi',
                'no_hp' => '08123456789',
                'status' => 'tersedia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Andi',
                'no_hp' => '08987654321',
                'status' => 'tersedia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
