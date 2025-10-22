<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoriesController extends Controller
{
    /**
     * Tampilkan semua subkategori beserta kategori terkait.
     */
    public function index()
    {
        $subcategories = ProductSubcategory::with('category')->get();
        $categories = ProductCategories::all(); // Untuk dropdown kategori

        return view('admin.read.subcategory', compact('subcategories', 'categories'));
    }

    /**
     * Simpan subkategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['subcategory_name']);

        ProductSubcategory::create($validated);

        return redirect()->route('subcategory.index')
            ->with('success', 'Subkategori berhasil ditambahkan.');
    }

    /**
     * Perbarui data subkategori.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['subcategory_name']);

        $subcategory = ProductSubcategory::findOrFail($id);
        $subcategory->update($validated);

        return redirect()->route('subcategory.index')
            ->with('success', 'Subkategori berhasil diperbarui.');
    }

    /**
     * Hapus subkategori.
     */
    public function destroy($id)
    {
        $subcategory = ProductSubcategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('subcategory.index')
            ->with('success', 'Subkategori berhasil dihapus.');
    }
}
