<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // Get current week number
        $currentWeek = now()->week;
        
        // Get week filter from request or default to current week
        $weekFilter = $request->input('week', $currentWeek);
        
        // Base query ordered by time_start
        $query = Program::orderBy('time_start', 'asc');
        
        // Apply week filter
        if ($weekFilter !== 'all') {
            $query->where('week_number', (int)$weekFilter);
        }
        
        $programs = $query->get();
        
        // Get list of all available week numbers for the filter dropdown
        $weekNumbers = Program::distinct()
            ->whereNotNull('week_number')
            ->pluck('week_number')
            ->sort()
            ->values();
        
        // Ensure current week is in the list even if no programs yet
        if (!$weekNumbers->contains($currentWeek)) {
            $weekNumbers->push($currentWeek);
            $weekNumbers = $weekNumbers->sort()->values();
        }
        
        return view('admin.programs.index', compact('programs', 'weekNumbers', 'weekFilter', 'currentWeek'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        Log::info('Starting program creation process', ['request_data' => $request->all()]);
        
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'presenter' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'time_start' => 'required|date_format:H:i',
                'time_end' => 'required|date_format:H:i|after:time_start',
                'days' => 'required|array',
                'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'week_number' => 'required|integer|min:1|max:53',
            ]);
            
            // Only add active field if the column exists in the database
            if (Schema::hasColumn('programs', 'active')) {
                $validated['active'] = $request->has('active') ? true : false;
            }
            
            Log::info('Validation passed', ['validated_data' => $validated]);

            if ($request->hasFile('image')) {
                Log::info('Processing image upload');
                $imagePath = $request->file('image')->store('programs', 'public');
                $validated['image'] = $imagePath;
                Log::info('Image uploaded successfully', ['path' => $imagePath]);
            }

            $program = Program::create($validated);
            Log::info('Program created successfully', ['program_id' => $program->id]);

            return redirect()->route('admin.programs.index')
                ->with('success', 'Programma succesvol aangemaakt.');
        } catch (\Exception $e) {
            Log::error('Error creating program', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van het programma: ' . $e->getMessage()]);
        }
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        Log::info('Starting program update process', ['program_id' => $program->id, 'request_data' => $request->all()]);
        
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'presenter' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'time_start' => 'required|date_format:H:i',
                'time_end' => 'required|date_format:H:i|after:time_start',
                'days' => 'required|array',
                'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'week_number' => 'required|integer|min:1|max:53',
            ]);
            
            // Only add active field if the column exists in the database
            if (Schema::hasColumn('programs', 'active')) {
                $validated['active'] = $request->has('active') ? true : false;
            }
            
            Log::info('Validation passed', ['validated_data' => $validated]);

            if ($request->hasFile('image')) {
                Log::info('Processing image upload for update');
                // Remove the old image if it exists
                if ($program->image) {
                    Storage::disk('public')->delete($program->image);
                    Log::info('Deleted old image', ['old_path' => $program->image]);
                }
                $imagePath = $request->file('image')->store('programs', 'public');
                $validated['image'] = $imagePath;
                Log::info('Image uploaded successfully', ['path' => $imagePath]);
            }

            if ($request->has('remove_image') && $program->image) {
                Log::info('Removing image as requested');
                Storage::disk('public')->delete($program->image);
                $validated['image'] = null;
            }

            $program->update($validated);
            Log::info('Program updated successfully');

            return redirect()->route('admin.programs.index')
                ->with('success', 'Programma succesvol bijgewerkt.');
        } catch (\Exception $e) {
            Log::error('Error updating program', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het bijwerken van het programma: ' . $e->getMessage()]);
        }
    }

    public function destroy(Program $program)
    {
        try {
            Log::info('Starting program deletion process', ['program_id' => $program->id]);
            
            // Verwijder de afbeelding als die bestaat
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
                Log::info('Deleted image for program', ['path' => $program->image]);
            }

            $program->delete();
            Log::info('Program deleted successfully');

            return redirect()->route('admin.programs.index')
                ->with('success', 'Programma succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Error deleting program', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het verwijderen van het programma: ' . $e->getMessage()]);
        }
    }
} 