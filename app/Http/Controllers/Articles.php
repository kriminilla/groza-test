<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\GaleriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 


class Articles extends Controller 
{
    /** 
     * Tampilkan daftar semua artikel.
     */
    public function index()
    {

        if (!auth('admin')->check()) {
            return redirect()->route('login');
        }

        $articles = Article::latest()->paginate(10); 
        return view('admin.read.articles', compact('articles'));
    }

    /**
     * Tampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('admin.create.createArticle');
    }

    /**
     * Simpan artikel baru ke database.
     *
    */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255|unique:articles,title',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072', 
            
            'galleries' => 'nullable|array',
            'galleries.*.src' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            'galleries.*.caption' => 'nullable|string|max:255',
        ]);
    
        $imagePath = null;
    
        try {
            DB::beginTransaction();
    
            // Fetch Admin ID
            $admin = auth('admin')->user();
            $adminId = $admin->id;
    
            // Upload Gambar Cover Utama
            $imagePath = $request->file('image')->store('articles/cover', 'public');
            
            // Store data artikel
            $article = Article::create([
                'title'    => $request->title,
                'slug'     => Str::slug($request->title), 
                'admin_id'  => $adminId,
                'image'   => $imagePath,
                'content'   => $request->content,
            ]);
            
            // Store foto/galeri artikel
            if ($request->has('galleries')) {
                $galleriesData = [];
                $order = 1; 
    
                foreach (array_filter($request->galleries) as $item) {
                    if (isset($item['src']) && $item['src'] instanceof \Illuminate\Http\UploadedFile) {
                        
                        $galleriesPath = $item['src']->store('articles/galleries', 'public');
    
                        $galleriesData[] = [
                            'article_id' => $article->id,
                            'src'        => $galleriesPath,
                            'caption'    => $item['caption'] ?? null,
                            'sort_order'      => $order++, 
                        ];
                    }
                }
                
                if (!empty($galleriesData)) {
                    DB::table('article_galleries')->insert($galleriesData);
                }
            }
    
            DB::commit();
            return redirect()
                ->route('article.index')
                ->with('success', 'Artikel berhasil dibuat!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus cover jika ada error
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
    
            // Debugging (sementara)
            dd($e->getMessage());
    
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat artikel: ' . $e->getMessage());
        }
    }

    /**
     * Simpan konten gambar Summernote ke database
     *
    */
    public function uploadImageSummernote(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            $path = $file->store('uploads/articles/contents', 'public'); 
    
            return response()->json([
                'url' => Storage::url($path)
            ], 200);
        }
        
        return response()->json(['error' => 'File gambar tidak ditemukan.'], 400);
    }


    /**
     * Tampilkan detail artikel tertentu.
     */
    public function show($slug)
    {
        // Cari detail artikel berdasarkan slug
        $articles = Article::where('slug', $slug)
                            ->with(['admin', 'galleries']) // Muat relasi admin dan galeri
                            ->firstOrFail();

        return view('admin.read.article-details', compact('articles'));
    }

    /**
     * Tampilkan form untuk mengedit artikel.
     */
    public function edit($id)
    {
        $article = Article::with('galleries')->findOrFail($id);
        
        return view('admin.update.update-article', compact('article'));
    }

    /**
     * Perbarui artikel tertentu di database.
    */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        $request->validate([
            'title' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('articles', 'title')->ignore($article->id),
            ],
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            
            // Validasi untuk galeri baru atau update
            'galleries_new' => 'nullable|array',
            'galleries_new.*.src' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            'galleries_new.*.caption' => 'nullable|string|max:255',

            // Validasi untuk galeri yang sudah ada (hanya caption yang di-update)
            'galleries_existing' => 'nullable|array',
            'galleries_existing.*.caption' => 'nullable|string|max:255',
            // ID Galeri yang akan dihapus
            'galleries_deleted_ids' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $admin = auth('admin')->user();
            $adminId = $admin->id; 
            
            // Update Gambar Cover Utama
            $imagePath = $article->image;
            if ($request->hasFile('image')) {
                // Penghapusan Gambar Cover Lama
                if ($article->image) {
                    Storage::disk('public')->delete($article->image);
                }
                $imagePath = $request->file('image')->store('articles/cover', 'public');
            }

            // 3. Update Artikel
            $article->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title), // Update slug
                'admin_id' => $adminId, // Mengambil ID/Session Admin
                'image' => $imagePath,
                'content' => $request->content, 
            ]);

            
            /**
             * Logika Update Konten Galeri
             *
            */
            // Hapus Konten Foto/Galeri Lama
            if ($request->has('galleries_deleted_ids')) {
                
                // Pengambilan variabel untuk penghapusan gambar/galeri
                $deletedIds = explode(',', $request->galleries_deleted_ids);
                $deletedIds = array_filter($deletedIds); // hapus string kosong
                
                // Memastikan $deletedIds bukan string kosong
                if (!empty($deletedIds)) {
                    $deletedItems = DB::table('article_galleries')->whereIn('id', $deletedIds)->get();

                    foreach ($deletedItems as $item) {
                        Storage::disk('public')->delete($item->src);
                    }

                    DB::table('article_galleries')->whereIn('id', $deletedIds)->delete();
                }
            }

            // Update Caption Galeri yang Sudah Ada
            if ($request->has('galleries_existing')) {
                foreach ($request->galleries_existing as $galleriesId => $item) {
                    DB::table('article_galleries')->where('id', $galleriesId)->update([
                        'caption' => $item['caption'] ?? null,
                    ]);
                }
            }
            
            // Tambah Galeri Baru
            if ($request->has('galleries_new')) {
                $galleriesData = [];
                foreach ($request->galleries_new as $item) {
                    if (isset($item['src']) && $item['src'] instanceof \Illuminate\Http\UploadedFile) {
                        $galleriesPath = $item['src']->store('article/galleries', 'public');
                        $galleriesData[] = [
                            'article_id' => $article->id,
                            'src' => $galleriesPath,
                            'caption' => $item['caption'] ?? null,
                        ];
                    }
                }
                if (!empty($galleriesData)) {
                    DB::table('article_galleries')->insert($galleriesData);
                }
            }

            DB::commit();
            return redirect()->route('article.index')->with('success', 'Artikel berhasil diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage()); // Debugging
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui artikel: ' . $e->getMessage());
        }
    }

    /**
     * Hapus artikel tertentu dari database.
     */
    public function destroy($id)
    {
        $article = Article::with('galleries')->findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Hapus file gambar cover
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            
            foreach($article->galleries as $galleriesItem) {
                Storage::disk('public')->delete($galleriesItem->src);
            }

            // Hapus record Artikel utama
            $article->delete();
            DB::commit();
            
            return redirect()->route('article.index')->with('success', 'Artikel berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus artikel: ' . $e->getMessage());
        }
    }

    // =========================================================
    // --- FUNCTION PAGE USER ---
    // =========================================================
    
    /**
     * Daftar Artikel - Frontend User
     *
    */
    public function list(Request $request)
    {
        $query = Article::query();
    
        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
    
        // Pagination
        $articles = $query->latest()->paginate(6)->withQueryString();
    
        return view('articles.articles-list', compact('articles'));
    }
    
    /**
     * Detail Artikel - Frontend User
     *
    */
    public function showDetails($slug)
    {
        $article = Article::with(['admin', 'galleries'])
            ->where('slug', $slug)
            ->firstOrFail();
    
        // Tambah views
        $article->increment('views');
    
        // Format data untuk view
        $content = [
            'name' => $article->title,
            'publisher' => $article->admin->name ?? 'Groza Official',
            'release-date' => $article->created_at->format('d M Y'),
            'content' => $article->content,
            'gallery' => $article->galleries->map(function ($item) {
                return [
                    'type' => 'image',
                    'src' => 'storage/' . $item->src,
                ];
            }),
        ];
    
        return view('articles.articles-detail', compact('content'));
    }

}


