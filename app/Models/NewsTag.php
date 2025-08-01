<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_tag', 'news_tag_id', 'news_id');
    }
}
