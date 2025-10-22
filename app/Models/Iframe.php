<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iframe extends Model
{
    use HasFactory;

    protected $table = 'iframe';
    protected $fillable = ['src'];

    public $timestamps = false;
}
