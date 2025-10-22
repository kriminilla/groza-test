<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorList extends Model
{
    use HasFactory;

    protected $table = 'distributor_locations';
    protected $fillable = [
        'distributor_name',
        'map_link',
        'address',
        'city_id',
        'province_id',
    ];

    public $timestamps = false;

    //Relasi Tabel 
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
