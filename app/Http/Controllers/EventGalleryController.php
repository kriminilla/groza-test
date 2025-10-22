<?php

namespace App\Http\Controllers;

use App\Models\EventGallery;
use App\Models\Event;
use Illuminate\Http\Request;

class EventGalleryController extends Controller
{
    /**
     * Index/Daftar Event Khusus Admin
     *
    */
    public function index($event_id)
    {
        $event = Event::with('galeri')->findOrFail($event_id);
        return view('galeri_event.index', compact('event'));
    }

    // Form tambah galeri untuk event tertentu
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('galeri_event.create', compact('event'));
    }

    // Simpan galeri baru
    public function store(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);

        $validated = $request->validate([
            'gambar.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('event_galeri', 'public');

                Event::create([
                    'event_id' => $event->id,
                    'gambar' => $path,
                ]);
            }
        }

        return redirect()->route('galeri_event.index', $event->id)
                         ->with('success', 'Galeri berhasil ditambahkan');
    }

    // Hapus galeri
    public function destroy($id)
    {
        $galeri = Event::findOrFail($id);
        $event_id = $galeri->event_id;

        $galeri->delete();

        return redirect()->route('galeri_event.index', $event_id)
                         ->with('success', 'Galeri berhasil dihapus');
    }
}
