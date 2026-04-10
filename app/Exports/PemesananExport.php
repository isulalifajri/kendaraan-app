<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemesananExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pemesanan::with(['user','kendaraan','driver','persetujuan'])
            ->get()
            ->map(function ($p, $i) {

                $level1 = $p->persetujuan->where('level', 1)->first();
                $level2 = $p->persetujuan->where('level', 2)->first();

                return [
                    $i + 1,
                    $p->user->name ?? '-',
                    $p->kendaraan->nama_kendaraan ?? '-',
                    $p->driver->nama ?? '-',
                    $p->tanggal_mulai,
                    $p->tanggal_selesai,
                    $p->tujuan,
                    $p->status,

                    // tambahan
                    $level1->user->name ?? '-',
                    $level1->status ?? '-',

                    $level2->user->name ?? '-',
                    $level2->status ?? '-',

                    $level2->tanggal_persetujuan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Pengguna',
            'Kendaraan',
            'Driver',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Tujuan',
            'Status',

            'Penyetuju Level 1',
            'Status Level 1',

            'Penyetuju Level 2',
            'Status Level 2',

            'Tanggal Persetujuan',
        ];
    }
}