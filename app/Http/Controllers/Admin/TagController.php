<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = NewsTag::orderBy('name')->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Check if slug already exists
        $count = 1;
        $originalSlug = $validated['slug'];
        while (NewsTag::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        NewsTag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag succesvol aangemaakt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsTag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsTag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate new slug only if name changed
        if ($tag->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);

            // Check if new slug already exists
            $count = 1;
            $originalSlug = $validated['slug'];
            while (NewsTag::where('slug', $validated['slug'])->where('id', '!=', $tag->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsTag $tag)
    {
        // This will automatically detach all news articles
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag succesvol verwijderd.');
    }
}
