<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'news_id',
        'name',
        'email',
        'content',
        'approved',
    ];
    
    protected $casts = [
        'approved' => 'boolean',
    ];
    
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
