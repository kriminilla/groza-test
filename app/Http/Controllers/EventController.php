<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{ 
    /**
     * Index/Daftar Event Khusus Admin
     *
    */
    public function index()
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $events = Event::with(['category', 'galleries'])->get();
        return view('admin.read.event-list', compact('events'));
    }

    /**
     * Form Tambah Event
     *
    */
    public function create()
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $categories = EventCategory::all();
        return view('admin.create.createEvent', compact('categories'));
    }

    /**
     * Simpan Event Baru
     *
    */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'title' => 'required|string|max:255',
            'category_event_id' => 'required|integer|exists:event_categories,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'galleries.*' => 'nullable|image|mimes:jpg,jpeg,png|max:3072'
        ]);

        // Upload cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('events/cover', 'public');
        }

        // Generate Slug
        $validated['slug'] = Str::slug($request->title);

        // Simpan event
        $event = Event::create($validated);

        // Upload gambar/galeri
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $path = $file->store('events/galleries', 'public');
                EventGallery::create([
                    'event_id' => $event->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan');
    }

    /**
     * Detail Event
     *
    */
    public function show($id)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }
        
        $event = Event::with(['category', 'galleries'])->findOrFail($id);
        return view('admin.read.event-details', compact('event'));
    }

    /**
     * Form Edit Event
     *
    */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $category = EventCategory::all();
        return view('admin.update.update-event', compact('event', 'category'));
    }

    /**
     * Proses Update Event
     *
    */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_event_id' => 'required|integer|exists:event_categories,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'galleries.*' => 'nullable|image|mimes:jpg,jpeg,png|max:3072'
        ]);

        // Update slug otomatis
        $validated['slug'] = Str::slug($request->title);

        // Update cover jika ada file baru
        if ($request->hasFile('cover')) {
            if ($event->cover) {
                Storage::disk('public')->delete($event->cover);
            }
            $validated['cover'] = $request->file('cover')->store('events/cover', 'public');
        }

        // Update data event utama
        $event->update($validated);

        // Tambah galeri baru (tidak hapus lama)
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $path = $file->store('events/galleries', 'public');
                EventGallery::create([
                    'event_id' => $event->id,
                    'image' => $path,
                ]);
            }
        }

        // Hapus galeri lama jika ada yang ditandai
        if ($request->filled('deleted_galleries')) {
            $ids = explode(',', $request->deleted_galleries);
            $ids = array_map('intval', $ids);
            
            $deleted = EventGallery::whereIn('id', $ids)->get();
            foreach ($deleted as $item) {
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();
            }
        }


        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui');
    }

    /**
     * Hapus Gambar Event
     *
    */
    public function destroy($id)
    {
        $event = Event::with('galleries')->findOrFail($id);

        // Hapus cover
        if ($event->cover) {
            Storage::disk('public')->delete($event->cover);
        }

        // Hapus file galeri terkait 
        foreach ($event->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        }

        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus');
    }

    // =========================================================
    // --- FUNCTION PAGE USER ---
    // =========================================================

    /**
     * Index/Daftar Event - Frontend User
     *
    */
    public function indexUser(Request $request)
    {
        $search = $request->input('q');

        $events = Event::with('category')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('event_date', 'desc')
            ->paginate(6);

        return view('events.events-list', compact('events', 'search'));
    }

    /**
     * Detail Event - Frontend User
     *
    */
    public function showUser($slug)
    {
        $event = Event::with(['category', 'galleries'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('events.events-detail', compact('event'));
    }
}
