<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get a specific number of recent news articles.
     * 
     * @param int $limit Number of articles to retrieve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentNews($limit = 3)
    {
        return News::with(['author', 'category'])
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Display a listing of news articles.
     */
    public function index(Request $request)
    {
        $query = News::with(['author', 'category', 'tags'])
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
            
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filter by tag
        if ($request->has('tag') && !empty($request->tag)) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }
        
        $news = $query->paginate(10)->withQueryString();
            
        $recentNews = $this->getRecentNews();
            
        $categories = NewsCategory::withCount(['news' => function($query) {
                $query->where('published_at', '<=', now());
            }])
            ->orderBy('name')
            ->get();
            
        $tags = NewsTag::withCount(['news' => function($query) {
                $query->where('published_at', '<=', now());
            }])
            ->orderBy('news_count', 'desc')
            ->limit(10)
            ->get();
            
        return view('pages.news', compact('news', 'recentNews', 'categories', 'tags'));
    }

    /**
     * Display the specified news article.
     */
    public function show($slug)
    {
        $article = News::with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->where('published_at', '<=', now())
            ->firstOrFail();
            
        // Get approved comments for this article
        $comments = $article->comments()
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $recentNews = $this->getRecentNews();
            
        $categories = NewsCategory::withCount(['news' => function($query) {
                $query->where('published_at', '<=', now());
            }])
            ->orderBy('name')
            ->get();
            
        $tags = NewsTag::withCount(['news' => function($query) {
                $query->where('published_at', '<=', now());
            }])
            ->orderBy('news_count', 'desc')
            ->limit(10)
            ->get();
            
        return view('pages.news-single', compact('article', 'comments', 'recentNews', 'categories', 'tags'));
    }
    
    /**
     * Display news articles by category.
     */
    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->firstOrFail();
        
        $request = request()->merge(['category' => $slug]);
        return $this->index($request);
    }
    
    /**
     * Display news articles by tag.
     */
    public function tag($slug)
    {
        $tag = NewsTag::where('slug', $slug)->firstOrFail();
        
        $request = request()->merge(['tag' => $slug]);
        return $this->index($request);
    }
} 