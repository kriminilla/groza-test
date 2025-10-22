<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorOption extends Model
{
    use HasFactory;

    protected $table = 'color_codes';

    protected $fillable = [
        'color_name',
        'color_code',
    ];

    public $timestamps = false;

    // Relasi Tabel
    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'color_code_id', 'id');
    }
}
