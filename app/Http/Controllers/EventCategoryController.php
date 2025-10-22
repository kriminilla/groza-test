<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori event.
     */
    public function index()
    {
        $category = EventCategory::all();
        return view('admin.read.event-category', compact('category'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        EventCategory::create($request->all());

        return redirect()->route('eventcategory.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update kategori event.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]); 

        $category = EventCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('eventcategory.index')->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Hapus kategori event.
     */
    public function destroy($id)
    {
        $category = EventCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('eventcategory.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
