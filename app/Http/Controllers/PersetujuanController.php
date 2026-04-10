<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Persetujuan;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    public function index()
    {
        $title = 'Page Persetujuan';

        $data = Pemesanan::with([
            'kendaraan',
            'persetujuan.penyetuju'
        ])->orderByDesc('created_at')->get();

        return view('persetujuan.index', compact('title','data'));
    }
}
