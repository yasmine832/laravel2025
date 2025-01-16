<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
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