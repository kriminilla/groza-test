<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_colors';
    protected $fillable = [
        'product_id',
        'color_code_id',
        'image',
    ];

    public $timestamps = false;

    // Relasi
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function colorCode()
    {
        return $this->belongsTo(ColorOption::class, 'color_code_id', 'id');
    }
}
