<?php

namespace App\Http\Controllers;

use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HeaderImageController extends Controller
{
    /**
     * Daftar Subkategori, dan Gambarnya
     */
    public function index()
    {
        $subcategories = ProductSubcategory::with('category')->get();
        return view('admin.read.header-image', compact('subcategories'));
    }

    /**
     * Update Gambar Hero Product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'header_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
    
        $subcategory = ProductSubcategory::findOrFail($id);
    
        if ($request->hasFile('header_image')) {
            // Hapus image lama jika ada
            if ($subcategory->header_image && File::exists(public_path($subcategory->header_image))) {
                File::delete(public_path($subcategory->header_image));
            }
    
            // Simpan image baru
            $file = $request->file('header_image');
            $filename = time() . '_' . $file->getClientOriginalName();
    
            // Pastikan folder tujuan ada
            $destination = public_path('img/hero-image');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
    
            // Simpan ke folder hero-image
            $file->move($destination, $filename);
    
            // Update path ke database
            $subcategory->header_image = 'img/hero-image/' . $filename;
        }
    
        $subcategory->save();
    
        return redirect()->back()->with('success', 'Hero image berhasil diperbarui!');
    }

}
