<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Top40Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Top40Controller extends Controller
{
    public function index()
    {
        $songs = Top40Song::orderBy('position')->get();
        return view('admin.top40.index', compact('songs'));
    }

    public function create()
    {
        return view('admin.top40.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|integer|min:1|max:50',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'art_url' => 'required|url',
            'trend_direction' => 'required|in:up,down,none,new',
            'trend_value' => 'required|integer|min:0',
            'is_new' => 'boolean'
        ]);

        Top40Song::create($validated);

        return redirect()->route('admin.top40.index')
            ->with('success', 'Nummer succesvol toegevoegd aan de TOP40.');
    }

    public function edit(Top40Song $top40)
    {
        return view('admin.top40.edit', compact('top40'));
    }

    public function update(Request $request, Top40Song $top40)
    {
        $validated = $request->validate([
            'position' => 'required|integer|min:1|max:50',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'art_url' => 'required|url',
            'trend_direction' => 'required|in:up,down,none,new',
            'trend_value' => 'required|integer|min:0',
            'is_new' => 'boolean'
        ]);

        $top40->update($validated);

        return redirect()->route('admin.top40.index')
            ->with('success', 'Nummer succesvol bijgewerkt.');
    }

    public function destroy(Top40Song $top40)
    {
        $top40->delete();

        return redirect()->route('admin.top40.index')
            ->with('success', 'Nummer succesvol verwijderd uit de TOP40.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*' => 'required|integer|min:1|max:50'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->positions as $position => $id) {
                Top40Song::where('id', $id)->update(['position' => $position + 1]);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
