<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Tampilkan semua provinsi
     */
    public function index()
    {
        $province = Province::all();
        return view('admin.read.province-list', compact('province'));
    }
 
    /**
     * Simpan provinsi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:100',
        ]);

        Province::create([
            'province_name' => $request->province_name,
        ]);

        return redirect()->back()->with('success', 'Provinsi berhasil ditambahkan.');
    }

    /**
     * Update provinsi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required|string|max:100',
        ]);

        $province = Province::findOrFail($id);
        $province->update([
            'province_name' => $request->province_name,
        ]);

        return redirect()->back()->with('success', 'Provinsi berhasil diperbarui.');
    }

    /**
     * Hapus provinsi
     */
    public function destroy($id)
    {
        $province = Province::findOrFail($id);
        $province->delete();

        return redirect()->back()->with('success', 'Provinsi berhasil dihapus.');
    }
}
