<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news_articles';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'excerpt',
        'author_id',
        'published_at',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(NewsTag::class, 'news_tag');
    }

    public function comments()
    {
        return $this->hasMany(NewsComment::class);
    }
}
