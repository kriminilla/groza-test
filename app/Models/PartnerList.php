<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class PartnerList extends Model
{
    use HasFactory;

    protected $table = 'partner_locations';

    protected $fillable = [
        'partner_name',
        'map_link',
        'address',
        'city_id',
        'province_id',
    ];

    public $timestamps = false;

    // Relasi
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
