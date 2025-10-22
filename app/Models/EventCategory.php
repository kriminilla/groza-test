<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $table = 'event_categories';
    protected $fillable = [
        'category_name',
    ];

    public $timestamps = false;

    // Relasi
    public function events()
    {
        return $this->hasMany(Event::class, 'category_event_id', 'id');
    }
}
