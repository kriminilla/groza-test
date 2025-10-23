<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces'; 
    protected $fillable = ['province_name'];
    
    public $timestamps = false;

    // Relasi
    public function locations()
    {
        return $this->hasMany(PartnerList::class, 'province_id');
    }
}
