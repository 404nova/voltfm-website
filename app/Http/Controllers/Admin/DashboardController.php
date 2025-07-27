<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Program;
use App\Models\DjAssignment;
use App\Models\DjAvailability;
use App\Models\SongRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        // Extra check to ensure user is authenticated
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }
        
        $user = Auth::user();
        
        // Role checks
        $isAdmin = $user->hasRole('admin');
        $isDj = $user->hasRole('dj');
        $isRedactie = $user->hasRole('redactie');
        $isBeheer = $user->hasRole('beheer');
        
        // Base data for all roles
        $data = [
            'isAdmin' => $isAdmin,
            'isDj' => $isDj,
            'isRedactie' => $isRedactie,
            'isBeheer' => $isBeheer,
        ];
        
        // Admin/Management and Editorial data
        if ($isAdmin || $isBeheer || $isRedactie) {
            $data['programCount'] = Program::count();
            $data['newsCount'] = News::count();
            $data['recentNews'] = News::orderBy('created_at', 'desc')->limit(5)->get();
        }
        
        // DJ specific data
        if ($isDj || $isAdmin || $isBeheer) {
            // Initialize with empty collection to prevent null errors
            $upcomingShifts = collect([]);
            $availabilityCount = 0;
            $todayShift = null;
            $nextShow = null;
            $timeToNextShow = null;
            
            // Recent song requests
            $recentSongRequests = collect([]);
            $pendingSongRequestsCount = 0;
            
            // Check if table exists before trying to query it
            $hasDjTables = Schema::hasTable('dj_assignments') && Schema::hasTable('dj_availabilities');
            $hasSongRequestsTable = Schema::hasTable('song_requests');
            
            if ($hasSongRequestsTable) {
                try {
                    // Get recent pending song requests
                    $recentSongRequests = SongRequest::where('status', 'pending')
                                                ->orderBy('created_at', 'desc')
                                                ->limit(5)
                                                ->get();
                                                
                    $pendingSongRequestsCount = SongRequest::where('status', 'pending')->count();
                } catch (QueryException $e) {
                    Log::error('Error querying song requests: ' . $e->getMessage());
                }
            }
            
            if ($hasDjTables) {
                try {
                    // Current date and time for comparison
                    $now = Carbon::now();
                    
                    // Get today and future DJ shifts
                    $upcomingShifts = DjAssignment::where('user_id', $user->id)
                                                ->where('date', '>=', now()->startOfDay())
                                                ->orderBy('date')
                                                ->orderBy('start_time')
                                                ->limit(7)
                                                ->get();
                    
                    // Get availability count
                    $availabilityCount = DjAvailability::where('user_id', $user->id)->count();
                    
                    // Check if next shift is today
                    $todayShift = $upcomingShifts->first(function($shift) {
                        return $shift->date->isToday();
                    });
                    
                    // Get next live show time and countdown
                    // Find the true next upcoming shift (current or future datetime)
                    if ($upcomingShifts->count() > 0) {
                        // Find the first shift that hasn't ended yet
                        foreach ($upcomingShifts as $shift) {
                            $shiftStartDateTime = Carbon::parse($shift->date->format('Y-m-d') . ' ' . $shift->start_time);
                            $shiftEndDateTime = Carbon::parse($shift->date->format('Y-m-d') . ' ' . $shift->end_time);
                            
                            // Check if this shift is in the future or currently happening
                            if ($shiftEndDateTime->isFuture()) {
                                $nextShow = $shift;
                                
                                // If shift is already started, count down to the end time
                                if ($shiftStartDateTime->isPast() && $now->between($shiftStartDateTime, $shiftEndDateTime)) {
                                    $diffInSeconds = $now->diffInSeconds($shiftEndDateTime, false);
                                    $countdownTitle = 'Live Show Eindigt Over';
                                } else {
                                    // Otherwise, count down to the start time
                                    $diffInSeconds = $now->diffInSeconds($shiftStartDateTime, false);
                                    $countdownTitle = 'Volgende Live Uitzending';
                                }
                                
                                if ($diffInSeconds > 0) {
                                    $days = floor($diffInSeconds / 86400);
                                    $hours = floor(($diffInSeconds % 86400) / 3600);
                                    $minutes = floor(($diffInSeconds % 3600) / 60);
                                    
                                    $timeToNextShow = [
                                        'days' => $days,
                                        'hours' => $hours,
                                        'minutes' => $minutes,
                                        'total_seconds' => $diffInSeconds,
                                        'next_show_datetime' => $shiftStartDateTime->isPast() ? $shiftEndDateTime->toIso8601String() : $shiftStartDateTime->toIso8601String(),
                                        'countdown_title' => $countdownTitle
                                    ];
                                }
                                
                                break; // We found our next show, exit the loop
                            }
                        }
                    }
                } catch (QueryException $e) {
                    // Log error but continue
                    Log::error('Error querying DJ data: ' . $e->getMessage());
                    
                    // In development mode, add a message
                    if (app()->environment('local')) {
                        session()->flash('info', 'DJ planning is alleen beschikbaar op de productieomgeving.');
                    }
                }
            } else {
                // In development mode, add a message
                if (app()->environment('local')) {
                    session()->flash('info', 'DJ planningstabellen zijn niet aanwezig in je lokale database.');
                }
            }
            
            $data['upcomingShifts'] = $upcomingShifts;
            $data['availabilityCount'] = $availabilityCount;
            $data['todayShift'] = $todayShift;
            $data['nextShow'] = $nextShow;
            $data['timeToNextShow'] = $timeToNextShow;
            $data['recentSongRequests'] = $recentSongRequests;
            $data['pendingSongRequestsCount'] = $pendingSongRequestsCount;
        }
        
        return view('admin.dashboard', $data);
    }
    
    /**
     * AJAX endpoint to get recent song requests for real-time updates
     */
    public function getRecentSongRequests()
    {
        // Check permissions
        $user = Auth::user();
        if (!$user || !($user->hasRole('admin') || $user->hasRole('dj') || $user->hasRole('beheer'))) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        try {
            // Get recent pending song requests
            $recentSongRequests = SongRequest::where('status', 'pending')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                        
            $pendingSongRequestsCount = SongRequest::where('status', 'pending')->count();
            
            // Transform data for frontend
            $requests = $recentSongRequests->map(function($request) {
                return [
                    'id' => $request->id,
                    'name' => $request->name,
                    'artist' => $request->artist,
                    'song_title' => $request->song_title,
                    'message' => $request->message,
                    'created_at' => $request->created_at->diffForHumans(),
                    'created_at_formatted' => $request->created_at->format('d-m-Y H:i'),
                    'status_url' => route('admin.song-requests.update-status', $request->id)
                ];
            });
            
            return response()->json([
                'requests' => $requests,
                'count' => $pendingSongRequestsCount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching song requests: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
} 