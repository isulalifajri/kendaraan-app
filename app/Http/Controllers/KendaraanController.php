<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KendaraanController extends Controller
{
    public function index()
    {
        $title = 'Page Kendaraan';
        $kendaraans = Kendaraan::orderBy('created_at', 'DESC')->paginate(5);
        return view('page.kendaraan.index', compact('title','kendaraans'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'nama_kendaraan' => ['required', 'string', 'max:255'],
                'jenis' => ['required', 'in:angkutan orang,angkutan barang'],
                'kepemilikan' => ['required', 'in:perusahaan,sewa'],
                'nomor_polisi' => ['required', 'string', 'max:20'],
                'status' => ['required', 'in:tersedia,digunakan,service'],
            ]);

            Kendaraan::create($validatedData);

            DB::commit();
            return to_route('kendaraan.index')->with('success', 'Data Kendaraan Berhasil di Tambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:angkutan orang,angkutan barang'],
            'kepemilikan' => ['required', 'in:perusahaan,sewa'],
            'nomor_polisi' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:tersedia,digunakan,service'],
        ]);

        DB::beginTransaction();
        try {
            $kendaraan = Kendaraan::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $kendaraan->update($validatedData);

            DB::commit();
            return to_route('kendaraan.index')->with('success', 'Data Kendaraan Berhasil di Update.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kendaraan = Kendaraan::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $kendaraan->delete(); 

            return to_route('kendaraan.index')->with('success-danger', 'Data Kendaraan Berhasil di hapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
