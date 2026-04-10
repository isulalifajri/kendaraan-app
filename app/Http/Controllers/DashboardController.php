<?php

namespace App\Http\Controllers;
use App\Models\Pemesanan;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $title = 'Dashboard Page';

        $total = Pemesanan::count();
        $menunggu = Pemesanan::where('status', 'menunggu')->count();
        $disetujui = Pemesanan::where('status', 'disetujui')->count();
        $ditolak = Pemesanan::where('status', 'ditolak')->count();

        $chart = [];

        for ($i = 1; $i <= 12; $i++) {
            $chart[] = Pemesanan::whereMonth('tanggal_mulai', $i)
                ->whereYear('tanggal_mulai', date('Y'))
                ->count();
        }

        return view('dashboard.dashboard', compact(
            'title',
            'total',
            'menunggu',
            'disetujui',
            'ditolak',
            'chart'
        ));
    }
}
