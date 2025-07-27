<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DjAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the assignment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the day of week
     */
    public function getDayOfWeekAttribute()
    {
        return $this->date->dayOfWeek;
    }

    /**
     * Get the formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format('d-m-Y');
    }

    /**
     * Get the formatted time range
     */
    public function getTimeRangeAttribute()
    {
        return $this->start_time . ' - ' . $this->end_time;
    }

    /**
     * Check if assignment is in the future
     */
    public function getIsFutureAttribute()
    {
        $assignmentStart = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->start_time);
        return $assignmentStart->isFuture();
    }
} 