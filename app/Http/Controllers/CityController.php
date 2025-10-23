<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Tampilkan semua kota
     */
    public function index()
    {
        // Ambil semua kota beserta provinsinya
        $city = City::with('province')->get();

        // Ambil semua provinsi untuk dropdown
        $provinces = Province::all();

        return view('admin.read.city-list', compact('city', 'provinces'));
    }

    /**
     * Simpan kota baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_name'   => 'required|string|max:100',
            'province_id' => 'required|exists:provinces,id',
        ]);

        City::create([
            'city_name'   => $request->city_name,
            'province_id' => $request->province_id,
        ]);

        return redirect()->back()->with('success', 'Kota berhasil ditambahkan.');
    }

    /**
     * Update kota
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'city_name'   => 'required|string|max:100',
            'province_id' => 'required|exists:provinces,id',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'city_name'   => $request->city_name,
            'province_id' => $request->province_id,
        ]);

        return redirect()->back()->with('success', 'Kota berhasil diperbarui.');
    }

    /**
     * Hapus kota
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->back()->with('success', 'Kota berhasil dihapus.');
    }
}
