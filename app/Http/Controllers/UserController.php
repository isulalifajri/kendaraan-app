<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Page User';
        $users = User::orderBy('created_at', 'DESC')->paginate(5);
        return view('page.user.index', compact('title','users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'role'  => ['required', 'in:admin,penyetuju'],
            ]);

            $validatedData['password'] = Hash::make('password');

            User::create($validatedData);

            DB::commit();
            return to_route('user.index')->with('success', 'Data User Berhasil di Tambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $user->update($validatedData);

            DB::commit();
            return to_route('user.index')->with('success', 'Data User Berhasil di Update.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->firstOrFail(); // Menggunakan firstOrFail untuk menangani kasus tidak ditemukan
            
            $user->delete(); 

            return to_route('user.index')->with('success-danger', 'Data User Berhasil di hapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

}
