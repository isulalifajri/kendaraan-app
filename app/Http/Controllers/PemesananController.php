<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\Persetujuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $title = 'Page Pemesanan';
        $data = Pemesanan::with(['user', 'kendaraan', 'driver'])->latest()->get();

        return view('pemesanan.index', compact('title','data'));
    }

    public function create()
    {
        return view('pemesanan.create', [
            'title' => 'Page Create Pemesanana',
            'kendaraan' => Kendaraan::all(),
            'driver' => Driver::all(),
            'penyetuju' => User::where('role', 'penyetuju')->get()
        ]);
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_id' => 'required|exists:drivers,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tujuan' => 'required|string|max:255',
            'penyetuju_level_1' => 'required|exists:users,id|different:penyetuju_level_2',
            'penyetuju_level_2' => 'required|exists:users,id',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai',
            'penyetuju_level_1.different' => 'Penyetuju tidak boleh sama'
        ]);

        // CEK BENTROK KENDARAAN
        $cek = Pemesanan::where('kendaraan_id', $request->kendaraan_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                  ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                         ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                  });
            })
            ->exists();

        if ($cek) {
            return back()->withInput()->with('error', 'Kendaraan sudah dipakai di tanggal tersebut');
        }

        $cekDriver = Pemesanan::where('driver_id', $request->driver_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                ->orWhere(function ($q2) use ($request) {
                    $q2->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                        ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                });
            })
            ->exists();

        if ($cekDriver) {
            return back()->withInput()->with('error', 'Driver sudah ditugaskan di tanggal tersebut');
        }

        DB::beginTransaction();

        try {

            $pemesanan = Pemesanan::create([
                'user_id' => auth()->id(),
                'kendaraan_id' => $request->kendaraan_id,
                'driver_id' => $request->driver_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tujuan' => $request->tujuan,
                'status' => 'menunggu'
            ]);

            // LEVEL 1
            Persetujuan::create([
                'pemesanan_id' => $pemesanan->id,
                'penyetuju_id' => $request->penyetuju_level_1,
                'level' => 1,
                'status' => 'menunggu'
            ]);

            // LEVEL 2
            Persetujuan::create([
                'pemesanan_id' => $pemesanan->id,
                'penyetuju_id' => $request->penyetuju_level_2,
                'level' => 2,
                'status' => 'menunggu'
            ]);

            DB::commit();

            return redirect()->route('pemesanan.index')
                ->with('success', 'Pemesanan berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Pemesanan $pemesanan)
    {
        return view('pemesanan.edit', [
            'title' => 'Page Edit Pemesanan',
            'pemesanan' => $pemesanan,
            'kendaraan' => Kendaraan::all(),
            'driver' => Driver::all(),
            'penyetuju' => User::where('role', 'penyetuju')->get()
        ]);
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_id' => 'required|exists:drivers,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tujuan' => 'required|string|max:255',
            'penyetuju_level_1' => 'required|exists:users,id|different:penyetuju_level_2',
            'penyetuju_level_2' => 'required|exists:users,id',
        ]);

        // CEK BENTROK (exclude data sendiri)
        $cek = Pemesanan::where('id', '!=', $pemesanan->id)
            ->where('kendaraan_id', $request->kendaraan_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                  ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                         ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                  });
            })
            ->exists();

        if ($cek) {
            return back()->withInput()->with('error', 'Kendaraan sudah dipakai di tanggal tersebut');
        }

        $cekDriver = Pemesanan::where('id', '!=', $pemesanan->id)
            ->where('driver_id', $request->driver_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                ->orWhere(function ($q2) use ($request) {
                    $q2->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                        ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                });
            })
            ->exists();

        if ($cekDriver) {
            return back()->withInput()->with('error', 'Driver sudah ditugaskan di tanggal tersebut');
        }

        DB::beginTransaction();

        try {

            $pemesanan->update([
                'kendaraan_id' => $request->kendaraan_id,
                'driver_id' => $request->driver_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tujuan' => $request->tujuan,
            ]);

            // RESET APPROVAL
            $pemesanan->persetujuan()->delete();

            // LEVEL 1
            Persetujuan::create([
                'pemesanan_id' => $pemesanan->id,
                'penyetuju_id' => $request->penyetuju_level_1,
                'level' => 1,
                'status' => 'menunggu'
            ]);

            // LEVEL 2
            Persetujuan::create([
                'pemesanan_id' => $pemesanan->id,
                'penyetuju_id' => $request->penyetuju_level_2,
                'level' => 2,
                'status' => 'menunggu'
            ]);

            DB::commit();

            return redirect()->route('pemesanan.index')
                ->with('success', 'Pemesanan berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();

        return back()->with('success', 'Pemesanan dihapus');
    }
}