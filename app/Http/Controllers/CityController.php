<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Tampilkan semua kota
     */
    public function index()
    {
        $city = City::all();

        return view('admin.read.city-list', compact('city'));
    }

    /**
     * Simpan kota baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string|max:100',
        ]);

        City::create([
            'city_name' => $request->city_name,
        ]);

        return redirect()->back()->with('success', 'Kota berhasil ditambahkan.');
    }

    /**
     * Update kota
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'city_name' => 'required|string|max:100',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'city_name' => $request->city_name,
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
