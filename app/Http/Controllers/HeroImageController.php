<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use Illuminate\Http\Request;

class HeroImageController extends Controller
{
    /**
     * Index Konten Hero Image
     *
    */
    public function index()
    {
        $images = HeroImage::all();
        return view('admin.read.heroimage', compact('images'));
    }

    /**
     * Tambah Hero Image Baru
     *
    */
    public function store(Request $request)
    {
        $request->validate([
            'src' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'alt' => 'nullable|string|max:255',
        ]);

        // Simpan file ke storage/app/public/hero
        $path = $request->file('src')->store('hero', 'public');

        HeroImage::create([
            'src' => 'storage/'.$path,
            'alt' => $request->alt,
        ]);

        return redirect()->route('heroimage.index')->with('success', 'Hero Image berhasil ditambahkan.');
    }

    /**
     * Update Hero Image
     *
    */
    public function update(Request $request, $id)
    {
        $image = HeroImage::findOrFail($id);

        $request->validate([
            'src' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'alt' => 'nullable|string|max:255',
        ]);

        $data = ['alt' => $request->alt];

        if ($request->hasFile('src')) {
            $path = $request->file('src')->store('hero', 'public');
            $data['src'] = 'storage/'.$path;
        }

        $image->update($data);

        return redirect()->route('heroimage.index')->with('success', 'Hero Image berhasil diperbarui.');
    }

    /**
     * Hapus Hero Image
     *
    */
    public function destroy($id)
    {
        $image = HeroImage::findOrFail($id);
        $image->delete();

        return redirect()->route('heroimage.index')->with('success', 'Hero Image berhasil dihapus.');
    }
}
