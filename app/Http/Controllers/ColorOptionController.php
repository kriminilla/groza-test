<?php

namespace App\Http\Controllers;

use App\Models\ColorOption;
use Illuminate\Http\Request;

class ColorOptionController extends Controller
{
    /**
     * Tampilkan semua kode warna
     */
    public function index()
    {
        $colorOptions = ColorOption::all();
        return view('admin.read.color-options', compact('colorOptions'));
    }

    /**
     * Simpan warna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'color_name' => 'required|string|max:255',
            'color_code' => 'required|string|max:50',
        ]);

        ColorOption::create([
            'color_name' => $request->color_name,
            'color_code'   => $request->color_code,
        ]);

        return redirect()->back()->with('success', 'Warna berhasil ditambahkan.');
    }

    /**
     * Update warna
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'color_name' => 'required|string|max:255',
            'color_code'   => 'required|string|max:50',
        ]);

        $warna = ColorOption::findOrFail($id);
        $warna->update([
            'color_name' => $request->color_name,
            'color_code'   => $request->color_code, 
        ]);

        return redirect()->back()->with('success', 'Warna berhasil diperbarui.');
    }

    /**
     * Hapus warna
     */
    public function destroy($id)
    {
        $warna = ColorOption::findOrFail($id);
        $warna->delete();

        return redirect()->back()->with('success', 'Warna berhasil dihapus.');
    }
}
