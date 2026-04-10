<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index()
    {
        $title = 'Page Driver';
        $drivers = Driver::orderBy('created_at', 'DESC')->paginate(5);
        return view('page.driver.index', compact('title','drivers'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'no_hp' => ['required', 'digits_between:10,15'],
                'status' => ['required', 'in:tersedia,bertugas'],
            ]);

            Driver::create($validatedData);

            DB::commit();
            return to_route('driver.index')->with('success', 'Data Driver Berhasil di Tambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'digits_between:10,15'],
            'status' => ['required', 'in:tersedia,bertugas'],
        ]);

        DB::beginTransaction();
        try {
            $driver = Driver::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $driver->update($validatedData);

            DB::commit();
            return to_route('driver.index')->with('success', 'Data Driver Berhasil di Update.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $driver = Driver::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $driver->delete(); 

            return to_route('driver.index')->with('success-danger', 'Data Driver Berhasil di hapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
