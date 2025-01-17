<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}