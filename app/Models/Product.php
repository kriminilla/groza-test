<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'slug',
        'description',
        'image',
        'logo',
        'caption',
        'category_id',
        'subcategory_id',
    ];

    public $timestamps = false;

    // Relasi
    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id', 'id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }

    public function flyers()
    {
        return $this->hasMany(ProductFlyer::class, 'product_id', 'id');
    }

}
