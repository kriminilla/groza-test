<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use App\Models\Iframe;
use App\Models\Kategori;
use App\Models\ProductSubcategory;
use App\Models\Produk;
use App\Models\Subkategori;
use Illuminate\Http\Request;

class PageController extends Controller
{
    function home()
    {
        $heroImages = HeroImage::all();
        $iframe     = Iframe::first();

        return view('home', compact('heroImages', 'iframe'));
    }
 
    function about()  
    {
        return view('about');
    }

    function catalog()
    {
        return view('catalog');
    }

}
