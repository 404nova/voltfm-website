<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DjAvailability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * Get the user that owns the availability
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the day name
     */
    public function getDayNameAttribute()
    {
        $days = [
            0 => 'Maandag',
            1 => 'Dinsdag',
            2 => 'Woensdag',
            3 => 'Donderdag',
            4 => 'Vrijdag',
            5 => 'Zaterdag',
            6 => 'Zondag'
        ];

        return $days[$this->day_of_week] ?? '';
    }
} 