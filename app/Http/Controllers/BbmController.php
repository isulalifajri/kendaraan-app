<?php

namespace App\Http\Controllers;

use App\Models\Bbm;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BbmController extends Controller
{
    public function index()
    {
        $title = 'Page Monitoring BBM';
        $bbms = Bbm::with(['kendaraan'])->latest()->get();

        return view('page.bbm.index', compact('title','bbms'));
    }

    public function create()
    {
        return view('page.bbm.create', [
            'title' => 'Page Create Monitoring BBM',
            'kendaraan' => Kendaraan::all(),
        ]);
    }

    public function store(Request $request)
    {

        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date',
            'liter' => 'required|string|max:255',
            'biaya' => 'required|numeric',
            'keterangan' => 'string|nullable',
        ]);

        DB::beginTransaction();

        try {

            $bbm = Bbm::create([
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal' => $request->tanggal,
                'liter' => $request->liter,
                'biaya' => $request->biaya,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            return redirect()->route('bbm.index')
                ->with('success', 'Monitoring Bbm berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Bbm $bbm)
    {
        return view('page.bbm.edit', [
            'title' => 'Page Edit Monitoring BBM',
            'bbm' => $bbm,
            'kendaraan' => Kendaraan::all(),
        ]);
    }

    public function update(Request $request, Bbm $bbm)
    {

        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date',
            'liter' => 'required|string|max:255',
            'biaya' => 'required|numeric',
            'keterangan' => 'string|nullable',
        ]);

        DB::beginTransaction();

        try {

            $bbm->update([
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal' => $request->tanggal,
                'liter' => $request->liter,
                'biaya' => $request->biaya,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            return redirect()->route('bbm.index')
                ->with('success', 'Monitoring Bbm berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Bbm $bbm)
    {
        $bbm->delete();

        return back()->with('success', 'Monitoring BBM Berhasil dihapus');
    }
}
