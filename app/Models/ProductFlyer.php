<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFlyer extends Model
{
    use HasFactory;

    protected $table = 'product_flyers';

    protected $fillable = [
        'product_id',
        'flyer',
    ];

    public $timestamps = false;

    // Relasi
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
