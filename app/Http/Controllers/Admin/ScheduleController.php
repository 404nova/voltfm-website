<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DjAvailability;
use App\Models\DjAssignment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ScheduleController extends BaseAdminController
{
    /**
     * Display the schedule overview page
     */
    public function index()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('index');
        }

        try {
            $currentWeek = Carbon::now()->startOfWeek();
            $assignments = DjAssignment::with('user')
                                      ->where('date', '>=', $currentWeek)
                                      ->where('date', '<', $currentWeek->copy()->addDays(7))
                                      ->orderBy('date')
                                      ->orderBy('start_time')
                                      ->get();

            $daysOfWeek = [
                'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag',
                'Vrijdag', 'Zaterdag', 'Zondag'
            ];

            $timeSlots = $this->getTimeSlots();

            // Check if user is DJ and only show the view-only version of the schedule
            $user = auth()->user();
            $isDj = $user->hasRole('dj');
            $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');

            return view('admin.schedule.index', compact(
                'assignments',
                'daysOfWeek',
                'timeSlots',
                'currentWeek',
                'isDj',
                'isAdmin'
            ));
        } catch (QueryException $e) {
            Log::error('Error querying schedule data: ' . $e->getMessage());
            return $this->handleMissingTables('index');
        }
    }

    /**
     * Display the availability management page
     */
    public function availability()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('availability');
        }

        try {
            $user = auth()->user();
            $isDj = $user->hasRole('dj');
            $isAdmin = $user->hasRole('admin');
            $isBeheer = $user->hasRole('beheer');
            
            // If user is a DJ trying to access another DJ's availability, redirect to their own
            if ($isDj && !$isAdmin && !$isBeheer && request()->has('user_id') && request()->input('user_id') != $user->id) {
                return redirect()->route('admin.schedule.availability', ['user_id' => $user->id])
                    ->with('error', 'Je kunt alleen je eigen beschikbaarheid beheren.');
            }
            
            // For DJ users, force their own user_id
            if ($isDj && !$isAdmin && !$isBeheer && !request()->has('user_id')) {
                return redirect()->route('admin.schedule.availability', ['user_id' => $user->id]);
            }
            
            // For admins/non-DJs without user_id, show the list view without a selected user
            if (($isAdmin || $isBeheer || !$isDj) && !request()->has('user_id')) {
                // Do nothing, just show the list view
            }
            
            // For admins, show all DJs
            $users = ($user->hasAnyRole(['admin', 'beheer']))
    ? User::whereHas('role', function ($query) {
        $query->whereIn('name', ['admin', 'beheer', 'dj', 'redactie']);
    })->with('availabilities')->get()
    : collect([$user->load('availabilities')]);

                
            $availabilities = DjAvailability::with('user')->get()->groupBy('user_id');
            $daysOfWeek = [
                'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 
                'Vrijdag', 'Zaterdag', 'Zondag'
            ];
            
            $timeSlots = $this->getTimeSlots();
            
            return view('admin.schedule.availability', compact(
                'users', 
                'availabilities', 
                'daysOfWeek', 
                'timeSlots',
                'isDj',
                'isAdmin',
                'isBeheer'
            ));
        } catch (QueryException $e) {
            Log::error('Error querying availability data: ' . $e->getMessage());
            return $this->handleMissingTables('availability');
        }
    }

    /**
     * Store user availability data
     */
    public function storeAvailability(Request $request)
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('availability');
        }

        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'availabilities' => 'required|array'
            ]);

            $user = auth()->user();
            $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');

            // DJ users can only update their own availability
            if (!$isAdmin && $validated['user_id'] != $user->id) {
                return redirect()->route('admin.schedule.availability', ['user_id' => $user->id])
                    ->with('error', 'Je kunt alleen je eigen beschikbaarheid beheren.');
            }

            // Delete existing availability entries for this user
            DjAvailability::where('user_id', $validated['user_id'])->delete();

            // Create new availability entries
            foreach ($validated['availabilities'] as $item) {
                DjAvailability::create([
                    'user_id' => $validated['user_id'],
                    'day_of_week' => $item['day'],
                    'start_time' => $item['start'],
                    'end_time' => $item['end']
                ]);
            }

            return redirect()->route('admin.schedule.availability', ['user_id' => $validated['user_id']])
                            ->with('success', 'Beschikbaarheid succesvol opgeslagen.');
        } catch (QueryException $e) {
            Log::error('Error storing availability data: ' . $e->getMessage());
            return $this->handleMissingTables('availability');
        }
    }

    /**
     * Display the DJ assignment management page
     */
    public function assignments()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');

        // Only admin users can access this page
        if (!$isAdmin) {
            return redirect()->route('admin.schedule.index')
                ->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('assignments');
        }

        try {
            // Fetch all DJ users for the dropdown
            $users = User::whereHas('role', function ($query) {
    $query->whereIn('name', ['admin', 'beheer', 'dj', 'redactie']);
})->with('availabilities')->get();

            
            // Get all assignments (don't filter by date to ensure we see everything)
            $currentAssignments = DjAssignment::with('user')
                                         ->orderBy('date', 'desc')
                                         ->orderBy('start_time')
                                         ->limit(50) // Add a reasonable limit
                                         ->get();
            
            // Log the number of assignments found (for debugging)
            \Log::info('Assignments retrieved on assignments page: ' . $currentAssignments->count());
            
            // Also log the dates of a few assignments if any exist
            if ($currentAssignments->count() > 0) {
                $sample = $currentAssignments->take(5);
                foreach ($sample as $index => $assignment) {
                    \Log::info("Sample assignment {$index}: Date: {$assignment->date}, DJ: {$assignment->user->name}");
                }
            }

            $timeSlots = $this->getTimeSlots();

            return view('admin.schedule.assignments', compact('users', 'currentAssignments', 'timeSlots'));
        } catch (QueryException $e) {
            Log::error('Error querying assignments data: ' . $e->getMessage());
            return $this->handleMissingTables('assignments');
        }
    }

    /**
     * Store a new DJ assignment
     */
    public function storeAssignments(Request $request)
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');

        // Only admin users can create assignments
        if (!$isAdmin) {
            return redirect()->route('admin.schedule.index')
                ->with('error', 'Je hebt geen toegang tot deze functie.');
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('assignments');
        }

        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'notes' => 'nullable|string|max:255'
            ]);

            // Check for overlapping shifts
            $overlapping = DjAssignment::where('date', $validated['date'])
                ->where(function($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                          ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                          ->orWhere(function($q) use ($validated) {
                              $q->where('start_time', '<=', $validated['start_time'])
                                ->where('end_time', '>=', $validated['end_time']);
                          });
                })
                ->exists();

            if ($overlapping) {
                return back()->withErrors(['overlap' => 'Er is al een DJ ingepland voor deze tijd.'])->withInput();
            }

            // Create the assignment
            DjAssignment::create([
                'user_id' => $validated['user_id'],
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'notes' => $validated['notes'] ?? null
            ]);

            return redirect()->route('admin.schedule.assignments')
                            ->with('success', 'DJ uren succesvol ingepland.');
        } catch (QueryException $e) {
            Log::error('Error storing assignment data: ' . $e->getMessage());
            return $this->handleMissingTables('assignments');
        }
    }

    /**
     * Delete a DJ assignment
     */
    public function destroyAssignment($id)
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');

        // Only admin users can delete assignments
        if (!$isAdmin) {
            return redirect()->route('admin.schedule.index')
                ->with('error', 'Je hebt geen toegang tot deze functie.');
        }

        // Check if DJ tables exist
        if (!$this->checkDjTablesExist()) {
            return $this->handleMissingTables('assignments');
        }

        try {
            // Log the deletion attempt
            \Log::info("Attempting to delete assignment with ID: {$id} by user: {$user->name}");
            
            // First check if the assignment exists
            $assignment = DjAssignment::find($id);
            
            if (!$assignment) {
                \Log::warning("Assignment with ID: {$id} not found when trying to delete");
                return redirect()->route('admin.schedule.assignments')
                                ->with('error', 'Toewijzing niet gevonden.');
            }
            
            // Log details of the assignment before deletion
            \Log::info("Deleting assignment: Date: {$assignment->date}, DJ: {$assignment->user->name}, Time: {$assignment->start_time}-{$assignment->end_time}");
            
            // Delete the assignment
            $assignment->delete();
            \Log::info("Assignment deleted successfully");

            return redirect()->route('admin.schedule.assignments')
                            ->with('success', 'DJ planning verwijderd.');
        } catch (QueryException $e) {
            \Log::error('Error deleting assignment data: ' . $e->getMessage());
            return $this->handleMissingTables('assignments');
        }
    }

    /**
     * Helper method to generate time slots
     */
    private function getTimeSlots()
    {
        $slots = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $slots[] = sprintf('%02d:00', $hour);
        }
        return $slots;
    }

    /**
     * Check if DJ tables exist in the database
     */
    private function checkDjTablesExist()
    {
        return Schema::hasTable('dj_assignments') && Schema::hasTable('dj_availabilities');
    }

    /**
     * Handle missing DJ tables
     */
    private function handleMissingTables($page)
    {
        // Display a flash message for local environment
        if (app()->environment('local')) {
            session()->flash('info', 'DJ planningstabellen zijn niet aanwezig in je lokale database. Deze functie is alleen beschikbaar op de productieomgeving.');
            
            // Return appropriate view based on page type
            switch ($page) {
                case 'assignments':
                    $users = collect([]);
                    $currentAssignments = collect([]);
                    $timeSlots = $this->getTimeSlots();
                    return view('admin.schedule.assignments', compact('users', 'currentAssignments', 'timeSlots'));
                    
                case 'index':
                    $assignments = collect([]);
                    $currentWeek = Carbon::now()->startOfWeek();
                    $daysOfWeek = [
                        'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag',
                        'Vrijdag', 'Zaterdag', 'Zondag'
                    ];
                    $timeSlots = $this->getTimeSlots();
                    $user = auth()->user();
                    $isDj = $user->hasRole('dj');
                    $isAdmin = $user->hasRole('admin') || $user->hasRole('beheer');
                    return view('admin.schedule.index', compact(
                        'assignments',
                        'daysOfWeek',
                        'timeSlots',
                        'currentWeek',
                        'isDj',
                        'isAdmin'
                    ));
                    
                case 'availability':
                    $users = collect([auth()->user()]);
                    $availabilities = collect([]);
                    $daysOfWeek = [
                        'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 
                        'Vrijdag', 'Zaterdag', 'Zondag'
                    ];
                    $timeSlots = $this->getTimeSlots();
                    $user = auth()->user();
                    $isDj = $user->hasRole('dj');
                    $isAdmin = $user->hasRole('admin');
                    $isBeheer = $user->hasRole('beheer');
                    return view('admin.schedule.availability', compact(
                        'users', 
                        'availabilities', 
                        'daysOfWeek', 
                        'timeSlots',
                        'isDj',
                        'isAdmin',
                        'isBeheer'
                    ));
                    
                default:
                    return redirect()->route('admin.dashboard');
            }
        }
        
        // For production, redirect to dashboard with error
        return redirect()->route('admin.dashboard')
                        ->with('error', 'Er is een probleem opgetreden bij het laden van de DJ planning. Neem contact op met de beheerder.');
    }
}
