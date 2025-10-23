<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DistributorList;
use App\Models\Province;
use Illuminate\Http\Request;

class DistributorListController extends Controller
{
    /**
     * Helper function untuk mengkonversi URL/Iframe Google Maps menjadi Iframe Source (src)
     */
    private function convertToMapEmbedSrc($map_link)
    {
        if (empty($map_link)) {
            return '';
        }

        // Trim link embed untuk diambil bagian src saja
        if (strpos($map_link, '<iframe') !== false) {
            if (preg_match('/src="([^"]+)"/i', $map_link, $matches)) {
                return $matches[1];
            }
        }

        // Jika sudah berupa link embed, langsung kembalikan
        if (strpos($map_link, 'embed') !== false) {
            return $map_link;
        }

        // Mengembalikan nilai default
        return $map_link;
    }

    /**
     * Tampilkan daftar lokasi distributor (halaman admin)
     */
    public function index()
    {
        // Ambil semua data lokasi beserta relasi city & province
        $distributorList = DistributorList::with(['city', 'province'])->get();

        // Ambil data master
        $provinces = Province::orderBy('province_name')->get();
        $cities = City::orderBy('city_name')->get();

        return view('admin.read.distributor-list', compact('distributorList', 'provinces', 'cities'));
    }

    /**
     * Simpan data lokasi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distributor_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'province_id' => 'required|exists:provinces,id',
            'map_link' => 'nullable|string',
        ]);

        // Konversi link map sebelum disimpan
        $validated['map_link'] = $this->convertToMapEmbedSrc($request->map_link);

        DistributorList::create($validated);

        return back()->with('success', 'Lokasi Distributor Berhasil Ditambahkan.');
    }

    /**
     * Perbarui data lokasi
     */
    public function update(Request $request, $id)
    {
        $location = DistributorList::findOrFail($id);

        $validated = $request->validate([
            'distributor_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'province_id' => 'required|exists:provinces,id',
            'map_link' => 'nullable|string',
        ]);

        // Konversi link map sebelum diperbarui
        $validated['map_link'] = $this->convertToMapEmbedSrc($request->map_link);

        $location->update($validated);

        return back()->with('success', 'Lokasi Distributor Berhasil Diperbarui.');
    }

    /**
     * Hapus data lokasi
     */
    public function destroy($id)
    {
        DistributorList::findOrFail($id)->delete();

        return back()->with('success', 'Lokasi Distributor Berhasil Dihapus.');
    }

    // =========================================================
    // --- FUNCTION PAGE USER ---
    // =========================================================

    /**
     * Tampilkan halaman lokasi distributor (frontend user)
     */

    public function list()
    {
        $distributorList = DistributorList::with(['city.province'])->get();
        $cities = City::with('province')->orderBy('city_name')->get();
        $provinces = Province::orderBy('province_name')->get();
    
        $initialMapSrc = $distributorList->first()->map_link ?? null;
    
        return view('locations.distributor-list', compact('distributorList', 'cities', 'provinces', 'initialMapSrc'));
    }

    /**
     * Filter via AJAX
     */
    public function filter(Request $request)
    {
        $query = DistributorList::with(['city', 'province']); 

        // Filter berdasarkan nama distributor, dan alamatnya
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('distributor_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan provinsi
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        // Filter berdasarkan kota
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $distributorLocations = $query->get();

        return response()->json($distributorLocations);
    }

    /**
     * Ambil data kota berdasarkan provinsi (AJAX)
     */
    public function getCitiesByProvince(Request $request)
    {
        $provinceId = $request->input('province_id');
        $cities = City::where('province_id', $provinceId)
            ->orderBy('city_name')
            ->get(['id', 'city_name']);

        return response()->json($cities);
    }
}
