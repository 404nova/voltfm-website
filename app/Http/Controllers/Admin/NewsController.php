<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::orderBy('name')->get();
        $tags = NewsTag::orderBy('name')->get();
        return view('admin.news.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'excerpt' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:news_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:news_tags,id',
        ]);

        // Genereer een slug van de titel
        $validated['slug'] = Str::slug($validated['title']);
        
        // Zet de huidige gebruiker als auteur
        $validated['author_id'] = Auth::id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        // Extract tags from validated data
        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $news = News::create($validated);
        
        // Attach tags
        if (!empty($tags)) {
            $news->tags()->attach($tags);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsartikel succesvol aangemaakt.');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::orderBy('name')->get();
        $tags = NewsTag::orderBy('name')->get();
        $selectedTags = $news->tags->pluck('id')->toArray();
        
        return view('admin.news.edit', compact('news', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'excerpt' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:news_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:news_tags,id',
        ]);

        // Update de slug alleen als de titel is gewijzigd
        if ($news->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        if ($request->hasFile('image')) {
            // Verwijder de oude afbeelding als die bestaat
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Extract tags from validated data
        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $news->update($validated);
        
        // Sync tags (will detach any tags not in the array and attach new ones)
        $news->tags()->sync($tags);

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsartikel succesvol bijgewerkt.');
    }

    public function destroy(News $news)
    {
        // Verwijder de afbeelding als die bestaat
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsartikel succesvol verwijderd.');
    }
} 