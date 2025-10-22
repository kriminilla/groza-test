<?php

namespace App\Http\Controllers;

use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HeroProductController extends Controller
{
    /**
     * Daftar Subkategori, dan Gambarnya
     */
    public function index()
    {
        $subcategories = ProductSubcategory::with('category')->get();
        return view('admin.read.heroproduct', compact('subcategories'));
    }

    /**
     * Update Gambar Hero Product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $subkategori = ProductSubcategory::findOrFail($id);

        // Jika upload baru
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($subkategori->image && File::exists(public_path($subkategori->image))) {
                File::delete(public_path($subkategori->image));
            }

            // Simpan image baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/hero-product'), $filename);

            // Update path ke database
            $subkategori->image = 'img/hero-product/' . $filename;
        }

        $subkategori->save();

        return redirect()->back()->with('success', 'Hero product berhasil diperbarui!');
    }
}
