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

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $persetujuan = Persetujuan::findOrFail($id);

        if (auth()->id() != $persetujuan->penyetuju_id) {
            abort(403, 'Tidak punya akses');
        }

        $persetujuan->update([
            'status' => $request->status,
            'tanggal_persetujuan' => now()
        ]);

        $pemesanan = $persetujuan->pemesanan;

        $lvl1 = $pemesanan->persetujuan->where('level', 1)->first();
        $lvl2 = $pemesanan->persetujuan->where('level', 2)->first();

        if ($lvl1 && $lvl1->status == 'ditolak') {
            $pemesanan->update(['status' => 'ditolak']);
        } elseif ($lvl2 && $lvl2->status == 'ditolak') {
            $pemesanan->update(['status' => 'ditolak']);
        } elseif (
            $lvl1 && $lvl2 &&
            $lvl1->status == 'disetujui' &&
            $lvl2->status == 'disetujui'
        ) {
            $pemesanan->update(['status' => 'disetujui']);
        } else {
            $pemesanan->update(['status' => 'menunggu']);
        }

        return back()->with('success', 'Berhasil update persetujuan');
    }
}
