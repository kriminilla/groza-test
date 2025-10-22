<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroImage extends Model
{
    protected $table = 'hero_image'; 
    protected $fillable = [
        'src',
        'alt',
    ];

    public $timestamps = false;
}
