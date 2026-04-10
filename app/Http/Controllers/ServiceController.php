<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $title = 'Page Jadwal Service';
        $services = Service::with(['kendaraan'])->latest()->get();

        return view('page.service.index', compact('title','services'));
    }

    public function create()
    {
        $status = ['pending','selesai'];
        return view('page.service.create', [
            'title' => 'Page Create Jadwal Service',
            'kendaraan' => Kendaraan::all(),
            'status' => $status,
        ]);
    }

    public function store(Request $request)
    {

        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_service' => 'required|date',
            'keterangan' => 'string|nullable',
            'status' => ['required', 'in:pending,selesai'],
        ]);

        DB::beginTransaction();

        try {

            $service = Service::create([
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal_service' => $request->tanggal_service,
                'keterangan' => $request->keterangan,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('service.index')
                ->with('success', 'Jadwal Service berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        $status = ['pending','selesai'];
        return view('page.service.edit', [
            'title' => 'Page Edit Jadwal Service',
            'service' => $service,
            'kendaraan' => Kendaraan::all(),
            'status' => $status,
        ]);
    }

    public function update(Request $request, Service $service)
    {

        // VALIDASI
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_service' => 'required|date',
            'keterangan' => 'string|nullable',
            'status' => ['required', 'in:pending,selesai'],
        ]);

        DB::beginTransaction();

        try {

            $service->update([
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal_service' => $request->tanggal_service,
                'keterangan' => $request->keterangan,
                'status' => $request->biaya,
            ]);

            DB::commit();

            return redirect()->route('service.index')
                ->with('success', 'Jadwal Service berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Jadwal Service Berhasil dihapus');
    }
}
