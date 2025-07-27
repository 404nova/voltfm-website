<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Top40Song extends Model
{
    protected $fillable = [
        'position',
        'title',
        'artist',
        'art_url',
        'trend_direction',
        'trend_value',
        'is_new'
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'position' => 'integer',
        'trend_value' => 'integer'
    ];
} 