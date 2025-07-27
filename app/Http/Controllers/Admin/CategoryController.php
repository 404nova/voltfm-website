<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = NewsCategory::orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Check if slug already exists
        $count = 1;
        $originalSlug = $validated['slug'];
        while (NewsCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        NewsCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie succesvol aangemaakt.');
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
    public function edit(NewsCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
        ]);

        // Generate new slug only if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);

            // Check if new slug already exists
            $count = 1;
            $originalSlug = $validated['slug'];
            while (NewsCategory::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsCategory $category)
    {
        // Check if category is used by any news articles
        if ($category->news()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Categorie kan niet worden verwijderd omdat deze nog in gebruik is door nieuwsartikelen.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie succesvol verwijderd.');
    }
}
