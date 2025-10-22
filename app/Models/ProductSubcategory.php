<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';
    protected $fillable = [
        'category_id',
        'subcategory_name',
        'slug',
        'image',
        'header_image',
    ];

    public $timestamps = false;

    // Relasi
    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'category_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id');
    }
}
