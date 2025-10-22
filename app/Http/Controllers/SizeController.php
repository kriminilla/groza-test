<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Tampilkan daftar ukuran (dengan opsi pencarian)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sizes = Size::when($search, function ($query, $search) {
                return $query->where('size_label', 'like', "%{$search}%");
            })
            ->orderBy('size_label', 'asc')
            ->get();

        return view('admin.read.size-list', compact('sizes'));
    }

    /**
     * Simpan ukuran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'size_label' => 'required|string|max:100',
        ]);

        Size::create([
            'size_label' => $request->size_label,
        ]);

        return back()->with('success', 'Size berhasil ditambahkan.');
    }

    /**
     * Update ukuran yang ada
     */
    public function update(Request $request, $id) 
    {
        $request->validate([
            'size_label' => 'required|string|max:100',
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'size_label' => $request->size_label,
        ]);

        return back()->with('success', 'Size berhasil diperbarui.');
    }

    /**
     * Hapus ukuran
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id); 
        $size->delete();

        return back()->with('success', 'Size berhasil dihapus.');
    }
}
