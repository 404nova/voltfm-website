<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacature extends Model
{
    use HasFactory;

    protected $table = 'vacatures';

    protected $fillable = [
        'naam',
        'leeftijd',
        'motivatie',
        'ervaring',
        'email',
        'discord',
		'vacancy_id'
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];
public function vacancy()
{
    return $this->belongsTo(Vacancy::class, 'vacancy_id');
}


}
