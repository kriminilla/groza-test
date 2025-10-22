<?php


use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Articles;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ColorOptionController;
use App\Http\Controllers\DistributorListController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventGalleryController;
use App\Http\Controllers\HeaderImageController;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\HeroProductController;
use App\Http\Controllers\IframeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubcategoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (tanpa login admin)
|--------------------------------------------------------------------------
*/ 
// Halaman login admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Authentication
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

// Home page → lewat PageController
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/katalog', [PageController::class, 'catalog'])->name('catalog');

// LOKASI MITRA
Route::get('/partners', [PartnerListController::class, 'list'])->name('partner.list');
Route::get('/partners/filter', [PartnerListController::class, 'filter'])->name('partner.filter');

// LOKASI DISTRIBUTOR
Route::get('/distributors', [DistributorListController::class, 'list'])->name('distributor.list'); 
Route::get('/distributors/filter', [DistributorListController::class, 'filter'])->name('distributor.filter'); 

// PRODUK publik
Route::get('/products', [ProductController::class, 'product'])->name('products');
Route::get('/products/{categorySlug}', [ProductController::class, 'showCategory'])
    ->where('categorySlug', 'aksesoris|pengereman|suspensi')
    ->name('product.categories');
Route::get('/products/catalog/{subCategorySlug}', [ProductController::class, 'showSubCategory'])
    ->name('catalog.subcategories');
Route::get('/products/{subcategory}/{slug}', [ProductController::class, 'showProductDetail'])
    ->name('products.detail');

// ARTIKEL publik
Route::get('/articles', [Articles::class, 'list'])->name('articles.list');
Route::get('/articles/{slug}', [Articles::class, 'showDetails'])->name('articles.detail');

// EVENT Publik
Route::get('/events', [EventController::class, 'indexUser'])->name('events.list');
Route::get('/events/{slug}', [EventController::class, 'showUser'])->name('events.detail');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (butuh login)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'home'])->name('admin.dashboard');

    // Hanya bisa diakses superadmin (contoh)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/list-admin', [AdminController::class, 'daftaradmin'])->name('admin.list');
        
        // CRUD admin
        Route::post('/store', [AdminController::class, 'store'])->name('admin.list.store');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.list.update');
        Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.list.destroy');
    });


    // CRUD resource
    Route::resource('category', CategoryController::class)->only(['index','store','update','destroy']);
    Route::resource('subcategory', SubcategoriesController::class)->only(['index','store','update','destroy']);
    Route::resource('color', ColorOptionController::class)->only(['index','store','update','destroy']);
    Route::resource('province', ProvinceController::class)->only(['index','store','update','destroy']);
    Route::resource('size', SizeController::class)->only(['index','store','update','destroy']);
    Route::resource('heroimage', HeroImageController::class)->only(['index','store','update','destroy']);
    Route::resource('headerimage', HeaderImageController::class)->only(['index','store','update','destroy']);
    Route::resource('city', CityController::class);
    Route::resource('partnerlist', PartnerListController::class);
    Route::resource('distributorlist', DistributorListController::class);
    Route::resource('product', ProductController::class);
    Route::resource('article', Articles::class);
    Route::resource('event', EventController::class);
    Route::resource('eventcategory', EventCategoryController::class)->only(['index','store','update','destroy']);
    
    Route::get('/hero-product', [HeroProductController::class, 'index'])->name('heroproduct.index');
    Route::put('/hero-product/{id}', [HeroProductController::class, 'update'])->name('heroproduct.update');

    // Specified Partner/Distributor Route
    Route::get('/admin/iframe', [IframeController::class, 'index'])->name('iframe.index');
    Route::put('/admin/iframe/{id}', [IframeController::class, 'update'])->name('iframe.update');
    Route::get('/admin/partner/get-city/{provinsiId}', [PartnerListController::class, 'getKotaByProvinsi']);
    Route::get('/admin/distributor/get-city/{provinsiId}', [DistributorListController::class, 'getKotaByProvinsi']);

    // Specified Article Route
    Route::get('article/{slug}/detail', [Articles::class, 'show'])->name('article.show');
    Route::post('/article/upload-image', [Articles::class, 'uploadImageSummernote'])->name('article.uploadimage');
});

