<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductFlyer;
use App\Models\Size;
use App\Models\ProductCategories;
use App\Models\ColorOption;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Index/Daftar Produk Khusus Admin
     *
    */
    public function index()
    {
        $category = ProductCategories::orderBy('category_name')->get();
        $products = Product::with(['category','subcategory','colors','flyers','sizes'])
                         ->paginate(10);
        return view('admin.read.product-list', compact('products', 'category'));
    }

    /**
     * Form Tambah Produk
     *
    */
    public function create()
    {
        $categories    = ProductCategories::orderBy('category_name')->get();
        $subcategories = ProductSubcategory::orderBy('subcategory_name')->get();
        $sizes      = Size::orderBy('size_label')->pluck('size_label', 'id');
        $colorCodes = ColorOption::all();

        return view('admin.create.createProduct', compact('categories', 'subcategories', 'sizes', 'colorCodes'));
    }

    /**
     * Store produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'product_name'   => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'description'    => 'nullable|string', // Kolom description tidak berubah
            'caption'        => 'nullable|string',
            'sizes'          => 'nullable|array',

            // Flyer (gambar / video)
            'flyer'          => 'nullable|array',
            'flyer.*'        => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,avi,mov|max:51200',

            // Warna
            'color_image.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'color_code_id.*'=> 'nullable|exists:color_codes,id',
        ]);

        // Store Gambar Logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('products/logo', 'public');
        }

        // Store Gambar Utama (cover)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products/image', 'public');
        }

        // Generate Slug
        $validated['slug'] = Str::slug($validated['product_name']);

        // Store Produk
        $product = Product::create($validated);

        // Store Warna
        if ($request->hasFile('color_image')) {
            foreach ($request->file('color_image') as $index => $file) {
                if ($file) {
                    $path = $file->store('products/colors', 'public');
                    $product->colors()->create([
                        'color_code_id' => $request->color_code_id[$index] ?? null,
                        'image'         => $path,
                    ]);
                }
            }
        }

        // Store Flyer (foto / video)
        if ($request->hasFile('flyer')) {
            foreach ($request->file('flyer') as $flyer) {
                if ($flyer) {
                    $path = $flyer->store('products/flyer', 'public');
                    $product->flyers()->create(['flyer' => $path]);
                }
            }
        }

        // Store Variasi Ukuran
        if ($request->has('sizes') && is_array($request->sizes)) {
            $product->sizes()->attach($request->sizes);
        }

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    /**
     * Form Edit Produk
     *
    */
    public function edit(Product $product)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('login'); 
        }

        $product->load(['category','subcategory','colors','flyers','sizes']);
        $categories    = ProductCategories::orderBy('category_name')->get();
        $subcategories = ProductSubcategory::orderBy('subcategory_name')->get();
        $colorCodes = ColorOption::all();
        $sizes      = Size::orderBy('size_label')->pluck('size_label', 'id'); 

        return view('admin.update.update-product', compact('product', 'categories', 'subcategories', 'colorCodes', 'sizes'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, Product $product)
    {
        // Validasi Input
        $validated = $request->validate([
            'product_name'      => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'subcategory_id'    => 'required|exists:subcategories,id',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'caption'           => 'nullable|string',
            'description'       => 'nullable|string',
            'sizes'             => 'nullable|array',
            
            // WARNA
            'color_ids'         => 'nullable|array',           
            'color_code_id'     => 'nullable|array',           
            'color_code_id.*'   => 'nullable|exists:color_codes,id',
            'color_image'       => 'nullable|array',           
            'color_image.*'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'deleted_color_ids' => 'nullable|array',           
    
            // FLYER
            'flyers'            => 'nullable|array',           
            'flyers.*'          => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,avi,mov|max:51200',
            'deleted_flyer_ids' => 'nullable|array',           
        ]);
    
        // Update Konten Utama/Cover (Logo & Gambar)
        if ($request->hasFile('logo')) {
            if ($product->logo) Storage::disk('public')->delete($product->logo);
            $validated['logo'] = $request->file('logo')->store('products/logo', 'public');
        }
    
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('products/image', 'public');
        }
    
        $validated['slug'] = Str::slug($validated['product_name']);
        $product->update($validated);
    
        /**
         * Logika Update Warna
         *
        */
        $deletedColors = $request->input('deleted_color_ids', []); // Mengambil dari JS
    
        // Logika Penghapusan
        if (!empty($deletedColors)) {
            foreach ($deletedColors as $colorId) {
                $color = $product->colors()->find($colorId);
                if ($color) {
                    if ($color->image) Storage::disk('public')->delete($color->image);
                    $color->delete();
                }
            }
        }
    
        // Logika Update dan Penambahan Warna
        if ($request->has('color_code_id')) {
            foreach ($request->color_code_id as $index => $colorCodeId) {
                $colorId = $request->color_ids[$index] ?? null;
        
                // Lewati jika warna ini dihapus
                if ($colorId && in_array($colorId, $deletedColors)) continue;
        
                $file = $request->file("color_image.$index");
        
                if ($colorId) {
                    // Update warna lama
                    $color = $product->colors()->find($colorId);
                    if ($color) {
                        $color->color_code_id = $colorCodeId;
                        if ($file) {
                            if ($color->image) {
                                Storage::disk('public')->delete($color->image);
                            }
                            $color->image = $file->store('products/colors', 'public');
                        }
                        $color->save();
                    }
                } else {
                    // Tambah warna baru
                    if ($file) {
                        $path = $file->store('products/colors', 'public');
                        $product->colors()->create([
                            'color_code_id' => $colorCodeId,
                            'image'         => $path,
                        ]);
                    }
                }
            }
        }

    
        /**
         * Logika Update Flyer
         *
        */
        $deletedFlyers = $request->input('deleted_flyer_ids', []); // Mengambil dari JS
    
        // Hapus Flyer
        if (!empty($deletedFlyers)) {
            $flyers = $product->flyers()->whereIn('id', $deletedFlyers)->get();
            foreach ($flyers as $flyer) {
                if ($flyer->flyer) Storage::disk('public')->delete($flyer->flyer);
                $flyer->delete();
            }
        }
    
        // Penambahan Flyer Baru
        if ($request->hasFile('flyers')) {
            $files = $request->file('flyers');
            
            foreach ($files as $file) {
                 if ($file) {
                    $path = $file->store('products/flyers', 'public');
                    $product->flyers()->create(['flyer' => $path]);
                }
            }
        }
    
        // Update Ukuran
        if ($request->has('sizes') && is_array($request->sizes)) {
            $product->sizes()->sync($request->sizes);
        } else {
            $product->sizes()->detach();
        }
    
        return redirect()->route('product.index')->with('success', 'Produk berhasil diupdate!');
    }
    
    /**
     * Page Detail Produk
     *
    */
    public function show($id)
    {
        $kodeWarnaOptions = ColorOption::all();
        $product = Product::with(['category', 'subcategory', 'colors.colorCode', 'flyers', 'sizes'])
                         ->findOrFail($id);

        return view('admin.read.product-details', compact('product', 'kodeWarnaOptions'));
    }

    /**
     * Hapus Produk Tertentu
     *
    */
    public function destroy(Product $product)
    {
        foreach ($product->flyers as $flyer) {
            if ($flyer->flyer) Storage::disk('public')->delete($flyer->flyer);
            $flyer->delete();
        }

        foreach ($product->colors as $warna) {
            if ($warna->image) Storage::disk('public')->delete($warna->image);
            $warna->delete();
        }

        // Hapus Opsi Ukuran Produk
        $product->sizes()->detach();

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus');
    }

    // =========================================================
    // --- PAGE FRONTEND USER ---
    // =========================================================

    /**
     * Menampilkan halaman utama produk
     */
    public function product()
    {
        $subcategories = ProductSubcategory::all();
     
        return view('product.product-lineup', compact('subcategories'));
    }
    
    /**
     * Tampilkan Produk Berdasarkan Kategori
     *
    */
    public function showCategory($categorySlug)
    {
        // Mapping Kategori
        $categoryMap = [
            'aksesoris'  => 'AKSESORIS',
            'pengereman' => 'PENGEREMAN',
            'suspensi'   => 'SUSPENSI',
        ];
    
        $categoryName = $categoryMap[$categorySlug] ?? null;
    
        if (!$categoryName) {
            abort(404, 'Kategori tidak ditemukan.');
        }

        $category = ProductCategories::where('category_name', $categoryName)
                                     ->with('subcategories')
                                     ->firstOrFail();

        $subcategories = $category->subcategories
            ->map(function ($sub) {
                return [
                    'name' => $sub->subcategory_name, 
                    'slug' => $sub->slug,
                    'img'  => asset('img/' . Str::slug($sub->slug) . '.png'),
                ];
            });
    
        return view('product.category-lineup', [
            'categoryName'  => $category->category_name,
            'categorySlug'  => $categorySlug,
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Menampilkan katalog produk berdasarkan Subkategori Slug.
     */
    public function showSubCategory($subCategorySlug)
    {
        // Slug Mapping (Berdasarkan Subkategori)
        $categoryMap = [
            'kaliper'       => 'KALIPER',
            'master-rem'    => 'MASTER REM',
            'selangrem'     => 'SELANG REM',
            'piringan'      => 'PIRINGAN',
            'shockbreaker'  => 'SHOCKBREAKER',
            'tabung-minyak' => 'TABUNG MINYAK',
            'handgrip'      => 'HANDGRIP',
            'gas-spontan'   => 'GAS SPONTAN',
            'swing-arm'     => 'SWING ARM',
        ];
    
        // Pastikan slug valid
        if (!array_key_exists($subCategorySlug, $categoryMap)) {
            abort(404, 'Katalog subkategori tidak ditemukan.');
        }
    
        // Ambil nama subkategori berdasarkan slug
        $categoryName = $categoryMap[$subCategorySlug];
    
        // Ambil data subkategori dari DB
        $subCategory = ProductSubcategory::where('subcategory_name', $categoryName)->firstOrFail();
    
        // Setelah subcategory berhasil ditemukan, baru ambil slug kategori induk (jika ada)
        $categorySlug = $subCategory->category->slug ?? $subCategory->slug;
    
        // Ambil semua produk terkait
        $productList = Product::where('subcategory_id', $subCategory->id)
            ->select('product_name', 'slug', 'caption', 'image')
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->product_name,
                    'desc' => $product->caption,
                    'img'  => $product->image ? Storage::url($product->image) : 'img/placeholder.png',
                    'slug' => $product->slug,
                ];
            });
    
        // Ambil header image (dengan fallback)
        $headerImage = $subCategory->header_image
            ? asset($subCategory->header_image)
            : asset('img/default-header.jpg');
    
        // Return Views
        return view('product.subcategory-lineup', compact(
            'categoryMap',
            'categoryName',
            'subCategory',
            'categorySlug',
            'productList',
            'headerImage'
        ));
    }


    /**
     * Tampilkan Detail Produk
     *
    */
    public function showProductDetail($subcategory, $slug)
    {
        $product = Product::with(['subcategory', 'sizes', 'flyers', 'colors.colorCode'])
            ->where('slug', $slug)
            ->firstOrFail();
    
        // Header dari subkategori produk
        $headerImage = $product->subcategory->header_image
            ? asset($product->subcategory->header_image)
            : asset('img/Hanasita - 1.png');

        // Susun data produk untuk dikirim ke view
        $productData = [
            'name'          => $product->product_name,
            'description'   => $product->description ?? '-',
            'logo'          => $product->logo ? asset('storage/' . $product->logo) : null,
            'main_image'    => $product->image ? asset('storage/' . $product->image) : asset('img/placeholder.png'),
    
            // Galeri (flyer)
            'gallery' => $product->flyers->map(function ($item) {
                return [
                    'type' => Str::endsWith($item->flyer, ['.mp4', '.avi', '.mov']) ? 'video' : 'image',
                    'src'  => asset('storage/' . $item->flyer),
                ];
            })->toArray(),
    
            // Warna
            'colors' => $product->colors->map(function ($product_color) {
                $colorCodes = $product_color->colorCode; 
                return [
                    'name'  => $colorCodes->color_name ?? 'N/A', 
                    'code'  => $colorCodes->color_code ?? '#000000',
                    'image' => $product_color->image ? asset('storage/' . $product_color->image) : asset('img/placeholder.png'),
                ];
            })->toArray(),
    
            // Ukuran
            'sizes' => $product->sizes->pluck('size_label')->toArray(),
        ];
        
        return view('product.product-detail', [
            'product'     => $productData,
            'subcategory' => $subcategory,
            'headerImage' => $headerImage,
        ]);
    }
}