<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;

class RiwayatController extends Controller
{
    public function index()
    {
        $title = 'Page Riwayat Pemakaian Kendaraan';
        $riwayats = Pemesanan::where('status','disetujui')->orderByDESC('id')->get();
        return view('page.riwayat.index', compact('title','riwayats'));
    }
}
