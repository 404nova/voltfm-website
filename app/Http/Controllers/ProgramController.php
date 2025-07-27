<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgramController extends Controller
{
    public function index()
    {
        // Get current week number
        $currentWeek = now()->week;
        
        // Get programs for the current week
        $programs = Program::where('week_number', $currentWeek)
            ->where('active', true)
            ->orderBy('time_start', 'asc')
            ->get();
        
        return view('pages.program', compact('programs'));
    }
    
    /**
     * Get upcoming shows for the homepage
     * Shows only upcoming shows for current day, or next day's shows if none left today
     * 
     * @param int $limit Number of shows to return
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingShows($limit = 3)
    {
        // Expliciet tijdzone instellen, ongeacht globale instellingen
        $now = Carbon::now('Europe/Amsterdam');
        $currentDayName = strtolower($now->englishDayOfWeek);
        $currentWeekNumber = $now->weekOfYear;
        $currentTimeString = $now->format('H:i:s');
        
        // Debug logs
        \Log::info("Current time (Amsterdam): " . $now->format('H:i:s'));
        
        // Get shows for today that are currently running or haven't started yet
        $todayShows = Program::where('active', 1)
            ->where(function($query) use ($currentDayName) {
                $query->whereJsonContains('days', $currentDayName)
                    ->orWhereJsonContains('days', strtolower($currentDayName));
            })
            ->where(function($query) use ($currentTimeString) {
                // Either the show is currently running (start time <= current time && end time > current time)
                // OR the show hasn't started yet (start time > current time)
                $query->where(function($q) use ($currentTimeString) {
                    $q->whereRaw("time_start <= ? AND time_end > ?", [$currentTimeString, $currentTimeString]);
                })->orWhere('time_start', '>', $currentTimeString);
            })
            ->where(function($query) use ($currentWeekNumber) {
                $query->where('week_number', $currentWeekNumber)
                    ->orWhereNull('week_number');
            })
            ->orderBy('time_start', 'asc')
            ->take($limit)
            ->get();
        
        // Log the today shows for debugging
        foreach ($todayShows as $show) {
            // Create Carbon objects for the show times
            $showStart = Carbon::parse($show->time_start)->setDate($now->year, $now->month, $now->day);
            $showEnd = Carbon::parse($show->time_end)->setDate($now->year, $now->month, $now->day);
            
            // Check if show is currently live
            $isLive = $now->between($showStart, $showEnd) ? 'true' : 'false';
            
            \Log::info("Today show: {$show->title}, time_start: {$show->time_start}, time_end: {$show->time_end}, current: {$now->format('H:i:s')}");
            \Log::info("Is live using Carbon: {$isLive}");
        }
        
        // If we don't have enough shows for today, get shows for tomorrow
        if ($todayShows->count() < $limit) {
            $tomorrow = $now->copy()->addDay();
            $tomorrowDayName = strtolower($tomorrow->englishDayOfWeek);
            $tomorrowWeekNumber = $tomorrow->weekOfYear;
            
            \Log::info("Tomorrow day: " . $tomorrowDayName);
            
            $neededShows = $limit - $todayShows->count();
            
            $tomorrowShows = Program::where('active', 1)
                ->where(function($query) use ($tomorrowDayName) {
                    $query->whereJsonContains('days', $tomorrowDayName)
                        ->orWhereJsonContains('days', strtolower($tomorrowDayName));
                })
                ->where(function($query) use ($tomorrowWeekNumber) {
                    $query->where('week_number', $tomorrowWeekNumber)
                        ->orWhereNull('week_number');
                })
                ->orderBy('time_start', 'asc')
                ->take($neededShows)
                ->get();
                
            // Log the tomorrow shows for debugging
            foreach ($tomorrowShows as $show) {
                \Log::info("Tomorrow show: {$show->title}, time_start: {$show->time_start}, time_end: {$show->time_end}");
            }
            
            // Add sorting indicators based on live status and day
            foreach ($todayShows as $show) {
                // Create Carbon objects for show times
                $showStart = Carbon::parse($show->time_start)->setDate($now->year, $now->month, $now->day);
                $showEnd = Carbon::parse($show->time_end)->setDate($now->year, $now->month, $now->day);
                
                // Check if the show is currently live
                if ($now->between($showStart, $showEnd)) {
                    $show->sort_order = 1; // Live shows first
                } else {
                    $show->sort_order = 2; // Upcoming today shows second
                }
            }
            
            foreach ($tomorrowShows as $show) {
                $show->sort_order = 3; // Tomorrow's shows last
            }
            
            // Merge collections
            $upcomingShows = $todayShows->concat($tomorrowShows);
        } else {
            foreach ($todayShows as $show) {
                // Create Carbon objects for show times
                $showStart = Carbon::parse($show->time_start)->setDate($now->year, $now->month, $now->day);
                $showEnd = Carbon::parse($show->time_end)->setDate($now->year, $now->month, $now->day);
                
                // Check if the show is currently live
                if ($now->between($showStart, $showEnd)) {
                    $show->sort_order = 1; // Live shows first
                } else {
                    $show->sort_order = 2; // Upcoming today shows second
                }
            }
            $upcomingShows = $todayShows;
        }
        
        // Sort by our custom sort order first, then by start time
        return $upcomingShows->sortBy([
            ['sort_order', 'asc'],
            ['time_start', 'asc']
        ])->values();
    }
} 