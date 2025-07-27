<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'presenter',
        'description',
        'image',
        'time_start',
        'time_end',
        'days',
        'week_number',
        'active',
    ];

    protected $casts = [
        'days' => 'array',
        'active' => 'boolean',
    ];
} 