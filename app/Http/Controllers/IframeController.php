<?php

namespace App\Http\Controllers;

use App\Models\Iframe;
use Illuminate\Http\Request;

class IframeController extends Controller
{
    /**
     * Menampilkan halaman pengaturan iframe (hanya satu konten).
     */
    public function index()
    {
        // Ambil iframe pertama (jika belum ada, buat data kosong)
        $iframe = Iframe::first();
        if (!$iframe) {
            $iframe = Iframe::create(['src' => null]);
        }

        return view('admin.read.iframe-content', compact('iframe'));
    }

    /**
     * Memperbarui iframe yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'src' => 'required|string',
        ]);

        // Ambil src dari embed iframe yang disubmit
        $src = $this->extractSrc($request->src);

        $iframe = Iframe::findOrFail($id);
        $iframe->update(['src' => $src]);

        return redirect()->route('iframe.index')->with('success', 'Iframe berhasil diperbarui.');
    }

    /**
     * Trim Full-code I-Frame YouTube
     */
    private function extractSrc($iframeCode)
    {
        if (preg_match('/src=["\']([^"\']+)["\']/', $iframeCode, $match)) {
            return $match[1];
        }

        // Kalau user langsung paste link tanpa tag iframe
        return trim($iframeCode);
    }
}
