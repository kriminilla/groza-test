<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PartnerList;
use App\Models\Province;
use Illuminate\Http\Request;

class PartnerListController extends Controller
{
    /**
     * Helper untuk mengonversi URL/Iframe Google Maps menjadi src embed.
     */
    private function convertToMapEmbedSrc($map_link)
    {
        if (empty($map_link)) {
            return '';
        }

        // Trim full iframe code untuk diambil nilai src-nya
        if (strpos($map_link, '<iframe') !== false) {
            if (preg_match('/src="([^"]+)"/', $map_link, $matches)) {
                return $matches[1];
            }
        }

        // Jika sudah embed link
        if (strpos($map_link, 'embed') !== false) {
            return $map_link;
        }

        return $map_link;
    }

    /**
     * Tampilkan daftar lokasi mitra (admin)
     */
    public function index()
    {
        $partnerList = PartnerList::with(['city', 'province'])->get();
        $provinces = Province::orderBy('province_name')->get();
        $cities = City::orderBy('city_name')->get();

        return view('admin.read.partner-list', compact('partnerList', 'provinces', 'cities'));
    }

    /**
     * Simpan data lokasi mitra baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'address'      => 'required|string',
            'city_id'      => 'required|exists:cities,id',
            'province_id'  => 'required|exists:provinces,id',
            'map_link'     => 'nullable|string',
        ]);

        $validated['map_link'] = $this->convertToMapEmbedSrc($request->map_link);

        PartnerList::create($validated);

        return back()->with('success', 'Lokasi mitra berhasil ditambahkan.');
    }

    /**
     * Perbarui data lokasi mitra
     */
    public function update(Request $request, $id)
    {
        $partner = PartnerList::findOrFail($id);

        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'address'      => 'required|string',
            'city_id'      => 'required|exists:cities,id',
            'province_id'  => 'required|exists:provinces,id',
            'map_link'     => 'nullable|string',
        ]);

        $validated['map_link'] = $this->convertToMapEmbedSrc($request->map_link);

        $partner->update($validated);

        return back()->with('updated', 'Lokasi mitra berhasil diperbarui.');
        
    }

    /**
     * Hapus data lokasi mitra
     */
    public function destroy($id)
    {
        PartnerList::findOrFail($id)->delete();

        return back()->with('deleted', 'Lokasi mitra berhasil dihapus.');
    }

    // =========================================================
    // --- FUNCTION PAGE USER ---
    // =========================================================]
    
    /**
     * Halaman lokasi mitra untuk pengguna (frontend)
     */
    public function list()
    {
        $partnerList = PartnerList::with(['city.province'])->get();
        $cities = City::with('province')->orderBy('city_name')->get();
        $provinces = Province::orderBy('province_name')->get();
    
        $initialMapSrc = $partnerList->first()->map_link ?? null;
    
        return view('locations.partner-list', compact('partnerList', 'cities', 'provinces', 'initialMapSrc'));
    }

    /**
     * Filter lokasi mitra (AJAX)
     */
    public function filter(Request $request)
    {
        $query = PartnerList::with(['city', 'province']);

        // Filter nama mitra atau alamat
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('partner_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter provinsi
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        // Filter kota
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $partnerList = $query->get();

        return response()->json($partnerList);
    }

    public function getCitiesByProvince($province_id)
    {
        $cities = City::where('province_id', $province_id)
            ->orderBy('city_name')
            ->get(['id', 'city_name']);
    
        return response()->json($cities);
    }

}
