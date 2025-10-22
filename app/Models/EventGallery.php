<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    use HasFactory;

    protected $table = 'event_galleries'; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'image',
    ];
    
    public $timestamps = false; 
    
    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
