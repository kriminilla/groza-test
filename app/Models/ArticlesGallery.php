<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesGallery extends Model
{
    use HasFactory;

    protected $table = 'article_galleries';

    protected $fillable = [
        'article_id',
        'src',
        'caption',
        'sort_order',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
