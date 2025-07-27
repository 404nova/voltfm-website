<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsCommentController extends Controller
{
    /**
     * Store a new comment for a news article.
     */
    public function store(Request $request, $slug)
    {
        $article = News::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|min:3',
        ]);
        
        $comment = new NewsComment([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'approved' => false, // Default is false, will be approved by admin
        ]);
        
        $article->comments()->save($comment);
        
        Log::info('New comment submitted for review', [
            'article_id' => $article->id, 
            'article_title' => $article->title,
            'commenter_name' => $validated['name']
        ]);
        
        return redirect()->back()->with('success', 'Bedankt voor je reactie! Je bericht wordt momenteel beoordeeld en zal binnenkort zichtbaar zijn.');
    }
}
