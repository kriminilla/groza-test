<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'category_event_id',
        'cover',
        'description',
        'event_date',
    ];
    
    // Relasi
    public function galleries()
    {
        return $this->hasMany(EventGallery::class, 'event_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_event_id', 'id');
    }
}
