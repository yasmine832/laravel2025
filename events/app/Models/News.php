<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory; 
    protected $fillable = [
        'title',
        'image_path',
        'content',
        'publish_date'
    ];

    protected $casts = [
        'publish_date' => 'datetime'
    ];
}