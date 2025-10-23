<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = ['city_name', 'province_id'];

    public $timestamps = false;

    // Relasi Tabel
    public function partnerLocations() 
    {
        return $this->hasMany(PartnerList::class, 'city_id', 'id');
    }

    public function distributorLocations()
    {
        return $this->hasMany(DistributorList::class, 'city_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
